( function( $ ) {	
	get_timeapi(); // get time api on load

	// function get time api
	function get_timeapi() {
		var request = new XMLHttpRequest()

		request.open('GET', 'http://worldtimeapi.org/api/ip', true)
		request.onload = function() {
		  	// Begin accessing JSON data here
		  	var data = JSON.parse(this.response)
		  	var timezone = null;
		  	var datetime = null;

		  	if (request.status >= 200 && request.status < 400) {
		  		timezone = data.timezone;
		  		datetime = data.datetime;
		  	} 
		  	else {
		    	console.log('error')
		  	}

		  	// set the fields
		  	$( "input[name=timezone]" ).val( data.timezone );
		  	$( "input[name=datetime]" ).val( data.datetime );
		}

		request.send()
	}	

	// form customer on submit
	$( '#form-customer' ).on( 'submit', function( event ) {
		// data to send
		var data = {
			action: 'save_data_customer',
			nonce: $('input#nonce').val(),
			name: $( "input#name" ).val(),
			phone_number: $( "input#phone_number" ).val(),
			email: $( "input#email" ).val(),
			budget: $( "input#budget" ).val(),
			message: $( "textarea#message" ).val(),
			timezone: $( "input#timezone" ).val(),
			datetime: $( "input#datetime" ).val(),
		}

		// client side verifications
		if( data.name == '' || data.phone_number == '' || data.email == '' || data.budget == '' || data.message == '' ) {
			$( '.alert-danger' ).show();
		}
		else {
			// send ajax request
			$.post( wp_ajax_obj.ajax_url, data, function( response ) {
				var url = window.location.href;  

				// add separator
				if ( url.indexOf( '?' ) !== -1 ) {
				   url += '&'
				}
				else {
				   url += '?'
				}
	
				// do reload
				if( parseInt( response.post_id ) > 0 ) {
					window.location.href = url + 'success=1';
				}
				else {
					window.location.href = url + 'success=0';
				}
			} )
		}		

		event.preventDefault();
	} );
} )( jQuery )