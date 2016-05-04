var $j = jQuery.noConflict(); 
$j(document).ready(function () {

    // Check if ADD SURVEY form is submitted.
    // NOTE: Please make sure that all functions still work even without ajax. Like this one.
    $j('form[name="edit-survey-form"]').submit(function (event) {
        // Check if we have some visible error messages.
        if ($j('.error:visible').size() > 0)
        {
            return false;
        }

        var url = 'admin/surveys/add_survey';    
        var msg = 'Survey saved.';    

        if ($j('input[name="survey_id"]').size() > 0)
        {
            url = 'admin/surveys/edit_survey/' + $j('input[name="survey_id"]').val();
            msg = 'Survey updated.';
        }                
        
        s = ajax_submit(this, BASE_URL + url);       

        if (s > 0)
        {
            $j('#message-div').empty().append(msg).hide().fadeIn('slow');
            
            if ($j('input[name="survey_id"]').size() <= 0)
            {
                $j(this).append('<input type="hidden" name="survey_id" />');
            }

            $j('input[name="survey_id"]').val(s);
        }

        event.preventDefault();
    });

    // Check if ADD SURVEY form is submitted.
    // NOTE: Please make sure that all functions still work even without ajax. Like this one.
    $j('form[name="edit-question-form"]').submit(function (event) {
        // Check if we have some visible error messages.
        if ($j('.error:visible').size() > 0)
        {
            return false;
        }

        var url = 'admin/surveys/add_question';    
        var msg = 'Question saved.';    

        if ($j('input[name="question_id"]').size() > 0)
        {
            url = 'admin/surveys/edit_question/' + $j('input[name="question_id"]').val();
            msg = 'Question updated.';
        }                
        
        s = ajax_submit(this, BASE_URL + url);       

        if (s > 0)
        {
            $j('#message-div').empty().append(msg).hide().fadeIn('slow');
            
            if ($j('input[name="question_id"]').size() <= 0)
            {
                $j(this).append('<input type="hidden" name="question_id" />');
            }

            $j('input[name="question_id"]').val(s);
        }

        event.preventDefault();
    });
    
    // Check if ADD RECURRING EVENT form is submitted.
    // NOTE: Please make sure that all functions still work even without ajax. Like this one.
    $j('form[name="form-edit-recurring-event"]').submit(function (event) {
        // Check if we have some visible error messages.
        if ($j('.error:visible').size() > 0)
        {
            return false;
        }

        var url = 'admin/calendar/add_recurring_event';    
        var msg = 'Event saved.';    

        if ($j('input[name="id"]').size() > 0)
        {
            url = 'admin/calendar/edit_recurring_event/' + $j('input[name="id"]').val();
            msg = 'Event updated.';
        }                
        
        s = ajax_submit(this, BASE_URL + url);       

        if (s > 0)
        {
            $j('#message-div').empty().append(msg).hide().fadeIn('slow');
            
            if ($j('input[name="id"]').size() <= 0)
            {
                $j(this).append('<input type="hidden" name="id" />');
            }

            $j('input[name="id"]').val(s);
        }

        event.preventDefault();
    });    

    // Delete survey.
    $j('.delete').click(function (event) {
   		var ans = confirm('Delete this item?');
        var obj = $j(this);

		if (ans) 
        {
            $j.get(
                $j(this).attr('href'),
                function (msg) {
                    $j('#message-div').empty().append(msg).hide().fadeIn('slow');

                    obj.closest('tr').fadeOut('slow', function () {
                        obj.closest('tr').remove();
                        $j('table.list tbody tr').attr('class','');
                        $j('table.list tbody tr:odd').attr('class','colored');
                    });
                }
            );
        }

        event.preventDefault();
    });
});

/**
 *
 * Submit a form via ajax request.
 *
 * @param object form
 * @param string url 
 *
 * @return mixed
 */
function ajax_submit(form, url, data_type, animation_loc)
{    
    if (data_type == undefined)
    {
        data_type = 'text';
    }

    if (animation_loc == undefined)
    {
        //animation_loc = $j(form).find('input[type="submit"]');

        $j('#message-div').empty().html('<img id="load-anim" src="' + BASE_URL + 'images/loading.gif" />');
    }

    var data = $j(form).serialize();
    var s;

    $j.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: data_type,
        async: false,
        success: function(response) {
            s = response;
        }
    });

    return s;
}

	function check_all(hiddenCheckbox, checkboxes){
		var hiddenCB = document.getElementById(hiddenCheckbox);
		if(!hiddenCB.value || hiddenCB.value == 0){
			hiddenCB.value = 1;
		}else{
			hiddenCB.value = 0;
		}

		if(checkboxes.length){
			if(hiddenCB.value == 1){
				for(var i=0; i!=checkboxes.length; i++){
					checkboxes[i].checked = true;
				}
			}
			else{
				for(var i=0; i!=checkboxes.length; i++){
					checkboxes[i].checked = false;
				}
			}
		}
		else{
			if(hiddenCB.value == 1) checkboxes.checked = true;
			else checkboxes.checked = false;
		}
	}
	
	function confirmAction(form,action){
		var ans;
		switch(action){
			case 'delete':
				ans = confirm("Are you sure?");
				break
			default:
				ans = true;
				break;
		}
		if(ans){
			form.submit();
		}
	}	
