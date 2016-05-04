var $j = jQuery.noConflict(); 
$j(document).ready(function () {
    
    if (ROOT_PAGE != '')
    {
        var list_item = $j('#' + ROOT_PAGE);

        var nav_index = $j('.mainnav').not('ul .subnavs li').index(list_item);

        /**
         * Hide subnav when not selected.
         */
        if (nav_index >= 0)
        {
            ddaccordion.expandone('mainnav', nav_index);
        }
    }
    /**
     * Clear the content of search box on set focus.
     */
    $j('input[name="search"]').focus(function () {
        $j(this).val('');
    });

    $j('input[name="search"]').blur(function () {
        if ($j(this).val() == '')
        {
            $j(this).val('Search the web');
        }
    });

    $j('input[name="inches"]').keyup(function(event)
    {
        if ($j(this).val().length > 1)
        {
        	
            event.preventDefault();

            if ($j('input[name="pounds"]').size() > 0)
            {
                $j('input[name="pounds"]').focus();
            }
        }
    });

    $j('input[name="feet"]').keyup(function () {
        if ($j('input[name="feet"]').val().length > 0) 
        {
            $j('input[name="inches"]').focus();
        }
    });

    /**
     * Auto-move cursor for phone number fields.
     */
    $j('.phone1').keydown(function (event) {
   		// Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 )
        {
            if ($j(this).val().length == 0)
            {
                $j(this).prev().focus();
            }
        }	
        else if ($j(this).val().length > 2 )
        {
            event.preventDefault();
            $j(this).next().focus();
        }
    });
    
    
    $j('.phone2').keydown(function (event) {
        if ( event.keyCode == 46 || event.keyCode == 8 )
        {
        
        }
        else if ($j(this).val().length > 3)
        {
            event.preventDefault();
        }
    });     


	$j('.require_numeric').keydown(function(event) {
		// Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 )
        {
        
        }
        else {
            if (event.keyCode < 95) 
            {
                if (event.keyCode < 48 || event.keyCode > 57 ) 
      	          {
                    event.preventDefault();
                }
            } 
            else 
            {
                if (event.keyCode < 96 || event.keyCode > 105 ) 
                {
                    event.preventDefault();
                }
            }
        }
    });


   /** 
    * Alert when clicking nav message.
    */
    $j('.back-button').live('click', function () {
        var x = confirm('Are you sure you want to leave this page? All your typed entries will be lost.');

        if (x)
        {
            window.location = BASE_URL + ROOT_PAGE;
        }
    });     

    $j('input[name="referral_name"]').keyup(function ()
    {         
          $j('span[name="referral-name"]').empty().text($j(this).val());
    });

    $j('input[name="patient_name"]').keyup(function ()
    {         
          $j('span[name="patient-name"]').empty().text($j(this).val());
    });

    if ($j('#referral-message').size() > 0)
    {
        var referral_message = $j('#referral-message').html();

        $j('#referral-message').html(referral_message.replace(/%%REFERRAL_NAME%%/g, '<span name="referral-name"></span>'));

        referral_message = $j('#referral-message').html();

        $j('#referral-message').html(referral_message.replace(/%%PATIENT_NAME%%/g, '<span name="patient-name"></span>'));

        referral_message = $j('#referral-message').html();

        $j('#referral-message').html(referral_message.replace(/%%CLOSING%%/g, 'Alleghenies Surgical'));

        $j('#referral-message').hide();
    }

    $j('#referral-message-preview').toggle(
        function() {
            $j('#referral-message').show();
        }, 
        function() {
            $j('#referral-message').hide();
        }
    );
    
    $j('.datepick').datepick({dateFormat: 'MM d, yyyy'});
});