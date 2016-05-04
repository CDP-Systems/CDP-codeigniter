var $j = jQuery.noConflict(); 
$j(document).ready(function () {
    // Redirect to a different seminar when changing selection.
    $j('select[name="seminar_id"]').change(function() {
        var seminar_id = $j('select[name="seminar_id"] :checked').val();
	
        window.location = CURR_MODULE2 + '/seminar/register/' + seminar_id;

    });

    if ($j('input[name="seminar_date"]').size() > 0) {        
        $j('input[name="seminar_date"]').datepick({dateFormat: 'yyyy-mm-dd'});
    }
});

