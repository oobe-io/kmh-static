<?php
require_once(dirname( __FILE__ ) . '/../../../wp-load.php');

$csrf = md5(date("Ymd"));
if (isset($_POST['seminar_name']) && $_POST['csrf'] == $csrf) {
	// データ取得
	$postid = $_POST['seminar_name'];
	$filename = 'export' .$postid .'.csv';
	
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME . '2');
	if (mysqli_connect_errno()) {
		throw new Exception('接続失敗です。'.mysqli_error());
	}

	$db_rows = mysqli_query($link, 'SELECT post_id, form_id, datetime, text FROM  t_seminar WHERE post_id = ' .$postid);
	if (!$db_rows) {
		throw new Exception('クエリーが失敗しました。'.mysqli_error());
	}
	if ($db_rows->num_rows < 1) {
		throw new Exception("取得対象データがありません。");
	}
			
	// ヘッダー設定
	$head = array('申込日時','投稿ID','講座名','開催日','会場','氏名','性別','年齢','郵便番号','住所','電話番号','メールアドレス','お知らせ');
	$csvdata[] = $head;
	// 詳細設定
	while ($row = mysqli_fetch_assoc($db_rows)) {
		$arydata = array();
		$ary = array();
		$encrypted = base64_decode($row['text']);
		$json_data = openssl_decrypt($encrypted, 'AES-128-CBC', DB_AUTH, OPENSSL_RAW_DATA, md5(DB_AUTH, true));
		$arydata = json_decode($json_data, true);
		
		$ary[] = $row['datetime'];
		$ary[] = $row['post_id'];
		$ary[] = $arydata['title'];
		$ary[] = $arydata['post_date'];
		$ary[] = $arydata['post_venue'];
		$ary[] = $arydata['last_name'] .' ' .$arydata['first_name'];
		if ($arydata['gender'] == 'male') {
			$ary[] = '男性';
		} else {
			$ary[] = '女性';
		}
		$ary[] = $arydata['age'];
		$ary[] = $arydata['postno1'] .'-' .$arydata['postno2'];
		$ary[] = $arydata['address'];
		$ary[] = $arydata['telno1'] .'-' .$arydata['telno2'] .'-' .$arydata['telno3'];
		$ary[] = $arydata['email'];
		if ($arydata['dm'] == 'yes') {
			$ary[] = 'はい';
		} else {
			$ary[] = 'いいえ';
		}
		$csvdata[] = $ary;
	}

	// 配列をカンマ区切りにしてファイルに書き込み(UTF-8 BOMつき)
	$rec = "\xEF\xBB\xBF";
	foreach($csvdata as $output){
		$rec .= '"' .implode('","' , $output) .'"' ."\n";
	}
	
	// ファイルサイズに注意。
	header('Content-Type: application/octet-stream');
	header('X-Content-Type-Options: nosniff');
	header('Content-Length: ' . strlen($rec));
	header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
	header('Connection: close');
	
	while (ob_get_level()) { ob_end_clean(); }
	echo $rec;
	//readfile($rec);
}
?>
