<?php 

// 外部関数群（お知らせツール）
require_once('news-tools.php');

//定数
const FILE_NAME_PDF_URL 			  				= "../../news/pdf_url_latest.js";
const FILE_NAME_INFO_UPDATE_JSON 				= "../../news/info_list_update.json";
const FILE_NAME_INFO_MEDIA_JSON 				= "../../news/info_list_media.json";
const LIST_TARGET_START_DATE 						= '2000/01/01';
const LIST_TARGET_END_DATE 							= '2099/12/31';

/*
	PDFのURLファイル作成
*/
function create_pdf_url_file() {

	global $wpdb;

	//新規アップロードしたPDFファイルを取得
	$sql_upload = 
		" SELECT guid "
		. " FROM wp_posts "
		. " WHERE post_type = 'attachment' "
		. " AND post_mime_type = 'application/pdf' "
		. " ORDER BY post_date DESC " 
		. " LIMIT 1 ";
    $url_upload = $wpdb->get_col($sql_upload, 0);

	$val_pdfup_file 			= get_field('pdfup-file');		//アップロードファイル
	$val_pdfup_select 			= get_field('pdfup-select');	//セレクトの選択項目（ラベル）
	$val_pdfup_select_filenm 	= get_field_object('pdfup-select')['choices'][$val_pdfup_select];	//セレクトの選択項目（値）
	//セレクトから選択したPDFファイルを取得
	$sql_select = 
		" SELECT guid "
		. " FROM wp_posts "
		. " WHERE post_type = 'attachment' "
		. " AND post_mime_type = 'application/pdf' " 
		. " AND post_title = " . "'" . $val_pdfup_select_filenm . "'";
	$url_select = $wpdb->get_col($sql_select, 0);

	$pdf_url = "";
	//ファイルを新規アップロードした場合
	if(!empty($url_upload) && $val_pdfup_file != false){
		$pdf_url = $url_upload[0];
	//セレクトから選択、かつ、未選択（0）でない場合
	} else if (!empty($url_select) && $val_pdfup_select != "0"){
		$pdf_url = $url_select[0];
	}

	$domain = $_SERVER['HTTP_HOST'];

	//本番環境
	create_static_file(FILE_NAME_PDF_URL, 'const filePath = "'.$pdf_url.'";');

	//ファイルの選択状態を初期化
	if(!empty($url_upload) && $val_pdfup_file != false){
		$post_id = (int)$_POST['post_ID'];
		$query  = " UPDATE wp_postmeta " 
			. " SET meta_value = '' " 
			. " WHERE post_id = %d " 
			. " AND meta_key = 'pdfup-file' ";
		$result = $wpdb->query($wpdb->prepare($query, $post_id));
	}
}

/*
	お知らせ作成（更新情報/メディア掲載情報）
*/
function create_info_list($post_id_exclusion) {

	$args = array(
		'post_type' 		=> 'news',
		'posts_per_page' 	=> -1,				//全件取得（-1を指定）
		'post__not_in' 		=> array($post_id_exclusion),	//ゴミ箱に移動したお知らせを非表示
		'meta_key' 			=> 'news-date',
		'orderby' 			=> 'meta_value',	//投稿日時（news-date）の降順
		'order' 			=> 'DESC',
		'meta_query' 		=> array(
			'relation' 		=> 'AND',
			array(
				'key' 		=> 'news-date',		//投稿日時（news-date）の期間で取得
				'value'		=> array(LIST_TARGET_START_DATE, LIST_TARGET_END_DATE),
				'compare'	=> 'BETWEEN',
				'type'		=> 'DATE'
			),
		),
	);

	$json_info_update = array();
	$json_info_media = array();

	$posts = get_posts($args);
	foreach ($posts as $post):

		//カスタムフィールドの取得
		$fields 		= get_fields($post->ID);
		$news_type 		= $fields['news-type'];		//種類（ラジオボタン） -- 0:更新情報　1:メディア掲載情報
		$news_date 		= $fields['news-date'];		//投稿日時（デイトピッカー）
		$news_content 	= $fields['news-content'];	//投稿内容（WYSIWYGエディタ）
		$news_media		= $fields['news-media']; 	//媒体（セレクト） -- 0:（なし）　1:web　2:テレビ　3:新聞　4:雑誌　5:その他
		$news_linktype	= $fields['news-linktype'];	//リンクタイプ（ラジオボタン） -- 0:URL　1:ファイル
		$news_url 		= $fields['news-url'];		//URL（テキスト）
		$news_file 		= $fields['news-file'];		//ファイル（ファイル）

		//前処理（投稿日時）
		$news_date 		= preprocess_date ($news_date);
		//前処理（投稿内容）
		$news_content 	= preprocess_content($news_content);

		// JSONデータの作成
		$json_data = array(
			'date' => $news_date,
			'content' => $news_content,
			'media' => $news_media,
			'link' => ($news_linktype == "0" ? $news_url : $news_file)
		);

		//媒体（更新情報）
		if($news_type == "0") {
			// $list_info_update .= $tmp;
			$json_info_update[] = $json_data;
		//媒体（メディア掲載情報）
		} else if ($news_type == "1") {
			// $list_info_medeia .= $tmp;
			$json_info_media[] = $json_data;
		}

	endforeach;

	$domain = $_SERVER['HTTP_HOST'];
	//本番環境
	create_static_file(FILE_NAME_INFO_UPDATE_JSON, json_encode($json_info_update, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	create_static_file(FILE_NAME_INFO_MEDIA_JSON,  json_encode($json_info_media,  JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

?>
