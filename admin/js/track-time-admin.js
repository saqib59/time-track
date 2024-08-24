document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    let selectAllCheckbox = document.getElementById('select_all');
    let pageCheckboxes = document.querySelectorAll('input[name="track_time_selected_pages[]"]');
    
    selectAllCheckbox.addEventListener('click', function() {
        pageCheckboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
});
