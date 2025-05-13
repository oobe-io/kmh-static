<?php
/*
Template Name: lecture-list
Description: 市民公開講座の一覧画面
*/
?>
<?php get_header('lecture'); ?>
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
				<ul id="sinryouMenu" class="al">
				<?php $currentYear = getLectureCurrentYear(); ?>
				<?php if (is_page('list')): ?>
					<li class="active"><a href="/lecture/list/"><?php echo $currentYear; ?>年度</a></li>
				<?php else: ?>
					<li><a href="/lecture/list/"><?php echo $currentYear; ?>年度</a></li>
				<?php endif; ?> 
				<?php
					$page = get_page_by_path('lecture/list');
					$pages = get_posts('post_type=page&posts_per_page=10&orderby=menu_order&post_parent=' . $page->ID);
				?>
				<?php foreach ($pages as $page): ?>
					<?php $year = get_the_title($page->ID); ?>
					<?php if ($post->ID == $page->ID): ?>
					<li class="active"><a href="/lecture/list/<?php echo $year; ?>/"><?php echo $year; ?>年度</a></li>
					<?php else: ?>
					<li><a href="/lecture/list/<?php echo $year; ?>/"><?php echo $year; ?>年度</a></li>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>
					<p class="center bold" style="font-size: 2em; width:70%; float:left;"><span class="colorRed">市民公開講座終了後に録画配信します。<br>約１週間ご覧いただけます。</span></p>
					<p style="float:left; width:10%;"><a href="https://www.youtube.com/@kokura-memorial-hospital/videos" target="_blank"><img src="/common/images/ico_youtube.png" alt="LINK"></a></p>
					<p style="float:left; width:20%; margin-top:1.5%;">小倉記念病院youtubeチャンネルはこちらをクリック</p>
				<ul class="l-lecture-lists">
					<?php
						// メインページは本年度の取得、その他はタイトルから年度を取得
						if (is_page('list')) {
							$year = $currentYear;
						} else {
							$year = get_the_title();
						}
						// 講座情報一覧
						$args = array(
							'post_type' => 'lecture',
							'posts_per_page' => -1,
							'meta_key' => 'lecture-date',
							'orderby' => 'meta_value',
							'order' =>  'ASC',
							'meta_query' => array(
								'relation' => 'AND',
								array(
									'key' => 'lecture-date',
									'value'=> array($year . '/04/01', $year + 1 . '/03/31'),
									'compare'=>'BETWEEN',
									'type'=>'DATE'
								),
							),
						);
						$posts = get_posts($args);
						foreach ($posts as $post):
							// カスタムフィールドの取得
							$fields = get_fields($post->ID);
							// 申込みが可能な場合
							if ($fields['lecture-limit'] == 0 || $fields['lecture-count'] < $fields['lecture-limit']) {
								$entry = canLectureEntry($post->ID);
							} else {
								$entry = false;
							}
							// 開催日の取得
							$lecture_date = str_replace('年', '年<br />', getLectureDate($post->ID));
					?>
					<li>
						<dl>
							<dt>
							<?php if ($entry): ?>
								<div><?php echo $lecture_date; ?></div>
								<div class="pc">
									<div class="btn">
										<a href="/lecture/entry/?id=<?php echo $post->ID; ?>">会場参加申込</a>
									</div>
								</div>
							<?php else: ?>
								<?php echo $lecture_date; ?>
							<?php endif; ?>
							</dt>
							<dd class="thumb thumb_list">
							<?php if ($fields['lecture-thumbnail'] == 'image'): ?>
								<img src="<?php echo $fields['lecture-image']; ?>" alt="" style="border:solid 1px #ccc;">
							<?php else: ?>
								<div class="youtube"><?php echo $fields['lecture-movie']; ?></div>
							<?php endif; ?>
							</dd>
							<dd class="detail">
								<?php if ($fields['lecture-status'] == 'cancel'): ?>
								<div class="title">
									<h2 class="bold"><?php echo $fields['lecture-cancel-text']; ?></h2>
								</div>
								<?php else: ?>
								<div class="title">
									<?php if (!empty($fields['lecture-series'])): ?>
									<p class="type"><?php echo $fields['lecture-series']; ?></p>
									<?php endif; ?>
									<h2 class="kakkoIndent">「<?php the_title(); ?>」</h2>
									<p class="schejule">
										<i>●</i><?php echo $fields['lecture-time']; ?>
										&nbsp;
										<?php if ($fields['lecture-venue-highlight']): ?>
										<i><span class="colorRed">●</span></i><span class="colorRed" style="font-weight:bold;"><?php echo $fields['lecture-venue']; ?></span>
										<?php else: ?>
										<i>●</i><?php echo $fields['lecture-venue']; ?>
										<?php endif; ?>
									</p>
								</div>
								<p>対象：<?php echo $fields['lecture-target']; ?> 参加費：<?php echo $fields['lecture-fee']; ?><br />
								講師：<?php echo $fields['lecture-lecturer']; ?></p>
								<?php endif; ?>
							</dd>
							<dd class="file">
								<?php if (!empty($fields['lecture-url'])): ?>
									<a href="<?php echo $fields['lecture-url']; ?>" target="_blank"><img src="/common/images/ico_youtube.png" alt="LINK"></a>
								<?php endif; ?>
								<?php if (!empty($fields['lecture-file'])): ?>
									<a href="<?php echo $fields['lecture-file']; ?>" target="_blank"><img src="/common/images/ico_pdf.png" alt="PDF"></a>
								<?php endif; ?>
							</dd>
							<dd class="entry">
								<?php if ($entry): ?>
								<div class="sp">
									<div class="btn">
										<a href="/lecture/entry/?id=<?php echo $post->ID; ?>">会場参加申込</a>
									</div>
								</div>
								<?php endif; ?>
							</dd>
						</dl>
					</li>
					<?php endforeach;?>
					<?php wp_reset_query(); ?>
				</ul>
			</section>
		</article>
	</section><!--/ #main -->
<?php get_footer(); ?>
