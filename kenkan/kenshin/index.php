<?php
  session_start();
  require("./settings/kenshin.php");
  require("./validate.php");
  // コース情報取得
  $json = file_get_contents("./settings/cource.json"); 
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $courseData = json_decode($json,true);
  // 個人情報テキスト読み込み
  $policy = getPolicyText("./settings/policy.txt");
  if($_SERVER ['REQUEST_METHOD'] === 'POST')
  {
    $_SESSION = [];
    if(count($errors) === 0)
    {
      foreach($_POST as $key => $value)
      {
        $_SESSION[$key] = $value;
      }
      // 307でパラメーターを保持したままリダイレクト
      header('Location: ./confirm.php', true, 307);
      exit();
    }
  }
  if(isset($_SESSION['compete'])) unset($_SESSION['complete']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <link rel="stylesheet" href="./css/bootstrap-5.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./js/jquery-ui-1.12.1.custom/jquery-ui.css">
  <link rel="stylesheet" href="/common/css/kenkan.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <script src="/common/js/jquery-1.11.1.min.js"></script>
  <script src="./js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
  <script src="./css/bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
  <title>小倉記念病院健診予約フォーム</title>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
    <header id="header">
      <div class="menu" style="margin-left:0px;">
        <nav id="globalNavi">
          <ul class="mainNavi">
				<!-- <li><a href="/kenkan/pdf/20210804_yoyakuuketuke.pdf" target="_blank"><img src="/kenkan/common/images/btn_global_corona.png" alt=""><span>新型コロナ<br>感染対策<br><font color="red">NEW</font color></span></a></li> -->
				<li><a href="/kenkan/stay/"><img src="/kenkan/common/images/btn_global_stay.png" alt=""><span>宿泊ドック</span></a></li>
				<li><a href="/kenkan/1day/"><img src="/kenkan/common/images/btn_global_1day.png" alt=""><span class="space1day">日帰り<br>人間ドック</span></a></li>
				<li><a href="/kenkan/ippan/"><img src="/kenkan/common/images/btn_global_ippan.png" alt=""><span>一般健診</span></a></li>
				<li><a href="/kenkan/nou/"><img src="/kenkan/common/images/btn_global_nou.png" alt=""><span>脳ドック</span></a></li>
				<li><a href="/kenkan/nyugan/"><img src="/kenkan/common/images/btn_global_nyugan.png" alt=""><span>乳がん検診</span></a></li>
				<li><a href="/kenkan/koukuu/"><img src="/kenkan/common/images/btn_global_koukuu.png" alt=""><span>航空身体<br>検査</span></a></li>
				<li><a href="/kenkan/option/"><img src="/kenkan/common/images/btn_global_option.png" alt=""><span>オプション<br>検査</span></a></li>
				<li><a href="/kenkan/yoyaku/" target="_blank"><img src="/kenkan/common/images/btn_global_yoyaku.png" alt=""><span>予約方法</span></a></li>
				<li><a href="/press/pdf/other/20210312_kenkan.pdf" target="_blank"><img src="/kenkan/common/images/btn_global_ningen.png" alt=""><span>人間ドック<br>のススメ</span></a></li>
				<li><a href="/kenkan/kenshin/" target="_blank"><img src="/kenkan/common/images/btn_global_kenshin.png" alt=""><span>健診予約</span></a></li>
			</ul>
          <ul class="subNavi">
            <li><a href="/kenkan/jyushin/beginner/"><img src="/kenkan/common/images/ico_beginner.png" alt=""><span>はじめての方へ</span></a></li>
            <li><a href="/kenkan/jyushin/support/"><img src="/kenkan/common/images/ico_support.png" alt=""><span>受診後のサポート</span></a></li>
            <li><a href="/kenkan/jyushin/floormap/"><img src="/kenkan/common/images/ico_floormap.png" alt=""><span>フロアマップ</span></a></li>
            <li><a href="/kenkan/jyushin/access/"><img src="/kenkan/common/images/ico_access.png" alt=""><span>交通アクセス</span></a></li>
            <li><a href="/kenkan/nintei/"><img src="/kenkan/common/images/ico_nintei.png" alt=""><span>施設認定</span></a></li>
            <li><a href="/kenkan/faq/"><img src="/kenkan/common/images/ico_faq.png" alt=""><span>よくある質問</span></a></li>
          </ul>
        </nav>
      </div>
      <div class="brand">
        <p class="logo">小倉記念病院 健康管理センター</p>
        <div class="address">
          <p>〒802-8555  福岡県北九州市小倉北区浅野3丁目2-1</p>
          <p>受付時間／月～金曜日　9：30～15：30</p>
          <p><span class="spaceKyushin">休診日</span>／土・日曜日、祝日、年末年始</p>
        </div>
        <div class="tel"><span class="telNumber">TEL.093-511-3255</span><span class="small">（完全予約）</span></div>
      </div>
    </header>
    </div>
  </div>
  <div class="container mt-5">
    <h3><img src="/kenkan/kenshin/images/btn_global_kenshin.png" class="pe-2" alt="">健診申込書</h3>
    <p class="mt-4 mb-3">下記の健診申込書フォームで当院の健康診断にお申込いただけます。</p>
    <div class="">
      <p>ご予約フォーム</p>
      <ul>
        <li>お申し込みは予約希望日の2週間前までになりますので、早めにご予約ください。</li>
        <li>全てが必須項目になりますので、必ず入力してください。</li>
        <li>予約確認後、申し込み完了メールを返送いたします。また、内容確認が必要な場合は、当院より<span class="red">7営業日</span>以内に電話にてご連絡いたします。</li>
        <li>社会保険の加盟団体により料金体系が異なります。予めご確認いただきお申し込みください。</li>
        <li>この頁はSSLセキュリティを使用しております。送信できない場合は、お手数ですが電話でお問い合わせください。</li>
        <li>本申込書送付後、<span class="red">7営業日</span>を過ぎて返信の無い場合お手数ですが電話で問い合わせください。</li>
      </ul>
      <p class="mt-2">小倉記念病院 健康管理センター <br> TEL 093-511-3255</p>
    </div>
    <div>
      <?php
        if(count($errors) > 0 && $_SERVER ['REQUEST_METHOD'] === 'POST')
        {
          $errorMessage = "<div class='alert alert-danger' role='alert'>";
          foreach($errors as $key => $error)
          {
            $errorMessage .= "{$error}<br>";
          }
          $errorMessage .= "</div>";
          echo $errorMessage;
        }
        ?>
    </div>
    <form method="POST" action="./">
        <h4 class="title">受診希望日</h4>
        <div>
          <table class="table">
            <tbody>
              <tr>
                <th class="text-left w-25"><label for="preferred_date_1">第1希望</label></th>
                <td class="w-75"><input type="text" id="preferred_date_1" name="preferred_date_1" class="datepicker date_box" readonly="readonly" value="<?php echo htmlspecialchars($input['preferred_date_1'])?>" ></td>
              </tr>
              <tr>
                <th><label for="preferred_date_2">第2希望</label></th>
                <td><input type="text" id="preferred_date_2" name="preferred_date_2" class="datepicker date_box" readonly="readonly" value="<?php echo htmlspecialchars($input['preferred_date_2'])?>" ></td>
              </tr>
              <tr class="">
                <th><label for="preferred_date_3">第3希望</label></th>
                <td><input type="text" id="preferred_date_3" name="preferred_date_3" class="datepicker date_box" readonly="readonly" value="<?php echo htmlspecialchars($input['preferred_date_3'])?>"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <h4 class="title">受診の区分</h4>
        <div class="form-group m-3">
          <div class="d-md-inline radio-form">
            <input type="radio" class="form-check-input" id="union" name="consultation_div" value="健康保険組合の補助を受けて受診する" <?php if($input['consultation_div'] == "健康保険組合の補助を受けて受診する") echo "checked"?>>
            <label for="union">健康保険組合の補助を受けて受診する</label>
          </div>
          <div class="d-md-inline">
            <input type="radio" class="form-check-input" id="individual" name="consultation_div" value="個人で受診する" <?php if($input['consultation_div'] == "個人で受診する") echo "checked"?> >
            <label for="individual">個人で受診する</label>
          </div>
        </div>
        <div>
        </div>
        <h4 class="title">受診歴</h4>
        <b>過去に当院で受診されたことがありますか？</b>
        <div class="form-group m-3">
          <div class="d-md-inline radio-form">
            <input type="radio" class="form-check-input" id="exist" name="medical_examination_history" value="ある" <?php if($input['medical_examination_history'] == "ある") echo "checked"?>>
            <label for="exist">ある</label>
          </div>
          <div class="d-md-inline">
            <input type="radio" class="form-check-input" id="not_exist" name="medical_examination_history" value="ない" <?php if($input['medical_examination_history'] == "ない") echo "checked"?>>
            <label for="not_exist">ない</label>
          </div>
        </div>
        <h4 class="title">受診者情報</h4>
        <div class="center-block">
          <table class="table mt-5 mb-5">
            <tbody>
              <tr>
                <th class="text-left w-25"><label for="last_name">氏名</label></th>
                <td class="w-75">
                    <div class="d-md-inline">
                      <label for="last_name">姓:</label>
                      <input type="text" class="m-2" id="last_name" name="last_name" placeholder="" value="<?php echo $input['last_name']?>">
                    </div>
                    <div class="d-md-inline">
                      <label for="first_name">名:</label>
                      <input type="text" id="first_name" class="m-2" name="first_name" placeholder="" value="<?php echo $input['first_name']?>">
                    </div>
                </td>
              </tr>
              <tr>
                <th class="text-left w-25"><label for="last_name_kana">フリガナ(全角)</label></th>
                <td class="w-75">
                  <div class="d-md-inline">
                    <label for="last_name_kana">姓:</label>
                    <input type="text" inputmode="katakana" id="last_name_kana" class="m-2" name="last_name_kana" value="<?php echo htmlspecialchars($input['last_name_kana']) ?>">
                  </div>
                  <div class="d-md-inline">
                    <label for="first_name_kana">名:</label>
                    <input type="text" id="first_name_kana" class="m-2" name="first_name_kana" value="<?php echo htmlspecialchars($input['first_name_kana']) ?>">
                  </div>
                </td>
              </tr>
              <tr>
                <th class="text-left w-25">性別</label></th>
                <td class="w-75">
                  <input type="radio" id="male" class="sex ms-2 form-check-input" name="sex" value="男性" <?php if($input['sex'] == '男性') echo "checked"?> >
                  <label for="male">男性</label>
                  <input type="radio" id="female" class="sex ms-2 form-check-input" name="sex" value="女性" <?php if($input['sex'] == '女性') echo "checked"?> >
                  <label for="female">女性</label>
                </td>
              </tr>
              <tr>
                <th class="text-left">健康保険証</label></th>
                <td>
                  <div class="d-md-inline">
                    <input type="radio" id="person" class="ms-2 form-check-input" name="insurance_tribe" value="本人" <?php if($input['insurance_tribe'] == '本人') echo "checked"?> >
                    <label for="person">本人</label>
                  </div>
                  <div class="d-md-inline">
                    <input type="radio" id="family" class="ms-2 form-check-input" name="insurance_tribe" value="家族(配偶者)" <?php if($input['insurance_tribe'] == '家族(配偶者)') echo "checked"?> >
                    <label for="family">家族(配偶者)</label>
                  </div>
                  <div class="d-md-inline">
                    <input type="radio" id="continuation" class="ms-2 form-check-input" name="insurance_tribe" value="任意継続・退職者" <?php if($input['insurance_tribe'] == '任意継続・退職者') echo "checked"?> >
                    <label for="continuation">任意継続・退職者</label>
                  </div>
                </td>
              </tr>
              <tr>
                <th class="text-left w-25">保険者番号</label></th>
                <td class="w-75">
                  <div>
                    <label for="insurance_union_symbol">保険者番号 :</label>
                    <input type="text" id="insurance_union_symbol" class="m-2" name="insurer_number" maxlength="8" value="<?php echo htmlspecialchars($input['insurer_number']) ?>" ><br>
                  </div>
                  <div class="d-md-inline">
                    <label for="insurance_union_symbol">保険証記号 :</label>
                    <input type="text" id="insurance_union_symbol" class="m-2" name="insurance_union_symbol" maxlength="8" value="<?php echo htmlspecialchars($input['insurance_union_symbol']) ?>" >
                  </div>
                  <div class="d-md-inline">
                    <label for="insurer_number">保険証番号 :</label>
                    <input type="text" id="insurer_number" class="m-2" name="insurance_number" maxlength="8" value="<?php echo htmlspecialchars($input['insurance_number']) ?>" >
                  </div>
                </td>
              </tr>
              <tr>
                <th class="text-left"><label for="birthday">生年月日</label></th>
                <td>
                  <input type="date" id="birthday" class="m-2" max="<?php echo $today?>" name="birthday" value="<?php echo htmlspecialchars($input['birthday']) ?>" >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <h4 class="title">健康保険組合名・事業所名</h4>
        <div class="center-block">
          <table class="table mt-5 mb-5">
            <tbody>
              <tr>
                <th class="text-left w-25"><label for="office_name">会社・事業所名</label></th>
                <td class="w-75">
                  <input type="text" id="office_name" class="m-2" style="width:100%;" name="office_name" placeholder="" value="<?php echo htmlspecialchars($input['office_name'])?>">
                </td>
              </tr>
               <tr>
                <th class="text-left w-25"><label for="insurer_name">健康保険組合名</label></th>
                <td class="w-75">
                  <input type="text" id="insurer_name" class="m-2" style="width:100%;" name="insurer_name" placeholder="" value="<?php echo htmlspecialchars($input['insurer_name'])?>">
                </td>
              </tr>
              <tr>
                <th class="text-left"><label for="office_postal_code">郵便番号</label></th>
                <td>
                  <input type="text" id="office_postal_code" class="m-2" name="office_postal_code" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','office_address','office_address');" value="<?php echo htmlspecialchars($input['office_postal_code'])?>">
                </td>
              </tr>
              <tr>
                <th class="text-left"><label for="address">住所</label></th>
                <td>
                  <input type="text" id="office_address" class="m-2" style="width:100%;" name="office_address" value="<?php echo htmlspecialchars($input['office_address'])?>" placeholder="">
                </td>
              </tr>
              <tr>
                <th class="text-left"><label for="office_phone_number">電話番号</label></th>
                <td>
                  <input type="text" id="office_phone_number" class="m-2" name="office_phone_number" value="<?php echo htmlspecialchars($input['office_phone_number'])?>" placeholder="">
                </td>
              </tr>
            </tbody>
          </table>
          <h4 class="title">ご連絡先</h4>
          <div class="center-block">
            <table class="table mt-5 mb-5">
              <tbody>
                <tr>
                  <th class="text-left w-25">ご連絡先</th>
                  <td class="w-75">
                    <input type="radio" id="home_number" class="ms-2 form-check-input" name="contact_div" value="自宅" <?php if($input['contact_div'] == "自宅") echo "checked"?> >
                    <label for="home_number" >自宅</label>
                    <input type="radio" id="company_number" class="ms-2 form-check-input" name="contact_div" value="会社" <?php if($input['contact_div'] == "会社") echo "checked"?> >
                    <label for="company_number">会社</label>
                    <input type="radio" id="mobile_phone" class="ms-2 form-check-input" name="contact_div" value="携帯電話" <?php if($input['contact_div'] == "携帯電話") echo "checked"?> >
                    <label for="mobile_phone">携帯電話</label>
                  </td>
                </tr>
                <tr>
                  <th class="text-left"><label for="contact_phone_number">電話番号</label></th>
                  <td>
                    <input type="text" id="contact_phone_number" class="m-2" name="contact_phone_number" value="<?php echo htmlspecialchars($input['contact_phone_number'])?>" placeholder="">
                  </td>
                </tr>
                <tr>
                  <th class="text-left"><label for="mail_address">メールアドレス</label></th>
                  <td>
                    <input type="text" id="mail_address" class="m-2" style="width:100%;" name="mail_address" value="<?php echo htmlspecialchars($input['mail_address'])?>" placeholder="">
                  </td>
                </tr>
                <tr>
                  <th class="text-left"><label for="contact_mail_address_confirm">メールアドレス（確認用）</label></th>
                  <td>
                    <input type="text" id="mail_address_confirm" class="m-2" style="width:100%;" name="mail_address_confirm" value="<?php echo htmlspecialchars($input['mail_address_confirm'])?>" placeholder="">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <h4 class="title">受診書類送付先</h4>
        <div class="center-block">
          <table class="table mt-5 mb-5">
            <tbody>
              <tr>
                <th class="text-left w-25"><label for="office_name">受診書類送付先</label></th>
                <td class="w-75">
                  <div class="d-md-inline">
                    <input type="radio" id="send_home" class="ms-2 form-check-input" name="send_div" value="自宅" <?php if($input['send_div'] == "自宅") echo "checked"?> >
                    <label for="send_home" class="ml-1">自宅 </label>
                  </div> 
                  <div class="d-md-inline">
                    <input type="radio" id="send_company" class="ms-2 form-check-input" name="send_div" value="会社" <?php if($input['send_div'] == "会社") echo "checked"?> >
                    <label for="send_company" class="ml-1">会社 </label>
                  </div> 
                  <div class="d-md-inline">
                    <input type="radio" id="send_input_address" class="ms-2 form-check-input" name="send_div" value="上記の住所" <?php if($input['send_div'] == "上記の住所") echo "checked"?> >
                    <label for="send_input_address" class="ml-1">上記の住所</label>
                  </div>
                </td>
              </tr>
              <tr>
                <th class="text-left"><label for="send_postal_code">郵便番号</label></th>
                <td>
                  <input type="text" id="send_postal_code" class="m-2" name="send_postal_code" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','send_address','send_address');" value="<?php echo htmlentities($input['send_postal_code'])?>" >
                </td>
              </tr>
              <tr>
                <th class="text-left"><label for="send_address">住所</label></th>
                <td>
                  <input type="text" id="send_address" class="m-2" style="width:100%;" name="send_address" value="<?php echo htmlentities($input['send_address'])?>">
                </td>
              </tr>
              <tr>
                <th class="text-left"><label for="send_phone_number">電話番号</label></th>
                <td>
                  <input type="text" id="send_phone_number" class="m-2" name="send_phone_number" value="<?php echo htmlspecialchars($input['send_phone_number'])?>" placeholder="">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <h4 class="title">希望健診コース</h4>
        <div class="form-group m-3">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 max-auto">
            <?php
              $courses = "";
              foreach($courseData['courses'] as $course)
              {
                $checked = "";
                if($input['course'] === $course['name']) $checked = "checked";
                $courses .= "<div class='col'>";
                $courses .= "<input type='radio' class='me-1 form-check-input' id='course{$course['id']}' class='check-inline' name='course' value='{$course['name']}' {$checked}>";
                $courses .= "<label for='course{$course['id']}'>{$course['name']}</label>";
                $courses .= "</div>";
              }
              echo $courses;
            ?>
          </div>
        </div>
        <h4 class="title">希望健診オプション</h4>
        <div class="form-group m-3">
          <div class="mb-1">
            <p><span class="red">※ご登録者様のご年齢・お住まいによっては上記内容と異なるご案内になる場合がございます</span><br>
            オプション検査に関する詳細は<a href="/kenkan/option/" class="d-inline blue" target="_blank">こちら</a></p>
          </div>
          <div class="form-group">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 max-auto">
              <?php
                $options = "";
                foreach($courseData['options'] as $option)
                {
                  $checked = "";
                  $sex = 'sex' . $option['sex'];
                  $fee = ($option['fee'] !== "") ? '￥' . number_format($option['fee']) : "";
                  if(is_array($input['option'])) $checked = in_array($option['name'], $input['option']) ?"checked" : $checked;
                  $options .= "<div class='col-md-4 {$sex}'><label class='checkbox-inline' for='option{$option['id']}'><input type='checkbox' id='option{$option['id']}' class='form-check-input me-1' name='option[]' value='{$option['name']}' {$checked}>{$option['name']}</label></div>";
                  $options .= "<div class='col-md-2 text-right {$sex}'><label for='option{$option['id']}'>{$fee}</label></div>";
                }
                echo $options;
              ?>
            </div>
          </div>
        </div>
        <h4 class="title">その他質問</h4>
        <div class="form-group">
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" name="request" placeholder="こちらにご入力ください。"><?php echo htmlspecialchars($input['request'])?></textarea>
        </div>
        <h4 class="title">個人情報の取り扱いについて</h4>
        <div class="form-group">
          <textarea readonly class="form-control" rows="7"><?php echo $policy?></textarea>
        </div>
        <div class="mt-5">
          <div class="text-center">
            <input type="checkbox" class="form-check-input me-1" id="policy">
            <label for="policy">個人情報の取り扱いに同意する。</label>
            <p class="mt-3">入力内容を確認後、送信ボタンをクリックしてください。</p>
            <input type="submit" class="btn btn-primary w-25 mt-5" id="submit" name="aaa" value="送信" disabled>
          </div>
        </div>
      </form>
    </div>
  </div>
  <footer id="footer">
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
      <p id="copyright">Copyright c 2014Kokura Kinen Hospital All rights reserved. </p>
    </div>
  </footer>
  <script src="./js/ajaxzip3.github.io-master/ajaxzip3.js" charset="UTF-8"></script>
  <script src="./js/kenshin.js"></script>
  <script src="./js/calender.js"></script>
  <script>
    <?php
      $holidays = [];
      // １行ずつ読み込む
      $f = fopen("./settings/syukujitsu.csv", "r");
      $count = 0;
      while($data = fgetcsv($f))
      {
        if($count == 0)
        {
          $count++;
          continue;
        }
        $holidays[] = str_replace("/", "", date( 'Y/m/d', strtotime($data[0])));
      }
      fclose($f);
      // jsへ休日リストを渡す
      $holidays = json_encode($holidays);
    ?>
    // 休日情報取得
    var holidays = <?php echo $holidays?>;
  </script>
</body>
</html>