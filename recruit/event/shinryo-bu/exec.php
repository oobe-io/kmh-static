<?php

	ini_set("display_errors", 1);
	error_reporting(E_ALL);
	
	session_start();

	include('./validate.php');
	
	if(is_valid_csrf($Inputs['csrf']) === FALSE)
	{
		header('Location: ./');
		exit();
	}
	
	if(count($Errors) > 0)
	{
		header('Location: ./', true, 307);
		exit();
	}

	$body = '氏名 = '.$Inputs['name']."\r\n";
	$body .= 'ふりがな = '.$Inputs['hurigana']."\r\n";
	$body .= '生年月日・年 = '.$Inputs['byear']."\r\n";
	$body .= '生年月日・月 = '.$Inputs['bmon']."\r\n";
	$body .= '生年月日・日 = '.$Inputs['bday']."\r\n";
	$body .= '性別 = '.$SexName."\r\n";
	$body .= '大学名 = '.$Inputs['daigaku']."\r\n";
	$body .= '学年 = '.$Inputs['gakunen']."\r\n";
	$body .= '郵便番号 = '.$Inputs['zip']."\r\n";
	$body .= '住所 = '.$Inputs['address']."\r\n";
	$body .= '電話 = '.$Inputs['tel']."\r\n";
	$body .= 'email = '.$Inputs['mail']."\r\n";
	$body .= '希望日 = '.$Inputs['kinoubi']."\r\n";
	$body .= '第1希望 = '.$Kibouka1Name."\r\n";
	$body .= '第2希望 = '.$Kibouka2Name."\r\n";
	$body .= '第3希望 = '.$Kibouka3Name."\r\n";
	$body .= '選考希望科 = '.$Inputs['senko']."\r\n";
	$body .= '備考 = '.$Inputs['other'];
	
	// 病院様指定の送り先
	$to = "jinji-2@kokurakinen.or.jp";

	// メール件名の設定
	$subject = "【小倉記念病院】病院見学";

	// メールヘッダー設定
	$headers =
	"MIME-Version: 1.0\n" .
	"From: " .mb_encode_mimeheader("小倉記念病院") ."<jinji-2@kokurakinen.or.jp>\n";

	// Return-Pathを設定
	$params = "-f jinji-2@kokurakinen.or.jp";

	// メール送信(成功失敗は問わない)
	mb_send_mail($to, $subject, $body, $headers, $params);

	header('Location: ./complete/');
	exit();
?>

