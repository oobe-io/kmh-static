<?php
/*
Template Name: セミナー用テーマ
*/

$page = get_post( get_the_ID() );
$slug = $page->post_name;

?>

<!DOCTYPE html>

<html lang="ja">

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<meta http-equiv="content-style-type" content="text/css">

	<meta http-equiv="content-script-type" content="text/javascript">

	<meta name="robots" content="index, follow">

	<title>市民公開講座|小倉記念病院</title>

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

	<link rel="stylesheet" href="/common/css/style.min.css">

	<link rel="stylesheet" href="/lecture/css/style.css">

	<link rel="shortcut icon" type="images/x-icon" href="/favicon.ico">

	<script src="/common/js/jquery-1.11.1.min.js"></script>

	<!-- seminar -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/list.css">

<!--[if lt IE 9]>

	<script src="/common/js/html5shiv.js"></script>

	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

	<script src="/common/js/jquery.belatedPNG.min.js"></script>

	<script src="/common/js/jquery.backgroundSize.js"></script>

<![endif]-->

</head>



<body class="page-lecture">



<header>

	<p id="siteLogo"><a href="/"><img src="/common/images/logo.png" alt="一般財団法人 平成紫川会 小倉記念病院"></a></p>

	<nav id="globalNavi">

		<ul>

			<li class="menu01"><a href="/byoin/">病院案内</a></li>

			<li class="menu02"><a href="/raiin/">ご来院の皆様へ</a></li>

			<li class="menu03"><a href="/shinryou/">診療案内</a></li>

			<li class="menu04"><a href="/shokai/">当院へのご紹介</a></li>

			<li class="menu05"><a href="/recruit/" target="_blank">リクルート</a></li>

			<li class="menu06"><a href="/kenkan/" target="_blank">健康管理センター</a></li>

			<li class="menu07"><a href="/access/">アクセス</a></li>

			<li class="menu08 sns"><a href="https://www.facebook.com/pages/小倉記念病院/703019479789510" target="_blank">記念日記</a></li>

		</ul>

	</nav>

	<p id="shareBtn"><a href=""><img src="/common/images/ico_share.png" alt=""><span>シェアする</span></a></p>

</header>



<div id="contents">

	<section id="main">

		<div class="breadcrumbs">

			<a href="/">ホーム</a>

			＞

			<a href="/lecture/">市民公開講座・勉強会・研究会のご案内</a>

			＞

			<strong>市民公開講座</strong>

		</div>

		<article>

			<hgroup>

				<h1 class="slim">市民公開講座</h1>

				<small>Lecture</small>

			</hgroup>

			<section>


				<?php
					// list が現在の西暦になる
					$thisyear = date('Y');
					$page_data = get_page_by_path('lecture/list');
					$page_id = $page_data->ID;
					$children = wp_list_pages(array(
						'title_li' => '',
						'child_of' => $page_id,
						'echo' => '0',
						'depth' => -1,
					));
					if($children){
						echo '<ul id="sinryouMenu" class="al">';
						if( is_page('list')){
							echo '<li class="active"><a href="/lecture/list/">' .$thisyear .'年度</a></li>';
						}else{
							echo '<li><a href="/lecture/list/">' .$thisyear .'年度</a></li>';
						}
						echo $children;
						echo '</ul>';
					}
				?>


				<p class="center bold mb1" style="font-size: 2em">2018年度からの市民公開講座は10:00スタートになります。</p>

				<ul class="l-lecture-lists">

					<?php
						if ( is_page('list') ) {
							$year = date('Y'); //list では現在の西暦を取得
							$year_start = $year.'-04-01';
						}else{
							$year = substr($slug, 0, 4); //数字だけのスラッグは自動で「-2」がつくため頭4桁を抜き出す
							$year_start = $year.'-04-01';
						}

						$next_year = $year + 1; //4/1～翌年の3/31までなので$yearに+1
						$year_end = $next_year.'-03-31';

						$args = array(
						    'post_type' => 'seminar',
						    'meta_key' => 'seminar-date',
						    'orderby' => 'meta_value',
						    'order' =>  'ASC',
						    'meta_query' => array(
						    	'relation' => 'AND',
						    	array(
						    		'key' => 'seminar-date',
						    		'value'=>array( $year_start, $year_end ), //期間
						    		'compare'=>'BETWEEN',
						    		'type'=>'DATE'
						    	),
						    ),
						 );

						$the_query = new WP_Query($args);
						if ($the_query->have_posts()) :
						while ($the_query->have_posts()) : $the_query->the_post();

					?>
					<li>

						<dl>
							<dt>
								
								<?php
									$seminar_check = get_field('seminar-date-none-check');

									//開催日が未定の場合
									if ( $seminar_check == 1 ) {
										$detenone = get_field('seminar-date-none');
										echo $detenone;
									}else{

									//開催日
									$date = date_create(get_field('seminar-date'));
									$post_year = date_format($date,'Y');
									$post_month = date_format($date,'n');
									$post_day = date_format($date,'j');

									$week = array("日", "月", "火", "水", "木", "金", "土");
									$post_week = $week[(int)date_format($date,'w')];

									echo $post_year.'年<br>' .$post_month .'月' .$post_day .'日（' .$post_week .'）';
									
									}
								?>

								<?php
									//申込数の判定
									$capacity = get_field('seminar-limit'); //定員
									$count = get_field('seminar-count'); //申込数
									if ($capacity > $count) {

										//ステータスの判定
										$st = get_field('seminar-st');
										//ステータス：申込期間を指定
										if ($st == '申込期間を指定') {
									
											//PCでの参加申込ボタン 受付期間で表示/非表示
											$today = current_time("Y/m/d H:i");
											$start = get_field('seminar-start');
											$end = get_field('seminar-end');
											$post_id = get_the_ID(); 

											if(strtotime($today) >= strtotime("$start 00:00") && strtotime("$end 23:59") >= strtotime($today)){
											echo '<div class="btn pc"><a href="/lecture/entry/?id=' .$post_id .'">参加申込</a></div>';
											}
									
										}

									}
								?>

							</dt>

							<dd class="thumb thumb_list">
								<?php
									//画像もしくはyoutube動画を表示
									$img = get_field('seminar-img');
									$movie = get_field('seminar-movie');
    								$thumb = get_field('seminar-thumb');
    								if ($thumb == 'img') {
										echo '<img src="' .$img  .'" alt="" style="border:solid 1px #ccc;">';
									} elseif ($thumb == 'movie') {
										echo '<div class="youtube">' .$movie .'</div>';
									}
								?>
							</dd>

							<dd class="detail">
								<?php
									//ステータス
									$st = get_field('seminar-st');
									//中止
									if ($st == '中止') {
										$comment = get_field('seminar-cancel-comment');
										echo '<div class="title"><h2 class="bold">' .$comment .'</h2></div>';
									}else{
								?>
								<div class="title">
									<p class="type"><?php the_field('seminar-type'); ?></p>
									<h2 class="kakkoIndent"><?php the_title(); ?></h2>
									<p class="schejule">
										<i>●</i><?php the_field('seminar-time'); ?>　
										<?php
											$venue = get_field('seminar-venue');
											$venue_color = get_field('seminar-venue-red');
											if ( $venue_color == 1 ) {
												echo '<span class="colorRed">●</span><span class="colorRed" style="font-weight:bold;">' .$venue .'</span>';
											}else{
												echo '<i>●</i>' .$venue;
											}
										?>
									</p>
								</div>
								<p>対象：<?php the_field('seminar-target'); ?> 参加費:<?php the_field('seminar-fee'); ?><br>
								講師：<?php the_field('seminar-teacher'); ?></p>

								<?php } ?>

							</dd>

							<dd class="file">
								<?php
									//申込数の判定
									$capacity = get_field('seminar-limit'); //定員
									$count = get_field('seminar-count'); //申込数
									if ($capacity > $count) {

										//ステータスの判定
										$st = get_field('seminar-st');
										//ステータス：申込期間を指定
										if ($st == '申込期間を指定') {
									
											//PCでの参加申込ボタン 受付期間で表示/非表示
											$today = current_time("Y/m/d H:i");
											$start = get_field('seminar-start');
											$end = get_field('seminar-end');
											$post_id = get_the_ID(); 

											if(strtotime($today) >= strtotime("$start 00:00") && strtotime("$end 23:59") >= strtotime($today)){
											echo '<div class="btn sp"><a href="/lecture/entry/?id=' .$post_id .'">参加申込</a></div>';
											}
									
										}

									}
								?>

								<?php
									//セミナー資料 設定がなければ表示しない
									if( get_field('seminar-file') ) { ?>
									<a href="<?php the_field('seminar-file'); ?>" target="_blank"><img src="/common/images/ico_pdf.png" alt="PDF"></a>
								<?php } ?>
							</dd>

						</dl>

					</li>
					<?php endwhile;?><?php endif; ?><?php wp_reset_query(); ?>
				</ul>

			</section>

		</article>

	</section><!--/ #main -->



	<section id="side">

		<div id="sideMenu">

			<ul>

				<li><a href="/byoin/rinen/">理念</a></li>

				<li><a href="/byoin/gaiyo/">病院概要</a></li>

				<li><a href="/byoin/nintei/">施設認定・施設基準</a></li>

				<li><a href="/byoin/enkaku/">当院の歩み・沿革</a></li>

				<li><a href="/byoin/message/">院長挨拶・幹部紹介</a></li>

				<li><a href="/byoin/nintei-senmoni/">学会認定専門医/学会等施設認定</a></li>

			</ul>

			<ul>

				<li><a href="/byoin/data/">病院情報の公表</a></li>

				<li><a href="/byoin/chiikishien/">地域医療支援病院</a></li>

				<li><a href="/byoin/training/">臨床研修指定病院</a></li>

				<li><a href="/byoin/gaikoku-ishi/">外国医師臨床修練指定病院</a></li>

				<li><a href="/byoin/kyukyu/">救急告示病院</a></li>

			</ul>

			<ul>

				<li><a href="/lecture/">市民公開講座・勉強会・研究会のご案内</a></li>

				<li><a href="/kokuralive/">Live Demonstration in Kokura</a></li>

				<li><a href="/kanjyanokai/">患者の会</a></li>

				<li><a href="/volunteer/">ボランティア活動員について</a></li>



			</ul>

			<ul>

				<li><a href="/press/">当院の広報物</a></li>

				<li><a href="/gallery/" target="_blank">フォトギャラリー</a></li>

				<li><a href="/byoin/line_at/">LINE＠</a></li>

			</ul>

		</div>

		<div id="sideInfo">

			<dl>

				<dt>受付時間 （診察開始8:30&#65374;）</dt>

					<dd>新患/8:10&#65374;11:00　再来/8:10&#65374;11:30</dd>

					<dd class="note">＊詳しくは各診療科案内の外来医師担当表をご確認ください。</dd>

				<dt>休診日</dt>

					<dd>土・日曜日、祝日、年末年始</dd>

			</dl>

			<p class="address">〒802-8555<br>福岡県北九州市小倉北区浅野3丁目2-1</p>

			<p><img src="/common/images/img_side_tel.png" alt="093-511-2000（代表）"></p>

		</div>

	</section><!--/ #side -->

</div><!--/ #contents -->



<footer>

	<div class="inner">

		<div id="footerMenu">

			<ul>

				<li><a href="/privacy/">個人情報保護方針</a></li>

				<li><a href="/sitemap/">サイトマップ</a></li>

				<li><a href="http://www.shisenkai.jp/" target="_blank">一般財団法人 平成紫川会</a></li>

				<li><a href="/gallery/" target="_blank">フォトギャラリー</a></li>

				<li><a href="/common/pdf/fb_unyou.pdf" target="_blank">Facebook運用ポリシー</a></li>

			</ul>

		</div>

		<p id="copyright">Copyright © 2014Kokura Kinen Hospital All rights reserved. </p>

	</div>

</footer>



<script src="/common/js/share.js"></script>

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