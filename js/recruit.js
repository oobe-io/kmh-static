(function() {
  $(function() {
    var sameHeight, w_size;
    w_size = $(window).width() * 1.05;
    if ($('#localMenu').size()) {
      $('#localMenu').find('li').each(function() {
        var $this, _container_width, _count, _i, _img_tag, _len, _num, _num_image_size, _results;
        $this = $(this);
        _count = $this.data('count');
        _count = String(_count);
        if (w_size > 480) {
          _num_image_size = 32;
        } else {
          _num_image_size = 20;
        }
        _container_width = _count.length * _num_image_size;
        _results = [];
        for (_i = 0, _len = _count.length; _i < _len; _i++) {
          _num = _count[_i];
          _img_tag = '<div class="numInner"><img class="numOutline" src="/common/images/ico_num_' + _num + '.png"><img class="numShadow" src="/common/images/ico_num_' + _num + '_shadow.png"></div>';
          _results.push($this.find('.count').css('width', _container_width).append(_img_tag).find('.numInner').css('width', _num_image_size));
        }
        return _results;
      });
    }
    if ($('.counter').size()) {
      $('.counter').each(function() {
        var $this, _container_width, _count, _i, _img_tag, _len, _num, _num_image_size, _results, _saiyo_fleg;
        $this = $(this);
        _count = $this.data('count');
        _count = String(_count);
        _saiyo_fleg = $('.l-saiyo').size();
        _num_image_size = 50;
        _container_width = _count.length * _num_image_size;
        _results = [];
        for (_i = 0, _len = _count.length; _i < _len; _i++) {
          _num = _count[_i];
          _img_tag = '<img src="/common/images/ico_no_' + _num + '.png">';
          $this.append(_img_tag);
          if (w_size > 400 && !_saiyo_fleg) {
            _results.push($this.css('width', _container_width));
          } else {
            _results.push(void 0);
          }
        }
        return _results;
      });
    }
    if (w_size > 480) {
      $(window).on('load', function() {
        return sameHeight();
      });
      $(window).on('resize', function() {
        return sameHeight();
      });
    }
    sameHeight = function() {
      var fl_height, r_height, _same_h, _same_h_max;
      if ($('.fullLeft').size()) {
        fl_height = $('.fullLeft').outerHeight();
        r_height = $('.flR.w800.relBox').outerHeight();
        if (fl_height > r_height) {
          return $('.flR.w800.relBox').height(fl_height);
        } else {
          return $('.fullLeft').height(r_height - 70);
        }
      } else {
        _same_h = $('.sameHeight').map(function() {
          return $(this).height();
        });
        _same_h_max = Math.max.apply(null, _same_h);
        return $('.sameHeight').each(function() {
          return $(this).height(_same_h_max);
        });
      }
    };
  });

}).call(this);
