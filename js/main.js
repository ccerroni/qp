$(document).ready(function(){
	$('.bigslider_slider').slick({
		mobileFirst: true,
		lazyLoad: 'progressive',
		fade: true,
		adaptiveHeight: true,
		autoplay: true,
		dots: true,
		arrows: false,
		centerMode: true,
		pauseOnHover: false,
		speed: 300
	});

	$('.smallslider_slider').slick({
		mobileFirst: true,
		lazyLoad: 'progressive',
		adaptiveHeight: false,
		autoplay: true,
		dots: false,
		arrows: false,
		centerMode: true,
		pauseOnHover: false,
		slidesToShow: 3,
		variableWidth: true,
		speed: 500
	});
});