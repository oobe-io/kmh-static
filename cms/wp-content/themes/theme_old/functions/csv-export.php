<?php
	function show_options_page()
	{
		$action = plugin_dir_url(__FILE__) . 'file-output.php';
		$csrf = md5(date("Ymd"));
?>
		<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div><h2>申込データCSVエクスポート</h2>
			<form action="<?php echo $action; ?>" method="post" name="form_exp" >
				<input type="hidden" name="csrf" value="<?php echo $csrf; ?>" /><br>
				<?php wp_nonce_field('csv_export');?>
				<table class="form-table1">
					<tr>
						<?php 
							// 申込データに存在し、申込期間内の投稿をリスト対象とする。
							$plist = array();
							$plist = getRequestDataList();
							$week = array("日", "月", "火", "水", "木", "金", "土");
							$args = array('post_status' => 'publish', 'post_type' => 'seminar', 'posts_per_page' => 100);
							$customPosts = get_posts($args);
							$rows = array();
							foreach ($customPosts as $post) {
								setup_postdata($post);
								if(in_array($post->ID, $plist)) {
									$date = date_create(get_field('seminar-date',$post->ID));
									$row = array();
									$row['postid'] = $post->ID;
									$row['title'] = get_the_title($post->ID);
									$row['pdate'] = $date;
									$rows[] = $row;
								}
							}
							
							foreach ((array) $rows as $key => $value) {
								$sort[$key] = $value['pdate'];
							}
							if (count($rows) > 0){
								array_multisort($sort, SORT_ASC, $rows);
							}
						?>
						<th scope="row"><label for="inputtext">セミナータイトル</label></th>
						<td>
							<select name="seminar_name" class="regular-text" onChange="sethpostid()">
								<?php foreach ($rows as $row) {
									$post_year = date_format($row['pdate'],'Y');
									$post_month = date_format($row['pdate'],'n');
									$post_day = date_format($row['pdate'],'j');
									$post_week = $week[(int)date_format($row['pdate'],'w')];
									$post_date = $post_year .'年' . $post_month .'月' . $post_day .'日（' .$post_week .'）';
								?>
								<option value="<?php echo $row['postid']; ?>"><?php echo $row['title']. "　" .$post_date; ?></option>
								<?php }?>
							</select>
						</td>
					</tr>
				</table>
				<p class="submit"><input type="submit" class="button-primary" value="エクスポート" /></p>
			</form>
			<br>			
			<form action="" method="post" name="form_del" >
				<table class="form-table2">
					<tr>
						<th scope="row"><label for="inputtext">パスワード</label></th>
						<td>
							<input type="password" name="user_pass" value="" ><br>
						</td>
					</tr>
				</table>
				<p class="submit"><input type="submit" name="submit" class="button-primary" value="削除" /></p>
				<input type="hidden" name="hpostid" value="<?php echo $rows[0]['postid']; ?>" /><br>
			</form>
			<script>
				// form_expの講座申込時にform_delのhiddenへ保持
				function sethpostid(){
					obj = document.form_exp.seminar_name;
					index = obj.selectedIndex;
					href = obj.options[index].value;
					document.form_del.hpostid.value = href;
				}
			</script>
<?php result(); ?>
		</div>
<?php
	}
	
	// 削除処理
function result()
{
	if(isset($_POST['submit'])){
		// 処理メッセージ表示（エラーメッセージ含む）
		echo "<hr />";
		if(isset($_POST['hpostid']) && $_POST['hpostid'] != "")
		{
			if(isset($_POST['user_pass']) && $_POST['user_pass'] != "")
			{
				try {
					$result = post_del($_POST['hpostid']);
					echo "<p>データの削除が完了しました。</p>";
				} catch (Exception $ex) {
					printf("<p>%s</p>", $ex->getMessage());
				}
			} else {
				echo "<p>パスワードを入力してください。</p>";
			}
		} else {
			echo "<p>セミナー名を選択してください。</p>";
		}
	}
}

require_once(dirname( __FILE__ ) . '/../../../../wp-load.php');

// 申込データの削除
// 条件：パスワード一致且つ申込期間外
function post_del($postid)
{
	global $wpdb;
	$user = wp_get_current_user();
	if ( !wp_check_password( $_POST['user_pass'], $user->user_pass, $user->ID ) ) {
		throw new Exception("パスワードが正しくありません。");
	}
	
	$today = current_time("Y/m/d H:i");
	$start = get_field('seminar-start',$postid);
	$end = get_field('seminar-end',$postid);

	if(strtotime($today) >= strtotime("$start 00:00") && strtotime("$end 23:59") >= strtotime($today)){
		throw new Exception("申込期間中のため、申込データは削除できません。");
	}
	
	$another_db = new wpdb(DB_USER, DB_PASSWORD, DB_NAME . '2', DB_HOST);
	$another_db->delete( 't_seminar', array( 'post_id' => $postid ) );
}

// 投稿一覧生成用取得
// ※申込データが存在している講座を対象とするため
// 戻り値は投稿IDリスト
function getRequestDataList()
{
	global $wpdb;
	$postlist = array();
	
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, /* DB_NAME */ 'kokurakinen_data');
	if (mysqli_connect_errno()) {
		throw new Exception('接続失敗です。'.mysqli_error());
	}

	$db_rows = mysqli_query($link, 'SELECT post_id FROM  t_seminar');
	if (!$db_rows) {
		return $postlist;
	}
	
	while ($row = mysqli_fetch_assoc($db_rows)) {
		$postlist[] = $row['post_id'];
	}

	return $postlist;
}

?>
