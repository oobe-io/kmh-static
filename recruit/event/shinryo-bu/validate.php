<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");

$SexData = array(
	array('code_id'=>1,'name'=>'男'),
	array('code_id'=>2,'name'=>'女')
);


$KiboukaData = array(
	array('code_id'=>1,'name'=>'麻酔科'),
	array('code_id'=>2,'name'=>'救急部'),
	array('code_id'=>3,'name'=>'循環器内科'),
	array('code_id'=>4,'name'=>'消化器内科'),
	array('code_id'=>5,'name'=>'脳神経外科'),
	array('code_id'=>6,'name'=>'脳神経内科'),
	array('code_id'=>7,'name'=>'心臓血管外科'),
	array('code_id'=>8,'name'=>'外科'),
	array('code_id'=>9,'name'=>'血液内科'),
	array('code_id'=>10,'name'=>'腎臓内科'),
	array('code_id'=>11,'name'=>'呼吸器内科'),
	array('code_id'=>12,'name'=>'糖尿病・内分泌・代謝内科')
);

$Errors = array();
$Inputs = array();

$Inputs['csrf'] = isset($_POST['csrf']) ? $_POST['csrf'] : '';
$Inputs['name'] = isset($_POST['name']) ? $_POST['name'] : '';
$Inputs['hurigana'] = isset($_POST['hurigana']) ? $_POST['hurigana'] : '';
$Inputs['byear'] = isset($_POST['byear']) ? $_POST['byear'] : '';
$Inputs['bmon'] = isset($_POST['bmon']) ? $_POST['bmon'] : '';
$Inputs['bday'] = isset($_POST['bday']) ? $_POST['bday'] : '';
$Inputs['sex'] = isset($_POST['sex']) ? $_POST['sex'] : '';
$Inputs['daigaku'] = isset($_POST['daigaku']) ? $_POST['daigaku'] : '';
$Inputs['gakunen'] = isset($_POST['gakunen']) ? $_POST['gakunen'] : '';
$Inputs['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
$Inputs['address'] = isset($_POST['address']) ? $_POST['address'] : '';
$Inputs['tel'] = isset($_POST['tel']) ? $_POST['tel'] : '';
$Inputs['mail'] = isset($_POST['mail']) ? $_POST['mail'] : '';
$Inputs['kinoubi'] = isset($_POST['kinoubi']) ? $_POST['kinoubi'] : '';
$Inputs['kibouka1'] = isset($_POST['kibouka1']) ? $_POST['kibouka1'] : '';
$Inputs['kibouka2'] = isset($_POST['kibouka2']) ? $_POST['kibouka2'] : '';
$Inputs['kibouka3'] = isset($_POST['kibouka3']) ? $_POST['kibouka3'] : '';
$Inputs['senko'] = isset($_POST['senko']) ? $_POST['senko'] : '';
$Inputs['other'] = isset($_POST['other']) ? $_POST['other'] : '';

$Inputs['byear'] = mb_convert_kana($Inputs['byear'],'a');
$Inputs['bmon'] = mb_convert_kana($Inputs['bmon'],'a');
$Inputs['bday'] = mb_convert_kana($Inputs['bday'],'a');
$Inputs['zip'] = mb_convert_kana($Inputs['zip'],'a');
$Inputs['tel'] = mb_convert_kana($Inputs['tel'],'a');
$Inputs['hurigana'] = mb_convert_kana($Inputs['hurigana'],'HcV');

$SexName = CodeIDtoName($SexData,$Inputs['sex']);
$Kibouka1Name = CodeIDtoName($KiboukaData,$Inputs['kibouka1']);
$Kibouka2Name = CodeIDtoName($KiboukaData,$Inputs['kibouka2']);
$Kibouka3Name = CodeIDtoName($KiboukaData,$Inputs['kibouka3']);


# 氏名
if (empty($Inputs['name']) === TRUE) {
	$Errors['name'] = '氏名をご入力ください。';
} elseif (mb_strlen($Inputs['name']) > 128) {
	$Errors['name'] = '氏名は128文字以内でご入力ください。';
}

# ふりがな
if (empty($Inputs['hurigana']) === TRUE){
	$Errors['hurigana'] = 'ふりがなをご入力ください。';
} elseif (is_valid_hurigana($Inputs['hurigana']) === FALSE) {
	$Errors['hurigana'] = 'ふりがなをご入力ください。';
} elseif (mb_strlen($Inputs['hurigana']) > 128) {
	$Errors['hurigana'] = 'ふりがなは128文字以内でご入力ください。';
}

# 生年月日
if (empty($Inputs['byear']) === TRUE) {
	$Errors['byear'] = '生年月日（年）をご入力ください。';
} elseif (mb_strlen($Inputs['byear']) > 4) {
	$Errors['byear'] = '生年月日（年）は4文字以内でご入力ください。';
}
if (empty($Inputs['bmon']) === TRUE) {
	$Errors['bmon'] = '生年月日（月）をご入力ください。';
} elseif (mb_strlen($Inputs['bmon']) > 2) {
	$Errors['bmon'] = '生年月日（月）は2文字以内でご入力ください。';
}
if (empty($Inputs['bday']) === TRUE) {
	$Errors['bday'] = '生年月日（日）をご入力ください。';
} elseif (mb_strlen($Inputs['bday']) > 2) {
	$Errors['bday'] = '生年月日（日）は2文字以内でご入力ください。';
}
if (empty($Inputs['byear']) === FALSE and empty($Inputs['bmon']) === FALSE and empty($Inputs['bday']) === FALSE) {
	if (checkdate ($Inputs['bmon'], $Inputs['bday'], $Inputs['byear']) === FALSE) {
		$Errors['byear'] = '生年月日が有効ではありません。';
		$Errors['bmon'] = '生年月日が有効ではありません。';
		$Errors['bday'] = '生年月日が有効ではありません。';
	}
}

# 性別
if (empty($Inputs['sex']) === TRUE){
	$Errors['sex'] = '性別をお選びください。';
} else if (is_valid_code_id($SexData,$Inputs['sex']) === FALSE) {
	$Errors['sex'] = '性別をお選びください。';
}

# 大学名
if (empty($Inputs['daigaku']) === TRUE) {
	$Errors['daigaku'] = '大学名をご入力ください。';
} elseif (mb_strlen($Inputs['daigaku']) > 128) {
	$Errors['daigaku'] = '大学名は128文字以内でご入力ください。';
}

# 学年
if (empty($Inputs['gakunen']) === TRUE) {
	$Errors['gakunen'] = '学年をご入力ください。';
} elseif (mb_strlen($Inputs['gakunen']) > 128) {
	$Errors['gakunen'] = '学年は128文字以内でご入力ください。';
}

# 郵便番号
if (empty($Inputs['zip']) === TRUE) {
	$Errors['zip'] = '郵便番号をご入力ください。';
} elseif(is_valid_zip($Inputs['zip']) === FALSE) {
	$Errors['zip'] = '郵便番号を正しくご入力ください。';
}


# 住所
if (empty($Inputs['address']) === TRUE) {
	$Errors['address'] = '住所をご入力ください。';
} elseif (mb_strlen($Inputs['address']) > 128) {
	$Errors['address'] = '住所は128文字以内でご入力ください。';
}

# 電話
if (empty($Inputs['tel']) === TRUE) {
	$Errors['tel'] = '電話番号をご入力ください。';
} elseif (is_valid_phone_number($Inputs['tel']) === FALSE) {
	$Errors['tel'] = '電話番号を正しくご入力ください。';
}

# e-mail
if (empty($Inputs['mail']) === TRUE) {
	$Errors['mail'] = 'e-mailをご入力ください。';
} elseif (is_valid_email($Inputs['mail']) === FALSE) {
	$Errors['mail'] = 'e-mailを正しくご入力ください。';
}elseif (strlen($Inputs['address']) > 256) {
	$Errors['address'] = 'e-mailは256文字以内でご入力ください。';
}

# 見学希望日
if (empty($Inputs['kinoubi']) === TRUE) {
	$Errors['kinoubi'] = '見学希望日をご入力ください。';
}elseif (mb_strlen($Inputs['kinoubi']) > 128) {
	$Errors['kinoubi'] = '見学希望日は128文字以内でご入力ください。';
}

# 見学第１希望科
if (empty($Inputs['kibouka1']) === TRUE){
	$Errors['kibouka1'] = '見学第１希望科をお選びください。';
}else if (is_valid_code_id($KiboukaData,$Inputs['kibouka1']) === FALSE) {
	$Errors['kibouka1'] = '見学第１希望科をお選びください。';
}

# 選考希望科
if (empty($Inputs['senko']) === FALSE) {
	if (mb_strlen($Inputs['senko']) > 128) {
		$Errors['senko'] = '選考希望科は128文字以内でご入力ください。';
	}
}

# 備考欄
if (empty($Inputs['other']) === FALSE) {
	if (mb_strlen($Inputs['other']) > 2000) {
		$Errors['other'] = '備考欄は2000文字以内でご入力ください。';
	}
}

function is_valid_code_id(&$items,$value)
{
	foreach($items as $item)
	{
		if($item['code_id'] == $value) return true;
	}
	return false;
}

function is_valid_zip($zip)
{
	return is_string($zip) && preg_match('/^(([0-9]{3}-[0-9]{4})|([0-9]{7}))$/',$zip);
}

function is_valid_phone_number($number)
{
    return is_string($number) && preg_match('/\A(((0(\d{1}[-(]?\d{4}|\d{2}[-(]?\d{3}|\d{3}[-(]?\d{2}|\d{4}[-(]?\d{1}|[5789]0[-(]?\d{4})[-)]?)|\d{1,4}\-?)\d{4}|0120[-(]?\d{3}[-)]?\d{3})\z/', $number);
}

function is_valid_email($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_valid_hurigana($name)
{
	if(mb_ereg("^[あ-んー～　 ]+$", $name)) return true;
	return false;
}

function CodeIDtoName(&$items,$code_id)
{
	foreach($items as $item)
	{
		if($item['code_id'] == $code_id) return $item['name'];
	}
	return '';
}


function generate_csrf()
{
	return hash('sha256', session_id());
}

function is_valid_csrf($token)
{
	$ret = generate_csrf() === $token;
	return $ret;
}

?>

