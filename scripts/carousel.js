/** @format */

$(document).ready(function () {
	// Activate all carousels
	$('.carousel').carousel();

	// Enable Carousel Indicators
	$('[data-slide-to]').click(function () {
		const target = $(this).data('target');
		const slideTo = $(this).data('slide-to');

		$(target).carousel(parseInt(slideTo, 10));
	});

	// Enable Carousel Controls
	$('[data-slide]').click(function () {
		const target = $(this).data('target');
		const slide = $(this).data('slide');

		if (slide === 'prev') {
			$(target).carousel('prev');
		} else if (slide === 'next') {
			$(target).carousel('next');
		}
	});
});
