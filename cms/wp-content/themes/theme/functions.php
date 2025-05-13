<?php

// 外部関数群（市民公開講座）
require_once('functions/lecture.php');
require_once('functions/news.php');

// 定数
const CUSTOM_POST_TYPE_NEWS		= 'news';
const CUSTOM_POST_TYPE_PDFUP	= 'pdfup';
const PDFUP_LIST_COUNT			= '50';

// 管理者以外は表示情報を抑制する
if (!current_user_can('administrator')) {
	// ワードプレス更新通知の非表示
	add_filter("pre_site_transient_update_core", "__return_null");
	// プラグイン更新通知の非表示
	add_filter("pre_site_transient_update_plugins", "__return_null");
	//フッターテキストの削除
	add_filter('admin_footer_text', '__return_null');
}

/*
	管理画面ログイン後の初期ページ設定
*/
add_action('admin_init', 'my_redirect_adminmenu');
function my_redirect_adminmenu()
{
	global $pagenow;
	
	// ダッシュボードにいる場合
	if (is_admin() && $pagenow == 'index.php') {
		// 投稿者の場合（小倉記念病院）
		if (current_user_can('author')) {
			wp_redirect(admin_url('admin.php?page=lecture-export'));
			return;
		}
		// 編集者の場合（ネクシス運営）
		if (current_user_can('editor')) {
			wp_redirect(admin_url('edit.php?post_type=lecture'));
			return;
		}
	}
}

/*
	管理画面の市民公開講座にJavaScriptを挿入する
*/
add_action('admin_print_footer_scripts', 'my_admin_footer_script');
function my_admin_footer_script()
{
	$values = array();
	$posts = get_posts('post_type=lecture&posts_per_page=-1');
	foreach ($posts as $post) {
		$text = getLectureStatusText($post->ID);
		$values[] = '"post-' . $post->ID . '": "' . $text . '" ';
	}
	$states = implode(',', $values);
echo <<<EOT
<script>
var states = { {$states} };
if (pagenow=='edit-lecture') {
	jQuery('#the-list > tr').each(
		function(index, element) {
			jQuery(element).find('[data-colname="開催状況"]').text(states[element.id]);
		}
	);
}
</script>
EOT;
}

/*
	自動リダイレクト機能の無効化
	https://www.doe.co.jp/hp-tips/wordpress/special-redirect/
*/
add_filter('redirect_canonical', 'my_redirect_canonical', 10, 2);
function my_redirect_canonical($redirect_url, $requested_url)
{
	// 市民公開講座の場合、カスタム投稿タイプ(lecture)と被って永久ループする模様
	if ($redirect_url == home_url('/lecture/list')) {
//		remove_filter('template_redirect', 'redirect_canonical');
		return false;
	}
	return $redirect_url;
}

/*
	カスタム投稿タイプのリライト
	http://www.560designs.com/memo/861.html
	https://torounit.com/blog/2015/09/02/2077/
*/
add_action('generate_rewrite_rules', 'my_generate_rewrite_rules');
function my_generate_rewrite_rules($wp_rewrite)
{
	$feed_rules = array(
		'lecture/list/?$' => 'index.php?pagename=lecture/list',
		'lecture/list/(202[0-9])?$' => 'index.php?pagename=lecture/list&page=$matches[1]year',
		'lecture/list/(.*)?$' => 'index.php?error=404',
	);
	$wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
	return $wp_rewrite->rules;
}

/*
	カスタム投稿タイプの追加
*/
add_action('init', 'my_register_post_type');
function my_register_post_type()
{
	register_post_type('lecture', [
		'labels' => [
			'name'			=> '市民公開講座',
			'singular_name'	=> 'lecture',
		],
		'public'			=> true,
		'has_archive'		=> true,
		'menu_position'		=> 5,
	]);
	register_post_type(CUSTOM_POST_TYPE_NEWS, [
		'labels' => [
			'name'			=> 'お知らせ',
			'singular_name'	=> CUSTOM_POST_TYPE_NEWS,
		],
		'public'			=> true,
		'has_archive'		=> true,
		'menu_position'		=> 6,
	]);
	register_post_type(CUSTOM_POST_TYPE_PDFUP, [
		'labels' => [
			'name'			=> 'PDFアップロード',
			'singular_name'	=> CUSTOM_POST_TYPE_PDFUP,
		],
		'public'			=> true,
		'has_archive'		=> true,
		'menu_position'		=> 7,
	]);
	register_post_type('reply-type', [
		'labels' => [
			'name'			=> '返信文面',
			'singular_name'	=> 'reply-type',
		],
		'public'			=> true,
		'has_archive'		=> true,
		'menu_position'		=> 8,
	]);
}

/*
	市民公開講座の投稿一覧をソートする
*/
add_action('pre_get_posts', 'my_custom_post_sort');
function my_custom_post_sort($query)
{
	// メインクエリの場合のみ実行する
	if (!$query->is_main_query()) {
		return;
	}
	// 管理画面の場合
	if (is_admin()) {
		// カスタム投稿タイプ「市民公開講座」である場合、開催日降順でソートする
		if (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'lecture') {
			$query->set('meta_key', 'lecture-date');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'DESC');
		}
	}
}

// 管理画面のメニューを制限する
add_action('admin_menu', 'my_remove_menus');
function my_remove_menus()
{
	// 投稿者（小倉記念病院）
	if (current_user_can('author')) {
		// メインメニューの非表示
		remove_menu_page('index.php');					// ダッシュボード
		remove_menu_page('edit.php');					// 投稿
		remove_menu_page('upload.php');					// メディア
		remove_menu_page('edit.php?post_type=page');	// 固定ページ
		remove_menu_page('edit-comments.php' );			// コメント
//		remove_menu_page('themes.php' );				// 外観（非表示）
//		remove_menu_page('plugins.php' );				// プラグイン（非表示）
		remove_menu_page('tools.php' );					// ツール
//		remove_menu_page('options-general.php' );		// 設定（非表示）
		remove_menu_page('edit.php?post_type=lecture');	// カスタム投稿ページ
		remove_menu_page('edit.php?post_type=reply-type');	// 返信文面
		// メインメニューの追加表示
		add_menu_page('page_title', 'ダウンロード', 'upload_files', 'lecture-export', 'my_lectue_download', 'dashicons-download', 8);
		// バージョン情報の削除
		remove_filter('update_footer', 'core_update_footer');
		return;
	}
	// 編集者（ネクシス運営）
	if (current_user_can('editor')) {
		// メインメニューの非表示
		remove_menu_page('index.php');					// ダッシュボード
		remove_menu_page('edit.php');					// 投稿
//		remove_menu_page('upload.php');					// メディア
		remove_menu_page('edit.php?post_type=page');	// 固定ページ
		remove_menu_page('edit-comments.php' );			// コメント
//		remove_menu_page('themes.php' );				// 外観（非表示）
//		remove_menu_page('plugins.php' );				// プラグイン（非表示）
		remove_menu_page('tools.php' );					// ツール
//		remove_menu_page('options-general.php' );		// 設定（非表示）
// サブメニューの非表示
		remove_submenu_page('edit.php?post_type=lecture', 'post-new.php?post_type=lecture');	// 市民公開講座 / 新規投稿
		remove_submenu_page('upload.php', 'upload.php');										// メディア / ライブラリ
		remove_submenu_page('upload.php', 'media-new.php');										// メディア / 新規追加
		// バージョン情報の削除
		remove_filter('update_footer', 'core_update_footer');
		return;
	}
	// 管理者（開発者）
	if (current_user_can('administrator')) {
		add_menu_page('page_title', 'ダウンロード', 'upload_files', 'lecture-export', 'my_lectue_download', 'dashicons-download', 8);
		return;
	}
}

/*
	管理画面の管理バー機能を制限する
*/
add_action('admin_bar_menu', 'my_remove_admin_bar_menus', 999);
function my_remove_admin_bar_menus($wp_admin_bar)
{
	// 投稿者（小倉記念病院）
	if (current_user_can('author')) {
		$wp_admin_bar->remove_menu('wp-logo');			// WordPressロゴ
	    $wp_admin_bar->remove_menu('dashboard');		// サイト情報 / ダッシュボード
		$wp_admin_bar->remove_menu('comments');			// コメント
		$wp_admin_bar->remove_menu('new-content');		// 新規投稿
		$wp_admin_bar->remove_menu('search');			// 検索
	}
	// 編集者（ネクシス運営）
	if (current_user_can('editor')) {
		$wp_admin_bar->remove_menu('wp-logo');			// WordPressロゴ
	    $wp_admin_bar->remove_menu('dashboard');		// サイト情報 / ダッシュボード
		$wp_admin_bar->remove_menu('comments');			// コメント
		$wp_admin_bar->remove_menu('new-content');		// 新規投稿
		$wp_admin_bar->remove_node('edit');				// 固定ページを編集
		$wp_admin_bar->remove_menu('archive');			// 投稿一覧を表示
		$wp_admin_bar->remove_menu('search');			// 検索
	}
}

/*
	市民公開講座のCSVダウンロード
*/
function my_lectue_download()
{
	require_once('functions/lecture-export.php');
	if (defined('DB_NAME_LECTURE')) {
		showLectureOptionsPage();
	} else {
		echo "error: DB_NAME_LECTURE が未定義です";
	}
}


/* PDFアップロード（カスタム） */
add_action('admin_menu', 'create_custom_fields_pdfup');
function create_custom_fields_pdfup()
{
    add_meta_box(
        'sample_setting',		//HTML ID
        'create_pdfup',			//HTML出力する関数
        CUSTOM_POST_TYPE_PDFUP	//カスタム投稿タイプ名
    );
}

/* お知らせ（カスタム） */
add_action('admin_menu', 'create_custom_fields_news');
function create_custom_fields_news()
{
    add_meta_box(
        'sample_setting',		//HTML ID
        'create_news',			//HTML出力する関数
        CUSTOM_POST_TYPE_NEWS	//カスタム投稿タイプ名
    );
}

/* 各処理実行 */
add_action('save_post', 'do_update_action');
function do_update_action()
{
	$post_type = "";
	if(isset($_POST['post_type'])){
		$post_type = $_POST['post_type'];
	} else {
		//処理なし
		return;
	}

	//PDFアップロード、お知らせ以外の場合
	if ($post_type != CUSTOM_POST_TYPE_PDFUP && $post_type != CUSTOM_POST_TYPE_NEWS){
		//処理なし
		return;
	}

	//PDFアップロードの場合
	if ($post_type == CUSTOM_POST_TYPE_PDFUP){
		create_pdf_url_file();
	//お知らせの場合
	} else if ($post_type == CUSTOM_POST_TYPE_NEWS) {
		create_info_list('');
	}
}

/* お知らせ非表示（ゴミ箱に移動） */
add_action('wp_trash_post', 'do_delete_action' );
function do_delete_action($post_id)
{
	$post_type = get_post_type($post_id);
	//お知らせ以外の場合
	if ($post_type != CUSTOM_POST_TYPE_NEWS){
		//処理なし
		return;
		
	//お知らせの場合
	} else if ($post_type == CUSTOM_POST_TYPE_NEWS) {
		create_info_list($post_id);
	}
}

/* PDFアップロード（選択肢の取得） */
add_filter('acf/load_field/name=pdfup-select', 'acf_load_faq_category_field_choices');
function acf_load_faq_category_field_choices( $field ) {
    $field['choices'] = array("未選択");
    $args = array(
		'posts_per_page' 	=> PDFUP_LIST_COUNT,	//指定件数を取得
		'post_type' 		=> 'attachment',
		'post_mime_type' 	=> 'application/pdf',
		'orderby' 			=> 'post_title',		//ファイル名の昇順
		'order' 			=> 'DESC'
	);
    $choices = get_posts($args);

    foreach($choices as $choice):
        array_push($field['choices'], $choice -> post_title);
    endforeach;
 
    return $field;
}

/* Wysiwygエディタの項目カスタマイズ */
add_filter('acf/fields/wysiwyg/toolbars' , 'my_acf_toolbars');
function my_acf_toolbars($toolbars) {
	// ツールバーに「kokura」を追加
	$toolbars['kokura'] = array();
	$toolbars['kokura'][1] = array(  //「kokura」に表示するボタン一覧
		'bold', 		//太字
		'italic', 		//斜体
		'underline',	//下線
		'forecolor'		//文字色
	);
  
	return $toolbars;
}


//---------------------------------------
//ビジュアルエディタ無効にする
//---------------------------------------
function disable_visual_editor_in_page() {
	global $typenow;
	if($typenow == "reply-type"){  //条件にしたい投稿タイプ名 post/page/カスタム投稿名
		add_filter("user_can_richedit", "disable_visual_editor_filter");
	}
}

function disable_visual_editor_filter(){
	return false;
}
add_action("load-post.php", "disable_visual_editor_in_page");   //編集画面で無効に
add_action("load-post-new.php", "disable_visual_editor_in_page"); //新規投稿画面で無効に

//デフォルトクイックタグ全て非表示
function remove_html_editor_buttons( $qt_init) {
	global $typenow;
	if($typenow == "reply-type"){  //条件にしたい投稿タイプ名 post/page/カスタム投稿名
		$qt_init["buttons"] = ",";
		return $qt_init;
	}
}
add_filter( 'quicktags_settings', 'remove_html_editor_buttons' );
?>
