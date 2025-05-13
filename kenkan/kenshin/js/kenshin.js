$(function() {
  // 個人情報ポリシー同意
  if($('#policy').prop('checked') === true) {
    $("#policy").removeAttr("checked").prop("checked", false).change();
    $('#submit').prop('disabled', false);
  }

  // 送信ボタンの活性化
  $('#policy').on('click', function() {
    if($('#policy').prop('checked') === true) {
      $('#submit').prop('disabled', false);
    } else {
      $('#submit').prop('disabled', true);
    }
  });

  // 住所の引用
  $('input[name="send_div"]').change(function() {
    var sendDiv = $(this).val();
    if(sendDiv == '上記の住所') {
      $('#send_postal_code').val($('#office_postal_code').val());
      $('#send_address').val($('#office_address').val());
      $('#send_phone_number').val($('#office_phone_number').val());
    }
  });

  // フォームの多重送信防止
  $(document).on('submit', function(event) {
    $('#confirm-form').find('input[type="submit"], button[type="submit"]').prop('disabled', 'true');
  });

  //  性別毎にオプション表示
  if($('#male').prop('checked') === true) {
    $('div.sex2').hide();
    $('div.sex0').show();
    $('div.sex1').show();
  } else if($('#female').prop('checked') === true) {
    $('div.sex1').hide();
    $('div.sex0').show();
    $('div.sex2').show();
  }
  $('.sex').on('click', function() {
    var sex = $(this).attr('id');
    $('input[name="option[]"]').removeAttr("checked").prop("checked", false).change();
    if(sex == 'male') {
      $('div.sex2').hide();
      $('div.sex0').show();
      $('div.sex1').show();
    } else if(sex == 'female') {
      $('div.sex1').hide();
      $('div.sex0').show();
      $('div.sex2').show();
    }
  })
});