(function( $ ) {
	'use strict';

	// To select all pages on admin menu page.
	document.addEventListener('DOMContentLoaded', function() {
		var selectAllCheckbox = document.getElementById('select_all');
		var pageCheckboxes = document.querySelectorAll('input[name="track_time_selected_pages[]"]');
	
		selectAllCheckbox.addEventListener('click', function() {
			pageCheckboxes.forEach(function(checkbox) {
				checkbox.checked = selectAllCheckbox.checked;
			});
		});
	});
	

})( );
