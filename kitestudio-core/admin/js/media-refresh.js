(function( $ ) {
	'use strict';

	$(document).ready(function(){
	
		$(document).ajaxComplete(function(event, xhr, settings) {
			if (settings.data && settings.data.indexOf('action=query-attachments') !== -1 && wp.media ) {
			  $('.media-frame-menu #menu-item-library').on('click', function () {
				wp.media.frame.content.get('gallery').collection.props.set({ ignore: (+ new Date()) });
			  });
			}
		});
		
	});


})( jQuery );
