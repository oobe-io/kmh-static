<?php

/*
	開催日の取得
*/
function getLectureDate($post_id)
{
	if (get_field('lecture-date-check', $post_id)) {
		$date = get_field('lecture-date-text', $post_id);
	} else {
		$week = array("日", "月", "火", "水", "木", "金", "土");
		$lecture_date = get_field('lecture-date', $post_id);
		$lecture_week = date("w", strtotime($lecture_date));
		$date = date("Y年n月j日", strtotime($lecture_date)) . '（' . $week[$lecture_week] . '）';
	}
	return $date;
}

/*
	受付中かどうかの判定
*/
function canLectureEntry($post_id)
{
	// カスタム投稿タイプが市民公開講座であること
	if (get_post_type($post_id) != 'lecture') {
		return false;
	}
	
	// 投稿が公開済みであること
	if (get_post_status($post_id) != 'publish') {
		return false;
	}
	
	// ステータスの取得
	$status = get_field('lecture-status', $post_id);
	
	// 受付中の場合、当日まで受付する
	if ($status == 'open') {
		$today = current_time('Y/m/d');
		$date = get_field('lecture-date', $post_id);
		if (strtotime($today) <= strtotime($date)) {
			return true;
		}
	}
	
	// 受付予約の場合、指定期間中を受付する
	if ($status == 'period') {
		$today = current_time("Y/m/d H:i");
		$stime = get_field('lecture-start', $post_id);
		$etime = get_field('lecture-end', $post_id);
		if (strtotime("$stime 00:00") <= strtotime($today) && strtotime($today) <= strtotime("$etime 23:59")) {
			return true;
		}
	}
	return false;
}

/*
	開催状態の取得（テキスト）
*/
function getLectureStatusText($post_id)
{
	// カスタム投稿タイプが市民公開講座であること
	if (get_post_type($post_id) != 'lecture') {
		return '－';
	}
	
	// 投稿が公開済みであること
	if (get_post_status($post_id) != 'publish') {
		return '－';
	}
	
	// ステータスの取得
	$status = get_field('lecture-status', $post_id);
	
	// 受付中の場合
	if ($status == 'open') {
		$today = current_time('Y/m/d');
		$date = get_field('lecture-date', $post_id);
		// 開催翌日以降の判定
		if (strtotime($today) > strtotime($date)) {
			return '開催済 （受付中）';
		}
	}
	
	// 受付予約の場合
	if ($status == 'period') {
		$today = current_time("Y/m/d");
		// 受付開始日前の場合
		$date = get_field('lecture-start', $post_id);
		if (strtotime($today) < strtotime($date)) {
			return '受付前 （受付予約）';
		}
		// 受付終了日後の場合
		$date = get_field('lecture-end', $post_id);
		if (strtotime($today) > strtotime($date)) {
			return '開催済 （受付予約）';
		}
	}
	
	// 開催状況
	$labels = array(
		'ready'  => '受付前',
		'open'   => '受付中',
		'period' => '受付予約',
		'close'  => '開催済',
		'cancel' => '中止',
	);
	
	return $labels[$status];
}

/*
	本年度の取得
*/
function getLectureCurrentYear()
{
	$year = date('Y');
	$today = $year . date('/m/d');
	$start = $year . '/04/01';
	// 4月以前は前年度
	if (strtotime($today) < strtotime($start)) {
		$year = date('Y', strtotime('-1 year'));
	}
	return $year;
}

/*
	申し込みフォームのバリデーションチェック
*/
function checkLectureValidation($data)
{
	$error = array();
	
	// 氏名のバリデーション
	// 名
	if (empty($data['first_name1'])) {
		$error[] = "err1_first_name1";		// 未入力
	}
	// 姓
	if (empty($data['last_name1'])) {
		$error[] = "err1_last_name1";		// 未入力
	}
	// メイ
	if (empty($data['kana_first_name1'])) {
		$error[] = "err1_kana_first_name1";		// 未入力
	} elseif(!preg_match('/^[ァ-ヾ]+$/u', $data['kana_first_name1'])) {
		$error[] = "err2_kana_first_name1";		// カタカナ以外
	}
	// セイ
	if (empty($data['kana_last_name1'])) {
		$error[] = "err1_kana_last_name1";		// 未入力
	} elseif(!preg_match('/^[ァ-ヾ]+$/u', $data['kana_last_name1'])) {
		$error[] = "err2_kana_last_name1";		// カタカナ以外
	}
	// 性別のバリデーション
	if (empty($data['gender1'])) {
		$error[] = "err1_gender1";		// 未入力
	} elseif( $data['gender1'] !== 'male' && $data['gender1'] !== 'female' ) {
		$error[] = "err1_gender1";		// 未選択
	}
	// 年齢のバリデーション
	if (!preg_match('/^[0-9]+$/', $data['age1'])) {
		$error[] = "err1_age1";		// 数値以外
	}
	// 郵便番号のバリデーション
	if (empty($data['postno1_1']) || empty($data['postno1_2'])) {
		$error[] = "err1_postno1";		// 未入力
	} elseif (!preg_match('/^[0-9]+$/', $data['postno1_1']) || !preg_match('/^[0-9]+$/', $data['postno1_2'])) {
		$error[] = "err2_postno1";		// 数値以外
	} elseif (strlen($data['postno1_1'] .$data['postno1_2']) != 7) {
		$error[] = "err3_postno1";		// 7ケタ以外
	}
	// 住所のバリデーション
	if (empty($data['address1'])) {
		$error[] = "err1_address1";		// 未入力
	}
	// 電話番号のバリデーション
	if (empty($data['telno1_1']) || empty($data['telno1_2']) || empty($data['telno1_3'])) {
		$error[] = "err1_telno1";		// 未入力
	} elseif (!preg_match('/^[0-9]+$/', $data['telno1_1']) || !preg_match('/^[0-9]+$/', $data['telno1_2']) || !preg_match('/^[0-9]+$/', $data['telno1_3'])) {
		$error[] = "err2_telno1";		// 数値以外
	} elseif (strlen($data['telno1_1'] .$data['telno1_2'] .$data['telno1_3']) > 11) {
		$error[] = "err3_telno1";		// 12ケタ以上
	}
	// メールアドレスのバリデーション
	if (empty($data['email1'])) {
		$error[] = "err1_email1";		// 未入力
	} elseif (!preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email1'])) {
		$error[] = "err2_email1";		// メール形式以外
	}
	// メールアドレス（確認）のバリデーション
	if (empty($data['email_confirm1'])) {
		$error[] = "err1_email_confirm1";		// 未入力
	} elseif ($data['email1'] !== $data['email_confirm1']) {
		$error[] = "err2_email_confirm1";		// 不一致
	}
	// 参加者2は姓名どちらかが入力されている場合、バリデーションを行う
	if (!empty($data['last_name2']) || !empty($data['first_name2'])) {
		// 参加者2バリデーション開始
		// 氏名のバリデーション
		// 名
		if (empty($data['first_name2'])) {
			$error[] = "err1_first_name2";		// 未入力
		}
		// 姓
		if (empty($data['last_name2'])) {
			$error[] = "err1_last_name2";		// 未入力
		}
		// メイ
		if (empty($data['kana_first_name2'])) {
			$error[] = "err1_kana_first_name2";		// 未入力
		} elseif(!preg_match('/^[ァ-ヾ]+$/u', $data['kana_first_name2'])) {
			$error[] = "err2_kana_first_name2";		// カタカナ以外
		}
		// セイ
		if (empty($data['kana_last_name2'])) {
			$error[] = "err1_kana_last_name2";		// 未入力
		} elseif(!preg_match('/^[ァ-ヾ]+$/u', $data['kana_last_name2'])) {
			$error[] = "err2_kana_last_name2";		// カタカナ以外
		}
		// 性別のバリデーション
		if (empty($data['gender2'])) {
				$error[] = "err1_gender2";		// 未入力
		} elseif( $data['gender2'] !== 'male' && $data['gender2'] !== 'female') {
			$error[] = "err1_gender2";		// 未選択
		}
		// 年齢のバリデーション
		if (!preg_match('/^[0-9]+$/', $data['age2'])) {
			$error[] = "err1_age2";		// 数値以外
		}
		// 住所についてチェックボックス判定
		// チェックボックスが付いている場合は参加者１と同じものを設定する。
		// 未チェックの場合は通常バリデーションを行う。
		if (empty($data['user_check'])) {
			// チェックされてない
			// 郵便番号のバリデーション
			if (empty($data['postno2_1']) || empty($data['postno2_2'])) {
				$error[] = "err1_postno2";		// 未入力
			} elseif( !preg_match('/^[0-9]+$/', $data['postno2_1']) || !preg_match('/^[0-9]+$/', $data['postno2_2'])) {
				$error[] = "err2_postno2";		// 数値以外
			} elseif (strlen($data['postno2_1'] .$data['postno2_2']) != 7) {
				$error[] = "err3_postno2";		// 7ケタ以外
			}
			// 住所のバリデーション
			if (empty($data['address2'])) {
				$error[] = "err1_address2";		// 未入力
			}
		}
		// 電話番号のバリデーション
		if (empty($data['telno2_1']) || empty($data['telno2_2']) || empty($data['telno2_3'])) {
			$error[] = "err1_telno2";		// 未入力
		} elseif( !preg_match('/^[0-9]+$/', $data['telno2_1']) || !preg_match('/^[0-9]+$/', $data['telno2_2']) || !preg_match('/^[0-9]+$/', $data['telno2_3'])) {
			$error[] = "err2_telno2";		// 数値以外
		} elseif (strlen($data['telno2_1'] .$data['telno2_2'] .$data['telno2_3']) > 11) {
			$error[] = "err3_telno2";		// 12ケタ以上
		}
		// メールアドレスのバリデーション
		if (empty($data['email2'])) {
			$error[] = "err1_email2";		// 未入力
		} elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email2']) ) {
			$error[] = "err2_email2";		// メール形式以外
		}
		// メールアドレス（確認）のバリデーション
		if (empty($data['email_confirm2'])) {
			$error[] = "err1_email_confirm2";		// 未入力
		} elseif( $data['email2'] !== $data['email_confirm2'] ) {
			$error[] = "err2_email_confirm2";		// 不一致
		}
	}
	return $error;
}

// 申込数更新処理
function updateLectureCount($post_id)
{
	$count = get_post_meta($post_id, 'lecture-count', true); 
	if (empty($count)) {
		update_post_meta($post_id, 'lecture-count', 1);
	} else {
		update_post_meta($post_id, 'lecture-count', $count + 1, $count);
	}
}

// 申込情報DB更新処理
function insertLectureData($post_id, $post_title, $post_date, $post_venue, $clean)
{
	$db = new wpdb(DB_USER, DB_PASSWORD, DB_NAME_LECTURE, DB_HOST);
	// 参加者１
	$data = array(
		'title'		 =>	$post_title,
		'post_date'	 => $post_date,
		'post_venue' => $post_venue,
		'participant_no' => 1,
		'name'		 => array($clean['last_name1'], $clean['first_name1']),
		'first_name' => $clean['first_name1'],
		'last_name'	 => $clean['last_name1'],
		'kana_first_name' => $clean['kana_first_name1'],
		'kana_last_name'  => $clean['kana_last_name1'],
		'gender'	 => $clean['gender1'],
		'age'		 => $clean['age1'],
		'zipcode'	 => array($clean['postno1_1'], $clean['postno1_2']),
		'postno1'	 => $clean['postno1_1'],
		'postno2'	 => $clean['postno1_2'],
		'address'	 => $clean['address1'],
		'phone'		 => array($clean['telno1_1'], $clean['telno1_2'], $clean['telno1_3']),
		'telno1'	 => $clean['telno1_1'],
		'telno2'	 => $clean['telno1_2'],
		'telno3'	 => $clean['telno1_3'],
		'email'	 	 => $clean['email1'],
		'dm'		 => $clean['dm'],
		'question'	 => $clean['question'],
	);
	
	// 入力値をjson形式へ変換後、暗号化
	$json = json_encode($data);
	$encrypted = openssl_encrypt($json, 'AES-128-CBC', DB_PASSWORD, OPENSSL_RAW_DATA, md5(DB_PASSWORD, true));
	$text = base64_encode($encrypted);
	
	// DB更新
	$result = $db->insert('t_lecture',
		array('post_id' => $post_id, 'form_id' => 1, 'datetime' => current_time('mysql'), 'text' => $text, 'remove' => 0),
		array('%d', '%d', '%s', '%s')
	);
	// エラー時はログを残す
	if ($result == false) {
		error_log("insert:[" . $text . "]");
	}
	
	// 参加者2は姓名どちらかが入力されている場合のみ
	if (empty($clean['last_name2']) && empty($clean['first_name2'])) {
		return;
	}
	
	// 参加者2
	$data = array(
		'title'		 => $post_title,
		'post_date'	 => $post_date,
		'post_venue' => $post_venue,
		'participant_no' => 2,
		'name'		 => array($clean['last_name2'], $clean['first_name2']),
		'first_name' => $clean['first_name2'],
		'last_name'	 => $clean['last_name2'],
		'kana_first_name' => $clean['kana_first_name2'],
		'kana_last_name'  => $clean['kana_last_name2'],
		'gender'	 => $clean['gender2'],
		'age'		 => $clean['age2'],
		'zipcode'	 => array($clean['postno2_1'], $clean['postno2_2']),
		'postno1'	 => $clean['postno2_1'],
		'postno2'	 => $clean['postno2_2'],
		'address'	 => $clean['address2'],
		'phone'		 => array($clean['telno2_1'], $clean['telno2_2'], $clean['telno2_3']),
		'telno1'	 => $clean['telno2_1'],
		'telno2'	 => $clean['telno2_2'],
		'telno3'	 => $clean['telno2_3'],
		'email'		 => $clean['email2'],
		'dm'		 => $clean['dm'],
		'question'	 => $clean['question'],
	);
	// 参加者1と同じにチェックされている場合
	if ($clean['user_check'] == '1') {
		$data['zipcode'] = array($clean['postno1_1'], $clean['postno1_2']);
		$data['postno1'] = $clean['postno1_1'];
		$data['postno2'] = $clean['postno1_2'];
		$data['address'] = $clean['address1'];
	}
	
	// 入力値をjson形式へ変換後、暗号化
	$json = json_encode($data);
	$encrypted = openssl_encrypt($json, 'AES-128-CBC', DB_PASSWORD, OPENSSL_RAW_DATA, md5(DB_PASSWORD, true));
	$text = base64_encode($encrypted);
	
	// DB更新
	$result = $db->insert('t_lecture',
		array('post_id' => $post_id, 'form_id' => 1, 'datetime' => current_time('mysql'), 'text' => $text, 'remove' => 0),
		array('%d', '%d', '%s', '%s')
	);
	
	// エラー時はログを残す
	if ($result == false) {
		error_log("insert:[" . $text . "]");
	}
}

// メール送信処理
function sendLectureMail($keywords, $clean)
{
	// 変数とタイムゾーンを初期化
	date_default_timezone_set('Asia/Tokyo');
	
	// メール件名の設定
	$subject = "市民公開講座「{$keywords['post_title']}」申し込み完了のお知らせ";
	
	// 氏名の加工
	$name1 = $clean['last_name1'] . ' ' . $clean['first_name1'] . ' 様';
	$kana_name1 = $clean['kana_last_name1'] . ' ' . $clean['kana_first_name1'] . ' 様';
	$name2 = '';
	if (!empty($clean['last_name2']) && !empty($clean['first_name2'])) {
		$name2 = $clean['last_name2'] . ' ' . $clean['first_name2'] .' 様';
	}
	$kana_name2 = '';
	if (!empty($clean['kana_last_name2']) && !empty($clean['kana_first_name2'])) {
		$kana_name2 = $clean['kana_last_name2'] . ' ' . $clean['kana_first_name2'] .' 様';
	}

	// 郵便番号の加工
	$postno1 = $clean['postno1_1'] . '-' . $clean['postno1_2'];
	$postno2 = $clean['postno2_1'] . '-' . $clean['postno2_2'];

	$address1 = $clean['address1'];
	$address2 = $clean['address2'];

	// 電話番号の加工
	$telno1 = $clean['telno1_1'] . '-' . $clean['telno1_2'] . '-' . $clean['telno1_3'];
	$telno2 = $clean['telno2_1'] . '-' . $clean['telno2_2'] . '-' . $clean['telno2_3'];
	
	$email1 = $clean['email1'];
	$email2 = $clean['email2'];
	
	// 質問の加工
	$question = $clean['question'];

	// メールヘッダー設定
	$headers =
		"MIME-Version: 1.0\n" .
		"From: <" . EMAIL_FROM_LECTURE . ">\n" .
		"BCC: <" . EMAIL_BCC_LECTURE . ">\n";
	
	// メールヘッダー追記（参加者2）
	if (!empty($name2) && !empty($clean['email2'])) {
		$headers .= "CC: <{$clean['email2']}>\n";
	}
	
	// 本文を取得
	if ($keywords['post_reply_type'] == 1) {
		$slug = "pattern1";
	} elseif ($keywords['post_reply_type'] == 2) {
		$slug = "pattern2";
	} elseif ($keywords['post_reply_type'] == 3) {
		$slug = "pattern3";
	}

	// 変数を置換
	$message = wwwc_get_page_by_slug( $slug )->post_content;
	$message = str_replace("<<name1>>", $name1, $message);
	$message = str_replace("<<kana_name1>>", $kana_name1, $message);
	$message = str_replace("<<name2>>", $name2, $message);
	$message = str_replace("<<kana_name2>>", $kana_name2, $message);
	$message = str_replace("<<postno1>>", $postno1, $message);
	$message = str_replace("<<postno2>>", $postno2, $message);
	$message = str_replace("<<address1>>", $address1, $message);
	$message = str_replace("<<address2>>", $address2, $message);
	$message = str_replace("<<telno1>>", $telno1, $message);
	$message = str_replace("<<telno2>>", $telno2, $message);
	$message = str_replace("<<email1>>", $email1, $message);
	$message = str_replace("<<email2>>", $email2, $message);
	$message = str_replace("<<question>>", $question, $message);
	$message = str_replace("<<post_title>>", $keywords['post_title'], $message);
	$message = str_replace("<<post_date>>", $keywords['post_date'], $message);
	$message = str_replace("<<post_time>>", $keywords['post_time'], $message);
	$message = str_replace("<<post_venue>>", $keywords['post_venue'], $message);
	$message = str_replace("<<post_reply_type>>", $keywords['post_reply_type'], $message);
	$message = str_replace("<<post_fee>>", $keywords['post_fee'], $message);
	$message = str_replace("<<post_lecturer>>", $keywords['post_lecturer'], $message);
	$message = str_replace("<<post_series>>", $keywords['post_series'], $message);
	
	// Return-Pathを設定
	$params = "-f " . EMAIL_FROM_LECTURE;
	
	// メール送信
	mb_send_mail($clean['email1'], $subject, $message, $headers, $params);
}

/**
 * Get a page object by slug.
 * https://codex.wordpress.org/Template_Tags/get_posts
 */
function wwwc_get_page_by_slug( $slug ) {
	$pages = get_posts(
		array(
		  'post_type'      => 'reply-type',
		  'name'           => $slug,
		  'posts_per_page' => 1,
		  'no_found_rows'  => true,
		)
	);
	return $pages ? $pages[0] : false;
}
?>
