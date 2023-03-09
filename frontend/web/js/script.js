/**
 * WEBSITE: https://themefisher.com
 * TWITTER: https://twitter.com/themefisher
 * FACEBOOK: https://www.facebook.com/themefisher
 * GITHUB: https://github.com/themefisher/
 */

(function ($) {
	'use strict';
	
	// Preloader js    
	$(window).on('load', function () {
		$('.preloader').fadeOut(100);
	});


	//  Search Form Open
	$('#searchOpen').on('click', function () {
		$('.search-wrapper').addClass('open');
		setTimeout(function () {
			$('.search-box').focus();
		}, 400);
	});
	$('#searchClose').on('click', function () {
		$('.search-wrapper').removeClass('open');
	});


	// tab
	$('.tab-content').find('.tab-pane').each(function (idx, item) {
		var navTabs = $(this).closest('.code-tabs').find('.nav-tabs'),
			title = $(this).attr('title');
		navTabs.append('<li class="nav-item"><a class="nav-link" href="#">' + title + '</a></li>');
	});

	$('.code-tabs ul.nav-tabs').each(function () {
		$(this).find('li:first').addClass('active');
	});

	$('.code-tabs .tab-content').each(function () {
		$(this).find('div:first').addClass('active');
	});

	$('.nav-tabs a').click(function (e) {
		e.preventDefault();
		var tab = $(this).parent(),
			tabIndex = tab.index(),
			tabPanel = $(this).closest('.code-tabs'),
			tabPane = tabPanel.find('.tab-pane').eq(tabIndex);
		tabPanel.find('.active').removeClass('active');
		tab.addClass('active');
		tabPane.addClass('active');
	});


	// Accordions
	$('.collapse').on('shown.bs.collapse', function () {
		$(this).parent().find('.ti-plus').removeClass('ti-plus').addClass('ti-minus');
	}).on('hidden.bs.collapse', function () {
		$(this).parent().find('.ti-minus').removeClass('ti-minus').addClass('ti-plus');
	});



	//easeInOutExpo Declaration
	jQuery.extend(jQuery.easing, {
		easeInOutExpo: function (x, t, b, c, d) {
			if (t === 0) {return b;}
			if (t === d) {return b + c;}
			if ((t /= d / 2) < 1) {return c / 2 * Math.pow(2, 10 * (t - 1)) + b;}
			return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
		}
	});

	// back to top button
	$('#scrollTop').click(function (e) {
		e.preventDefault();
		$('html,body').animate({
			scrollTop: 0
		}, 1500, 'easeInOutExpo');
	});

	//post slider
	

	$('#like_btn').on('click', function() {
		if ($(this).hasClass('disabled'))
		{
			return;
		}
		else
		{
			
			$(this).addClass('disabled');
			let like_count = parseInt($.trim($('#like_count').text())) + 1;
			let dislike_count = parseInt($.trim($('#dislike_count').text())) - 1;
			$('#like_count').text(like_count);
			$('#dislike_count').text(dislike_count < 0 ? 0 : dislike_count);
			if ($('#unlike_btn').hasClass('disabled'))
			{
				$('#unlike_btn').removeClass('disabled');
			}
		}
	});

	$('#unlike_btn').on('click', function() {
		if ($(this).hasClass('disabled'))
		{
			return;
		}
		else
		{
			$(this).addClass('disabled');
			let like_count = parseInt($.trim($('#like_count').text())) - 1;
			let dislike_count = parseInt($.trim($('#dislike_count').text())) + 1;
			$('#like_count').text(like_count < 0 ? 0 : like_count);
			$('#dislike_count').text(dislike_count);
			if ($('#like_btn').hasClass('disabled'))
			{
				$('#like_btn').removeClass('disabled');
			}
		}
	});

})(jQuery);
