<?php
/*
Template Name: lecture-thanks
Description: 市民公開講座の参加申し込み完了画面
*/

// GET/POST に関わらず id が付与される
$post_id = 0;
$keywords = array();
if (isset($_GET['id'])) {
	// カスタム投稿タイプが市民公開講座であること
	if (get_post_type($_GET['id']) == 'lecture') {
		$post_id = $_GET['id'];
		$post_title = get_the_title($post_id);
		$post_date = getLectureDate($post_id);
		$post_venue = get_field('lecture-venue', $post_id);

		$keywords = array_merge($keywords, array('post_title' => get_the_title($post_id)));
		$keywords = array_merge($keywords, array('post_date' => getLectureDate($post_id)));
		$keywords = array_merge($keywords, array('post_time' => get_field('lecture-time', $post_id)));
		$keywords = array_merge($keywords, array('post_venue' => get_field('lecture-venue', $post_id)));
		$keywords = array_merge($keywords, array('post_reply_type' => get_field('lecture-reply-type', $post_id)));
		$keywords = array_merge($keywords, array('post_fee' => get_field('lecture-fee', $post_id)));
		$keywords = array_merge($keywords, array('post_lecturer' => get_field('lecture-lecturer', $post_id)));
		$keywords = array_merge($keywords, array('post_series' => get_field('lecture-series', $post_id)));
	}
}

// POST時の処理
if ($post_id > 0 && isset($_POST['btn_submit'])) {
	$clean = array();
	// サニタイジング（無効化）
	foreach ($_POST as $key => $value) {
		$text = stripslashes($value);
		$clean[$key] = htmlspecialchars(trim($text), ENT_QUOTES);
	}
	// 申込数更新
	updateLectureCount($post_id);
	// 申込DBへ追加
	insertLectureData($post_id, $post_title, $post_date, $post_venue, $clean);
	// 自動返信メール送信
	sendLectureMail($keywords, $clean);
	// 二重投稿対策の為 GETで再呼び出し
	header('Location:' . $_SERVER['REQUEST_URI']);
}
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
			<strong>参加申し込み完了</strong>
		</div>
		<article>
			<hgroup>
				<h1 class="slim">市民公開講座</h1>
				<small>Lecture</small>
			</hgroup>
			<section class="form_wrap">
				<?php if (!empty($post_id)): ?>
				<div class="form_head">
					<h2>市民公開講座<br class="sp">「<?php echo $post_title; ?>」</h2>
					<p><span>開催日：<?php echo $post_date; ?></span><span>会場：<?php echo $post_venue; ?></span></p>
				</div>
				<div class="thanks_message">
					<p class="thanks_message_title">申し込み完了</p>
					<p>
						お申し込みありがとうございます。<br>
						ネットでの参加申込者には抽選はありませんので、当日は会場受付にてお送りしましたメールを、携帯電話でご提示いただくか、もしくは受信されたメールを印刷したものをご提示ください。
					</p>
					<div class="thanks_message_btn"><a href="/">トップへ戻る</a></div>
				</div>
				<?php endif; ?>
			</section>
		</article>
	</section><!--/ #main -->
<?php get_footer(); ?>
