<?php 

//ファイル作成
function create_static_file($filename, $file_content) {

	//存在チェック
	if(!file_exists($filename)){
		touch($filename);
	}

	//ファイル書き込み
	$fp = fopen($filename, "w");
	fwrite($fp, $file_content);
	fclose($fp);
}

//前処理（投稿日時）
function preprocess_date ($tmp_date) {

	/*
		処理内容
		・月日の先頭の値が”0”の場合、削除する（お知らせ画面の仕様準拠）
	*/
	$fix_date = "";
	$tmp_date_month = substr($tmp_date, 5, 1) ;		//月の先頭の値
	$tmp_date_day	= substr($tmp_date, 8, 1) ;		//日の先頭の値

	//年月日（文字列）の妥当性チェック
	if(empty($tmp_date) || strlen($tmp_date) != 10) { 
		return $tmp_date;
	}

	//例:2022.05.05 → 2022.5.5
	if($tmp_date_month == "0" && $tmp_date_day == "0"){
		$fix_date = substr($tmp_date, 0, 5) . substr($tmp_date, 6, 2) . substr($tmp_date, 9, 1);
	//例:2022.11.05 → 2022.11.5
	} else if ($tmp_date_month != "0" && $tmp_date_day == "0") {
		$fix_date = substr($tmp_date, 0, 5) . substr($tmp_date, 5, 3) . substr($tmp_date, 9, 1);
	//例:2022.05.11 → 2022.5.11
	} else if ($tmp_date_month == "0" && $tmp_date_day != "0") {
		$fix_date = substr($tmp_date, 0, 5) . substr($tmp_date, 6, 2) . substr($tmp_date, 8, 2);
	//例:2022.11.11 → 2022.11.11
	} else {
		$fix_date = $tmp_date;
	}
	
	return $fix_date;
}

//前処理（投稿内容）
function preprocess_content ($tmp_content) {

	/*
		処理内容
		・Pタグを削除（WYSIWYGエディタの投稿内容にPタグが自動付与される為、削除する）
		　<p>	→　''
		　</p>	→　''
		・太字タグをClass指定に変更（お知らせ画面の仕様準拠）
		　<strong>	→　<span class=\"bold\">
		　</strong>	→　</span>
	*/
	$target			= array("<p>", "</p>", "<strong>", "</strong>");
	$replace		= array('', '', "<span class=\"bold\">", "</span>");
	$tmp_content	= str_replace($target, $replace, $tmp_content);
	
	return $tmp_content;
}

?>
