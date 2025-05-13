(function() {
  $(function() {
    var h_size, menuClose, menuOpen, resizeSideInfo, side_bottom, side_size, side_top, side_width, w_size, _fixed_startline, _side_top, _sidemenu_h;
    w_size = $(window).width();
    h_size = $(window).height();
    if ($('#side').size()) {
      side_size = $('#side').height();
      side_top = $('#side').offset().top;
      side_width = $('#side').width();
    }
    side_bottom = side_size + side_top;
    if (w_size > 480) {
      if (w_size > 980) {
        _side_top = $('#side').offset().top;
        _side_top = Math.floor(_side_top);
        _sidemenu_h = $('#sideMenu').height();
        _fixed_startline = _side_top + _sidemenu_h + 33;
        $(window).on('load, resize', function() {
          w_size = $(window).width();
          h_size = $(window).height();
          side_width = $('#side').width();
          return resizeSideInfo();
        });
        $(window).on('scroll', function() {
          var _top, _wst;
          _wst = $(window).scrollTop();
          if (h_size > side_bottom) {
            _top = $('#side').offset().top;
            if (_top >= side_top && _wst > 0) {
              $('#side').css({
                position: 'fixed',
                bottom: 40,
                width: side_width + 'px'
              });
              resizeSideInfo();
            } else {
              $('#side').css({
                position: 'relative',
                bottom: 'auto',
                width: '21%'
              });
              resizeSideInfo();
            }
          } else {
            _top = $('#sideInfo').offset().top;
            _top = Math.floor(_top);
            if (_top >= _fixed_startline && _wst > 120) {
              $('#sideInfo').css({
                position: 'fixed',
                bottom: 40
              });
              resizeSideInfo();
            } else {
              $('#sideInfo').css({
                position: 'relative',
                width: 'auto',
                bottom: 'auto'
              });
            }
          }
        });
      }
      resizeSideInfo = function() {
        return $('#sideInfo').css({
          width: $('#side').width()
        });
      };
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
        $("#globalNavi").fadeOut(200, function() {
          return $(this).removeClass("open");
        });
        return $('#contents').removeClass('locked');
      };
      menuOpen = function() {
        $("#menuBtn").addClass("menuOpen");
        $("#headerMenuBtnNormal").hide();
        $("#headerMenuBtnOpen").show();
        return $("#globalNavi").addClass("open").fadeIn(200, function() {
          return $('#contents').addClass('locked');
        });
      };
    }
    $('.accordion').find('.btn a').on('click', function(e) {
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
  });

}).call(this);
