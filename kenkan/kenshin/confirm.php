<?php
  require("./settings/kenshin.php");
  session_start();
  // 不正の場合はリダイレクト
  if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION) || (isset($_SESSION) && count($_SESSION) == 0)|| isset($_SESSION['complete']))
  {
    unset($_SESSION['complete']);
    header('Location: ./');
    exit();
  }
  $token = uniqid('', true);
  $_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta charset="UTF-8">
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
  <h3><img src="/kenkan/kenshin//images/btn_global_kenshin.png" class="pe-2" alt="">健診申込書</h3>
  <h4 class="title mt-3">予約内容確認</h4>
  <div class="center-block">
    <table class="table mt-3 mb-3">
      <tbody>
        <tr>
          <th class="text-left w-25" rowspan="3">受診希望日</th>
          <td class="w-75"><span class="pe-1">第1希望:</span><?php echo htmlspecialchars($_SESSION['preferred_date_1'])?></td>
        </tr>
        <tr>
          <td><span class="pe-1">第2希望:</span><?php echo htmlspecialchars($_SESSION['preferred_date_2'])?></td>
        </tr>
        <tr>
          <td><span class="pe-1">第3希望:</span><?php echo htmlspecialchars($_SESSION['preferred_date_3'])?></td>
        </tr>
        <tr>
          <th class="text-left w-25">受診区分</th>
          <td class="w-75"><?php echo htmlspecialchars($_SESSION['consultation_div'])?></td>
        </tr>
        <tr>
          <th class="text-left w-25">受診歴</th>
          <td class="w-75"><?php echo htmlspecialchars($_SESSION['medical_examination_history'])?></td>
        </tr>
        <tr>
          <th class="text-left w-25" rowspan="5">受診者情報</th>
          <td class="w-75"><span class="pe-1">氏名:</span><?php echo htmlspecialchars($_SESSION['last_name']) . ' ' .htmlspecialchars($_SESSION['first_name'])?> </td>
        </tr>
        <tr>
          <td class="w-75"><span class="pe-1">フリガナ:</span><?php echo htmlspecialchars($_SESSION['last_name_kana']) . ' ' .htmlspecialchars($_SESSION['first_name_kana'])?> </td>
        </tr>
        <tr>
          <td><span class="pe-1">健康保険証:</span><?php echo htmlspecialchars($_SESSION['insurance_tribe'])?></td>
        </tr>
        <tr>
          <td>
            <div class="d-md-inline">
              <span class="pe-1">保険者番号:</span><?php echo htmlspecialchars($_SESSION['insurer_number'])?>
            </div>
            <div class="d-md-inline">
              <span class="pe-1">保険証記号:</span><?php echo htmlspecialchars($_SESSION['insurance_union_symbol'])?>
            </div>
            <div class="d-md-inline">
              <span class="pe-1">保険証番号:</span><?php echo htmlspecialchars($_SESSION['insurance_number'])?>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <span class="pe-1">生年月日:</span><?php echo htmlspecialchars(str_replace('-', '/', $_SESSION['birthday']))?>
          </td>
        </tr>
        <tr>
          <th class="text-left w-25" rowspan="5">健康保険組合名・事業所名</th>
          <td class="w-75">会社・事業所名:<br><?php echo htmlspecialchars($_SESSION['office_name'])?> </td>
        </tr>
        <tr>
          <td class="w-75"><span class="pe-1">健康保険組合名:</span><?php echo htmlspecialchars($_SESSION['insurer_name'])?></td>
        </tr>
        <tr>
          <td class="w-75"><span class="pe-1">郵便番号:</span><?php echo htmlspecialchars($_SESSION['office_postal_code'])?></td>
        </tr>
        <tr>
          <td>住所:<br><?php echo htmlspecialchars($_SESSION['office_address'])?></td>
        </tr>
        <tr>
          <td><span class="pe-1">電話番号:</span><?php echo htmlspecialchars($_SESSION['office_phone_number'])?></td>
        </tr>
        <tr>
          <th class="text-left w-25" rowspan="3">ご連絡先</th>
          <td class="w-75"><span class="pe-1">連絡先:</span><?php echo htmlspecialchars($_SESSION['contact_div'])?> </td>
        </tr>
        <tr>
          <td>電話番号:<?php echo htmlspecialchars($_SESSION['contact_phone_number'])?></td>
        </tr>
        <tr>
          <td class="w-75">メールアドレス:<br><?php echo htmlentities($_SESSION['mail_address'])?></td>
        </tr>
        <tr>
          <th class="text-left w-25" rowspan="4">受信書類送付先</th>
          <td class="w-75"><span class="pe-1">送付先:</span><?php echo htmlspecialchars($_SESSION['send_div'])?> </td>
        </tr>
        <tr>
          <td class="w-75"><span class="pe-1">郵便番号:</span><?php echo htmlentities($_SESSION['send_postal_code'])?></td>
        </tr>
        <tr>
          <td>住所:<br><?php echo htmlentities($_SESSION['send_address'])?></td>
        </tr>
        <tr>
          <td><span class="pe-1">電話番号:</span><?php echo htmlspecialchars($_SESSION['send_phone_number'])?></td>
        </tr>
        <tr>
          <th class="text-left w-25">希望健診</th>
          <td class="w-75"><?php echo htmlspecialchars($_SESSION['course'])?> </td>
        </tr>
        <tr>
          <th class="text-left w-25">希望健診オプション</th>
          <td class="w-75">
            <?php
              $options = "";
              if(isset($_SESSION['option']))
              {
                foreach($_SESSION['option'] as $option)
                {
                  $options .= "・{$option}<br>";
                }
              }
              else
              {
                $options = "無し";
              }
              echo $options;
            ?>
          </td>
        </tr>
        <tr>
          <th class="text-left w-25">その他（質問）</th>
          <td class="w-75"><?php echo htmlspecialchars($_SESSION['request'])?> </td>
        </tr>
      </tbody>
    </table>
  </div>
  <form id="confirm-form" method="POST" class="form-inline" action="./complete.php">
    <div class="form-group text-center mt-5">
      <input type="hidden" name="token" value="<?php echo $token;?>">
      <button class="btn btn-outline-dark d-inline p-2 col-md-2" formaction="./" formmethod="get">戻る</button>
      <button type="submit" id="confirm-submit" class="btn btn-primary p-2 col-md-2 offset-1">送信</button>
    </div>
  </form>
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
  <script src="./js/kenshin.js"></script>
</body>
</html>