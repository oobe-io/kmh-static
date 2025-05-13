<?php
require("lecture-function.php");

// 変数の初期化
$page_flag = 0;
$clean = array();
$error = array();

// パラメータから投稿（ID）取得
if(isset($_GET['id'])) { $postid = $_GET['id']; }

// タイトル、開催日、会場を取得
$post_title = get_the_title($postid);
$date = date_create(get_field('seminar-date',$postid));
$post_year = date_format($date,'Y');
$post_month = date_format($date,'n');
$post_day = date_format($date,'j');
$week = array("日", "月", "火", "水", "木", "金", "土");
$post_week = $week[(int)date_format($date,'w')];
$post_date = $post_year .'年' . $post_month .'月' . $post_day .'日（' .$post_week .'）';
$post_venue = get_field('seminar-venue',$postid);

// サニタイズ（POSTデータを配列に変換）
if( !empty($_POST) ) {
	foreach( $_POST as $key => $value ) {
		$clean[$key] = htmlspecialchars( $value, ENT_QUOTES);
	} 
}

// page遷移時の事前処理判定
if( !empty($clean['btn_confirm']) ) {
	// 入力判定（確認画面）
	$error = validation($clean);
	if( empty($error) ) {
		$page_flag = 1;		// 確認画面表示
	}
} elseif( !empty($clean['btn_submit']) ) {
	// メール送信＆DB更新処理
	$page_flag = 2; // 申込完了画面表示
	// 申込数更新
	updSeminarCount($postid);
	// 申込DBへ追加
	insSeminarData($postid, $post_title, $post_date, $post_venue, $clean);
	// 自動返信メール送信
	send_mail ($post_title, $post_date, $post_venue, $clean);
}
?>
	<article>
		<hgroup>
			<h1 class="slim">市民公開講座</h1>
			<small>Lecture</small>
		</hgroup>
		<section class="form_wrap">
			<div class="form_head">
				<h2>市民公開講座<br class="sp"><?php echo $post_title; ?></h2>
				<p><span>開催日：<?php echo $post_date; ?></span><span>会場：<?php echo $post_venue; ?></span></p>
			</div>

			<!--div class="form_message">
				<p class="form_message_att">同時に2名まで申し込みができます。<span class="required">＊</span>は必須項目です。</p>
				<p>
					※メールアドレスをお持ちでない方は、往復ハガキに①講座名 ②氏名 ③住所 ④年齢 ⑤電話番号をご明記し下記までご郵送ください。<br>
					〒802-0001 北九州市小倉北区浅野3-2-1 「一般財団法人平成紫川会 事務局」宛
				</p>
			</div-->
			
			<br>
			<!-- 確認画面 -->
			<?php if( $page_flag === 1 ): ?>
				<form method="post" action="" class="form_input">
					<table class="form">
						<caption>参加者１の基本情報</caption>
						<tr>
							<th>氏名</th>
							<td><?php echo $clean['last_name1']; ?> <?php echo $clean['first_name1']; ?></td>
						</tr>
						<tr>
							<th>性別</th>
							<td><?php if( $clean['gender1'] === "male" ){ echo '男性'; }else{ echo '女性'; } ?></td>
						</tr>
						<tr>
							<th>年齢</th>
							<td><?php echo $clean['age1']; ?>歳</td>
						</tr>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $clean['postno1_1']; ?>-<?php echo $clean['postno1_2']; ?></td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $clean['address1']; ?></td>
						</tr>
						<tr>
							<th>電話番号</th>
							<td><?php echo $clean['telno1_1']; ?>-<?php echo $clean['telno1_2']; ?>-<?php echo $clean['telno1_3']; ?>
							</td>
						</tr>
						<tr>
							<th>メールアドレス</th>
							<td><?php echo $clean['email1']; ?></td>
						</tr>
					</table>
					
					<?php if( !empty($clean['last_name2']) || !empty($clean['first_name2']) ): ?>
					<table class="form">
						<caption>参加者２の基本情報</caption>
						<tr>
							<th>氏名</th>
							<td><?php echo $clean['last_name2']; ?> <?php echo $clean['first_name2']; ?></td>
						</tr>
						<tr>
							<th>性別</th>
							<td><?php if( $clean['gender2'] === "male" ){ echo '男性'; }else{ echo '女性'; } ?></td>
						</tr>
						<tr>
							<th>年齢</th>
							<td><?php echo $clean['age2']; ?>歳</td>
						</tr>
						<?php if( empty($clean['user_check']) ): ?>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $clean['postno2_1']; ?>-<?php echo $clean['postno2_2']; ?></td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $clean['address2']; ?></td>
						</tr>
						<?php else: ?>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $clean['postno1_1']; ?>-<?php echo $clean['postno1_2']; ?></td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $clean['address1']; ?></td>
						</tr>
						<?php endif; ?>
						<tr>
							<th>電話番号</th>
							<td><?php echo $clean['telno2_1']; ?>-<?php echo $clean['telno2_2']; ?>-<?php echo $clean['telno2_3']; ?>
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
							<td><?php if( $clean['dm'] === "yes" ){ echo 'はい'; }else{ echo 'いいえ'; } ?></td>
						</tr>
					</table>

					<div class="form_btn">
						<input type="submit" name="btn_back" value="入力画面へ戻る" class="btn_back">
						<input type="submit" name="btn_submit" value="送信する">
						<input type="hidden" name="last_name1" value="<?php echo $clean['last_name1']; ?>">
						<input type="hidden" name="first_name1" value="<?php echo $clean['first_name1']; ?>">
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
						<input type="hidden" name="gender2" value="<?php echo $clean['gender2']; ?>">
						<input type="hidden" name="age2" value="<?php echo $clean['age2']; ?>">
						<input type="hidden" name="user_check" value="<?php if(!empty($clean['user_check'])){ echo "1";}else{ echo "";} ?>">
						<input type="hidden" name="postno2_1" value="<?php echo $clean['postno2_1']; ?>">
						<input type="hidden" name="postno2_2" value="<?php echo $clean['postno2_2']; ?>">
						<input type="hidden" name="address2" value="<?php echo $clean['address2']; ?>">
						<input type="hidden" name="telno2_1" value="<?php echo $clean['telno2_1']; ?>">
						<input type="hidden" name="telno2_2" value="<?php echo $clean['telno2_2']; ?>">
						<input type="hidden" name="telno2_3" value="<?php echo $clean['telno2_3']; ?>">
						<input type="hidden" name="email2" value="<?php echo $clean['email2']; ?>">
						<input type="hidden" name="email_confirm2" value="<?php echo $clean['email_confirm2']; ?>">
						<input type="hidden" name="dm" value="<?php echo $clean['dm']; ?>">
						<input type="hidden" name="title" value="<?php echo $post_title; ?>">
						<input type="hidden" name="event_date" value="<?php echo $post_date; ?>">
						<input type="hidden" name="venue" value="<?php echo $post_venue; ?>">
					</div>
				</form>
			<!-- 完了画面 -->
			<?php elseif( $page_flag === 2 ): ?>
				<div class="thanks_message">
					<p class="thanks_message_title">申し込み完了</p>
					<p>
						お申し込みありがとうございます。<br>
						ネットでの参加申込者には抽選はありませんので、当日は会場受付にてお送りしましたメールを、携帯電話でご提示いただくか、もしくは受信されたメールを印刷したものをご提示ください。
					</p>
					<div class="thanks_message_btn"><a href="/">トップへ戻る</a></div>
				</div>
				<?php $page_flag = 0; ?>

			<!-- 入力画面 -->
			<?php else: ?>
				<form method="post" action="" class="form_input" name="form_input">
					<table class="form">
					<caption>参加者１の基本情報</caption>
					<tr>
						<th>氏名<span class="required">＊</span></th>
						<td class="form_input_name">
							<span>姓</span>
							<input type="text" name="last_name1" value="<?php if( !empty($clean['last_name1']) ){ echo $clean['last_name1']; } ?>" class="name" >&ensp;
							<span>名</span>
							<input type="text" name="first_name1" value="<?php if( !empty($clean['first_name1']) ){ echo $clean['first_name1']; } ?>" class="name" >&ensp;&ensp;
							<br class="sp">
								<label for="gender_male"><input id="gender_male" type="radio" name="gender1" value="male" <?php if( !empty($clean['gender1']) && $clean['gender1'] === "male" ){ echo 'checked'; } ?>>男性</label>&nbsp;
								<label for="gender_female"><input id="gender_female" type="radio" name="gender1" value="female" <?php if( !empty($clean['gender1']) && $clean['gender1'] === "female" ){ echo 'checked'; } ?>>女性</label>&ensp;&ensp;
							<input type="tel" name="age1" value="<?php if( !empty($clean['age1']) ){ echo $clean['age1']; } ?>" class="w60" >&ensp;<span>歳</span>
							<p class="error_message" <?php if(in_array('err1_last_name1', $error)){ echo 'style="display: block"'; } ?>>＊「姓」は必ず入力してください。</p>
							<p class="error_message" <?php if(in_array('err1_first_name1', $error)){ echo 'style="display: block"'; } ?>>＊「名」は必ず入力してください。</p>
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
							<span>姓</span>
							<input type="text" name="last_name2" value="<?php if( !empty($clean['last_name2']) ){ echo $clean['last_name2']; } ?>" class="name" >&ensp;
							<span>名</span>
							<input type="text" name="first_name2" value="<?php if( !empty($clean['first_name2']) ){ echo $clean['first_name2']; } ?>" class="name" >&ensp;&ensp;
							<br class="sp">
							<label for="gender_male2"><input id="gender_male2" type="radio" name="gender2" value="male" <?php if( !empty($clean['gender2']) && $clean['gender2'] === "male" ){ echo 'checked'; } ?>>男性</label>&nbsp;
							<label for="gender_female2"><input id="gender_female2" type="radio" name="gender2" value="female" <?php if( !empty($clean['gender2']) && $clean['gender2'] === "female" ){ echo 'checked'; } ?>>女性</label>&ensp;&ensp;
							<input type="tel" name="age2" value="<?php if( !empty($clean['age2']) ){ echo $clean['age2']; } ?>" class="w60" >&ensp;<span>歳</span>
							<p class="error_message" <?php if(in_array('err1_last_name2', $error)){ echo 'style="display: block"'; } ?>>＊「姓」は必ず入力してください。</p>
							<p class="error_message" <?php if(in_array('err1_first_name2', $error)){ echo 'style="display: block"'; } ?>>＊「名」は必ず入力してください。</p>
							<p class="error_message" <?php if(in_array('err1_gender2', $error)){ echo 'style="display: block"'; } ?>>＊「性別」は必ず選択してください。</p>
							<p class="error_message" <?php if(in_array('err1_age2', $error)){ echo 'style="display: block"'; } ?>>＊「年齢」は半角数字で入力してください。</p>
						</td>
					</tr>
					<tr>
						<th>住所について</th>
						<td>
							<label><input id="user_check" type="checkbox" name="user_check" value="1" <?php if( !empty($clean['user_check']) ){ echo "checked"; } ?> onclick="fchk(this);">参加者1と同じ</label>&ensp;&ensp;
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

					<div class="form_btn">
						<input type="submit" name="btn_confirm" value="入力内容を確認する" class="btn_confirm">
						<input type="hidden" name="title" value="<?php echo $post_title; ?>">
						<input type="hidden" name="event_date" value="<?php echo $post_date; ?>">
						<input type="hidden" name="venue" value="<?php echo $post_venue; ?>">
					</div>
				</form>
			
				<script type="text/javascript">
					/* 住所同一チェックボックスの操作時、入力値をクリア及び有効無効化 */
					function fchk(obj){
						var frm=document.form_input;
						if(obj.checked){
							/* 入力値をクリア */
							frm.elements["postno2_1"].value="";
							frm.elements["postno2_2"].value="";
							frm.elements["address2"].value="";
							/* 無効化 */
							frm.elements["postno2_1"].disabled=true;
							frm.elements["postno2_2"].disabled=true;
							frm.elements["address2"].disabled=true;
						}else{
							/* 入力値をクリア */
							frm.elements["postno2_1"].value="";
							frm.elements["postno2_2"].value="";
							frm.elements["address2"].value="";
							/* 有効化 */
							frm.elements["postno2_1"].disabled=false;
							frm.elements["postno2_2"].disabled=false;
							frm.elements["address2"].disabled=false;
						}
					}
				</script>
			<?php endif; ?>
		</section>
	</article>