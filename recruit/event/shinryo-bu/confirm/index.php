<?php
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
	
	session_start();
	
	include('../validate.php');
	
	if(is_valid_csrf($Inputs['csrf']) === FALSE)
	{
		header('Location: ../');
		exit();
	}
	
	if(count($Errors) > 0)
	{
		header('Location: ../', true, 307);
		exit();
	}
	
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta http-equiv="content-style-type" content="text/css">
  <meta http-equiv="content-script-type" content="text/javascript">
  <meta name="robots" content="index, follow">
  <title>イベントを知る|小倉記念病院</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="copyright" content="">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">

	<meta property="og:type" content="article">
	<meta property="og:description" content="小倉記念病院は、高い専門性・緊急性のある診療、手術を要する医療を提供することが、ここ福岡・北九州（小倉）地域の住民・患者の皆様への役割と考えています。地域の医療施設が役割分担し、協力して医療を完結する「地域完結型医療」を目指します。">
	<meta property="og:title" content="患者さんの幸せと地域医療を支える｜小倉記念病院">
	<meta property="og:url" content="http://www.kokurakinen.or.jp/">
	<meta property="og:image" content="http://www.kokurakinen.or.jp/images/ogimage.jpg">
	<meta property="og:site_name" content="小倉記念病院">

  <link rel="stylesheet" href="/common/css/recruit.min.css">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

  <script src="/common/js/jquery-1.11.1.min.js"></script>

  <!--[if lt IE 9]>
  <script src="/common/js/html5shiv.js"></script>
  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <script src="/common/js/jquery.belatedPNG.min.js"></script>
  <script src="/common/js/jquery.backgroundSize.js"></script>
  <![endif]-->
</head>
<body>
<header>
	<div id="siteLogo"><a href="/recruit/"><img src="/recruit/images/img_logo.png" alt=""></a></div>
	<nav id="globalNavi">
		<ul>
			<li class="menu01"><a href="/recruit/">TOP</a></li>
			<li class="menu02"><a href="/recruit/concept/">採用コンセプト</a></li>
			<li class="menu03"><a href="/recruit/stage/">働く舞台を知る</a></li>
			<li class="menu04"><a href="/recruit/saiyo/">採用を知る</a></li>
			<li class="menu05 current"><a href="/recruit/event/">イベントを知る</a></li>
			<li class="menu06"><a href="/recruit/fukurikosei/">福利厚生を知る</a></li>
		</ul>
	</nav>
</header>

<form name="reentry" method="POST" action="../">
<input type="hidden" name="csrf" value="<?php echo htmlspecialchars($Inputs['csrf']); ?>" />
<input type="hidden" name="name" value="<?php echo htmlspecialchars($Inputs['name']); ?>" />
<input type="hidden" name="hurigana" value="<?php echo htmlspecialchars($Inputs['hurigana']); ?>" />
<input type="hidden" name="byear" value="<?php echo htmlspecialchars($Inputs['byear']); ?>" />
<input type="hidden" name="bmon" value="<?php echo htmlspecialchars($Inputs['bmon']); ?>" />
<input type="hidden" name="bday" value="<?php echo htmlspecialchars($Inputs['bday']); ?>" />
<input type="hidden" name="sex" value="<?php echo htmlspecialchars($Inputs['sex']); ?>" />
<input type="hidden" name="daigaku" value="<?php echo htmlspecialchars($Inputs['daigaku']); ?>" />
<input type="hidden" name="gakunen" value="<?php echo htmlspecialchars($Inputs['gakunen']); ?>" />
<input type="hidden" name="zip" value="<?php echo htmlspecialchars($Inputs['zip']); ?>" />
<input type="hidden" name="address" value="<?php echo htmlspecialchars($Inputs['address']); ?>" />
<input type="hidden" name="tel" value="<?php echo htmlspecialchars($Inputs['tel']); ?>" />
<input type="hidden" name="mail" value="<?php echo htmlspecialchars($Inputs['mail']); ?>" />
<input type="hidden" name="kinoubi" value="<?php echo htmlspecialchars($Inputs['kinoubi']); ?>" />
<input type="hidden" name="kibouka1" value="<?php echo htmlspecialchars($Inputs['kibouka1']); ?>" />
<input type="hidden" name="kibouka2" value="<?php echo htmlspecialchars($Inputs['kibouka2']); ?>" />
<input type="hidden" name="kibouka3" value="<?php echo htmlspecialchars($Inputs['kibouka3']); ?>" />
<input type="hidden" name="senko" value="<?php echo htmlspecialchars($Inputs['senko']); ?>" />
<input type="hidden" name="other" value="<?php echo htmlspecialchars($Inputs['other']); ?>" />
</form>

<form name="form" method="POST" action="../exec.php">
<input type="hidden" name="csrf" value="<?php echo htmlspecialchars($Inputs['csrf']); ?>" />
<input type="hidden" name="name" value="<?php echo htmlspecialchars($Inputs['name']); ?>" />
<input type="hidden" name="hurigana" value="<?php echo htmlspecialchars($Inputs['hurigana']); ?>" />
<input type="hidden" name="byear" value="<?php echo htmlspecialchars($Inputs['byear']); ?>" />
<input type="hidden" name="bmon" value="<?php echo htmlspecialchars($Inputs['bmon']); ?>" />
<input type="hidden" name="bday" value="<?php echo htmlspecialchars($Inputs['bday']); ?>" />
<input type="hidden" name="sex" value="<?php echo htmlspecialchars($Inputs['sex']); ?>" />
<input type="hidden" name="daigaku" value="<?php echo htmlspecialchars($Inputs['daigaku']); ?>" />
<input type="hidden" name="gakunen" value="<?php echo htmlspecialchars($Inputs['gakunen']); ?>" />
<input type="hidden" name="zip" value="<?php echo htmlspecialchars($Inputs['zip']); ?>" />
<input type="hidden" name="address" value="<?php echo htmlspecialchars($Inputs['address']); ?>" />
<input type="hidden" name="tel" value="<?php echo htmlspecialchars($Inputs['tel']); ?>" />
<input type="hidden" name="mail" value="<?php echo htmlspecialchars($Inputs['mail']); ?>" />
<input type="hidden" name="kinoubi" value="<?php echo htmlspecialchars($Inputs['kinoubi']); ?>" />
<input type="hidden" name="kibouka1" value="<?php echo htmlspecialchars($Inputs['kibouka1']); ?>" />
<input type="hidden" name="kibouka2" value="<?php echo htmlspecialchars($Inputs['kibouka2']); ?>" />
<input type="hidden" name="kibouka3" value="<?php echo htmlspecialchars($Inputs['kibouka3']); ?>" />
<input type="hidden" name="senko" value="<?php echo htmlspecialchars($Inputs['senko']); ?>" />
<input type="hidden" name="other" value="<?php echo htmlspecialchars($Inputs['other']); ?>" />
</form>

<div id="contents" class="bgIvory">
	<section id="main" class="full l-event">

		<div class="flL w50p">
			<div class="bgMist ps50 pt65 pb100 z2 bgSp">
				<p class="fz9 bold">【事前予約制】</p>
				<h1 class="fz20 bold">病院見学のご案内</h1>
				<p class="fz11 bold mb1">初期臨床研修希望者：随時</p>
				<p>初期臨床研修希望者を対象とした病院見学を随時行っています。参加ご希望の方は、申込フォームに記載の上送信してください。メール受信にて受付後、別途で連絡いたします。</p>
			</div>

			<img src="/recruit/event/shinryo-bu/images/img_main.jpg" alt="">
		</div>

		<div class="container">
			<p class="backBtn"><a href=""><img src="/recruit/images/ico_back.png" alt="">もどる</a></p>

			<div class="flR w50p bgIvory ps70 pt65">
				<p class="headline01 bottomBorder mb1">お申し込みの内容をご確認ください。</p>
				<p class="mb2">お申し込みの内容をご確認ください。<br>よろしければ「この内容で送信する」ボタンを押してください。</p>

				<p class="headerGray fz9 mb1">病院見学申込フォーム</p>

				<p class="mb2">以下の項目を記入し、送信して下さい。<span class="colorRed">（赤文字項目必須）</span></p>

				<form action="">
					<div class="">
						<dl class="inline form cf w2 mb1">
							<dt class="required">
								<label for="f_name">氏名</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['name']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_kana">ふりがな</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['hurigana']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_birth_y">生年月日</label>
							</dt>
							<dd>
								<?php echo htmlspecialchars($Inputs['byear']); ?>
								年
								<?php echo htmlspecialchars($Inputs['bmon']); ?>
								月
								<?php echo htmlspecialchars($Inputs['bday']); ?>
								日
							</dd>
							<dt class="required">
								<label for="f_sex">性別</label>
							</dt>
							<dd>
								<?php echo htmlspecialchars($SexName); ?>
							</dd>
							<dt class="required">
								<label for="f_university">大学名</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['daigaku']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_grade">学年</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['gakunen']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_p_code">郵便番号</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['zip']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_address">住所</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['address']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_tel">電話</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['tel']); ?></p>
								<!-- <input id="f_tel" type="hidden" name="" value=""> -->
							</dd>
							<dt class="required">
								<label for="f_e_mail">e-mail</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['mail']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_preferred_d">見学希望日</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Inputs['kinoubi']); ?></p>
							</dd>
							<dt class="required">
								<label for="f_preferred_1">見学第１希望科</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Kibouka1Name); ?></p>
							</dd>
							<dt>
								<label for="f_preferred_2">見学第2希望科</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Kibouka2Name); ?></p>
							</dd>
							<dt>
								<label for="f_preferred_3">見学第3希望科</label>
							</dt>
							<dd>
								<p><?php echo htmlspecialchars($Kibouka3Name); ?></p>
							</dd>
							<dt>
								<label for="f_preferred_senkou">選考希望科</label>
							</dt>
							<dd>
								<?php echo htmlspecialchars($Inputs['senko']); ?>
							</dd>
							<dt>
								<label for="f_bikou">備考欄</label>
							</dt>
							<dd>
								<p><?php echo nl2br(htmlspecialchars($Inputs['other'])); ?></p>
							</dd>
						</dl>

						<div class="center">
							<button type="button" class="fz9 mb1 dib back" onClick="document.reentry.submit();return false;">修正する</button>
							<button type="submit" class="fz9 mb1 dib" onClick="document.form.submit();return false;">この内容で送信する</button>
						</div>
					</div>
				</form>

			</div>
		</div>

	</section><!--/ #main -->
</div><!--/ #contents -->

<footer>
	<div class="inner">
		<div id="footerMenu">
			<ul>
				<li><a href="/privacy/">個人情報保護方針</a></li>
				<li><a href="/sitemap/">サイトマップ</a></li>
				<li><a href="/shisenkai/" target="_blank">一般財団法人 平成紫川会</a></li>
				<li><a href="/gallery/" target="_blank">フォトギャラリー</a></li>
				<li><a href="/common/pdf/fb_unyou.pdf" target="_blank">Facebook運用ポリシー</a></li>
			</ul>
		</div>
		<p id="copyright">Copyright © 2014Kokura Kinen Hospital All rights reserved. </p>
	</div>
</footer>

<script src="/common/js/share.js"></script>
<script src="/common/js/recruit.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-55024782-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
</script>
</body>
</html>