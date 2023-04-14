


$(document).ready(function(){


    var error ; 
	

	$("#sendMessage").prop('disabled', true);

$("#Message").focus( function() { setInterval(function(){ 
	if( true == validate( "Message") ){
		
		$("#sendMessage").prop('disabled', true);
        $('.errorspan').show();
		
		
	}
	else{
	
		 $("#sendMessage").prop('disabled', false);
		 $('.errorspan').hide();
	}
 }, 100)  } );

 

 function validate( id ){
     
    var message = document.getElementById( id ).value ;
    
    if ( message.length < 10 ||  message.length > 1000 ) return true;
    
    return false;


}



} );