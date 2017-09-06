/**
 * 
 * JsSearchSuggest
 * @author Sergey Leshchenko, 2012
 * 
 */
var JsSearchSuggest = {
	ver: '1.2',
	iKeyTimeout: 700,
	iShowTime: 300,
	mTimeout: false,
	sRequestUrl: '/ajax/search_suggest.php',
	bRequest: false,
	sCurRequest: '',
	obCurField: null,
	Redirect: function(sUrl, bBlank) {
		if(sUrl && typeof(sUrl) == 'string') {
			if(bBlank) {
				window.open(sUrl, '_blank');
			} else {
				window.location.href = sUrl;
			}
		}
		return false;
	},
	ResponseHandler: function(data, textStatus, jqXHR) {
		JsSearchSuggest.bRequest = false;
		if(data && data.RESULT) {
			var sHtml = '';
			for(var i in data.RESULT) {
				var obItem = data.RESULT[i];
				sHtml += '<div class="suggest-item" onclick="JsSearchSuggest.Redirect(\''+obItem.URL_WO_PARAMS+'\')"><div class="suggest-item-pad">'+obItem.TITLE+'</div></div>';
			}
			if(sHtml.length) {
				sHtml = '<div class="suggest-block">'+sHtml+'</div>';
			}
			var jqSuggestCont = jQuery('#suggest-cont');
			jqSuggestCont.html(sHtml);
			if(sHtml.length) {
				jQuery('div.suggest-item', jqSuggestCont).each(
					function() {
						var jqThis = jQuery(this);
						jqThis.bind(
							'hover',
							function() {
								JsSearchSuggest.SuggestItemHover(jqThis);
							}
						);
					}
				);
			}
		}
	},
	SuggestItemHover: function(jqNode) {
		jQuery('div.hover-state', '#suggest-cont').removeClass('hover-state');
		if(jqNode) {
			jqNode.addClass('hover-state');
		}
	},
	NavSuggestItems: function(jqField, sAction) {
		var bReturn = true;
		var jqSuggestCont = jQuery('#suggest-cont');
		if(jQuery('div.suggest-block', jqSuggestCont).get(0)) {
			var obHoverItem = null;
			switch(sAction) {
				case 'enter':
					obHoverItem = jQuery('div.hover-state', jqSuggestCont).get(0);
					if(obHoverItem) {
						jQuery(obHoverItem).trigger('click');
						return false;
					}
				break;

				case 'up':
					obHoverItem = jQuery('div.hover-state', jqSuggestCont).get(0);
					if(obHoverItem) {
						obHoverItem = jQuery(obHoverItem).prev().get(0);
					}
					if(!obHoverItem) {
						obHoverItem = jQuery('div.suggest-item', jqSuggestCont).last().get(0);
					}
				break;

				case 'down':
					obHoverItem = jQuery('div.hover-state', jqSuggestCont).get(0);
					if(obHoverItem) {
						obHoverItem = jQuery(obHoverItem).next().get(0);
					}
					if(!obHoverItem) {
						obHoverItem = jQuery('div.suggest-item', jqSuggestCont).first().get(0);
					}
				break;
			}
			if(obHoverItem) {
				JsSearchSuggest.SuggestItemHover(jQuery(obHoverItem));
				bReturn = false;
			}
		}
		return bReturn;
	},
	HideSuggestCont: function() {
		jQuery('#suggest-cont').fadeOut((JsSearchSuggest.iShowTime / 2));
		JsSearchSuggest.RemoveBodyHandler();
	},
	RemoveSuggestCont: function() {
		jQuery('#suggest-cont').remove();
		JsSearchSuggest.RemoveBodyHandler();
	},
	ShowSuggestCont: function(jqField) {
		var obOffset =	jqField.offset();
		var jqSuggestCont = jQuery('#suggest-cont');
		if(!jqSuggestCont.get(0)) {
			jQuery(document.body).append('<div id="suggest-cont"></div>');
			jqSuggestCont = jQuery('#suggest-cont');
			jqSuggestCont.bind(
				'click',
				function(event) {
					event.stopPropagation();
				}
			);
			jqSuggestCont.bind(
				'mouseleave',
				function() {
					JsSearchSuggest.SuggestItemHover();
				}
			);
		}

		jqSuggestCont.css({
			'position': 'absolute',
			'top': (obOffset.top + jqField.outerHeight())+'px',
			'left': obOffset.left+'px',
			'width': jqField.width()+'px'
		});

		//
		// custom event OnShowSuggestCont
		//
		jQuery(document).triggerHandler(
			'OnShowSuggestCont',
			[{
				'obThis': this,
				'jqField': jqField,
				'jqSuggestCont': jqSuggestCont
			}]
		);

		jqSuggestCont.fadeIn(JsSearchSuggest.iShowTime);

		JsSearchSuggest.AddBodyHandler();
		JsSearchSuggest.obCurField = jqField.get(0);
	},
	AddBodyHandler: function() {
		if(!jQuery(document.body).data('bSuggestHandler')) {
			jQuery(document.body).data('bSuggestHandler', true);
			jQuery(document.body).bind(
				'click',
				JsSearchSuggest.BodyHandler
			);
		}
	},
	RemoveBodyHandler: function() {
		clearTimeout(JsSearchSuggest.mTimeout);
		jQuery(document.body).unbind('click', JsSearchSuggest.BodyHandler);
		jQuery(document.body).data('bSuggestHandler', false);		
	},
	BodyHandler: function(event) {
		if(event.target != JsSearchSuggest.obCurField) {
			JsSearchSuggest.HideSuggestCont();
		}
	},
	Handler: function(obNode) {
		clearTimeout(JsSearchSuggest.mTimeout);
		JsSearchSuggest.mTimeout = setTimeout(
			function() {
				JsSearchSuggest._handler(obNode);
			}, 
			JsSearchSuggest.iKeyTimeout
		);
	},
	_handler: function(obNode, bIgnoreBodyHandler) {
		var jqField = jQuery(obNode);
		var sVal = jqField.val();
		if(sVal.length) {
			if(JsSearchSuggest.sCurRequest != sVal) {
				JsSearchSuggest.bRequest = false;
				JsSearchSuggest.sCurRequest = sVal;
				JsSearchSuggest.ShowSuggestCont(jqField);
				var obData = {
					'query': sVal
				};
				jQuery.getJSON(
					JsSearchSuggest.sRequestUrl,
					obData,
					JsSearchSuggest.ResponseHandler
				);
			} else {
				if(bIgnoreBodyHandler || jQuery(document.body).data('bSuggestHandler')) {
					JsSearchSuggest.ShowSuggestCont(jqField);
				}
			}
		} else {
			JsSearchSuggest.HideSuggestCont();
		}
	},
	FocusHandler: function(obNode) {
		JsSearchSuggest._handler(obNode, true);
	},
	Init: function(sSearchNode) {
		jQuery(sSearchNode).each(
			function() {
				var jqThis = jQuery(this);
				if(!jqThis.data('bSuggest')) {

					var jqForm = jqThis.closest('form');
					if(jqForm.get(0) && !jqForm.data('bSuggest')) {
						jqForm.data('bSuggest', true);
						jqForm.bind(
							'submit',
							function() {
								clearTimeout(JsSearchSuggest.mTimeout);
							}
						);
					}

					jqThis.data('bSuggest', true);
					jqThis.attr('autocomplete', 'off');
					jqThis.bind(
						'keydown', 
						function(event) {
							var bReturn = true;
							switch(event.keyCode) {
								case 38: 
									// Up
									bReturn = JsSearchSuggest.NavSuggestItems(jqThis, 'up');
								break;

								case 40: 
									// Down
									bReturn = JsSearchSuggest.NavSuggestItems(jqThis, 'down');
								break;

								case 13:
									// Enter
									bReturn = JsSearchSuggest.NavSuggestItems(jqThis, 'enter');
								break;

							}
							return bReturn;
						}
					);

					jqThis.bind(
						'keyup', 
						function(event) {
							switch(event.keyCode) {
								case 18: // Alt
								case 17: // Ctrl
								case 16: // Shift
								case 9: // Alt+Tab
								case 35: // end
								case 36: // home
								case 33: // Page Up
								case 34: // Page Down
								case 20: // Caps Lock
								case 45: // Insert
								case 144: // Num Lock
								case 145: // Scroll Lock
								case 37: // Left
								case 39: // Right
								case 38: // Up
								case 40: // Down
									// ничего не делаем
								break;

								case 27: // Esc
									JsSearchSuggest.HideSuggestCont();
								break;
								
								default:
									JsSearchSuggest.Handler(jqThis);
								break;
							}
						}
					);
					jqThis.bind(
						'focus', 
						function() {
							JsSearchSuggest.FocusHandler(jqThis);
						}
					);
				}
			}
		);
	}
};
