<?php
// 入力値判定
function validation($data) {
		$error = array();
	
		// 氏名のバリデーション
		// 名
		if( empty($data['first_name1']) ) {
			$error[] = "err1_first_name1";		// 未入力
		}
		
		// 姓
		if( empty($data['last_name1']) ) {
			$error[] = "err1_last_name1";		// 未入力
		}

		// 性別のバリデーション
		if( empty($data['gender1']) ) {
			$error[] = "err1_gender1";		// 未入力
		} elseif( $data['gender1'] !== 'male' && $data['gender1'] !== 'female' ) {
			$error[] = "err1_gender1";		// 未選択
		}
		
		// 年齢のバリデーション
		if(!preg_match('/^[0-9]+$/', $data['age1'])) {
			$error[] = "err1_age1";		// 数値以外
		}

		// 郵便番号のバリデーション
		if( empty($data['postno1_1']) || empty($data['postno1_2'])) {
			$error[] = "err1_postno1";		// 未入力
		} elseif( !preg_match('/^[0-9]+$/', $data['postno1_1']) || !preg_match('/^[0-9]+$/', $data['postno1_2'])) {
			$error[] = "err2_postno1";		// 数値以外
		} else if (strlen($data['postno1_1'] .$data['postno1_2']) != 7) {
			$error[] = "err3_postno1";		// 7ケタ以外
		}
		
		// 住所のバリデーション
		if( empty($data['address1'])) {
			$error[] = "err1_address1";		// 未入力
		}
		
		// 電話番号のバリデーション
		if( empty($data['telno1_1']) || empty($data['telno1_2']) || empty($data['telno1_3'])) {
			$error[] = "err1_telno1";		// 未入力
		} elseif( !preg_match('/^[0-9]+$/', $data['telno1_1']) || !preg_match('/^[0-9]+$/', $data['telno1_2']) || !preg_match('/^[0-9]+$/', $data['telno1_3'])) {
			$error[] = "err2_telno1";		// 数値以外
		} else if (strlen($data['telno1_1'] .$data['telno1_2'] .$data['telno1_3']) > 11) {
			$error[] = "err3_telno1";		// 12ケタ以上
		}
		
		// メールアドレスのバリデーション
		if( empty($data['email1']) ) {
			$error[] = "err1_email1";		// 未入力
		} elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email1']) ) {
			$error[] = "err2_email1";		// メール形式以外
		}
		
		// メールアドレス（確認）のバリデーション
		if( empty($data['email_confirm1']) ) {
			$error[] = "err1_email_confirm1";		// 未入力
		} elseif( $data['email1'] !== $data['email_confirm1'] ) {
			$error[] = "err2_email_confirm1";		// 不一致
		}
	
		// 参加者2は姓名どちらかが入力されている場合、バリデーションを行う
		if ( !empty($data['last_name2']) || !empty($data['first_name2']) ) {
			// 参加者2バリデーション開始
			// 氏名のバリデーション
			// 名
			if( empty($data['first_name2']) ) {
				$error[] = "err1_first_name2";		// 未入力
			}
			
			// 姓
			if( empty($data['last_name2']) ) {
				$error[] = "err1_last_name2";		// 未入力
			}

			// 性別のバリデーション
			if( empty($data['gender2']) ) {
				$error[] = "err1_gender2";		// 未入力
			} elseif( $data['gender2'] !== 'male' && $data['gender2'] !== 'female' ) {
				$error[] = "err1_gender2";		// 未選択
			}
			
			// 年齢のバリデーション
			if(!preg_match('/^[0-9]+$/', $data['age2'])) {
				$error[] = "err1_age2";		// 数値以外
			}
			
			// 住所についてチェックボックス判定
			// チェックボックスが付いている場合は参加者１と同じものを設定する。
			// 未チェックの場合は通常バリデーションを行う。
			if( empty($data['user_check']) ) {
				// チェックされてない
				// 郵便番号のバリデーション
				if( empty($data['postno2_1']) || empty($data['postno2_2'])) {
					$error[] = "err1_postno2";		// 未入力
				} elseif( !preg_match('/^[0-9]+$/', $data['postno2_1']) || !preg_match('/^[0-9]+$/', $data['postno2_2'])) {
					$error[] = "err2_postno2";		// 数値以外
				} else if (strlen($data['postno2_1'] .$data['postno2_2']) != 7) {
					$error[] = "err3_postno2";		// 7ケタ以外
				}
				
				// 住所のバリデーション
				if( empty($data['address2'])) {
					$error[] = "err1_address2";		// 未入力
				}
			}

			// 電話番号のバリデーション
			if( empty($data['telno2_1']) || empty($data['telno2_2']) || empty($data['telno2_3'])) {
				$error[] = "err1_telno2";		// 未入力
			} elseif( !preg_match('/^[0-9]+$/', $data['telno2_1']) || !preg_match('/^[0-9]+$/', $data['telno2_2']) || !preg_match('/^[0-9]+$/', $data['telno2_3'])) {
				$error[] = "err2_telno2";		// 数値以外
			} else if (strlen($data['telno2_1'] .$data['telno2_2'] .$data['telno2_3']) > 11) {
				$error[] = "err3_telno2";		// 12ケタ以上
			}
			
			// メールアドレスのバリデーション
			if( empty($data['email2']) ) {
				$error[] = "err1_email2";		// 未入力
			} elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email2']) ) {
				$error[] = "err2_email2";		// メール形式以外
			}
			
			// メールアドレス（確認）のバリデーション
			if( empty($data['email_confirm2']) ) {
				$error[] = "err1_email_confirm2";		// 未入力
			} elseif( $data['email2'] !== $data['email_confirm2'] ) {
				$error[] = "err2_email_confirm2";		// 不一致
			}
		}
		return $error;
}


// 申込数更新処理
function updSeminarCount ($postid) {
	$cnt_prev = get_post_meta($postid,'seminar-count', true); 
	if ($cnt_prev == null) {
		$cnt = 1;
	} else {
		$cnt = $cnt_prev + 1;
	}
	update_post_meta( $postid, 'seminar-count', $cnt, $cnt_prev );
}


// 申込情報DB更新処理
function insSeminarData ($postid, $post_title, $post_date, $post_venue, $clean) {
	$another_db = new wpdb(DB_USER, DB_PASSWORD, DB_NAME . '2', DB_HOST);
	// 参加者１
	$dbdata = array();
	$dbdata['title'] = $post_title;
	$dbdata['post_date'] = $post_date;
	$dbdata['post_venue'] = $post_venue;
	$dbdata['first_name'] = $clean['first_name1'];
	$dbdata['last_name'] = $clean['last_name1'];
	$dbdata['gender'] = $clean['gender1'];
	$dbdata['age'] = $clean['age1'];
	$dbdata['postno1'] = $clean['postno1_1'];
	$dbdata['postno2'] = $clean['postno1_2'];
	$dbdata['address'] = $clean['address1'];
	$dbdata['telno1'] = $clean['telno1_1'];
	$dbdata['telno2'] = $clean['telno1_2'];
	$dbdata['telno3'] = $clean['telno1_3'];
	$dbdata['email'] = $clean['email1'];
	$dbdata['dm'] = $clean['dm'];

	// 入力値をjson形式へ変換後、暗号化
	$jsonstr = json_encode($dbdata);
	$encrypted = openssl_encrypt($jsonstr, 'AES-128-CBC', DB_AUTH, OPENSSL_RAW_DATA, md5(DB_AUTH, true));
	$text = base64_encode($encrypted);

	// DB更新
	$another_db->insert('t_seminar',
		array('post_id' => $postid, 'form_id' => 1, 'datetime' => current_time('mysql'), 'text' => $text),
		array('%d', '%d', '%s', '%s')
	);

	// 参加者2は姓名どちらかが入力されている場合は追記
	if ( !empty($clean['last_name2']) || !empty($clean['first_name2']) ) {
		$dbdata = array();
		$dbdata['title'] = $post_title;
		$dbdata['post_date'] = $post_date;
		$dbdata['post_venue'] = $post_venue;
		$dbdata['first_name'] = $clean['first_name2'];
		$dbdata['last_name'] = $clean['last_name2'];
		$dbdata['gender'] = $clean['gender2'];
		$dbdata['age'] = $clean['age2'];
		if( $clean['user_check'] != "1") {
			// チェックされてない
			$dbdata['postno1'] = $clean['postno2_1'];
			$dbdata['postno2'] = $clean['postno2_2'];
			$dbdata['address'] = $clean['address2'];
		} else {
			// チェックされている
			$dbdata['postno1'] = $clean['postno1_1'];
			$dbdata['postno2'] = $clean['postno1_2'];
			$dbdata['address'] = $clean['address1'];
		}
		$dbdata['telno1'] = $clean['telno2_1'];
		$dbdata['telno2'] = $clean['telno2_2'];
		$dbdata['telno3'] = $clean['telno2_3'];
		$dbdata['email'] = $clean['email2'];
		$dbdata['dm'] = $clean['dm'];

		// 入力値をjson形式へ変換後、暗号化
		$jsonstr = json_encode($dbdata);
		$encrypted = openssl_encrypt($jsonstr, 'AES-128-CBC', DB_AUTH, OPENSSL_RAW_DATA, md5(DB_AUTH, true));
		$text = base64_encode($encrypted);
		// DB更新
		$another_db->insert('t_seminar',
			array('post_id' => $postid, 'form_id' => 1, 'datetime' => current_time('mysql'), 'text' => $text),
			array('%d', '%d', '%s', '%s')
		);
	}
}


// メール送信処理
function send_mail ($post_title, $post_date, $post_venue, $clean) {
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

// メールヘッダー設定
$header = <<<EOT
MIME-Version: 1.0
From: <iriguchi@accent-inc.jp>
Reply-To: <{$clean['email1']}>
BCC: <{$clean['email1']}>
EOT;

// 件名を設定
$auto_reply_subject = <<<EOT
市民公開講座{$post_title}申込完了のお知らせ
EOT;

// 事前に文字列変換
$request2 ="なし";
if (!empty($clean['last_name2'])){ 
	$request2 = $clean['last_name2'] ."　" .$clean['first_name2'] ."　様\n";
}

$request_dm ="受け取らない";
if( $clean['dm'] === "yes" ){
	$request_dm = "受け取る";
} 

// 本文を設定
$auto_reply_text = <<<EOT
市民公開講座 {$post_title} 申込完了のお知らせ

{$clean['last_name1']} 　{$clean['first_name1']} 　様

市民公開講座へのお申し込み、誠にありがとうございます。
申し込み内容は以下の通りです。
当日は会場受付にて本メールを携帯電話でご提示いただくか、
もしくは本メールを印刷したものをご提示ください。

市民公開講座{$post_title}
開催日：{$post_date}
会場：{$post_venue}
参加者１：{$clean['last_name1'] }　{$clean['first_name1']} 　様
参加者２：{$request2}

小倉記念病院からのお知らせ：{$request_dm}

当日のご来場を心よりお待ちしております。

■市民公開講座に関するお問合わせ
一般財団法人平成紫川会　事務局
TEL:096511-2058
EOT;

	// 参加者１メール送信
	mb_send_mail( $clean['email1'], $auto_reply_subject, $auto_reply_text, $header);
	
	// 指定があれば参加者２へのメール送信
	if (!empty($clean['last_name2'])){ 
		mb_send_mail( $clean['email2'], $auto_reply_subject, $auto_reply_text, $header);
	}
	
}
?>
