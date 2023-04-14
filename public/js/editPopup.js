$(document).ready(function(){
	
	
$("#edit").click(function(){
    $(".editCover").addClass("displayCover");
	$("#editPop").addClass("Editvisible");
	$("#viewCommentsPop").removeClass("Editvisible");
	$("#SendComment").removeClass("Editvisible");
    $('#avatarp').attr('src', $("#profile-pic").attr("src") );
    $("#Phone").attr("value" , $("#phone").text().trim() );
    $("#Speciality").attr("value" , $("#speciality").text().trim() );
    $("#facebook_link").attr("value" , $("#link-facebook").attr("href").trim() );
    $("#telegram_link").attr("value" , $("#link-telegram").attr("href").trim() );
    $("#twitter_link").attr("value" , $("#link-twitter").attr("href").trim() );
    $("#skype_link").attr("value" , $("#link-skype").attr("href").trim() );	
});

$("#cancelEdit").click(
	function(){
        $(".editCover").removeClass("displayCover");
	 	$("#editPop").removeClass("Editvisible");
	 	 $("#viewCommentsPop").removeClass("Editvisible");
		  $("#SendComment").removeClass("Editvisible");
	}
);

$("[id^=button]").click(function(){
    $(".editCover").addClass("displayCover");
    $("#viewCommentsPop").addClass("Editvisible");
    $("#editPop").removeClass("Editvisible");
	$("#SendComment").removeClass("Editvisible");
});

$("#exit-edit").click( function(){
	$(".editCover").removeClass("displayCover");
	 $("#editPop").removeClass("Editvisible");
	  $("#viewCommentsPop").removeClass("Editvisible");
}
);

$("#exit-comments").click( function(){
	$(".editCover").removeClass("displayCover");
	 $("#editPop").removeClass("Editvisible");
	  $("#viewCommentsPop").removeClass("Editvisible");
}
);
/*
$("[class^=addcomment_button]").on( "click" ,function(){
	$(".editCover").addClass("displayCover");
	$("#SendComment").addClass("Editvisible");
	$("#editPop").removeClass("Editvisible");
	  $("#viewCommentsPop").removeClass("Editvisible");
} );*/

$("#display").on( "click" ,function(){
	$(".editCover").addClass("displayCover");
	$("#SendComment").addClass("Editvisible");
	$("#editPop").removeClass("Editvisible");
	  $("#viewCommentsPop").removeClass("Editvisible");
} );

$("#cancelcomment").click( function(){
	$(".editCover").removeClass("displayCover");
	 $("#editPop").removeClass("Editvisible");
	  $("#viewCommentsPop").removeClass("Editvisible");
}
);

$('#avatar').change(function (event) {
    readURL(this);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatarp').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        
    }
    
}

$('#avatarp').on('mouseenter',function(){
    $('#avatarp').css("opacity", "0.4");
    $('#choose-image').css('display' , 'inline-block');
});
    
$('#avatarp').on('mouseleave',function(){
    $('#avatarp').css("opacity", "1");
    $('#choose-image').css('display' , 'none');
});



var error = [  "" , "" , "" , "" , "" ]; 

setInterval(function(){
	var message = "";
	var first = true;
    for( i=0 ; i< error.length ; i++) 
		if(error[i] !== "" ) {
			
			message = message + "  Format error:   " + error[i];
		   if( i != error.length ) message = message + "<br>";
		   if( first ) message = "<br>" + message;
		   first = false;
		}

	$("#error-edit").html( message );

}, 100 ) ;



 

 $("#Phone").focus( function() { setInterval(function(){ 
	if( true == validatePhone("Phone") ){
		var input= document.getElementById( "Phone" );
		input.style.backgroundColor = "red"; 
		input.style.opacity = 0.3; 
		$("#EditSubmit").prop('disabled', true);
		error[1]= "Phone format +[area code]-[9 digit number] ";
	}
	else{
		 document.getElementById( "Phone" ).style.backgroundColor = "rgba(228,217,232)"; 
         document.getElementById( "Phone" ).style.opacity = 1;
		 $("#EditSubmit").prop('disabled', false);
		 error[1] = "";
	}
 }, 100)  } );

 
 $("#facebook_link").focus( function() { setInterval(function(){ 
	if( true == validateLink1("facebook_link") ){
		var input= document.getElementById( "facebook_link" );
		input.style.backgroundColor = "red"; 
		input.style.opacity = 0.3; 
		$("#EditSubmit").prop('disabled', true);
		error[2]= "invalid facebook link ";
		
	}
	else{
		 document.getElementById( "facebook_link" ).style.backgroundColor = "rgba(228,217,232)"; 
         document.getElementById( "facebook_link" ).style.opacity = 1;
		 $("#EditSubmit").prop('disabled', false);
		 error[2]="";
	}
 }, 100)  } );

 $("#telegram_link").focus( function() { setInterval(function(){ 
	if( true == validateLink2("telegram_link") ){
		var input= document.getElementById("telegram_link");
		input.style.backgroundColor = "red"; 
		input.style.opacity = 0.3; 
		$("#EditSubmit").prop('disabled', true);
		
	    error[3]= " invalid telegram link "  ;
		
	}
	else{
		 document.getElementById( "telegram_link" ).style.backgroundColor = "rgba(228,217,232)"; 
         document.getElementById( "telegram_link" ).style.opacity = 1;
		 $("#EditSubmit").prop('disabled', false);
		 error[3] = "";
	}
 }, 100)  } );

 $("#twitter_link").focus( function() { setInterval(function(){ 
	if( true == validateLink3("twitter_link") ){
		var input= document.getElementById("twitter_link");
		input.style.backgroundColor = "red"; 
		input.style.opacity = 0.3; 
		$("#EditSubmit").prop('disabled', true);
		
		error[4]= " invalid twitter link "  ;
		
	}
	else{
		 document.getElementById( "twitter_link" ).style.backgroundColor = "rgba(228,217,232)"; 
         document.getElementById( "twitter_link" ).style.opacity = 1;
		 $("#EditSubmit").prop('disabled', false);
		 error[4]= "";
	}
 }, 100)  } );

 $("#skype_link").focus( function() { setInterval(function(){ 
	if( true == validateLink4("skype_link") ){
		var input= document.getElementById("skype_link");
		input.style.backgroundColor = "red"; 
		input.style.opacity = 0.3; 
		$("#EditSubmit").prop('disabled', true);
	
		error[5]=  " invalid skype link "  ;
		
	}
	else{
		 document.getElementById( "skype_link" ).style.backgroundColor = "rgba(228,217,232)"; 
         document.getElementById( "skype_link" ).style.opacity = 1;
		 $("#EditSubmit").prop('disabled', false);
		 error[5]= "" ;
		 
	}
 }, 100)  } );


    
    
});







function validateLink1( id ){
     
		var link = document.getElementById( id ).value ;
		var link1 = /^https:\/\/www\.facebook\.com/;
		var link2 = /^www\.facebook\.com/;
		if ( !link.match(link1) && !link.match(link2) ) return true;
		
		return false;


}
function validateLink2( id ){
     
	var link = document.getElementById( id ).value ;
	var link1 = /^https:\/\/www\.telegram\.org/;
	var link2 = /^www\.telegram\.org/;
	if ( !link.match(link1) && !link.match(link2) ) return true;
	
	return false;


}
function validateLink3( id ){
     
	var link = document.getElementById( id ).value ;
	var link1 = /^https:\/\/www\.twitter\.com/;
	var link2 = /^www\.twitter\.com/;
	if ( !link.match(link1) && !link.match(link2) ) return true;
	
	return false;


}
function validateLink4( id ){
     
	var link = document.getElementById( id ).value ;
	var link1 = /^https:\/\/www\.skype\.com/;
	var link2 = /^www\.skype\.com/;
	if ( !link.match(link1) && !link.match(link2) ) return true;
	
	return false;


}

function validatePhone(id){
	if( document.getElementById( id ).value.length == 0  ) return true;
	var phone= document.getElementById( id ).value;
	var phoneformat = /^\+[0-9]{3}\-[0-9]{9}$/;
	if(!phone.match(phoneformat)){ return true; }
	return false;

}

