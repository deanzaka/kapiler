$("#value").keyup(function() {
       var val = $("#value").val() || 0;
       $("#converse").html(parseFloat(val) * 10000);
});

$("#value").keyup(function() {
    $("#value").val(this.value.match(/[0-9]*/));
});

$("#phone").keyup(function() {
    $("#phone").val(this.value.match(/[0-9]*/));
});

document.querySelector( "form" )
        .addEventListener( "invalid", function( event ) {
            event.preventDefault();
        }, true );

$(document).ready(function(){


		$('#donation-form').validate({
	    rules: {
       	NAME: {
        	required: true,
       		customName: true
      	},
		  
	      EMAIL: {
	        required: true,
	        customMail: true
	    	},

	    	PHONE: {
	    		required: true,
	    		customPhone: true
	    	}
	    },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			// success: function(element) {
			// 	element
			// 	.text('OK!').removeClass('error').addClass('valid')
			// 	.closest('.control-group').removeClass('error').addClass('success');
			// }
	  });

}); // end document.ready