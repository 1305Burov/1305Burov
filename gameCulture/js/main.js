

$(window).scroll(function () {
	$('.periphery').each(function() {
		var imagePos = $(this).offset().top;

		var topOfWindow = $(window).scrollTop();
		if (imagePos < topOfWindow+650) {
			$(this).addClass('fadeIn');
		}
	});
});

$(window).scroll(function () {
	$('#img_coll').each(function() {
		var imagePos = $(this).offset().top;

		var topOfWindow = $(window).scrollTop();
		if (imagePos < topOfWindow+650) {
			$(this).addClass('fadeInRight');
		}
	});
});

$(window).scroll(function () {
	$('#coll_main').each(function() {
		var imagePos = $(this).offset().top;

		var topOfWindow = $(window).scrollTop();
		if (imagePos < topOfWindow+650) {
			$(this).addClass('fadeInLeft');
		}
	});
});

$(window).scroll(function () {
	$('#h').each(function() {
		var imagePos = $(this).offset().top;

		var topOfWindow = $(window).scrollTop();
		if (imagePos < topOfWindow+650) {
			$(this).addClass('fadeInLeft');
		}
	});
});



