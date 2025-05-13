$ ->

	as = audiojs.createAll()
	audio = as[0]

	w_size = $ window
		.width()
	h_size = $ window
		.height()

	$(window).on 'load', ->
		imageAdjust()
		resizeText()
		linkBtnPositioning()
	$(window).on 'resize', ->
		w_size = $ window
			.width()
		h_size = $ window
			.height()
		imageAdjust()
		resizeText()
		linkBtnPositioning()

	linkBtnPositioning = ->
		footer_top = $('#footer').offset().top
		btn_height = $('.linkBtnArea .linkBtn').height()

		$('.linkBtnArea').css 'top', footer_top - btn_height

	imageAdjust = ->
		if w_size > 480
			### without mobile ###
			$('#mainVisual ul li').find('img')
				.each ->
					$this = $ this
					w = w_size
					h = h_size
					imgAsp = $this.width() / $this.height()
					dispAsp = w / h
					if imgAsp > dispAsp
						$this.css({
							"width" : 'auto'
							"height" : h
							"margin-top" : 0
							"margin-left" : ( w - $this.width() ) / 2
							})
					else
						$this.css({
							"width" : '100%'
							"height" : 'auto'
							"top" : 'auto'
							"margin-top" : ( h - $this.height() ) / 2
							"margin-left" : 0
							})
			return
		else
			### mobile ###
			$('#mainVisual ul li').not('.lastSlide').find('img').each ->
				$this = $ this
				_a = $this.attr('src').split('/')

				_src = "#{_a[0]}/#{_a[1]}/#{_a[2]}/w640/#{_a[4]}"
				$this.attr 'src', _src

	shuffleImg = (_target_no) ->
		_current = $('#mainVisual ul').find('li').eq(_target_no)
		_img = _current.find 'img'
		_slide_no = _target_no + 1
		_prefix = ''

		switch _slide_no
			when 1 then _rand_base = $('#set_count_01').data('set-count') || 20
			when 2 then _rand_base = $('#set_count_02').data('set-count') || 20
			when 3 then _rand_base = $('#set_count_03').data('set-count') || 20
			when 4 then _rand_base = $('#set_count_04').data('set-count') || 20
			when 5 then _rand_base = $('#set_count_05').data('set-count') || 20
			when 6 then _rand_base = $('#set_count_06').data('set-count') || 20

		_rand = parseInt(Math.random() * _rand_base) + 1
		_rand = ('0' + _rand).slice(-2)


		if $(window).width() <= 480
			_prefix = '/w640'

		_src = './images/slide_' + _slide_no + _prefix + '/image' + _rand + '.jpg'
		_img.attr 'src', _src
		return

	resizeText = ->
		if w_size > 1240
			_fz = w_size / 1240 * 100
			$ 'html'
				.css {
					'font-size': _fz + '%'
				}
		else
			$ 'html'
				.css {
					'font-size': '100%'
				}

	### init slide ###
	for i in [0..5]
		shuffleImg(i)

	$ '#mainVisual'
		.flexslider({
			controlNav: false
			directionNav: false
			animationSpeed: 1000
			slideshowSpeed: 2500
			# develop
			# animationSpeed: 500
			# slideshowSpeed: 500
			# animationLoop: false
			start: (slider) ->
				imageAdjust()
				audio.play()
			after: (slider) ->
				imageAdjust()
				_current_no = slider.currentSlide
				_target_no = _current_no - 1
				if _target_no < 0 || _target_no >= 6
					_target_no = slider.count - 1
				else
					shuffleImg(_target_no)
				if _current_no is 7
					setTimeout ->
						$('#linkBtnArea').fadeIn(800)
					, 500
			end: (slider) ->
				slider.pause()
				setTimeout ->
					slider
						.play()
					audio.play()
				, 13000

		})

	return