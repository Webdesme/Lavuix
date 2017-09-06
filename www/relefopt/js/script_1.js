jQuery(document).ready(
	function() {
		HideMenuPopup = function() {
			var jqHolder = jQuery('#app-popup-menu');
			if(jqHolder.length) {
				app.HidePopup(jqHolder);
			}
		};

		RefreshMenuPopupPos = function(bAnimate) {
			var jqActiveMenu = jQuery('.inner-slide-list li.active');
			if(!jqActiveMenu.length) {
				return;
			}

			var iAnimateTime = bAnimate ? 300 : 0;

			var jqPopupHold = jQuery('#app-popup-menu');
			var jqPopup = jQuery('.popup', jqPopupHold);

			var bVisible = jqActiveMenu.is(':visible');
			var iActiveLinkOffsetTop = 0;
			if(!bVisible) {
				iActiveLinkOffsetTop = jqActiveMenu.closest('.slide-block').offset().top;
			} else {
				iActiveLinkOffsetTop = jqActiveMenu.offset().top;
			}

			var iPopupHeight = jqPopup.height();
			var iWindowScrollAndHeight = /*jQuery(window).scrollTop() + */jQuery(window).height();
			var iPopupScrollAndHeight = /*jqPopup.offset().top + */iPopupHeight;

			var iDeltaOffsetTop = 0;
			if(iPopupScrollAndHeight > iWindowScrollAndHeight) {
				iDeltaOffsetTop = iPopupScrollAndHeight - iWindowScrollAndHeight;
			}

			var iPopupTopTarget = iActiveLinkOffsetTop - iDeltaOffsetTop - 112;
			var jqMenuCont = jQuery('#shadow-box');
			var iMenuContTop = jqMenuCont.offset().top + 3;
			var iMenuContHeight = jqMenuCont.height();
			var iMenuContBottom = iMenuContTop + iMenuContHeight;

			if(iPopupHeight > (iMenuContHeight / 1.6)) {
				iPopupTopTarget = iMenuContTop;
			}
			if((iPopupTopTarget + iPopupHeight) > iMenuContBottom) {
				iPopupTopTarget = iMenuContBottom - iPopupHeight;
			}
			iPopupTopTarget = iPopupTopTarget < iMenuContTop ? iMenuContTop : iPopupTopTarget;

			jqPopup.stop().animate({'top': iPopupTopTarget+'px'}, iAnimateTime);
			jQuery('.slide-list-block__rectangle', jqPopup).stop().animate({'top': (iActiveLinkOffsetTop - iPopupTopTarget)+'px'}, iAnimateTime);
			//jqPopup.css({top: (iTopPopupOffset - iDeltaOffsetTop)+'px'});
			//jQuery('.slide-list-block__rectangle', jqPopup).css({top: (iActiveLinkOffsetTop - jqPopup.offset().top)+'px'});
		};

		ShowMenuPopup = function(sHtml) {
			var jqPopupHold = jQuery('#app-popup-menu');
			if(!jqPopupHold.length) {
				var sPopupBody = '';
				sPopupBody += '<div id="app-popup-menu" class="popup-holder popup-question" style="z-index: 100; display: none;">';
					sPopupBody += '<div class="bg"></div>';
					sPopupBody += '<div class="popup popup-menuleft">';
						sPopupBody += '<a class="close" href="javascript:void(0)">close</a>';
						sPopupBody += '<div class="popup-center"></div>';
						//sPopupBody += '<div class="popup-bottom"></div>';
					sPopupBody += '</div>';
				sPopupBody += '</div>';
				jQuery('body').append(sPopupBody);
				jqPopupHold = jQuery('#app-popup-menu');
			}
			if(jqPopupHold.length) {
				var jqPopup = jQuery('.popup', jqPopupHold);
				var bWasShowed = jqPopupHold.data('bShowed');
				jqPopupHold.data('bShowed', true);
				jQuery('.popup-center', jqPopupHold).html(sHtml);

                var countChildren = jQuery('#app-popup-menu .slide-list-block__body .slide-list-block__item').length;
                if (countChildren < 3)
                    {
											jQuery('.popup-menuleft', jqPopupHold).addClass('popup-menuleft-sm');
											if (countChildren = 2) jQuery('.popup-menuleft', jqPopupHold).addClass('popup-menuleft-sm_two');
										}
                else
                    jQuery('.popup-menuleft', jqPopupHold).removeClass('popup-menuleft-sm');

				jqPopup.css({width: '100%', 'margin-left': '-250px'});
				popupbg();
				jqPopupHold.css({'left': '-9999px'}).show();
				windowScroll(jqPopup.height());
				if(!bWasShowed) {
					jqPopupHold.hide();
				}
				jqPopupHold.css({'left': '0'});

				var iActiveLinkOffsetTop = jQuery('.inner-slide-list li.active').offset().top;
				jqPopup.css('top', (iActiveLinkOffsetTop - 112)+'px');
				jqPopupHold.fadeIn(300);

				jQuery('.slide-list-block__body', jqPopup).masonry({
					itemSelector : '.slide-list-block__item',
					columnWidth : 230
				});

				RefreshMenuPopupPos();
			}
		};

		var jqCont = jQuery('#shadow-box');
		var jqSecondLevelList = jQuery('.inner-slide-list li', jqCont);
		jQuery('.inner-slide-list li a', jqCont).each(
			function() {
				var jqThis = jQuery(this);
				var jqLi = jqThis.closest('li');
				var jqSubmenuCont = jQuery('div.slide-list-block', jqLi);
				if(jqSubmenuCont.get(0)) {
					jqThis.bind(
						'click',
						function(obEvent) {
							if(!jqLi.hasClass('active')) {
								jqSecondLevelList.removeClass('active');
								jqLi.addClass('active');
								ShowMenuPopup(jqSubmenuCont.html());
							} else {
								HideMenuPopup();
								jqLi.removeClass('active');
							}
							return false;
						}
					);
				}
			}
		);

		jQuery(document).bind(
			'OnPopupHolderClose', 
			function(obEvent, obData) {
				if(obData.jqHolder.length) {
					if(obData.jqHolder.attr('id') == 'app-popup-menu') {
						jQuery('.inner-slide-list li.active').removeClass('active');
					}
				}
			}
		);

		jQuery('.slide-list .open-close', jqCont).bind(
			'click',
			function() {
				jQuery('#btn-up').stop().animate(
					{'opacity': 0},
					500, 
					function() {
						jQuery('#btn-up-holder').css('padding-top', 0);
					}
				);
				setTimeout(
					function() {
						var jqBtn = jQuery('#btn-up');
						if(jqBtn.length) {
							window._up_pos = jqBtn.offset().top;
						}
						jQuery(window).scroll();
					},
					1000
				);

				//HideMenuPopup();
				setTimeout(
					function() {
						RefreshMenuPopupPos(true);
					},
					550
				);
			}
		);
	}
);
