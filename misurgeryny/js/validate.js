var $j = jQuery.noConflict(); 
$j(document).ready(function () {
	$j.validator.addMethod("phoneUS", 
			function(phone_number, element) {
    				phone_number = phone_number.replace(/\s+/g, ""); 
		
				return this.optional(element) || phone_number.length > 9 &&
					phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
				}, 
			"Please specify a valid phone number"
	);

    // Custom validation: check if past date.   
    $j.validator.addMethod(
        'valid_date', 
        function (value) {
            var val = new Date(value);
            var now = new Date();
            
            if (val.getFullYear() < now.getFullYear())
            {              
                return false;
            }
            else if (val.getMonth() < now.getMonth())
            {
                return false;
            }
            else if (val.getDate() < now.getDate())
            {
                return false;
            }
            else
            {
                return true;
            }
        }, 
        'Please enter a valid date'
    );
    
    // Validate forms with class require-validation.
    // http://docs.jquery.com/Plugins/Validation
    $j('form.require-validation').validate({
    		errorPlacement: function(error, element) {
			error.appendTo( element.parent() );
		}	
    });    
    
    
    if ($j('input[name="inches"]').size() > 0)
    {
	    $j('input[name="inches"]').rules(
	    	'add',
		{max: 11}
	    );    
     }	     
});