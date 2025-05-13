<?php
// オプションテキスト整形
$optionData = "";
if(isset($_SESSION['option']))
{
  foreach($_SESSION['option'] as $option)
  {
    $optionData .= "・{$option}\n";
  }
}

// 誕生日テキスト整形
$birthday = isset($_SESSION['birthday']) ? str_replace('-', '/', $_SESSION['birthday']) : "";
$age1 = ($birthday !== "" && isset($_SESSION['preferred_date_1'])) ? getAge($_SESSION['preferred_date_1'], $birthday) . "歳" : "";
$age2 = ($birthday !== "" && isset($_SESSION['preferred_date_2'])) ? getAge($_SESSION['preferred_date_2'], $birthday) . "歳" : "";
$age3 = ($birthday !== "" && isset($_SESSION['preferred_date_3'])) ? getAge($_SESSION['preferred_date_3'], $birthday) . "歳" : "";

// 患者様送信用
$reply_mail_text = <<< EOM
健診仮予約のお知らせ
本メールは仮予約が完了したお客様にお送りしている自動返信メールです。返信はできません。
下記で仮予約を承りました。
確定しましたら担当者より改めてご連絡させていただきます。
-------------------------------------------------------------------------------
受診希望日
第1希望: {$_SESSION['preferred_date_1']}
第2希望: {$_SESSION['preferred_date_2']}
第3希望: {$_SESSION['preferred_date_3']}

受診区分
{$_SESSION['consultation_div']}

受診歴
{$_SESSION['medical_examination_history']}

受診者情報
氏名:{$_SESSION['last_name']} {$_SESSION['first_name']}
フリガナ:{$_SESSION['last_name_kana']} {$_SESSION['first_name_kana']}
性別:{$_SESSION['sex']}
健康保険証:{$_SESSION['insurance_tribe']}
保険者番号:{$_SESSION['insurer_number']}
保険証記号:{$_SESSION['insurance_union_symbol']}
保険証番号:{$_SESSION['insurance_number']}
生年月日:{$birthday}

健康保険組合名・事業所名
会社事業所名:{$_SESSION['office_name']}
健康保険組合名:{$_SESSION['insurer_name']}
郵便番号:{$_SESSION['office_postal_code']}
住所:{$_SESSION['office_address']}
電話番号:{$_SESSION['office_phone_number']}

受診書類送付先住所
受診書類送付先:{$_SESSION['send_div']}
郵便番号:{$_SESSION['send_postal_code']}
住所:{$_SESSION['send_address']}
電話番号:{$_SESSION['send_phone_number']}

ご連絡先:
ご連絡先:{$_SESSION['contact_div']}
電話番号:{$_SESSION['contact_phone_number']}
メールアドレス:{$_SESSION['mail_address']}

希望コース:{$_SESSION['course']}

希望健診オプション
{$optionData}

その他質問
{$_SESSION['request']}

-------------------------------------------------------------------------------
EOM;

// 病院様送信用
$reserve_mail_text = <<< EOM
健診仮予約のお知らせ
健診予約のお申込みがありました。
下記をご確認いただき、受診希望者様へご連絡お願いいたします。
-------------------------------------------------------------------------------
受診者情報
氏名:{$_SESSION['last_name']} {$_SESSION['first_name']} 様
フリガナ:{$_SESSION['last_name_kana']} {$_SESSION['first_name_kana']} 様
性別:{$_SESSION['sex']}
健康保険証:{$_SESSION['insurance_tribe']}
保険者番号:{$_SESSION['insurer_number']}
保険証記号:{$_SESSION['insurance_union_symbol']}
保険証番号:{$_SESSION['insurance_number']}
生年月日:{$birthday}

受診希望日
第1希望: {$_SESSION['preferred_date_1']}  受診時の年齢 {$age1}
第2希望: {$_SESSION['preferred_date_2']}  受診時の年齢 {$age2}
第3希望: {$_SESSION['preferred_date_3']}  受診時の年齢 {$age3}

受診区分
{$_SESSION['consultation_div']}

受診歴
{$_SESSION['medical_examination_history']}

健康保険組合名・事業所名
会社事業所名:{$_SESSION['office_name']}
健康保険組合名:{$_SESSION['insurer_name']}
郵便番号:{$_SESSION['office_postal_code']}
住所:{$_SESSION['office_address']}
電話番号:{$_SESSION['office_phone_number']}

受診書類送付先住所
受診書類送付先:{$_SESSION['send_div']}
郵便番号:{$_SESSION['send_postal_code']}
住所:{$_SESSION['send_address']}
電話番号:{$_SESSION['send_phone_number']}

ご連絡先:
ご連絡先:{$_SESSION['contact_div']}
電話番号:{$_SESSION['contact_phone_number']}
メールアドレス:{$_SESSION['mail_address']}

希望コース:{$_SESSION['course']}

希望健診オプション
{$optionData}

その他質問
{$_SESSION['request']}

-------------------------------------------------------------------------------
EOM;
?>