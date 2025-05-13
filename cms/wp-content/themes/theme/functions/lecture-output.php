<?php
require_once('../../../../wp-load.php');

const GENDER = array('male' => '男性', 'female' => '女性');
const DM = array('yes' => 'はい', 'no' => 'いいえ');

$csrf = md5(date("Ymd"));
if (isset($_POST['lecture_name']) && $_POST['csrf'] == $csrf) {
	// データ取得
	$post_id = $_POST['lecture_name'];
	
	// データベースへの接続 (kokurakinen_data)
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME_LECTURE);
	if (!$link) {
		throw new Exception('☆データベース接続失敗' . mysqli_connect_error());
	}
	
	// テーブルの取得
	$db_rows = mysqli_query($link, 'SELECT post_id, datetime, text FROM t_lecture WHERE remove=0 AND post_id=' . $post_id);
	if (!$db_rows) {
		throw new Exception('☆クエリー失敗' . mysqli_error($link));
	}
	
	// CSVヘッダ作成
	$csvdata[] = array('申込日時','投稿ID','参加者番号','講座名','開催日','会場','氏名','シメイ','性別','年齢','郵便番号','住所','電話番号','メールアドレス','お知らせ','先生へ質問');
	
	// CSVボディ作成
	while ($row = mysqli_fetch_assoc($db_rows)) {
		// 暗号化テキストの展開
		$encrypted = base64_decode($row['text']);
		$json_data = openssl_decrypt($encrypted, 'AES-128-CBC', DB_PASSWORD, OPENSSL_RAW_DATA, md5(DB_PASSWORD, true));
		$arydata = json_decode($json_data, true);
		// CSVデータの作成
		$csvdata[] = array(
			$row['datetime'],
			$row['post_id'],
			$arydata['participant_no'],
			$arydata['title'],
			$arydata['post_date'],
			$arydata['post_venue'],
			$arydata['name'][0] .' ' .$arydata['name'][1],
			$arydata['kana_last_name'] .' ' .$arydata['kana_first_name'],
			GENDER[$arydata['gender']],
			$arydata['age'],
			$arydata['zipcode'][0] . '-' . $arydata['zipcode'][1],
			htmlspecialchars_decode($arydata['address']),
			$arydata['phone'][0] .'-' .$arydata['phone'][1] .'-' .$arydata['phone'][2],
			htmlspecialchars_decode($arydata['email']),
			DM[$arydata['dm']],
			$arydata['question'],
		);
	}
	
	// ユーザーエージェントによる分岐
	if ($_POST['user_agent'] == 'Macintosh') {
		// Mac の場合 (UTF-16 tsv形式)
		$fp = fopen('php://temp', 'r+b');
		foreach ($csvdata as $output) {
			fputcsv($fp, $output, "\t");
		}
		rewind($fp);
		$csvtext = "\xEF\xBB\xBF" . str_replace(PHP_EOL, "\n", stream_get_contents($fp));
		$csvtext = mb_convert_encoding($csvtext, 'UTF-16LE', 'UTF-8');
	} else {
		// Win の場合（UTF-8bom csv形式）
		$fp = fopen('php://temp', 'r+b');
		foreach ($csvdata as $output) {
			fputcsv($fp, $output);
		}
		rewind($fp);
		$csvtext = "\xEF\xBB\xBF" . str_replace(PHP_EOL, "\r\n", stream_get_contents($fp));
	}
	
	// ファイルを標準出力
	header('Content-Type: application/octet-stream');
	header('X-Content-Type-Options: nosniff');
	header('Content-Length: ' . strlen($csvtext));
	header('Content-Disposition: attachment; filename="export' . $post_id . '.csv"');
	header('Connection: close');
	while (ob_get_level()) {
		ob_end_clean();
	}
	echo $csvtext;
}
?>
