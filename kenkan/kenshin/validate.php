<?php
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  $errors = [];
  $input = [];

  $input['preferred_date_1'] = (isset($_SESSION['preferred_date_1'])) ? $_SESSION['preferred_date_1'] : " 年 /月/日";
  $input['preferred_date_2'] = (isset($_SESSION['preferred_date_2'])) ? $_SESSION['preferred_date_2'] : " 年 /月/日";
  $input['preferred_date_3'] = (isset($_SESSION['preferred_date_3'])) ? $_SESSION['preferred_date_3'] : " 年 /月/日";
  $input['consultation_div'] = (isset($_SESSION['consultation_div'])) ? $_SESSION['consultation_div'] : "";
  $input['medical_examination_history'] = (isset($_SESSION['medical_examination_history'])) ? $_SESSION['medical_examination_history'] : "";
  $input['last_name'] = (isset($_SESSION['last_name'])) ? $_SESSION['last_name'] : "";
  $input['first_name'] = (isset($_SESSION['first_name'])) ? $_SESSION['first_name'] : "";
  $input['last_name_kana'] = (isset($_SESSION['last_name_kana'])) ? $_SESSION['last_name_kana'] : "";
  $input['first_name_kana'] = (isset($_SESSION['first_name_kana'])) ? $_SESSION['first_name_kana'] : "";
  $input['sex'] = (isset($_SESSION['sex'])) ? $_SESSION['sex'] : "";
  $input['insurance_tribe'] = (isset($_SESSION['insurance_tribe'])) ? $_SESSION['insurance_tribe'] : "";
  $input['insurer_number'] = (isset($_SESSION['insurer_number'])) ? $_SESSION['insurer_number'] : "";
  $input['insurance_union_symbol'] = (isset($_SESSION['insurance_union_symbol'])) ? $_SESSION['insurance_union_symbol'] : "";
  $input['insurance_number'] = (isset($_SESSION['insurance_number'])) ? $_SESSION['insurance_number'] : "";
  $input['birthday'] = (isset($_SESSION['birthday'])) ? $_SESSION['birthday'] : "";
  $input['office_name'] = (isset($_SESSION['office_name'])) ? $_SESSION['office_name'] : "";
  $input['insurer_name'] = (isset($_SESSION['insurer_name'])) ? $_SESSION['insurer_name'] : "";
  $input['office_postal_code'] = (isset($_SESSION['office_postal_code'])) ? $_SESSION['office_postal_code'] : "";
  $input['office_address'] = (isset($_SESSION['office_address'])) ? $_SESSION['office_address'] : "";
  $input['office_phone_number'] = (isset($_SESSION['office_phone_number'])) ? $_SESSION['office_phone_number'] : "";
  $input['send_div'] = (isset($_SESSION['send_div'])) ? $_SESSION['send_div'] : "";
  $input['send_postal_code'] = (isset($_SESSION['send_postal_code'])) ? $_SESSION['send_postal_code'] : "";
  $input['send_address'] = (isset($_SESSION['send_address'])) ? $_SESSION['send_address'] : "";
  $input['send_phone_number'] = (isset($_SESSION['send_phone_number'])) ? $_SESSION['send_phone_number'] : "";
  $input['contact_div'] = (isset($_SESSION['contact_div'])) ? $_SESSION['contact_div'] : "";
  $input['contact_phone_number'] = (isset($_SESSION['contact_phone_number'])) ? $_SESSION['contact_phone_number'] : "";
  $input['mail_address'] = (isset($_SESSION['mail_address'])) ? $_SESSION['mail_address'] : "";
  $input['mail_address_confirm'] = (isset($_SESSION['mail_address_confirm'])) ? $_SESSION['mail_address_confirm'] : "";
  $input['insurance'] = (isset($_SESSION['insurance'])) ? $_SESSION['insurance'] : "";
  $input['course'] = (isset($_SESSION['course'])) ? $_SESSION['course'] : "";
  $input['option'] = (isset($_SESSION['option'])) ? $_SESSION['option'] : "";
  $input['request'] = (isset($_SESSION['request'])) ? $_SESSION['request'] : "";

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $input['preferred_date_1'] = (isset($_POST['preferred_date_1'])) ? $_POST['preferred_date_1'] : $input['preferred_date_1'];
    $input['preferred_date_2'] = (isset($_POST['preferred_date_2'])) ? $_POST['preferred_date_2'] : $input['preferred_date_2'];
    $input['preferred_date_3'] = (isset($_POST['preferred_date_3'])) ? $_POST['preferred_date_3'] : $input['preferred_date_3'];
    $input['consultation_div'] = (isset($_POST['consultation_div'])) ? $_POST['consultation_div'] : $input['consultation_div'];
    $input['medical_examination_history'] = (isset($_POST['medical_examination_history'])) ? $_POST['medical_examination_history'] : $input['medical_examination_history'];
    $input['last_name'] = (isset($_POST['last_name'])) ? $_POST['last_name'] : $input['last_name'];
    $input['first_name'] = (isset($_POST['first_name'])) ? $_POST['first_name'] : $input['first_name'];
    $input['last_name_kana'] = (isset($_POST['last_name_kana'])) ? $_POST['last_name_kana'] : $input['last_name_kana'];
    $input['first_name_kana'] = (isset($_POST['first_name_kana'])) ? $_POST['first_name_kana'] : $input['first_name_kana'];
    $input['sex'] = (isset($_POST['sex'])) ? $_POST['sex'] : $input['sex'];
    $input['insurance_tribe'] = (isset($_POST['insurance_tribe'])) ? $_POST['insurance_tribe'] : $input['insurance_tribe'];
    $input['insurer_number'] = (isset($_POST['insurer_number'])) ? $_POST['insurer_number'] : $input['insurer_number'];
    $input['insurance_union_symbol'] = (isset($_POST['insurance_union_symbol'])) ? $_POST['insurance_union_symbol'] : $input['insurance_union_symbol'];
    $input['insurance_number'] = (isset($_POST['insurance_number'])) ? $_POST['insurance_number'] : $input['insurance_number'];
    $input['birthday'] = (isset($_POST['birthday'])) ? $_POST['birthday'] : $input['birthday'];
    $input['office_name'] = (isset($_POST['office_name'])) ? $_POST['office_name'] : $input['office_name'];
    $input['office_postal_code'] = (isset($_POST['office_postal_code'])) ? $_POST['office_postal_code'] : $input['office_postal_code'];
    $input['office_address'] = (isset($_POST['office_address'])) ? $_POST['office_address'] : $input['office_address'];
    $input['office_phone_number'] = (isset($_POST['office_phone_number'])) ? $_POST['office_phone_number'] : $input['office_phone_number'];
    $input['contact_div'] = (isset($_POST['contact_div'])) ? $_POST['contact_div'] : $input['contact_div'];
    $input['contact_phone_number'] = (isset($_POST['contact_phone_number'])) ? $_POST['contact_phone_number'] : $input['contact_phone_number'];
    $input['mail_address'] = (isset($_POST['mail_address'])) ? $_POST['mail_address'] : $input['mail_address'];
    $input['mail_address_confirm'] = (isset($_POST['mail_address_confirm'])) ? $_POST['mail_address_confirm'] : $input['mail_address_confirm'];
    $input['send_div'] = (isset($_POST['send_div'])) ? $_POST['send_div'] : $input['send_div'];
    $input['send_postal_code'] = (isset($_POST['send_postal_code'])) ? $_POST['send_postal_code'] : $input['send_postal_code'];
    $input['send_address'] = (isset($_POST['send_address'])) ? $_POST['send_address'] : $input['send_address'];
    $input['send_phone_number'] = (isset($_POST['send_phone_number'])) ? $_POST['send_phone_number'] : $input['send_phone_number'];
    $input['insurance'] = (isset($_POST['insurance'])) ? $_POST['insurance'] : $input['insurance'];
    $input['course'] = (isset($_POST['course'])) ? $_POST['course'] : $input['course'];
    $input['option'] = (isset($_POST['option'])) ? $_POST['option'] : $input['option'];
    $input['request'] = (isset($_POST['request'])) ? $_POST['request'] : $input['request'];
    //$input[''] = (isset($_POST[''])) ? $_POST[''] : "";
  }


  // 希望日
  if($input['preferred_date_1'] == " 年 /月/日") $errors['preferred_date_1'] = "受診希望日(第1希望日)をご入力ください。";
  if($input['preferred_date_2'] == " 年 /月/日") $errors['preferred_date_2'] = "受診希望日(第2希望日)をご入力ください。";
  if($input['preferred_date_3'] == " 年 /月/日") $errors['preferred_date_3'] = "受診希望日(第3希望日)をご入力ください。";

  if($input['preferred_date_1'] === $input['preferred_date_2'] || $input['preferred_date_2'] === $input['preferred_date_3'] || $input['preferred_date_3'] === $input['preferred_date_1'])
  {
    if($input['preferred_date_1'] !== " 年 /月/日" && $input['preferred_date_2'] !== " 年 /月/日" && $input['preferred_date_3'] !== " 年 /月/日") $errors['preferred_date'] = "受診希望日が重複しています。";
  }

  // 受診区分
  if(empty($input['consultation_div'])) $errors['consultation_div'] = "受診区分をご入力ください。";
  // 受診歴
  if(empty($input['medical_examination_history'])) $errors['medical_examination_history'] = "受診歴をご入力ください。";

  //受診者情報
  if(empty($input['last_name']))
  {
    $errors['last_name'] = "氏名(姓)をご入力ください。(30文字以内)";
  }
  elseif(mb_strlen($input['last_name']) > 30)
  {
    $errors['last_name'] = "氏名(姓)は30文字以内でご入力ください。";
  }

  if(empty($input['first_name']))
  {
    $errors['first_name'] = "氏名(名)をご入力ください。(30文字以内)";
  }
  elseif(mb_strlen($input['first_name']) > 30)
  {
    $errors['first_name'] = "氏名(名)は30文字以内でご入力ください。";
  }

  if(empty($input['last_name_kana']))
  {
    $errors['last_name_kana'] = "氏名フリガナ(姓)をご入力ください。(30文字以内)";
  }
  elseif(mb_strlen($input['last_name_kana']) > 30)
  {
    $errors['last_name_kana'] = "氏名フリガナ(姓)は30文字以内でご入力ください。";
  }
  else if(!preg_match('/\A[ァ-ヴー]+\z/u', $input['last_name_kana']))
  {
    $errors['last_name_kana'] = "氏名フリガナ(姓)は全角カタカナでご入力ください。(30文字以内)";
  }

  if(empty($input['first_name_kana']))
  {
    $errors['first_name_kana'] = "氏名フリガナ(名)をご入力ください。(30文字以内)";
  }
  else if(mb_strlen($input['first_name_kana']) > 30)
  {
    $errors['first_name_kana'] = "氏名フリガナ(名)は30文字以内でご入力ください。";
  }
  else if(!preg_match('/\A[ァ-ヴー]+\z/u', $input['first_name_kana']))
  {
    $errors['first_name_kana'] = "氏名フリガナ(名)は全角カタカナで入力してください。(30文字以内)";
  }

  if(empty($input['sex'])) $errors['sex'] = "性別をご入力ください。";

  if(empty($input['insurance_tribe']))
  {
    $errors['insurance_tribe'] = "健康保険証情報をご入力ください。";
  }

  if(empty($input['insurer_number']))
  {
    $errors['insurer_number'] = "保険者番号をご入力ください。(6文字か8文字)";
  }
  else if((mb_strlen($input['insurer_number']) !== 6) && (mb_strlen($input['insurer_number']) !== 8))
  {
    $errors['insurer_number'] = "保険者番号は6文字か8文字でご入力ください。";
  }

  if(empty($input['insurance_union_symbol']))
  {
    $errors['insurance_union_symbol'] = "保険証記号をご入力ください。(8文字以内)";
  }
  elseif(mb_strlen($input['insurance_union_symbol']) > 8)
  {
    $errors['insurance_union_symbol'] = "保険証記号は8文字以内でご入力ください。";
  }

  if(empty($input['insurance_number']))
  {
    $errors['insurance_number'] = "保険証番号をご入力ください。(8文字以内)";
  }
  elseif(mb_strlen($input['insurance_number']) > 8)
  {
    $errors['insurance_number'] = "保険証番号は8文字以内でご入力ください。";
  }

  if(empty($input['birthday']))
  {
    $errors['birthday'] = "生年月日をご入力ください。(8文字以内)";
  }

  // 健康保険組合名・事業所名
  if(empty($input['office_name']))
  {
    $errors['office_name'] = "会社・事業所名をご入力ください。";
  }
  else if(mb_strlen($input['office_name']) > 150)
  {
    $errors['office_name'] = "会社・事業所名は150文字以内でご入力ください。";
  }

  if(empty($input['office_postal_code']))
  {
    $errors['office_postal_code'] = "会社・事業所名の郵便番号をご入力ください。";
  }
  else if(!checkPostalCode($input['office_postal_code']))
  {
    $errors['office_postal_code'] = "会社・事業所名の郵便番号を正しくご入力ください。(ハイフンは半角でご入力ください。)";
  }

  if(empty($input['office_address']))
  {
    $errors['office_address'] = "会社・事業所名の住所をご入力ください。";
  }
  else if(mb_strlen($input['office_address']) > 150)
  {
    $errors['office_address'] = "会社・事業所名の住所は150文字以内でご入力ください。";
  }

  if(empty($input['office_phone_number']))
  {
    $errors['office_phone_number'] = "会社・事業所名の電話番号をご入力ください。";
  }
  else if(!checkPhoneNumber($input['office_phone_number']))
  {
    $errors['office_phone_number'] = "会社・事業所名の電話番号を正しくご入力ください。(ハイフンは半角でご入力ください。)";
  }

  // ご連絡先
  if(empty($input['contact_div'])) $errors['contact_div'] = "ご連絡先区分をご入力ください。";

  if(empty($input['contact_phone_number']))
  {
    $errors['contact_phone_number'] = "ご連絡先の電話番号をご入力ください。";
  }
  else if(!checkPhoneNumber($input['contact_phone_number']))
  {
    $errors['contact_phone_number'] = "ご連絡先の電話番号を正しくご入力ください。(ハイフンは半角でご入力ください。)";
  }

  if(empty($input['mail_address']))
  {
    $errors['mail_address'] = "ご連絡先のメールアドレスをご入力ください。";
  }
  else if(!checkMailAddress($input['mail_address']))
  {
    $errors['mail_address'] = "ご連絡先のメールアドレスを正しくご入力ください。";
  }
  else if(empty($input['mail_address_confirm']))
  {
    $errors['mail_address'] = "ご連絡先のメールアドレス(確認用)をご入力ください。";
  }
  else if(!($input['mail_address'] === $input['mail_address_confirm']))
  {
    $errors['mail_address'] = "ご連絡先のメールアドレスとメールアドレス(確認用)が異なります。";
  }

  // 受診書類送付先
  if(empty($input['send_div'])) $errors['send_div'] = "受診書類送付先をご入力ください。";

  if(empty($input['send_postal_code']))
  {
    $errors['send_postal_code'] = "受診書類送付先の郵便番号をご入力ください。";
  }
  else if(!checkPostalCode($input['send_postal_code']))
  {
    $errors['send_postal_code'] = "受診書類送付先の郵便番号を正しくご入力ください。(ハイフンは半角でご入力ください。)";
  }

  if(empty($input['send_address']))
  {
    $errors['send_address'] = "受診書類送付先の住所をご入力ください。";
  }
  else if(mb_strlen($input['send_address']) > 150)
  {
    $errors['send_address'] = "受診書類送付先の住所は150文字以内でご入力ください。";
  }

  if(empty($input['send_phone_number']))
  {
    $errors['send_phone_number'] = "受診書類送付先の電話番号をご入力ください。";
  }
  else if(!checkPhoneNumber($input['send_phone_number']))
  {
    $errors['send_phone_number'] = "受診書類送付先の電話番号を正しくご入力ください。(ハイフンは半角でご入力ください。)";
  }

  // 健診コース
  if(empty($input['course'])) $errors['cource'] = "希望コースを入力してください。";

  // その他質問
  if(mb_strlen($input['request']) > 500) $errors['request'] = "その他質問は500文字以内で入力してください。";


  // 郵便番号
  function checkPostalCode($postalCode)
  {
    return preg_match("/^[0-9]{3}-?[0-9]{4}$/", $postalCode);
  }

  // 電話番号
  function checkPhoneNumber($phoneNumber)
  {
    return (preg_match("/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/", $phoneNumber) || preg_match("/^0[7-9]0-[0-9]{4}-[0-9]{4}$/", $phoneNumber) || preg_match( "/^0[7-9]0[0-9]{8}$/", $phoneNumber));
  }

  // 保険証記号文字あり
  function checkInsuranceUnionSymbol($insuranceUnionSymbol)
  {
    return preg_match("/^[a-zA-Z]+{}$/", $insuranceUnionSymbol);
  }

  // メールアドレス
  function checkMailAddress($mailAddress)
  {
    return filter_var($mailAddress, FILTER_VALIDATE_EMAIL);
  }
?>