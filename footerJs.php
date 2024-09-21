<div id="tvs-modal" class="modalbox-block mfp-hide"></div>
<script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/glightbox.min.js" id="jquery-glightbox-js"></script>
<script>
	var lightboxInlineIframe = GLightbox({
		selector: '.debateBox'
	});

	jQuery(document).ready(function () {


		jQuery('.ajax-popup').on("click", function (e) {
			e.preventDefault();
			jQuery.ajax({
				type: "POST",
				url: jQuery(this).data('url'),
				data: {
					action: 'ajax_action'
				},
				success: function (data) {
					jQuery.magnificPopup.open({
						type: 'inline',
						midClick: true,
						mainClass: 'mfp-fade',
						closeOnBgClick: false ,
						removalDelay: 500, //delay removal by X to allow out-animation
						items: {
							src: data
						}
					})
				}
			});
		});


		// jQuery('.ajax-popup').magnificPopup({
		// 	type: 'ajax',
		// 	alignTop: true,
		// 	overflowY: 'scroll',
		// });




		jQuery('body').on('click', '.closeModallBTN', function (e) {
			e.preventDefault();
			jQuery.magnificPopup.close();
		});


	});
</script>