$ ->

	auto_play_flg = true
	auto_play_timer = ''
	_showcase_w = 0
	_showcase_h = 0
	_count = 0
	_list_w = 0
	_loop_w = 0

	$.fx.interval = 7;

	ua = window.navigator.userAgent.toLowerCase()
	ver = window.navigator.appVersion.toLowerCase()

	ie8_flg = ua.indexOf("msie") != -1 and ver.indexOf("msie 8.") != -1

	# side menu

	$ '#menu'
		.find 'li a'
		.not '.outerLink'
		.on 'mouseenter', ->
			$ this
				.closest 'li'
				.addClass 'hover'
				.append '<div class="bg">'
			$ '.bg'
				.animate
					'width': '100%'
					'opacity': '1'
		.on 'mouseleave', ->
			$ this
				.closest 'li'
				.find '.bg'
				.animate
					'width': '0%'
					'opacity': '0'
				, ->
					$ this
						.closest 'li'
						.removeClass 'hover'
						.end()
						.remove()

	# slide loop

	loopSliderInit = ->
		_showcase_w = $ '#showcase'
			.width()
		_showcase_h = $ '#showcase'
			.height()
		_count = $ '#showcase'
			.find 'li'
			.size()
		_list_w = parseInt(_showcase_w / 5, 10)
		_loop_w = _list_w * _count

		# console.log _loop_w, _list_w

		$ '#showcase'
			.find 'ul'
			.wrapAll '<div id="showcaseWrapper">'
			.end()
			.find 'li'
			.width _list_w

		_duration = _count * 4000
		_duration = _duration / 1000
		# _duration = 1000

		$ '#showcaseWrapper'
			.width _loop_w * 2
			.height _showcase_h
			.css
				'left': 0

		loopsliderPosition = ->
			$ '#showcaseWrapper'
				.animate
					'left': '-' + _loop_w + 'px'
				, _duration * 1000
				, 'linear'
				, ->
					$ '#showcaseWrapper'
						.css
							'left': 0
					loopsliderPosition()

		setTimeout ->
			loopsliderPosition()
		, _duration

		$ '#showcase'
			.find 'ul'
			.clone()
			.appendTo '#showcaseWrapper'

	# switch image
	switchImage = (_src) ->
		_old_img_h = $ '#mainVisual'
			.height()
		_old_img_w = $ '#mainVisual'
			.width()
		_old_img = $ '#mainVisual'
			.addClass 'loading'
			.find 'img'
			.css
				'opacity': 0

		_img = new Image();
		_img.src = _src
		$(_img)
			.on 'load', ->
				_old_img.remove()

				$ '#mainVisual'
					.removeClass 'loading'
					.append $ this

	# switch set

	switchSet = (target) ->
		_set_code = target
			.attr 'href'
			.slice '6'
		_set_class = '.set_0' + _set_code


		# side menu
		$ '#menu'
			.find 'li'
			.removeClass 'current'
		target
			.closest 'li'
			.addClass 'current'

		# title
		$ '.title'
			.find 'p'
			.fadeOut()
			.end()
			.find _set_class
			.fadeIn()


		$ '#main'
			.find '.view'
			.fadeOut()
			.end()
			.find '#showcase'
			.fadeOut ->

				# main area

				url_array = location.pathname.split('/')
				# url_prefix = '/gallery/archives/early2015' # default
				url_prefix = ''

				if url_array[2] is 'archives'
					url_prefix = '/' + url_array[1] + '/' + url_array[2] + '/' + url_array[3]

				# main visual
				_first_image_src = url_prefix + "/images/slide_#{_set_code}/image01.jpg"
				switchImage(_first_image_src)
				# $ '#mainVisual'
				# 	.find 'img'
				# 	.attr 'src', _first_image_src

				# show case
				switch _set_code
					when '1' then _list_size = $('#set_count_01').data('set-count') || 20
					when '2' then _list_size = $('#set_count_02').data('set-count') || 20
					when '3' then _list_size = $('#set_count_03').data('set-count') || 20
					when '4' then _list_size = $('#set_count_04').data('set-count') || 20
					when '5' then _list_size = $('#set_count_05').data('set-count') || 20
					when '6' then _list_size = $('#set_count_06').data('set-count') || 20

				$ '#main'
					.find '#showcase'
					.find 'ul'
					.remove()
					.end()
					.append '<ul>'
					.find '#showcaseWrapper'
					.remove()

				for i in [1.._list_size]
					_num = parseInt(i)
					_num = ('0' + _num).slice(-2)
					_image_src = url_prefix + "/images/slide_#{_set_code}/w320/image#{_num}.jpg"

					$ '#main'
						.find '#showcase'
						.find 'ul'
						.append '<li><a href="#"><img src="' + _image_src + '"></a></li>'

				loopSliderInit()

				$ '#main'
					.find '.view, .title, #showcase'
					.fadeIn()

	$ '#menu'
		.find 'li a'
		.not '.outerLink'
		.on 'click', (e) ->
			e.preventDefault()
			switchSet($(this))
			auto_play_flg = false

	# set init

	_auto_play_target = $ '#menu'
		.find '.current'
		.find 'a'

	$ window
		.on 'load', ->
			switchSet(_auto_play_target)

	auto_play_timer = setInterval ->
		if auto_play_flg is true
			_next = $ '#menu'
				.find '.current'
				.next 'li'

			if _next.size()
				_auto_play_target = $ '#menu'
					.find '.current'
					.next 'li'
					.find 'a'
			else
				_auto_play_target = $ '#menu'
					.find 'li:first-child'
					.find 'a'

			switchSet(_auto_play_target)
		else
			clearInterval(auto_play_timer)
	, 8000




	# switch main visual

	$ '#main'
		.on 'click', '#showcase a', (e) ->
			e.preventDefault()
			_src = $ this
				.find 'img'
				.attr 'src'
				.split '/'

			if _src[5]
				_img_src = "/#{_src[1]}/#{_src[2]}/#{_src[3]}/#{_src[4]}/#{_src[5]}/#{_src[7]}" # archive
			else
				_img_src = "/#{_src[1]}/#{_src[2]}/#{_src[4]}" # top and gallery top

			switchImage(_img_src)

	$ '#navArchives'
		.on 'mouseenter', (e) ->
			$this = $(this)
			$this.addClass('is-open')
			$this.find('.navArchives_title').next('ul').slideDown()

		.on 'mouseleave', (e) ->
			$this = $(this).closest('#navArchives')
			$this.removeClass('is-open')
			$this.find('.navArchives_title').next('ul').slideUp()

	return