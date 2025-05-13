<?php

// カスタム投稿を追加
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
		register_post_type( 'seminar', [
			'labels' => [
				'name'			=> '市民公開講座',
				'singular_name'	=> 'seminar',
			],
			'public'			=> true,
			'has_archive'		=> true,
			'menu_position'		=> 5,
		]);
	}

// 管理画面（seminar）：投稿一覧をカスタムフィールドの開催日（seminar-date）で並びかえる
	add_action( 'pre_get_posts', 'custom_post_sort' );
	function custom_post_sort( $query ) {
		if ( ! $query->is_main_query() ) 
			return;

		elseif ( is_admin()
		 && ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'seminar' ) ) {
			$query->set( 'meta_key', 'seminar-date' );
	    	$query->set( 'orderby', 'meta_value_num' );
	    	$query->set( 'order', 'DESC' );
		}

	}

// 【管理画面】市民公開講座へボックス追加
function my_meta_box()
{
	add_meta_box('my_meta_box_export', 'CSVファイル出力', 'my_meta_box_export', 'seminar', 'side', 'low');
	// 開催日翌日以降に出現する
	if (true) {
		add_meta_box('my_meta_box_delete', '申込情報の削除', 'my_meta_box_delete', 'seminar', 'side', 'low');
	}
}
add_action('admin_menu', 'my_meta_box');

function my_meta_box_export()
{
	echo '<div id="preview-action">' . "\n";
	echo '<a class="preview button" href="#">ダウンロード</a>' ."\n";
	echo '</div>' . "\n";

	echo '<div class="misc-pub-section">';
	echo '申込数： 100 / 500<br />';
	echo '</div>' . "\n";
}

function my_meta_box_delete()
{
	echo '<div class="tagsdiv">';
	echo '<div class="ajaxtag">';
	echo '<input type="password" class="newtag form-input-tip ui-autocomplete-input" size="16" autocomplete="off" value="" placeholder="パスワード">';
	echo '<input type="button" class="button tagadd" value="実行">';
	echo '</div>';
	echo '<p class="howto" style="color:#a00">※データベースから完全に削除されます</p>';
	echo '</div>';
}

// 管理画面のメニューを制限する
function remove_menus()
{
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
		remove_submenu_page('edit.php?post_type=seminar', 'post-new.php?post_type=seminar');	// 市民公開講座＞新規投稿
	}
	
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
		remove_menu_page('edit.php?post_type=seminar');	// カスタム投稿ページ
		// サブメニューの非表示
//		remove_submenu_page('edit.php?post_type=seminar', 'post-new.php?post_type=seminar');	// 市民公開講座＞新規投稿
		add_menu_page('page_title', 'ダウンロード', 'upload_files', __FILE__, 'my_function', 'dashicons-download', 8);


	}
		add_menu_page('page_title', 'ダウンロード', 'upload_files', __FILE__, 'my_function', 'dashicons-download', 8);
	//	add_menu_page('CSVエクスポート', 'CSVエクスポート', 'manage_options', __FILE__, 'show_options_page');
}

add_action('admin_menu', 'remove_menus');

function my_function()
{
	get_template_part('functions/csv-export');
	show_options_page();
}

?>

