(function() {
  $(function() {
    $('#mainVisual').not('.animationSlide').flexslider({
      controlNav: false,
      directionNav: false,
      animationSpeed: 500
    });
    if ($('#mainVisual.animationSlide').size()) {
      $.fx.interval = 7;
      $(window).on('load', function() {
        var count, loop_count, slideAnimation, _slide_h, _slide_size, _slide_w, _window_w;
        _window_w = $(window).width();
        _slide_h = $('#mainVisual').find('li').height();
        _slide_w = $('#mainVisual').find('li').width();
        _slide_size = $('#mainVisual').find('li').size();
        $('#mainVisual').find('.slides').find('li').width(_window_w).end().width(_window_w * _slide_size).andSelf().height(_slide_h);
        count = 1;
        loop_count = 0;
        slideAnimation = function() {
          if (count >= _slide_size) {
            loop_count += count;
            count = 0;
          }
          $('#mainVisual').find('.slides').find('li').eq(count).css({
            'position': 'absolute',
            'left': _window_w,
            'z-index': count + loop_count + 1
          }).animate({
            'left': 0
          }, 3000, 'linear', function() {
            $(this).css({
              'z-index': count + loop_count
            }).prev('li').css({
              'left': _window_w
            });
            return setTimeout(function() {
              return slideAnimation();
            }, 7000);
          });
          return count += 1;
        };
        return setTimeout(function() {
          return slideAnimation();
        }, 7000);
      });
      setTimeout(function() {
        var _slide_h;
        _slide_h = $('#mainVisual').find('li').height();
        return $('#mainVisual').find('.slides').andSelf().height(_slide_h);
      }, 1000);
    }
  });

}).call(this);
