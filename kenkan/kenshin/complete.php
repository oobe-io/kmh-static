<?php
  session_start();
  require("./settings/kenshin.php");
  // トークンチェック
  $token = isset($_POST["token"]) ? $_POST["token"] : "";
  $session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
  unset($_SESSION['token']);
  $_SESSION['complete'] = true;

  // リダイレクト
  if($_SERVER['REQUEST_METHOD'] !== 'POST' || $session_token == "")
  {
    if(isset($_POST['continue']) && $_POST['continue'] == "はい")
    {
      //保持したくないセッションを削除
      header('Location: ./');
      exit;
    }
    else if(isset($_POST['continue']) && $_POST['continue'] == "いいえ")
    {
      $_SESSION = [];
      header('Location: ../');
      exit;
    }
    else
    {
      $_SESSION = [];
      header('Location: ./');
      exit();
    }
  }

  // メール送信
  if($token != "" && $token == $session_token)
  {
    require("./settings/mail.php");
    // 仮予約メール送信
    if(sendReplyMail($reply_mail_text, $_SESSION));
    if(sendReserveMail($reserve_mail_text));
  }
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
  <div class="container mt-4 mb-4">
    <h3><img src="/kenkan/kenshin/images/btn_global_kenshin.png" class="pe-2" alt="">健診申込書</h3>
    <div class="row text-center pt-5">
      <div class="d-block center">
        <img src="/kenkan/kenshin/images/icon_complete.png" class="pe-2" alt="">
      </div>
      <div class="pb-4">ご予約の申し込みを受け付けました。</div>
      <div>
        <b class="red"><?php echo $_SESSION['mail_address']?></b>に確認メールを送付しましたのでご確認下さい。<br>
        なお、現時点では仮予約の状態となります。<br>
        メールが届かない場合はお手数ですがお問い合わせ下さい。<br>
        <span class="me-1">小倉記念病院</span><span class="me-1">健康管理センター</span><b>TEL:093-511-3255</b>
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="text-center m-4">続けて入力を行いますか？</div>
        <form method="POST" id="complete-form" action="./complete.php">
          <div class="form-group text-center">
            <input type="submit" class="btn btn-primary d-inline p-2 col-md-2 s-button" name="continue" value="はい">
            <input type="submit" class="btn btn-outline-dark p-2 col-md-2 offset-1 s-button" name="continue" value="いいえ">
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
  <script src="./js/kenshin.js"></script>
</body>
</html>