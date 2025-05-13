<?php

	ini_set("display_errors", 1);
	error_reporting(E_ALL);

	session_start();
	
	include('./validate.php');
	
	$is_validate = false;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(count($Errors) > 0){
			$is_validate = true;
		}
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
			<li class="menu03 current"><a href="/recruit/event/">雰囲気を知る</a></li>
			<li class="menu04"><a href="/recruit/stage/">働く舞台を知る</a></li>
			<li class="menu05"><a href="/recruit/saiyo/">採用を知る</a></li>
			<li class="menu06"><a href="/recruit/fukurikosei/">福利厚生を知る</a></li>
		</ul>
	</nav>
</header>

<div id="contents" class="bgIvory">
<?php if ($is_validate == true) { ?>
	<section id="main" class="full l-event">
<?php } else { ?>
	<section id="main" class="full">
<?php } ?>

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
<?php if ($is_validate == true) { ?>
				<p class="headline01 bottomBorder mb1 errorHeader"><img src="/recruit/event/shinryo-bu/images/ico_error.png" alt="">入力内容をご確認ください。</p>
				<p class="mb2">入力内容に不備があるようです。<br>表示内容をご確認の上、再度入力を行ってください。</p>

				<div class="bgWhite colorRed p10 mb3">
					<ul class="indentList">
<?php if (!empty($Errors['name'])) { ?><li>・<?php echo htmlspecialchars($Errors['name']) ; ?></li><?php } ?>
<?php if (!empty($Errors['hurigana'])) { ?><li>・<?php echo htmlspecialchars($Errors['hurigana']) ; ?></li><?php } ?>
<?php if (!empty($Errors['byear'])) { ?><li>・<?php echo htmlspecialchars($Errors['byear']) ; ?></li><?php } ?>
<?php if (!empty($Errors['bmon'])) { ?><li>・<?php echo htmlspecialchars($Errors['bmon']) ; ?></li><?php } ?>
<?php if (!empty($Errors['bday'])) { ?><li>・<?php echo htmlspecialchars($Errors['bday']) ; ?></li><?php } ?>
<?php if (!empty($Errors['sex'])) { ?><li>・<?php echo htmlspecialchars($Errors['sex']) ; ?></li><?php } ?>
<?php if (!empty($Errors['daigaku'])) { ?><li>・<?php echo htmlspecialchars($Errors['daigaku']) ; ?></li><?php } ?>
<?php if (!empty($Errors['gakunen'])) { ?><li>・<?php echo htmlspecialchars($Errors['gakunen']) ; ?></li><?php } ?>
<?php if (!empty($Errors['zip'])) { ?><li>・<?php echo htmlspecialchars($Errors['zip']) ; ?></li><?php } ?>
<?php if (!empty($Errors['address'])) { ?><li>・<?php echo htmlspecialchars($Errors['address']) ; ?></li><?php } ?>
<?php if (!empty($Errors['tel'])) { ?><li>・<?php echo htmlspecialchars($Errors['tel']) ; ?></li><?php } ?>
<?php if (!empty($Errors['mail'])) { ?><li>・<?php echo htmlspecialchars($Errors['mail']) ; ?></li><?php } ?>
<?php if (!empty($Errors['kinoubi'])) { ?><li>・<?php echo htmlspecialchars($Errors['kinoubi']) ; ?></li><?php } ?>
<?php if (!empty($Errors['kibouka1'])) { ?><li>・<?php echo htmlspecialchars($Errors['kibouka1']) ; ?></li><?php } ?>
<?php if (!empty($Errors['kibouka2'])) { ?><li>・<?php echo htmlspecialchars($Errors['kibouka2']) ; ?></li><?php } ?>
<?php if (!empty($Errors['kibouka3'])) { ?><li>・<?php echo htmlspecialchars($Errors['kibouka3']) ; ?></li><?php } ?>
<?php if (!empty($Errors['senko'])) { ?><li>・<?php echo htmlspecialchars($Errors['senko']) ; ?></li><?php } ?>
<?php if (!empty($Errors['other'])) { ?><li>・<?php echo htmlspecialchars($Errors['other']) ; ?></li><?php } ?>
					</ul>
				</div>
<?php } else { ?>
				<ul class="discList mb4">
					<li><i>●</i>対象／医学部５・６年生</li>
					<li><i>●</i>見学内容／
						<ul class="indent">
							<li>9:30	集合</li>
							<li>10:00～12:00	第１希望科見学</li>
							<li>12:00～13:00	昼食</li>
							<li>13:00～15:00	第２希望科見学</li>
						</ul>
					</li>
					<li><i>●</i>申込方法／下記申込フォーム</li>
					<li><i>●</i>申込期限／各回とも予定日の１週間前</li>
					<li><i>●</i>持ち物／学生証・白衣・学校で使用している名札</li>
					<li><i>●</i>その他／交通費・宿泊に関しましては、自己負担をお願いいたします。</li>
					<li><i>●</i>お問い合わせ／小倉記念病院　人事課　TEL.093-511-2057（直通）</li>
				</ul>
<?php } ?>

				<p class="headerGray fz9 mb1">病院見学申込フォーム</p>

				<p class="mb2">以下の項目を記入し、送信して下さい。<span class="colorRed">（赤文字項目必須）</span></p>

<form name="form" method="POST" action="./confirm/">
					<input type="hidden" name="csrf" value="<?php echo generate_csrf(); ?>" />
					<div class="">
						<dl class="inline form cf w2 mb1">
							<dt class="required">
								<label for="f_name">氏名</label>
							</dt>
							<dd>
								<input id="f_name" class="w100p" type="text" name="name" value="<?php echo htmlspecialchars($Inputs['name']); ?>">
							</dd>
							<dt class="required">
								<label for="f_kana">ふりがな</label>
							</dt>
							<dd>
								<input id="f_kana" class="w100p" type="text" name="hurigana" value="<?php echo htmlspecialchars($Inputs['hurigana']); ?>">
							</dd>
							<dt class="required">
								<label for="f_birth_y">生年月日</label>
							</dt>
							<dd>
								<input id="f_birth_y" class="w20p" type="text" name="byear" value="<?php echo htmlspecialchars($Inputs['byear']); ?>">
								年
								<input id="f_birth_m" class="w10p" type="text" name="bmon" value="<?php echo htmlspecialchars($Inputs['bmon']); ?>">
								月
								<input id="f_birth_d" class="w10p" type="text" name="bday" value="<?php echo htmlspecialchars($Inputs['bday']); ?>">
								日
							</dd>
							<dt class="required">
								<label for="f_sex">性別</label>
							</dt>
							<dd>
<?php
	for ($i = 0; $i < count($SexData); $i++) {
		$data = $SexData[$i];
		$checked = '';
		if ($data['code_id'] == $Inputs['sex']) {
			$checked = ' checked="checked"';
		}
		print '<input id="f_sex_' . htmlspecialchars($data['code_id']) . '" type="radio" name="sex" value="' . htmlspecialchars($data['code_id']) . '"' . $checked . '>' . "\n";
		print '<label for="f_sex_' . htmlspecialchars($data['code_id']) . '">' . htmlspecialchars($data['name']) . '</label>' . "\n";
	}
?>
							</dd>
							<dt class="required">
								<label for="f_university">大学名</label>
							</dt>
							<dd>
								<input id="f_university" class="w100p" type="text" name="daigaku" value="<?php echo htmlspecialchars($Inputs['daigaku']); ?>">
							</dd>
							<dt class="required">
								<label for="f_grade">学年</label>
							</dt>
							<dd>
								<input id="f_grade" class="w100p" type="text" name="gakunen" value="<?php echo htmlspecialchars($Inputs['gakunen']); ?>">
							</dd>
							<dt class="required">
								<label for="f_p_code">郵便番号</label>
							</dt>
							<dd>
								<input id="f_p_code" class="w100p" type="text" name="zip" value="<?php echo htmlspecialchars($Inputs['zip']); ?>">
							</dd>
							<dt class="required">
								<label for="f_address">住所</label>
							</dt>
							<dd>
								<textarea id="f_address" class="w100p" name="address" rows="3"><?php echo htmlspecialchars($Inputs['address']); ?></textarea>
							</dd>
							<dt class="required">
								<label for="f_tel">電話</label>
							</dt>
							<dd>
								<input id="f_tel" class="w100p" type="text" name="tel" value="<?php echo htmlspecialchars($Inputs['tel']); ?>">
							</dd>
							<dt class="required">
								<label for="f_e_mail">e-mail</label>
							</dt>
							<dd>
								<input id="f_e_mail" class="w100p" type="text" name="mail" value="<?php echo htmlspecialchars($Inputs['mail']); ?>">
							</dd>
							<dt class="required">
								<label for="f_preferred_d">見学希望日</label>
							</dt>
							<dd>
								<input id="f_preferred_d" class="w100p" type="text" name="kinoubi" value="<?php echo htmlspecialchars($Inputs['kinoubi']); ?>">
							</dd>
							<dt class="required">
								<label for="f_preferred_1">見学第１希望科</label>
							</dt>
							<dd>
								<select id="f_preferred_1" name="kibouka1">
									<option>選択してください</option>
<?php
	for ($i = 0; $i < count($KiboukaData); $i++) {
		$data = $KiboukaData[$i];
		$selected = '';
		if ($data['code_id'] == $Inputs['kibouka1']) {
			$selected = ' selected="selected"';
		}
		print '<option value="' . htmlspecialchars($data['code_id']) . '"' . $selected . '>' . htmlspecialchars($data['name']) . '</option>';
	}
?>
								</select>
							</dd>
							<dt>
								<label for="f_preferred_2">見学第2希望科</label>
							</dt>
							<dd>
								<select id="f_preferred_2" name="kibouka2">
									<option>選択してください</option>
<?php
	for ($i = 0; $i < count($KiboukaData); $i++) {
		$data = $KiboukaData[$i];
		$selected = '';
		if ($data['code_id'] == $Inputs['kibouka2']) {
			$selected = ' selected="selected"';
		}
		print '<option value="' . htmlspecialchars($data['code_id']) . '"' . $selected . '>' . htmlspecialchars($data['name']) . '</option>';
	}
?>
								</select>
							</dd>
							<dt>
								<label for="f_preferred_3">見学第3希望科</label>
							</dt>
							<dd>
								<select id="f_preferred_3" name="kibouka3">
									<option>選択してください</option>
<?php
	for ($i = 0; $i < count($KiboukaData); $i++) {
		$data = $KiboukaData[$i];
		$selected = '';
		if ($data['code_id'] == $Inputs['kibouka3']) {
			$selected = ' selected="selected"';
		}
		print '<option value="' . htmlspecialchars($data['code_id']) . '"' . $selected . '>' . htmlspecialchars($data['name']) . '</option>';
	}
?>
								</select>
							</dd>
							<dt>
								<label for="f_preferred_senkou">専攻希望科</label>
							</dt>
							<dd>
								<input id="f_preferred_senkou" class="w100p" type="text" name="senko" placeholder="将来専攻を希望する科があればご記入ください。"  size="30" value="<?php echo htmlspecialchars($Inputs['senko']); ?>"">
							</dd>
							<dt>
								<label for="f_bikou">備考欄</label>
							</dt>
							<dd>
								<p class="fz6">質問事項・ご希望などございましたら遠慮なくお書き下さい。<br>例）第２希望科を１日見学したい、カンファレンスを見学したい、○○時までに終了希望など。</p>
								<textarea id="f_bikou" class="w100p" name="other" rows="5"><?php echo htmlspecialchars($Inputs['other']); ?></textarea>
							</dd>
						</dl>

						<button type="submit" class="fz9 mb1">確認に進む</button>
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