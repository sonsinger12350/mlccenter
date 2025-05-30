jQuery(function($) {
	$('.events-list').owlCarousel({
		loop: false,
		margin: 24,
		nav: true,
		autoplay: true,
		autoplayTimeout: 5000,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			1199: {
				items: 3
			}
		}
	});
});
