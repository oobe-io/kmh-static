(function() {
  $(function() {
    var fontSizeSwitch, h_size, ie8_flg, ie9_flg, initSideNavi, main_height, menuClose, menuOpen, resizeSideInfo, sameHeight, scrollFix, side_bottom, side_size, side_top, side_width, tantouId, tantouRow, ua, ver, w_size, _bottom, _font_size, _footer_top, _kkFlg, _ls_fontsize, _top, _wst;
    w_size = $(window).width() * 1.05;
    h_size = $(window).height();
    main_height = $('#main').height();
    _kkFlg = false;
    _wst = 0;
    _top = 0;
    _bottom = 0;
    _footer_top = 0;
    ua = window.navigator.userAgent.toLowerCase();
    ver = window.navigator.appVersion.toLowerCase();
    ie8_flg = ua.indexOf("msie") !== -1 && ver.indexOf("msie 8.") !== -1;
    ie9_flg = ua.indexOf("msie") !== -1 && ver.indexOf("msie 9.") !== -1;
    if (ie8_flg) {
      $('.l-ishi_profile').css('position', 'relative');
      $('.l-sinryou .text p').css('display', 'block');
      $('.l-ishi-other').css('background-size', 'contain');
      $('.l-sinryou-kangoshi .name').css({
        'position': 'relative',
        'bottom': 'auto',
        'margin-top': 100
      });
      $('#main .breadcrumbs').css('font-size', '.8em');
      $('.cupsule span').not('.data').css('padding', '10px 1% 11px');
      $('.l-data .cupsule span').not('.data').css('padding', '12px 1% 12px');
      $('#gairai_shindansyo_table').css('width', '89%');
      $('.l-soudanmadoguchi .bgArrowFlow p').css({
        'padding-left': 7,
        'margin-top': -5
      });
      $('#main .fz4').css({
        'font-size': '.83em'
      });
      $('#main .fz5').css({
        'font-size': '.95em'
      });
      $('#main #sinryouMenu .fz5').css({
        'font-size': '.78em'
      });
      $('#main .fz6').css({
        'font-size': '1em'
      });
      $('#main .fz7').css({
        'font-size': '1.08em'
      });
      $('#main .fz8').css({
        'font-size': '1.3em'
      });
      $('#main h1 .fz8').css({
        'font-size': '.4em'
      });
      $('#main .fz10').css({
        'font-size': '1.6em'
      });
      $('#main .fz11').css({
        'font-size': '1.83em'
      });
      $('#main .fz12').css({
        'font-size': '2em'
      });
      $('#main .fz13').css({
        'font-size': '2.16em'
      });
      $('.profile-header .list').css({
        'font-size': '1.8em'
      });
      $('.linker a').css({
        'background': '#fff',
        'opacity': 0
      }).on('mouseover', function() {
        return $(this).css('opacity', .5);
      }).on('mouseleave', function() {
        return $(this).css('opacity', 0);
      });
      $('#junkankiIshi01name').css({
        'padding': '15% 0'
      });
      $('.l-sinryou-shinzou .l-waterFlow_h').css({
        'width': '70px'
      });
      $('.l-shinryou-iryou-gan .toiawaseBox .title').css({
        'width': '80px'
      });
      $('.l-shiryou-saishin video').css({
        'height': '300'
      });
      $('.l-rights .bgArrowFlow').css({
        'background-image': 'url(/common/images/bg_arrow_flow_small_ie.png)'
      });
      $('.l-rights .tableLayout .dib').removeClass('.dib');
      if (w_size > 481) {
        $('.l-sinryou').addClass('pc-mini_window');
      }
    }
    if (w_size > 481 && w_size < 1200) {
      $('.l-sinryou').addClass('pc-mini_window');
    }
    if (ie9_flg) {
      $('.spacer').each(function() {
        var $this, _spacer_width;
        $this = $(this);
        _spacer_width = $this.data('space');
        return $this.append('<img class="spacer">').prepend('<img class="spacer">').find('.spacer').css({
          'width': _spacer_width,
          'height': 0
        });
      });
    }
    if ($('#side').size()) {
      side_size = $('#side').height();
      side_top = $('#side').offset().top;
      side_width = $('#side').width();
      side_bottom = side_size + side_top;
    }
    if (w_size > 480) {
      _ls_fontsize = localStorage.getItem('fontsize');
      if (_ls_fontsize != null) {
        _font_size = _ls_fontsize;
      } else {
        _font_size = '75';
        localStorage.setItem('fontsize', '75');
      }
      fontSizeSwitch = function(fz) {
        $('html').css({
          'font-size': fz + '%'
        });
        if (fz === '95') {
          $('header').find('#fzSwitch a').text('文字サイズ　縮小');
        } else {
          $('header').find('#fzSwitch a').text('文字サイズ　拡大');
        }
        _font_size = fz;
        return localStorage.setItem('fontsize', fz);
      };
      $('header').on('click', '#fzSwitch a', function(e) {
        e.preventDefault();
        if (_font_size === '75') {
          return fontSizeSwitch('95');
        } else {
          return fontSizeSwitch('75');
        }
      });
      $('header').append('<p id="fzSwitch"><a href="#">文字サイズ　拡大</a></p>');
      if (location.href.indexOf("/recruit/") === -1) {
        fontSizeSwitch(_font_size);
      }
      resizeSideInfo = function() {
        return $('#sideInfo').css({
          width: $('#side').width() - 1
        });
      };
      initSideNavi = function() {
        if (!ie8_flg) {
          _kkFlg = false;
          _wst = $('body').scrollTop();
          if (_wst >= side_top && _wst > 0) {
            $('#side').css({
              position: 'fixed',
              top: 0,
              bottom: 'auto',
              width: side_width + 'px'
            });
          }
          _top = $('#side').offset().top;
          _bottom = _top + $('#side').height();
          if (_bottom + 40 >= _footer_top) {
            _kkFlg = true;
            return $('#side').css({
              position: 'absolute',
              top: 'auto',
              bottom: 40,
              width: side_width + 'px'
            });
          }
        }
      };
      scrollFix = function() {
        if (main_height > side_size + 200) {
          initSideNavi();
          $(window).on('scroll', function() {
            _wst = $(window).scrollTop();
            _top = $('#side').offset().top;
            _bottom = _top + $('#side').height();
            _bottom = Math.floor(_bottom);
            if (_bottom + 40 >= _footer_top) {
              _kkFlg = true;
            }
            if (_kkFlg === false) {
              if (_wst >= side_top && _wst > 0) {
                return $('#side').css({
                  position: 'fixed',
                  top: 0,
                  bottom: 'auto',
                  width: side_width + 'px'
                });
              } else {
                return $('#side').css({
                  position: 'relative',
                  bottom: 'auto',
                  width: '21%'
                });
              }
            } else {
              $('#side').css({
                position: 'absolute',
                top: 'auto',
                bottom: 40,
                width: side_width + 'px'
              });
              if (_wst < _top) {
                _kkFlg = false;
                return $('#side').css({
                  bottom: 'auto'
                });
              }
            }
          });
          resizeSideInfo();
        }
      };
      if ($('#side').size()) {
        $(window).on('load resize', function() {
          var _fixed_startline, _side_top, _sidemenu_h;
          w_size = $(window).width();
          h_size = $(window).height();
          main_height = $('#main').height();
          side_width = $('#side').width();
          resizeSideInfo();
          _side_top = $('#side').offset().top;
          _side_top = Math.floor(_side_top);
          _sidemenu_h = $('#sideMenu').height();
          _fixed_startline = _side_top + _sidemenu_h + 33;
          _footer_top = $('footer').offset().top;
          _footer_top = Math.floor(_footer_top);
          if (!ie8_flg) {
            scrollFix();
          }
          if ($('.sameHeight').size()) {
            return sameHeight();
          }
        });
      }
      $('.accordion').find('> .btn a').on('click', function(e) {
        var _btn, _this;
        e.preventDefault();
        _this = $(this);
        _btn = _this.closest('.btn');
        if (_this.hasClass('open')) {
          _btn.next().slideUp(200, function() {
            main_height = $('#main').height();
            _footer_top = $('footer').offset().top;
            return scrollFix();
          });
          _this.removeClass('open');
          if (ie8_flg) {
            return _btn.animate({
              'margin-top': '.01em'
            });
          }
        } else {
          _btn.next().slideDown(200, function() {
            main_height = $('#main').height();
            _footer_top = $('footer').offset().top;
            return scrollFix();
          });
          return _this.addClass('open');
        }
      });
    } else {
      $(window).on('load', function() {
        $("#globalNavi").addClass('sp').append('<p class="closeBtn">閉じる</p>');
        $('header').append('<p id="menuBtn"><img src="/common/images/ico_menu.png" width="20"></p>');
        $('#menuBtn').on('click', function(e) {
          e.preventDefault();
          if ($("#menuBtn").hasClass("menuOpen")) {
            return menuClose();
          } else {
            return menuOpen();
          }
        });
        return $('#globalNavi .closeBtn').on('click', function(e) {
          return menuClose();
        });
      });
      menuClose = function() {
        $("#menuBtn").removeClass("menuOpen");
        $("#headerMenuBtnNormal").hide();
        $("#headerMenuBtnOpen").show();
        $("#globalNavi, #header .brand").fadeOut(200, function() {
          return $(this).removeClass("open");
        });
        return $('#contents').removeClass('locked');
      };
      menuOpen = function() {
        $("#menuBtn").addClass("menuOpen");
        $("#headerMenuBtnNormal").hide();
        $("#headerMenuBtnOpen").show();
        return $("#globalNavi, #header .brand").addClass("open").fadeIn(200, function() {
          return $('#contents').addClass('locked');
        });
      };
      $('.accordion').find('> .btn a').on('touchend', function(e) {
        var _btn, _this;
        e.preventDefault();
        _this = $(this);
        _btn = _this.closest('.btn');
        if (_this.hasClass('open')) {
          _btn.next().slideUp(200);
          return _this.removeClass('open');
        } else {
          _btn.next().slideDown(200);
          return _this.addClass('open');
        }
      });
      $('.spRemoveBr').find('br').remove();
      $('.spInsertBase').each(function() {
        var $this, _from;
        $this = $(this);
        _from = $this.find('.spInsertFrom');
        return $this.find('.spInsertTo').prepend(_from);
      });
      $('.l-ishi-rev').each(function() {
        var $this, _sec01, _sec02;
        $this = $(this);
        _sec01 = $this.find('.bgImage').closest('.row');
        _sec02 = $this.find('.l-ishi_text').closest('.row');
        return $this.find('.bgImage').appendTo(_sec01).end().end().find('.l-ishi_text').next('.cell').prependTo(_sec02);
      });
    }
    sameHeight = function() {
      var _same_h, _same_h_max;
      _same_h = $('.sameHeight').map(function() {
        return $(this).height();
      });
      _same_h_max = Math.max.apply(null, _same_h);
      return $('.sameHeight').each(function() {
        return $(this).height(_same_h_max);
      });
    };
    $(window).on('load', function() {
      var modalClose;
      w_size = $(window).width() * 1.05;
      h_size = $(window).height();
      modalClose = function() {
        return $('#shareBtnOverlay, #shareBtnContainer').stop().animate({
          'opacity': 0
        }, 300, function() {
          return $(this).hide();
        });
      };
      $('body').on('click', '#shareCloseBtn a', function(e) {
        e.preventDefault();
        return modalClose();
      });
      return $('#shareBtn').find('a').on('click', function(e) {
        e.preventDefault();
        if (!$('#shareBtnOverlay').size()) {
          $('body').append('<div id="shareBtnOverlay">').append('<div id="shareBtnContainer">');
          $('#shareBtnContainer').load('/common/parts/share.html');
        } else {
          $('#shareBtnOverlay, #shareBtnContainer').show();
        }
        $('#shareBtnOverlay').width(w_size).height(h_size).stop().animate({
          'opacity': .9
        }, 300).on('click', function() {
          return modalClose();
        });
        return $('#shareBtnContainer').css({
          'left': w_size / 2 - 350 / 2,
          'top': h_size / 2 - 240 / 2
        }).stop().animate({
          'opacity': 1
        }, 300);
      });
    });
    $('.backBtn').find('a').on('click', function(e) {
      e.preventDefault();
      history.back();
    });
    if ($('#tantouTable').size()) {
      tantouId = $('#tantouTable').data('id');
      tantouRow = $('#tantouTable').data('only');
      $('#tantouTable').load("/raiin/gairai_tantou/ #" + tantouId, function() {
        $(this).find(".department").remove();
        if (tantouRow) {
          return $(this).find(".selectRow").not('.' + tantouRow).remove();
        }
      });
    }
   
    const newsFilePath = `/news/info_list_update.json`
  
    // 指定したファイルを取得(news)
    return fetch(newsFilePath)
      .then(response => {
        if (!response.ok) {
            throw new Error(`HTTPエラー! ステータス: ${response.status}`);
        }
        return response.json(); // JSONデータを返す
      })
      .then(data => {
        // sideInfo要素を取得
        const sideInfo = $('#sideInfo').prepend('<div id="sideNews"><a href="/news/"><p class="headline">お知らせ</p><table></table>').find('#sideNews table')
  
        // JSONデータをループしてテーブルに行を追加
        var count = 3;
        data.some(item => {
          if (count-- <= 0) {
            return true;
          } 

          const row = document.createElement("tr");
  
          // 各カラムを生成してデータを挿入
          const dateCell = document.createElement("td");
          dateCell.textContent = item.date;
  
          const contentCell = document.createElement("td");
          if (item.content.length > 10) {
            item.content = item.content.slice(0, 15) + '…';
          }
          contentCell.textContent = item.content; 
  
          // 行にカラムを追加
          row.appendChild(dateCell);
          row.appendChild(contentCell);
  
          // 行をテーブルに追加
          sideInfo.append(row);
        });
      })
      .catch(error => {
        console.error("ニュースデータの読み込み中にエラーが発生しました:", error);
      });
  });

}).call(this);

$(function () {
  if ($('.l-ishi_profile').size()) {
    $('head').append('<link rel="stylesheet" href="/common/css/modaal.min.css">');
    $('footer').append('<script src="/common/js/modaal.min.js"></script>');
    $('.l-ishi_profile').each(function (i) {
      const $link = $('<a class="l-ishi_profile-link" href="#profile-' + i + '">専門医情報</a>');
      $(this).before($link);
      $(this).attr('id', 'profile-' + i ).before($link);
    });
    $(".l-ishi_profile-link").modaal({
      custom_class: 'l-ishi_profile'
    });
  }
});