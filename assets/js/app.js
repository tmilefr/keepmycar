


    //isotope
	$(window).on('load', function(){ 
		//responsive
		$('.nicdark_menu').tinyNav({
			active: 'selected',
			header: 'MENU'
		});
		///////////

		jQuery(document).ready(function($) {
			$(".clickable-row").click(function() {
				window.location = $(this).data("href");
			});
		});
	});
	///////////

