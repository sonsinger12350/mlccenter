jQuery(function($) {
	$('.events-list').owlCarousel({
		loop: false,
		margin: 24,
		nav: true,
		dots: false,
		responsive: {
			0: {
				items: 3
			}
		}
	});
});
