$(function(){

  // preferred_date
  resetPreferredDate();
  function resetPreferredDate(id) {
    $('.js-preferred_date').hide();
    $('.js-preferred_date-' + id).show();
  }

  $('[name=course]').on('change', function(e){
    var checked_id = $('[name=course]:checked').val();
    resetPreferredDate(checked_id);
  }).trigger('change');

  $('.js-form').on('submit', function(e){
    e.preventDefault();

    var submit_flg = true;

    $('.is-required:visible').each(function () {
      var $this = $(this);
      if ($this.hasClass('is-multi-input')) {
        $this.find('input, textarea').each(function () {
          if (!$(this).val()) {
            submit_flg = false;
          }
        });
      } else {
        var val = '';
        if ($this.hasClass('is-radio')) {
          val = $this.find('input:checked').val();
        } else {
          val = $this.find('input, textarea').val();
        }

        if ( !val ) {
          submit_flg = false;
        }
      }
    });

    if (!submit_flg) {
      $('.c-form__error').show();
    } else {
      $('.c-form__error').hide();
    }

    // send email
    if (submit_flg) {
      var data = $('.js-form').serializeArray();

      var address = 'matsumoto-sg@kokurakinen.or.jp';
      var subject = '【フェローコース・随時見学 申込み】送信用';
      var cource = ['フェローコース', '見学'];
      var cource_text = ['フェローコース希望月', '随時見学希望日'];
      var sex = ['男', '女'];
      var body = "\n\u3010\u30D5\u30A7\u30ED\u30FC\u30B3\u30FC\u30B9\u30FB\u968F\u6642\u898B\u5B66 \u7533\u8FBC\u307F\u3011\n\u3054\u898B\u5B66\u5E0C\u671B\u306E\u304A\u7533\u8FBC\u307F\u3042\u308A\u304C\u3068\u3046\u3054\u3056\u3044\u307E\u3059\u3002\n\u25BC\u4EE5\u4E0B\u3001\u7533\u8FBC\u307F\u5185\u5BB9\u3092\u3054\u78BA\u8A8D\u306E\u4E0A\u3001\u30E1\u30FC\u30EB\u3092\u9001\u4FE1\u304F\u3060\u3055\u3044\u3002\n\n\u3010\u9078\u3000\u629E\u3011\u3000".concat(cource[data[0].value], "\n\u3010").concat(cource_text[data[0].value], "\u3011\u3000").concat(data[0].value == 0 ? data[1].value : data[2].value, "\n\u3010\u6C0F\u3000\u540D\u3011\u3000").concat(data[3].value, "\n\u3010\u3075\u308A\u304C\u306A\u3011\u3000").concat(data[4].value, "\n\u3010\u751F\u5E74\u6708\u65E5\u3011\u3000").concat(data[5].value, "\u5E74").concat(data[6].value, "\u6708").concat(data[7].value, "\u65E5\n\u3010\u6027\u3000\u5225\u3011\u3000").concat(sex[data[8].value], "\n\u3010\u75C5\u9662\u540D\u3011\u3000").concat(data[9].value, "\n\u3010\u90F5\u4FBF\u756A\u53F7\u3011\u3000").concat(data[10].value, "\n\u3010\u4F4F\u3000\u6240\u3011\u3000").concat(data[11].value, "\n\u3010\u643A\u5E2F\u96FB\u8A71\u3011\u3000").concat(data[12].value, "\n\u3010e-mail\u3011\u3000").concat(data[13].value, "\n\u3010\u5099\u8003\u6B04\u3011\n").concat(data[14].value, "\n\n\u25B2\n\u304A\u7533\u8FBC\u307F\u3044\u305F\u3060\u304D\u307E\u3057\u3066\u3001\u8AA0\u306B\u3042\u308A\u304C\u3068\u3046\u3054\u3056\u3044\u307E\u3059\u3002\n\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\n\u201D\u3044\u3064\u3082\u306E\u66AE\u3089\u3057\u306B\u3001\u3044\u3064\u3082\u306E\u3042\u306A\u305F\u201D\n\u5C0F\u5009\u8A18\u5FF5\u75C5\u9662\n\u7D4C\u55B6\u4F01\u753B\u90E8\u3000\u4F01\u753B\u5E83\u5831\u8AB2\n\u3012802-8555 \u5317\u4E5D\u5DDE\u5E02\u5C0F\u5009\u5317\u533A\u6D45\u91CE3-2-1\nTEL\uFF1A093-511-2000(\u51854014)\nFAX\uFF1A093-511-3240\nhttp://www.kokurakinen.or.jp\n\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\u221E\n");

      body = encodeURIComponent(body);

      location.href = 'mailto:' + address + '?subject=' + subject + '&body=' + body;
    }

    return false;
    // return submit_flg;
  });
});