<?php
	function showLectureOptionsPage()
	{
		// 申し込みデータの削除
		if (!empty($_POST['delete_id'])) {
			removeLectureEntry($_POST['delete_id']);
		}
		// ユーザーエージェントの判別
		$user_agent = 'Unknown';
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh')) {
			$user_agent = 'Macintosh';
		}
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows')) {
			$user_agent = 'Windows';
		}
		// エクスポート時の POST先 URL
		$action = get_template_directory_uri() . '/functions/lecture-output.php';
		// CSRF対策コード
		$csrf = md5(date("Ymd"));
		// 申込データに存在し、申込期間内の投稿をリスト対象とする。
		$options = array();
		$removable = array();
		$list = getLectureEntryList();
		$args = array(
			'post_status' => 'publish',
			'post_type' => 'lecture',
			'posts_per_page' => 100,
			'orderby' => 'meta_value',
			'meta_key' => 'lecture-date',
			'order' => 'ASC'
		);
		$posts = get_posts($args);
		foreach ($posts as $post) {
			if (array_key_exists($post->ID, $list)) {
				$lecture_date = getLectureDate($post->ID);
				$options[] = array(
					'value' => $post->ID,
					'text' => $lecture_date . " 「" . $post->post_title . "」 " . $list[$post->ID] . "名",
				);
				if (!canLectureEntry($post->ID)) {
					$removable[] = $post->ID;
				}
			}
		}
?>
		<div class="wrap">
			<h2>市民公開講座 CSVダウンロード</h2>
			<?php if (!empty($_POST['delete_title'])): ?>
			<div id="message" class="updated notice is-dismissible">
				<p>申し込みデータを削除しました</p>
				<button type="button" class="notice-dismiss"></button>
			</div>
			<?php endif; ?>
			<form action="<?php echo $action; ?>" method="post" name="form_export" onsubmit="return checkSubmit()">
				<input type="hidden" name="csrf" value="<?php echo $csrf; ?>" />
				<input type="hidden" name="user_agent" value="<?php echo $user_agent; ?>" />
				<?php wp_nonce_field('csv_export');?>
				<table class="form-table tools-privacy-policy-page">
					<tr>
						<th scope="row"><label for="inputtext">市民公開講座のタイトル</label></th>
						<td>
							<select id="lecture" name="lecture_name" class="regular-text">
							<?php foreach ($options as $option): ?>
								<option class="hoge" data-hage="0" value="<?php echo $option['value']; ?>"><?php echo $option['text']; ?></option>
							<?php endforeach; ?>
							</select>
							<input type="submit" class="button button-primary" value="エクスポート" onclick="clickExport()" />
							<input id="submit_delete" type="submit" class="button" value="削除" onclick="clickDelete()" />
						</td>
					</tr>
				</table>
			</form>
			<form name="form_delete" action="" method="post">
				<input type="hidden" name="delete_id" value="0" />
				<input type="hidden" name="delete_title" value="-" />
			</form>
			<br>
			<script>
			var removable = [<?php echo implode(",", $removable); ?>];
			var submitAction = "";
			var enableButton = false;
			function clickExport()
			{
				submitAction = "export";
			}
			function clickDelete()
			{
				submitAction = "delete";
			}
			function checkSubmit()
			{
				if (submitAction == "export") {
					return true;
				}
				if (submitAction == "delete") {
					if (!enableButton) {
						document.getElementById("submit_delete").classList.add("button-primary");
						enableButton = true;
					} else {
						let object = document.getElementById("lecture");
						let post_id = parseInt(object.options[object.selectedIndex].value);
						let delete_title = object.options[object.selectedIndex].text;
						if (removable.indexOf(post_id) >= 0){
							if (window.confirm("次の申し込みデータを削除します。よろしいですか？\n" + delete_title)) {
								document.form_delete["delete_id"].value = post_id;
								document.form_delete["delete_title"].value = delete_title;
								document.form_delete.submit();
								return false;
							}
						} else {
							alert("申込受付中のデータは削除できません");
						}
					}
					return false;
				}
			}
			</script>
		</div>
<?php
	}

/*
	申込データの削除
*/
function removeLectureEntry($post_id)
{
	// データベースへの接続 (kokurakinen_data)
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME_LECTURE);
	if (!$link) {
		throw new Exception('☆データベース接続失敗' . mysqli_connect_error());
	}
	
	// 削除フラグの更新
	mysqli_query($link, 'UPDATE t_lecture SET remove=1 WHERE post_id=' . $post_id);
	
	// データベースへの接続解除
	mysqli_close($link);
}

/*
	市民公開講座の一覧取得（申込数が1件以上の講座のみ）
*/
function getLectureEntryList()
{
	$list = array();
	
	// データベースへの接続 (kokurakinen_data)
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME_LECTURE);
	if (!$link) {
		throw new Exception('☆データベース接続失敗' . mysqli_connect_error());
	}
	
	// テーブルの取得
	if ($rows = mysqli_query($link, 'SELECT post_id FROM t_lecture WHERE remove=0')) {
		while ($row = mysqli_fetch_assoc($rows)) {
			$post_id = $row['post_id'];
			if (array_key_exists($post_id, $list)) {
				$list[$post_id]++;
			} else {
				$list[$post_id] = 1;
			}
		}
		mysqli_free_result($rows);
	}
	
	// データベースへの接続解除
	mysqli_close($link);
	
	return $list;
}

?>
