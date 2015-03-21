$(function(){
//	$('.yearpicker-input').datepicker({
//			dateFormat: 'yyyy',
//			showButtonPanel: true,
//                        showOtherMonths: false,
//			changeMonth: false,
//			changeYear: true
//	});
        
        $( ".yearpicker-input" ).datepicker( {
            changeMonth: false,
            changeYear: true,
            showButtonPanel: false,
            showOtherMonths: false,
            dateFormat: 'yy',
            onClose: function(dateText, inst) { 
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, 1, 1));
            }
        });
	
	$('.yearpicker-input-clear').button();
	
	$('.yearpicker-input-clear').click(function(){
		$(this).parent().find('.yearpicker-input').val("");
		return false;
	});
        
        $('.ui-datepicker-calendar').hide();
	
});