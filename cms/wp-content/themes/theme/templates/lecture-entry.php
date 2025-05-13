<?php
/*
Template Name: lecture-entry
Description: 市民公開講座の参加申し込み入力画面
*/

// 引数から投稿IDを取得する
$state = 0;
if (isset($_GET['id'])) {
	$post_id = $_GET['id'];
	// 申し込みが可能な場合、講座情報の取得
	if (canLectureEntry($post_id)) {
		$post_title = get_the_title($post_id);
		$post_date = getLectureDate($post_id);
		$post_venue = get_field('lecture-venue', $post_id);
		$state = 1; // 入力画面
	}
}

// POST処理の場合
$clean = array();
$error = array();
if (!empty($_POST)) {
	// サニタイジング（無害化）
	foreach ($_POST as $key => $value) {
		$text = stripslashes($value);
		$clean[$key] = htmlspecialchars(trim($text), ENT_QUOTES);
	}
	// 入力画面から遷移した場合、バリデーションチェックの実施
	if (!empty($clean['btn_confirm'])) {
		$error = checkLectureValidation($clean);
		if (empty($error)) {
			$state = 2; // 確認画面
		}
	}
}

// page遷移時の事前処理判定
?>
<?php get_header('lecture'); ?>
	<section id="main">
		<div class="breadcrumbs">
			<a href="/">ホーム</a>
			＞
			<a href="/lecture/">市民公開講座・勉強会・研究会のご案内</a>
			＞
			<a href="/lecture/list/">市民公開講座</a>
			＞
			<strong>参加申し込みフォーム</strong>
		</div>
		<article>
			<hgroup>
				<h1 class="slim">市民公開講座</h1>
				<small>Lecture</small>
			</hgroup>
			<section class="form_wrap">
				<?php if ($state != 0): ?>
				<div class="form_head">
					<h2>市民公開講座<br class="sp">「<?php echo $post_title; ?>」</h2>
					<p><span>開催日：<?php echo $post_date; ?></span><span>会場：<?php echo $post_venue; ?></span></p>
				</div>
				<?php endif; ?>
				<?php if ($state == 1): /* 入力画面 */ ?>
				<div class="form_message">
					<p class="form_message_att">同時に2名まで申し込みができます。<span class="required">＊</span>は必須項目です。</p>
					<p>
						※メールアドレスをお持ちでない方は、往復ハガキに①講座名 ②氏名 ③住所 ④年齢 ⑤電話番号をご明記し下記までご郵送ください。<br>
						〒802-0001 北九州市小倉北区浅野3-2-1 「一般財団法人平成紫川会 事務局」宛
					</p>
				</div>
				<form method="post" action="" class="form_input" name="form_input">
					<table class="form">
						<caption>参加者１の基本情報</caption>
						<tr>
							<th>氏名<span class="required">＊</span></th>
							<td class="form_input_name">
								<span>姓　</span>
								<input type="text" id="last_name1" name="last_name1" value="<?php if( !empty($clean['last_name1']) ){ echo $clean['last_name1']; } ?>" class="name" >&ensp;
								<span>名　</span>
								<input type="text" id="first_name1" name="first_name1" value="<?php if( !empty($clean['first_name1']) ){ echo $clean['first_name1']; } ?>" class="name" >&ensp;&ensp;
								<br class="sp">
									<label for="gender_male"><input id="gender_male" type="radio" name="gender1" value="male" <?php if( !empty($clean['gender1']) && $clean['gender1'] === "male" ){ echo 'checked'; } ?>>男性</label>&nbsp;
									<label for="gender_female"><input id="gender_female" type="radio" name="gender1" value="female" <?php if( !empty($clean['gender1']) && $clean['gender1'] === "female" ){ echo 'checked'; } ?>>女性</label>&ensp;&ensp;
								<input type="tel" name="age1" value="<?php if( !empty($clean['age1']) ){ echo $clean['age1']; } ?>" class="w60" >&ensp;<span>歳</span>
								<br>
								<span>セイ</span>
								<input type="text" id="kana_last_name1" name="kana_last_name1" value="<?php if( !empty($clean['kana_last_name1']) ){ echo $clean['kana_last_name1']; } ?>" class="name" >&ensp;
								<span>メイ</span>
								<input type="text" id="kana_first_name1" name="kana_first_name1" value="<?php if( !empty($clean['kana_first_name1']) ){ echo $clean['kana_first_name1']; } ?>" class="name" >&ensp;&ensp;
								<p class="error_message" <?php if(in_array('err1_last_name1', $error)){ echo 'style="display: block"'; } ?>>＊「姓」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_first_name1', $error)){ echo 'style="display: block"'; } ?>>＊「名」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_kana_last_name1', $error)){ echo 'style="display: block"'; } ?>>＊「セイ」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_kana_last_name1', $error)){ echo 'style="display: block"'; } ?>>＊「セイ」は全角カタカナで入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_kana_first_name1', $error)){ echo 'style="display: block"'; } ?>>＊「メイ」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_kana_first_name1', $error)){ echo 'style="display: block"'; } ?>>＊「メイ」は全角カタカナで入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_gender1', $error)){ echo 'style="display: block"'; } ?>>＊「性別」は必ず選択してください。</p>
								<p class="error_message" <?php if(in_array('err1_age1', $error)){ echo 'style="display: block"'; } ?>>＊「年齢」は半角数字で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>郵便番号<span class="required">＊</span></th>
							<td>
								<input type="tel" name="postno1_1" value="<?php if( !empty($clean['postno1_1']) ){ echo $clean['postno1_1']; } ?>" class="w60" >
								-
								<input type="tel" name="postno1_2" value="<?php if( !empty($clean['postno1_2']) ){ echo $clean['postno1_2']; } ?>" class="w60" >
								<button type="button" class="js-button">住所の自動入力</button>
								<p class="error_message" <?php if(in_array('err1_postno1', $error)){ echo 'style="display: block"'; } ?>>＊「郵便番号」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_postno1', $error)){ echo 'style="display: block"'; } ?>>＊「郵便番号」は半角数字で入力してください。</p>
								<p class="error_message" <?php if(in_array('err3_postno1', $error)){ echo 'style="display: block"'; } ?>>＊「郵便番号」は3桁と4桁で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>住所<span class="required">＊</span></th>
							<td>
								<input type="text" name="address1" value="<?php if( !empty($clean['address1']) ){ echo $clean['address1']; } ?>" class="address" >
								<p class="error_message" <?php if(in_array('err1_address1', $error)){ echo 'style="display: block"'; } ?>>＊「住所」は必ず入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>電話番号<span class="required">＊</span></th>
							<td>
								<input type="tel" name="telno1_1" value="<?php if( !empty($clean['telno1_1']) ){ echo $clean['telno1_1']; } ?>" class="w60" >
								-
								<input type="tel" name="telno1_2" value="<?php if( !empty($clean['telno1_2']) ){ echo $clean['telno1_2']; } ?>" class="w60" >
								-
								<input type="tel" name="telno1_3" value="<?php if( !empty($clean['telno1_3']) ){ echo $clean['telno1_3']; } ?>" class="w60" >
								<p class="error_message" <?php if(in_array('err1_telno1', $error)){ echo 'style="display: block"'; } ?>>＊「電話番号」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_telno1', $error)){ echo 'style="display: block"'; } ?>>＊「電話番号」は半角数字で入力してください。</p>
								<p class="error_message" <?php if(in_array('err3_telno1', $error)){ echo 'style="display: block"'; } ?>>＊「電話番号」は11文字以内で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>メールアドレス<span class="required">＊</span></th>
							<td>
								<input type="email" name="email1" value="<?php if( !empty($clean['email1']) ){ echo $clean['email1']; } ?>" class="email" ><br>
								<span>＊携帯アドレス推奨。当日の受付は送信されたメールをご提示するだけで入場できます。</span>
								<p class="error_message" <?php if(in_array('err1_email1', $error)){ echo 'style="display: block"'; } ?>>＊「メールアドレス」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_email1', $error)){ echo 'style="display: block"'; } ?>>＊「メールアドレス」は正しい形式で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>メールアドレス（確認）<span class="required">＊</span></th>
							<td>
								<input type="email" name="email_confirm1" value="<?php if( !empty($clean['email_confirm1']) ){ echo $clean['email_confirm1']; } ?>" class="email" >
								<p class="error_message" <?php if(in_array('err1_email_confirm1', $error)){ echo 'style="display: block"'; } ?>>＊「メールアドレス（確認）」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_email_confirm1', $error)){ echo 'style="display: block"'; } ?>>＊メールアドレスが一致しません。</p>
							</td>
						</tr>
						</table>
						<table class="form">
						<caption>参加者２の基本情報</caption>
						<tr>
							<th>氏名</th>
							<td class="form_input_name">
								<span>姓　</span>
								<input type="text" id="last_name2" name="last_name2" value="<?php if( !empty($clean['last_name2']) ){ echo $clean['last_name2']; } ?>" class="name" >&ensp;
								<span>名　</span>
								<input type="text" id="first_name2" name="first_name2" value="<?php if( !empty($clean['first_name2']) ){ echo $clean['first_name2']; } ?>" class="name" >&ensp;&ensp;
								<br class="sp">
								<label for="gender_male2"><input id="gender_male2" type="radio" name="gender2" value="male" <?php if( !empty($clean['gender2']) && $clean['gender2'] === "male" ){ echo 'checked'; } ?>>男性</label>&nbsp;
								<label for="gender_female2"><input id="gender_female2" type="radio" name="gender2" value="female" <?php if( !empty($clean['gender2']) && $clean['gender2'] === "female" ){ echo 'checked'; } ?>>女性</label>&ensp;&ensp;
								<input type="tel" name="age2" value="<?php if( !empty($clean['age2']) ){ echo $clean['age2']; } ?>" class="w60" >&ensp;<span>歳</span>
								<br>
								<span>セイ</span>
								<input type="text" id="kana_last_name2" name="kana_last_name2" value="<?php if( !empty($clean['kana_last_name2']) ){ echo $clean['kana_last_name2']; } ?>" class="name" >&ensp;
								<span>メイ</span>
								<input type="text" id="kana_first_name2" name="kana_first_name2" value="<?php if( !empty($clean['kana_first_name2']) ){ echo $clean['kana_first_name2']; } ?>" class="name" >&ensp;&ensp;
								<p class="error_message" <?php if(in_array('err1_last_name2', $error)){ echo 'style="display: block"'; } ?>>＊「姓」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_first_name2', $error)){ echo 'style="display: block"'; } ?>>＊「名」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_kana_last_name2', $error)){ echo 'style="display: block"'; } ?>>＊「セイ」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_kana_last_name2', $error)){ echo 'style="display: block"'; } ?>>＊「セイ」は全角カタカナで入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_kana_first_name2', $error)){ echo 'style="display: block"'; } ?>>＊「メイ」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_kana_first_name2', $error)){ echo 'style="display: block"'; } ?>>＊「メイ」は全角カタカナで入力してください。</p>
								<p class="error_message" <?php if(in_array('err1_gender2', $error)){ echo 'style="display: block"'; } ?>>＊「性別」は必ず選択してください。</p>
								<p class="error_message" <?php if(in_array('err1_age2', $error)){ echo 'style="display: block"'; } ?>>＊「年齢」は半角数字で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>住所について</th>
							<td>
								<label><input id="user_check" type="checkbox" name="user_check" value="1" <?php if( !empty($clean['user_check']) ){ echo "checked"; } ?> onclick="update(this);">参加者1と同じ</label>&ensp;&ensp;
								<br class="sp"><span>※参加者1と同じ場合は、郵便番号・住所の入力は必要ありません。</span>
							</td>
						</tr>
						<tr>
							<th>郵便番号</th>
							<td>
								<input type="tel" id="postno2_1" name="postno2_1" value="<?php if( !empty($clean['user_check'])){ echo "" ; } elseif( !empty($clean['postno2_1']) ){ echo $clean['postno2_1']; } ?>" class="w60" <?php if( !empty($clean['user_check'])){ echo "disabled" ; }?>>
								-
								<input type="tel" id="postno2_2" name="postno2_2" value="<?php if( !empty($clean['user_check'])){ echo "" ; } elseif( !empty($clean['postno2_2']) ){ echo $clean['postno2_2']; } ?>" class="w60" <?php if( !empty($clean['user_check'])){ echo "disabled" ; }?>>
								<button type="button" class="js-button2">住所の自動入力</button>
								<p class="error_message" <?php if(in_array('err1_postno2', $error)){ echo 'style="display: block"'; } ?>>＊「郵便番号」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_postno2', $error)){ echo 'style="display: block"'; } ?>>＊「郵便番号」は半角数字で入力してください。</p>
								<p class="error_message" <?php if(in_array('err3_postno2', $error)){ echo 'style="display: block"'; } ?>>＊「郵便番号」は3桁と4桁で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>住所</th>
							<td>
								<input type="text" id="address2" name="address2" value="<?php if( !empty($clean['user_check'])){ echo "" ; } elseif( !empty($clean['address2']) ){ echo $clean['address2']; } ?>" class="address2" <?php if( !empty($clean['user_check'])){ echo "disabled" ; }?>>
								<p class="error_message" <?php if(in_array('err1_address2', $error)){ echo 'style="display: block"'; } ?>>＊「住所」は必ず入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>電話番号</th>
							<td>
								<input type="tel" name="telno2_1" value="<?php if( !empty($clean['telno2_1']) ){ echo $clean['telno2_1']; } ?>" class="w60" >
								-
								<input type="tel" name="telno2_2" value="<?php if( !empty($clean['telno2_2']) ){ echo $clean['telno2_2']; } ?>" class="w60" >
								-
								<input type="tel" name="telno2_3" value="<?php if( !empty($clean['telno2_3']) ){ echo $clean['telno2_3']; } ?>" class="w60" >
								<p class="error_message" <?php if(in_array('err1_telno2', $error)){ echo 'style="display: block"'; } ?>>＊「電話番号」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_telno2', $error)){ echo 'style="display: block"'; } ?>>＊「電話番号」半角数字で入力してください。</p>
								<p class="error_message" <?php if(in_array('err3_telno2', $error)){ echo 'style="display: block"'; } ?>>＊「電話番号」11文字以内で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>メールアドレス</th>
							<td>
								<input type="email" name="email2" value="<?php if( !empty($clean['email2']) ){ echo $clean['email2']; } ?>" class="email" >
								<p class="error_message" <?php if(in_array('err1_email2', $error)){ echo 'style="display: block"'; } ?>>＊「メールアドレス」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_email2', $error)){ echo 'style="display: block"'; } ?>>＊「メールアドレス」は正しい形式で入力してください。</p>
							</td>
						</tr>
						<tr>
							<th>メールアドレス（確認）</th>
							<td>
								<input type="email" name="email_confirm2" value="<?php if( !empty($clean['email_confirm2']) ){ echo $clean['email_confirm2']; } ?>" class="email" ><br>
								<span>＊携帯アドレス推奨。当日の受付は送信されたメールをご提示するだけで入場できます。</span>
								<p class="error_message" <?php if(in_array('err1_email_confirm2', $error)){ echo 'style="display: block"'; } ?>>＊「メールアドレス（確認）」は必ず入力してください。</p>
								<p class="error_message" <?php if(in_array('err2_email_confirm2', $error)){ echo 'style="display: block"'; } ?>>＊メールアドレスが一致しません。</p>
							</td>
						</tr>
					</table>
					<table class="form">
						<caption>小倉記念病院からのお知らせ</caption>
						<tr>
							<th>小倉記念病院からのお知らせを希望しますか？</th>
							<td>
								<label for="dm_yes"><input id="dm_yes" type="radio" name="dm" value="yes" <?php if( !empty($clean['dm']) && $clean['dm'] === "yes" || empty($clean['dm'])){ echo 'checked'; } ?>>はい</label>&nbsp;
								<label for="dm_no"><input id="dm_no" type="radio" name="dm" value="no" <?php if( !empty($clean['dm']) && $clean['dm'] === "no" ){ echo 'checked'; } ?>>いいえ</label>
							</td>
						</tr>
					</table>
					<table class="form">
						<caption>先生へ質問</caption>
						<tr>
							<th>先生へ質問</th>
							<td>
								講演の最後に質問への回答コーナーを予定しています。<br>
								お時間の都合上質問が採用されない場合もありますのでご了承ください。※最大300文字<br>
								<textarea name="question" rows="5" cols="96" maxlength="300" ><?php if( !empty($clean['question']) ){ echo $clean['question']; } ?></textarea>
							</td>
						</tr>
					</table>
					<div class="form_btn">
						<input type="submit" name="btn_confirm" value="入力内容を確認する" class="btn_confirm" style="color:#000000;">
						<input type="hidden" name="title" value="<?php echo $post_title; ?>">
						<input type="hidden" name="event_date" value="<?php echo $post_date; ?>">
						<input type="hidden" name="venue" value="<?php echo $post_venue; ?>">
					</div>
				</form>
				<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/ajaxzip3.js" charset="UTF-8"></script>
				<script>
					$(function() {
						$('.js-button').click(function(){
							AjaxZip3.zip2addr('postno1_1', 'postno1_2', 'address1', 'address1');
							//成功
							AjaxZip3.onSuccess = function() {
								setTimeout(function() {
									$('.address1').focus();
								},10);
							};
							//失敗
							AjaxZip3.onFailure = function() {
								alert('郵便番号に該当する住所が見つかりません');
							};
						});
						$('.js-button2').click(function(){
							AjaxZip3.zip2addr('postno2_1', 'postno2_2', 'address2', 'address2');
							//成功
							AjaxZip3.onSuccess = function() {
								setTimeout(function() {
									$('.address2').focus();
								},10);
							};
							//失敗
							AjaxZip3.onFailure = function() {
								alert('郵便番号に該当する住所が見つかりません');
							};
						});
					 });
				</script>
				<script type="text/javascript">
					/* 住所が参加者1と同じ場合の動作、入力値をクリア及び有効無効化 */
					function update(obj) {
						document.form_input.elements["postno2_1"].value = "";
						document.form_input.elements["postno2_2"].value = "";
						document.form_input.elements["address2"].value = "";
						document.form_input.elements["postno2_1"].disabled = obj.checked;
						document.form_input.elements["postno2_2"].disabled = obj.checked;
						document.form_input.elements["address2"].disabled = obj.checked;
					}
				</script>
				<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.autoKana.js"></script>
				<script>
				$(function() {
					// カナ自動入力
					$.fn.autoKana('#last_name1', '#kana_last_name1', {katakana : true});
					$.fn.autoKana('#first_name1', '#kana_first_name1', {katakana : true});
					$.fn.autoKana('#last_name2', '#kana_last_name2', {katakana : true});
					$.fn.autoKana('#first_name2', '#kana_first_name2', {katakana : true});
				});
				</script>
				<?php endif; ?>
				<br>
				<?php if ($state == 2): /* 確認画面 */ ?>
				<form name="form_confirm" method="post" action="" class="form_input">
					<table class="form">
						<caption>参加者１の基本情報</caption>
						<tr>
							<th>氏名</th>
							<td><?php echo $clean['last_name1'] . ' ' . $clean['first_name1']; ?></td>
						</tr>
						<tr>
							<th>シメイ</th>
							<td><?php echo $clean['kana_last_name1'] . ' ' . $clean['kana_first_name1']; ?></td>
						</tr>
						<tr>
							<th>性別</th>
							<td>
								<?php if ($clean['gender1'] == 'male')   echo '男性'; ?>
								<?php if ($clean['gender1'] == 'female') echo '女性'; ?>
							</td>
						</tr>
						<tr>
							<th>年齢</th>
							<td><?php echo $clean['age1']; ?>歳</td>
						</tr>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $clean['postno1_1'] . '-' . $clean['postno1_2']; ?></td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $clean['address1']; ?></td>
						</tr>
						<tr>
							<th>電話番号</th>
							<td><?php echo $clean['telno1_1'] . '-' . $clean['telno1_2'] . '-' . $clean['telno1_3']; ?>
							</td>
						</tr>
						<tr>
							<th>メールアドレス</th>
							<td><?php echo $clean['email1']; ?></td>
						</tr>
					</table>
					<?php if (!empty($clean['last_name2']) || !empty($clean['first_name2'])): ?>
					<table class="form">
						<caption>参加者２の基本情報</caption>
						<tr>
							<th>氏名</th>
							<td><?php echo $clean['last_name2'] . ' ' . $clean['first_name2']; ?></td>
						</tr>
						<tr>
							<th>シメイ</th>
							<td><?php echo $clean['kana_last_name2'] . ' ' . $clean['kana_first_name2']; ?></td>
						</tr>
						<tr>
							<th>性別</th>
							<td>
								<?php if ($clean['gender2'] == 'male')   echo '男性'; ?>
								<?php if ($clean['gender2'] == 'female') echo '女性'; ?>
							</td>
						</tr>
						<tr>
							<th>年齢</th>
							<td><?php echo $clean['age2']; ?>歳</td>
						</tr>
						<?php if (empty($clean['user_check'])): ?>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $clean['postno2_1'] . '-' . $clean['postno2_2']; ?></td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $clean['address2']; ?></td>
						</tr>
						<?php else: ?>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $clean['postno1_1'] . '-' . $clean['postno1_2']; ?></td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $clean['address1']; ?></td>
						</tr>
						<?php endif; ?>
						<tr>
							<th>電話番号</th>
							<td><?php echo $clean['telno2_1'] . '-' . $clean['telno2_2'] . '-' . $clean['telno2_3']; ?>
							</td>
						</tr>
						<tr>
							<th>メールアドレス</th>
							<td><?php echo $clean['email2']; ?></td>
						</tr>
					</table>
					<?php endif; ?>
					<table class="form">
						<caption>小倉記念病院からのお知らせ</caption>
						<tr>
							<th>お知らせ</th>
							<?php if ($clean['dm'] === "yes"): ?>
							<td>はい</td>
							<?php else: ?>
							<td>いいえ</td>
							<?php endif; ?>
							</td>
						</tr>
					</table>
					<table class="form">
						<caption>先生へ質問</caption>
						<tr>
						<th>先生へ質問</th>
							<td><?php echo nl2br(htmlspecialchars($clean['question'], ENT_QUOTES, 'UTF-8')); ?></td>
						</tr>
					</table>
					<div class="form_btn">
						<input type="submit" name="btn_back" value="入力画面へ戻る" class="btn_back">
						<input type="submit" name="btn_submit" value="送信する" onclick="goThanks()">
						<input type="hidden" name="last_name1" value="<?php echo $clean['last_name1']; ?>">
						<input type="hidden" name="first_name1" value="<?php echo $clean['first_name1']; ?>">
						<input type="hidden" name="kana_last_name1" value="<?php echo $clean['kana_last_name1']; ?>">
						<input type="hidden" name="kana_first_name1" value="<?php echo $clean['kana_first_name1']; ?>">
						<input type="hidden" name="gender1" value="<?php echo $clean['gender1']; ?>">
						<input type="hidden" name="age1" value="<?php echo $clean['age1']; ?>">
						<input type="hidden" name="postno1_1" value="<?php echo $clean['postno1_1']; ?>">
						<input type="hidden" name="postno1_2" value="<?php echo $clean['postno1_2']; ?>">
						<input type="hidden" name="address1" value="<?php echo $clean['address1']; ?>">
						<input type="hidden" name="telno1_1" value="<?php echo $clean['telno1_1']; ?>">
						<input type="hidden" name="telno1_2" value="<?php echo $clean['telno1_2']; ?>">
						<input type="hidden" name="telno1_3" value="<?php echo $clean['telno1_3']; ?>">
						<input type="hidden" name="email1" value="<?php echo $clean['email1']; ?>">
						<input type="hidden" name="email_confirm1" value="<?php echo $clean['email_confirm1']; ?>">
						<input type="hidden" name="last_name2" value="<?php echo $clean['last_name2']; ?>">
						<input type="hidden" name="first_name2" value="<?php echo $clean['first_name2']; ?>">
						<input type="hidden" name="kana_last_name2" value="<?php echo $clean['kana_last_name2']; ?>">
						<input type="hidden" name="kana_first_name2" value="<?php echo $clean['kana_first_name2']; ?>">
						<input type="hidden" name="gender2" value="<?php echo $clean['gender2']; ?>">
						<input type="hidden" name="age2" value="<?php echo $clean['age2']; ?>">
						<input type="hidden" name="user_check" value="<?php echo $clean['user_check']; ?>">
						<input type="hidden" name="postno2_1" value="<?php echo isset($clean['postno2_1']) ? htmlspecialchars($clean['postno2_1'], ENT_QUOTES, 'UTF-8') : ''; ?>">
						<input type="hidden" name="postno2_2" value="<?php echo isset($clean['postno2_2']) ? htmlspecialchars($clean['postno2_2'], ENT_QUOTES, 'UTF-8') : ''; ?>">
						<input type="hidden" name="address2" value="<?php echo isset($clean['address2']) ? htmlspecialchars($clean['address2'], ENT_QUOTES, 'UTF-8') : ''; ?>">
						<input type="hidden" name="telno2_1" value="<?php echo $clean['telno2_1']; ?>">
						<input type="hidden" name="telno2_2" value="<?php echo $clean['telno2_2']; ?>">
						<input type="hidden" name="telno2_3" value="<?php echo $clean['telno2_3']; ?>">
						<input type="hidden" name="email2" value="<?php echo $clean['email2']; ?>">
						<input type="hidden" name="email_confirm2" value="<?php echo $clean['email_confirm2']; ?>">
						<input type="hidden" name="dm" value="<?php echo $clean['dm']; ?>">
						<input type="hidden" name="question" value="<?php echo $clean['question']; ?>">
						<input type="hidden" name="title" value="<?php echo $post_title; ?>">
						<input type="hidden" name="event_date" value="<?php echo $post_date; ?>">
						<input type="hidden" name="venue" value="<?php echo $post_venue; ?>">
					</div>
				</form>
				<script>
					function goThanks() {
						document.form_confirm.action = "/lecture/thanks?id=<?php echo $post_id; ?>";
					}
				</script>
				<?php endif; ?>
			</section>
		</article>
	</section><!--/ #main -->
<?php get_footer(); ?>
