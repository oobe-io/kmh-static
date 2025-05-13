$ ->

	w_size = $ window
		.width() * 1.05
	h_size = $ window
		.height()

	main_height = $ '#main'
		.height()
	_kkFlg = false
	_wst = 0
	_top = 0
	_bottom = 0
	_footer_top = 0

	ua = window.navigator.userAgent.toLowerCase()
	ver = window.navigator.appVersion.toLowerCase()

	ie8_flg = ua.indexOf("msie") != -1 and ver.indexOf("msie 8.") != -1
	ie9_flg = ua.indexOf("msie") != -1 and ver.indexOf("msie 9.") != -1

	if ie8_flg
		$('.l-ishi_profile').css 'position', 'relative'
		$('.l-sinryou .text p').css 'display', 'block'
		$('.l-ishi-other').css 'background-size', 'contain'
		$('.l-sinryou-kangoshi .name').css({
			'position': 'relative'
			'bottom': 'auto'
			'margin-top': 100
			})
		$('#main .breadcrumbs').css 'font-size', '.8em'
		$('.cupsule span').not('.data').css 'padding', '10px 1% 11px'
		$('.l-data .cupsule span').not('.data').css 'padding', '12px 1% 12px'
		$('#gairai_shindansyo_table').css 'width', '89%'
		$('.l-soudanmadoguchi .bgArrowFlow p').css({
			'padding-left': 7
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
		$ '.profile-header .list'
			.css
				'font-size': '1.8em'

		$('.linker a').css({
			'background': '#fff'
			'opacity': 0
		}).on 'mouseover', ->
			$ this
				.css 'opacity', .5
		.on 'mouseleave', ->
			$ this
				.css 'opacity', 0

		$ '#junkankiIshi01name'
			.css
				'padding': '15% 0'

		$ '.l-sinryou-shinzou .l-waterFlow_h'
			.css
				'width': '70px'
		$ '.l-shinryou-iryou-gan .toiawaseBox .title'
			.css
				'width': '80px'

		$ '.l-shiryou-saishin video'
			.css
				'height': '300'

		$ '.l-rights .bgArrowFlow'
			.css
				'background-image': 'url(/common/images/bg_arrow_flow_small_ie.png)'
		$ '.l-rights .tableLayout .dib'
			.removeClass('.dib')


	if ie9_flg
		$('.spacer').each ->
			$this = $(this)
			_spacer_width = $this.data('space')
			$this
				.append('<img class="spacer">')
				.prepend('<img class="spacer">')
				.find('.spacer')
				.css({
					'width': _spacer_width
					'height': 0
				})



	if $('#side').size()
		side_size = $ '#side'
			.height()
		side_top = $ '#side'
			.offset().top
		side_width = $ '#side'
			.width()

		side_bottom = side_size + side_top



	if w_size > 480
		# not mobile

		_ls_fontsize = localStorage.getItem 'fontsize'

		if _ls_fontsize?
			_font_size = _ls_fontsize
		else
			_font_size = '75' # default
			localStorage.setItem 'fontsize', '75'

		fontSizeSwitch = (fz) ->

			$ 'html'
				.css
					'font-size': fz + '%'

			if fz is '95'
				$ 'header'
					.find '#fzSwitch a'
					.text '文字サイズ　縮小'
			else
				$ 'header'
					.find '#fzSwitch a'
					.text '文字サイズ　拡大'

			_font_size = fz
			localStorage.setItem 'fontsize', fz


		$ 'header'
			.on 'click', '#fzSwitch a', (e) ->
				e.preventDefault()
				if _font_size is '75'
					fontSizeSwitch('95')
				else
					fontSizeSwitch('75')

		$ 'header'
			.append '<p id="fzSwitch"><a href="#">文字サイズ　拡大</a></p>'


		if location.href.indexOf("/recruit/") == -1
			fontSizeSwitch(_font_size)


		resizeSideInfo = ->
			$ '#sideInfo'
				.css {
					width: $('#side').width() - 1
				}

		initSideNavi = ->
			if !ie8_flg
				_kkFlg = false
				_wst = $ 'body'
					.scrollTop()


				if _wst >= side_top and _wst > 0
					$ '#side'
						.css {
							position: 'fixed'
							top: 0
							bottom: 'auto'
							width: side_width + 'px'
						}

				_top = $ '#side'
					.offset().top
				_bottom = _top + $ '#side'
					.height()

				if _bottom + 40 >= _footer_top
					_kkFlg = true
					$ '#side'
						.css {
							position: 'absolute'
							top: 'auto'
							bottom: 40
							width: side_width + 'px'
						}

		scrollFix = ->

			if ( main_height > side_size+200 )

				initSideNavi()

				$(window).on 'scroll', ->

					_wst = $ window
						.scrollTop()

					_top = $ '#side'
						.offset().top

					_bottom = _top + $ '#side'
						.height()
					_bottom = Math.floor(_bottom)

					if _bottom + 40 >= _footer_top
						# 下部固定モードへ移行
						_kkFlg = true

					if _kkFlg is false
						# 上部固定モード
						if _wst >= side_top and _wst > 0
							$ '#side'
								.css {
									position: 'fixed'
									top: 0
									bottom: 'auto'
									width: side_width + 'px'
								}
						else
							$ '#side'
								.css {
									position: 'relative'
									bottom: 'auto'
									width: '21%'
								}
					else
						# 下部固定モード
						$ '#side'
							.css {
								position: 'absolute'
								top: 'auto'
								bottom: 40
								width: side_width + 'px'
							}

						if _wst < _top
							# 下部固定モード解除
							_kkFlg = false
							$ '#side'
								.css {
									bottom: 'auto'
								}


				resizeSideInfo()

				return

		# if w_size > 980 && $('#side').size()
		if $('#side').size()

			$(window).on 'load resize', ->

				w_size = $ window
					.width()
				h_size = $ window
					.height()
				main_height = $ '#main'
					.height()
				side_width = $ '#side'
					.width()
				resizeSideInfo()

				_side_top = $ '#side'
					.offset().top
				_side_top = Math.floor(_side_top)
				_sidemenu_h = $ '#sideMenu'
					.height()

				_fixed_startline = _side_top + _sidemenu_h + 33

				_footer_top = $ 'footer'
					.offset().top
				_footer_top = Math.floor(_footer_top)

				if !ie8_flg
					scrollFix()

				if ( $('.sameHeight').size() )
					sameHeight()

			$ window
				.on 'load', ->
					addSideNews()


		#accordion
		$ '.accordion'
			.find '> .btn a'
			.on 'click', (e) ->
				e.preventDefault()
				_this = $ this
				_btn = _this
					.closest '.btn'

				if (_this.hasClass('open'))
					_btn.next()
						.slideUp 200, ->
							main_height = $ '#main'
								.height()
							_footer_top = $ 'footer'
								.offset().top
							scrollFix()
					_this.removeClass 'open'
					if ie8_flg
						_btn.animate
							'margin-top': '.01em'
				else
					_btn.next()
						.slideDown 200, ->
							main_height = $ '#main'
								.height()
							_footer_top = $ 'footer'
								.offset().top
							scrollFix()
					_this.addClass 'open'

	else
		# mobile
		$(window).on 'load', ->
			$ "#globalNavi"
				.addClass 'sp'
				.append '<p class="closeBtn">閉じる</p>'
			$ 'header'
				.append '<p id="menuBtn"><img src="/common/images/ico_menu.png" width="20"></p>'

			$ '#menuBtn'
				.on 'click', (e) ->
					e.preventDefault()
					if $("#menuBtn").hasClass("menuOpen")
						menuClose()
					else
						menuOpen()

			$ '#globalNavi .closeBtn'
				.on 'click', (e) ->
					menuClose()


		menuClose = ->
			$ "#menuBtn"
				.removeClass "menuOpen"
			$ "#headerMenuBtnNormal"
				.hide()
			$ "#headerMenuBtnOpen"
				.show()
			$ "#globalNavi, #header .brand"
				.fadeOut 200, ->
					$ this
						.removeClass "open"
			$ '#contents'
				.removeClass 'locked'

		menuOpen = ->
			$ "#menuBtn"
				.addClass "menuOpen"
			$ "#headerMenuBtnNormal"
				.hide()
			$ "#headerMenuBtnOpen"
				.show()
			$ "#globalNavi, #header .brand"
				.addClass "open"
				.fadeIn 200, ->
					$ '#contents'
						.addClass 'locked'

		#accordion
		$ '.accordion'
			.find '> .btn a'
			.on 'touchend', (e) ->
				e.preventDefault()
				_this = $ this
				_btn = _this
					.closest '.btn'

				if (_this.hasClass('open'))
					_btn.next()
						.slideUp 200
					_this.removeClass 'open'
				else
					_btn.next()
						.slideDown 200
					_this.addClass 'open'

		#spRemoveBr
		$ '.spRemoveBr'
			.find 'br'
			.remove()

		#spInsert
		$ '.spInsertBase'
			.each ->
				$this = $(this)
				_from = $this
					.find '.spInsertFrom'
				$this
					.find '.spInsertTo'
					.prepend _from

		$ '.l-ishi-rev'
			.each ->
				$this = $(this)
				_sec01 = $this
					.find '.bgImage'
					.closest '.row'
				_sec02 = $this
					.find '.l-ishi_text'
					.closest '.row'

				$this
					.find '.bgImage'
					.appendTo _sec01
					.end().end()
					.find '.l-ishi_text'
					.next '.cell'
					.prependTo _sec02

	# 共通

	sameHeight = ->
		_same_h = $ '.sameHeight'
			.map ->
				$(this).height()

		_same_h_max = Math.max.apply(null, _same_h)

		$ '.sameHeight'
			.each ->
				$(this).height(_same_h_max)

	addSideNews = ->
		$.ajax
			type: 'get'
			url: '/news/'
			dataType: 'html'
			success: (data) ->
				_news = $ data
					.find '.newsTable tr'
					.slice 0, 3

				# media削除
				_news
					.find '.media'
					.remove()
					.end()


				_news
					.find 'td'
					.each ->
						# aタグ削除
						_txt = $ this
							.find 'a'
							.remove()
							.text()
						if _txt
							$ this
								.text _txt

						# 文字数省略
						_txt = $ this
							.text()

						if _txt.length > 10
							$ this
								.text(_txt.slice(0, 10) + '…')


				$ '#sideInfo'
					.prepend '<div id="sideNews"><a href="/news/"><p class="headline">お知らせ</p><table>'
					.find '#sideNews table'
					.append _news

				$ '#sideNews'
					.on 'click', ->
						location.href '/news/'



	$ window
		.on 'load', ->
			w_size = $ window
				.width() * 1.05
			h_size = $ window
				.height()

			modalClose = ->
				$ '#shareBtnOverlay, #shareBtnContainer'
					.stop()
					.animate
						'opacity': 0
					, 300
					, ->
						$ this
							.hide()

			$ 'body'
				.on 'click', '#shareCloseBtn a', (e) ->
					e.preventDefault()
					modalClose()

			$ '#shareBtn'
				.find 'a'
				.on 'click', (e) ->
					e.preventDefault()

					if !$('#shareBtnOverlay').size()
						$ 'body'
							.append '<div id="shareBtnOverlay">'
							.append '<div id="shareBtnContainer">'

						$ '#shareBtnContainer'
							.load '/common/parts/share.html'

					else
						$ '#shareBtnOverlay, #shareBtnContainer'
							.show()

					$ '#shareBtnOverlay'
						.width w_size
						.height h_size
						.stop()
						.animate
							'opacity': .9
						, 300
						.on 'click', ->
							modalClose()

					$ '#shareBtnContainer'
						.css
							'left': w_size / 2 - 350 / 2
							'top': h_size / 2 - 240 / 2
						.stop()
						.animate
							'opacity': 1
						, 300





	$ '.backBtn'
		.find 'a'
		.on 'click', (e) ->
			e.preventDefault()
			history.back()
			return

	if $('#tantouTable').size()
		tantouId = $ '#tantouTable'
			.data 'id'
		tantouRow = $ '#tantouTable'
			.data 'only'

		$ '#tantouTable'
			.load "/raiin/gairai_tantou/ ##{tantouId}", ->
				$(this).find(".department").remove()
				if tantouRow
					$(this).find(".selectRow").not('.' + tantouRow).remove()

	return