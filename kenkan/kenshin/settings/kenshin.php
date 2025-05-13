<?php
date_default_timezone_set('Asia/Tokyo');
$today = date("Y-m-d");

// メール送信処理
function sendReplyMail($message, $data)
{
	try {
		// 変数とタイムゾーンを初期化
		date_default_timezone_set('Asia/Tokyo');
		
		// メール件名の設定
		$subject = "【小倉記念病院】健診仮予約のお知らせ";
		
		// メールヘッダー設定
		$headers =
			"MIME-Version: 1.0\n" .
			"From: <kenshin@kokurakinen.or.jp>\n";

		// Return-Pathを設定
		$params = "-f kenshin@kokurakinen.or.jp";
		
		// メール送信
		mb_send_mail($data['mail_address'], $subject, $message, $headers, $params);

		return true;
	}
	catch(Exception $e) {
		return false;
	}
}

// メール送信処理
function sendReserveMail($message)
{
	try {
		// 変数とタイムゾーンを初期化
		date_default_timezone_set('Asia/Tokyo');

		// 病院様指定の送り先
		$to = "kenshin@kokurakinen.or.jp,nakanishi-h@kokurakinen.or.jp";

		// メール件名の設定
		$subject = "【お知らせ】健診仮予約";
		
		// メールヘッダー設定
		$headers =
			"MIME-Version: 1.0\n" .
			"From: <kenshin@kokurakinen.or.jp>\n";

	  // Return-Pathを設定
		$params = "-f kenshin@kokurakinen.or.jp";

		// メール送信
		mb_send_mail($to, $subject, $message, $headers, $params);

		return true;
	}
	catch(Exception $e) {
		return false;
	}
}

// 年齢算出
function getAge($reserveDate, $birthday)
{
	// 日付だけを取得
  $date = mb_substr($reserveDate, 0, 10);
  $date = new DateTime($date);
  $date = $date->format("Ymd");
  $birthday = str_replace("/", "", $birthday);
  // 指定日からの誕生日を算出
  $age = floor(($date - $birthday) / 10000);
  return $age;
}

// テキスト読み込み
function getPolicyText($filePath)
{
	//読み込みモードでファイルを開く
	$fp = fopen($filePath, 'r');
	$txt = "";
	// 文末まで読み込み
	while(!feof($fp))
	{
		$txt .= fgets($fp);
	}
	fclose($fp);
	return $txt;
}
?>