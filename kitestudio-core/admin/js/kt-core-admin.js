(function( $ ) {
	'use strict';

	var CurrentMouseXPostion;
	var CurrentMouseYPostion;

	$(document).mousemove(function(event) {
		CurrentMouseXPostion = event.pageX;
		CurrentMouseYPostion = event.pageY;
	});

	$(document).ready(function(){
		// activatino modal
		var activation_modal = function() {
				$('#kt-activation-modal').iziModal({width: 670});
				$(document).on('click', '.kt-activate-now', function (event) {
					event.preventDefault();
					$('.kt-activation-form').css('opacity','1');
					$('#kt-activation-modal').iziModal('open');
				});
			},
			// lazy load demo images
			lazy_load_demo_images = function() {
				$('.kt-lazy img').each(function(){
					var $image = $(this);
					var src = $image.data("src");
					var img = new Image();

					img.onload = function () {
						$image.attr('src', src).removeAttr('data-src');
					}

					$image.attr("src", src);
				});
			},
			// activation_form
			activation_form = function() {
				$(document).on( 'click', '.kt-activation-form span.submit', function(){
					var self = $(this);
		
					self.addClass('kt-checking');
					$.ajax({
						url: kitestudio_vars.ajax_url,
						dataType: 'json',
						type: 'POST',
						cache: false,
						headers: { 'cache-control': 'no-cache' },
						data: {
							'action': 'activate_theme',
							'token': self.parents('form').find('input[type="text"]').val(),
							'nonce': kite_theme_admin_vars.wpnonce
						},
						success: function(response){
							if(response.success) {
								self.removeClass('kt-checking');
								$('.kt-activation-form .kt-result').addClass('kt-success').html(response.data.message);
								self.parents('form').submit();
							} else {
								self.removeClass('kt-checking');
								$('.kt-activation-form .kt-result').addClass('kt-error').html(response.data.message);
							}
						}
					});
		
				});
			},
			// import demo
			import_demo = function() {
				$(document).on( 'click', '.kt-import:not(.disable)', function(e){
					e.preventDefault();
					$(this).parents('li').find('input').prop('checked',true);
					$('form#kt-demo-import, form#kt-template-import').submit();
				});
			},
			kite_hint= function() {
				$('.kt-has-hint').hover(
					function(){
						$(this).find('.kt-hint').toggleClass('show');
						$(this).find('.kt-hint').css( 'left', CurrentMouseXPostion - $(this).offset().left );
					},
					function(){
						$(this).find('.kt-hint').toggleClass('show');
						$(this).find('.kt-hint').css( 'left', CurrentMouseXPostion - $(this).offset().left );
					}
				);
			},
			kiteToast = function() {
				$('.iziToast.success').each(function(){
					iziToast.success({
						title: $(this).data('title'),
						message: $(this).data('message')
					});
				});
			}
		;
		
		if ( $('#kt-activation-modal').length ) {
			activation_modal();
		}	
		lazy_load_demo_images();
		activation_form();
		import_demo();
		kite_hint();
		kiteToast();
	});
	
	$(function(){
		var $template_tabs_items = $('.kt-template-tabs li:not(.disable)'),
			$template_panels = $('form#kt-template-import > ul:not(.kt-template-tabs)');

		$template_tabs_items.on( 'click', function(){
			$template_tabs_items.removeClass('active');
			$(this).addClass('active');

			var panel_id = $(this).data('panel');
			$template_panels.removeClass('active');
			$( 'ul' + panel_id ).addClass('active');
		});
	 });

})( jQuery );
