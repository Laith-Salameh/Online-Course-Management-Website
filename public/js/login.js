$(document).ready(function(){

$("#log").addClass("active");
$(".formBox").addClass("login");

$("#log").click(function(){
	$("#logForm").show();
	$("#signForm").hide();
	$("#log").addClass("active");
	$("#sign").removeClass("active");
	$(".formBox").addClass("login");

});

$("#sign").on("click",function(){
	$("#signForm").show();
	$("#logForm").hide();
	$("#sign").addClass("active");
	$("#log").removeClass("active");
	$(".formBox").removeClass("login");

	
});

$(".showPassword").click(function() {
    $(".showPassword").toggleClass("active");
  });

$( ".birthday" ).datepicker({ minDate: "-90Y", maxDate: "-10Y" , changeMonth: true, changeYear: true });

$("#degree").hide();
$("#teacher").change(function(){
	if(this.checked)
	$("#degree").show();

});
$("#student").change(function(){
	if(this.checked)
	$("#degree").hide();

});
});



function togglePassword(passId) {
  var x = document.getElementById(passId);
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
};


//setInterval(function(){ validateWithoutRequires();},100);
//document.getElementById("signForm").onsubmit=function(){return validate()};
//document.getElementById("logForm").onsubmit=function(){return requiredLogData()};


function validate(){
	var f=requiredData();
	var e=emailValidate();
	var n=nameValidate();
	var p=passwordValidate();
	var c=passwordConfirm();

	

	if(e && n && p && c && f )
		return true;
	else return false;
}
function validateWithoutRequires(){
	var e=emailValidate();
	var n=nameValidate();
	var p=passwordValidate();
	var c=passwordConfirm();
	var h=phoneValidate();
	

	if(e && n && p && c && h)
		return true;
	else return false;
}

function requiredData(){
	arr=["name", "email", "pass2" ,"confirmPassword","birthdayId","phone"]
	var filled=true;
	for (i=0;i< arr.length ; i++){
		var input= document.getElementById(arr[i]);
		if(input.value.length==0){
			input.focus();
			filled= false;
			break;
		}	
	}
	return filled;
}
function requiredLogData(){
	arr=["username", "pass1"]
	var filled=true;
	for (i=0;i< arr.length ; i++){
		var input= document.getElementById(arr[i]);
		if(input.value.length==0){
			input.focus();
			filled= false;
			break;
		}	
	}
	return filled;
}
function passwordValidate(){
	var passValue=document.getElementById("pass2").value;
	 if( passValue!="" ){
	 	document.getElementById("password_style").classList.remove("empty");
	 	if(passValue.length<6){
	 		document.getElementById("password_style").innerHTML="at least 6 characters";
			document.getElementById("password_style").classList.remove("correct");
			document.getElementById("password_style").classList.add("incorrect");
			return false;
	 	}
	 	else{
			document.getElementById("password_style").innerHTML="Accepted!";
			document.getElementById("password_style").classList.remove("incorrect");
			document.getElementById("password_style").classList.add("correct");
			return true;
		}


	}
	else{
		document.getElementById("password_style").classList.add("empty");
	}
}


function passwordConfirm(){
 	var confirmPassValue=document.getElementById("confirmPassword").value;
 	var passValue=document.getElementById("pass2").value;
 	if(confirmPassValue!=""){
 		document.getElementById("password_confirm").classList.remove("empty");
		if(confirmPassValue!=passValue){
    		document.getElementById("password_confirm").innerHTML="doesn't match password";
			document.getElementById("password_confirm").classList.remove("correct");
			document.getElementById("password_confirm").classList.add("incorrect");
			return false;
		}
		else{
			document.getElementById("password_confirm").innerHTML="Accepted!";
			document.getElementById("password_confirm").classList.remove("incorrect");
			document.getElementById("password_confirm").classList.add("correct");
			return true;
		}
	}
	else{
		
		document.getElementById("password_confirm").classList.add("empty");
	}
}

function emailValidate(){
 	var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+/;
	var emailValue=document.getElementById("email").value;
 	if(emailValue!=""){
 		document.getElementById("email_address").classList.remove("empty");
		if(!emailValue.match(mailformat)){
			document.getElementById("email_address").innerHTML="invalid email address";
			document.getElementById("email_address").classList.remove("correct");
			document.getElementById("email_address").classList.add("incorrect");
			return false;
		}
		else{
			document.getElementById("email_address").innerHTML="Accepted!";
			document.getElementById("email_address").classList.remove("incorrect");
			document.getElementById("email_address").classList.add("correct");
			return true;
		}
 	}
 	else{
		document.getElementById("email_address").classList.add("empty");
	}
}

function nameValidate(){
	var nameformat=/^[a-zA-Z ]{2,30}$/;
	var nameValue=document.getElementById("name").value;
	if(nameValue!=""){
		document.getElementById("first_name").classList.remove("empty");
		if(!nameValue.match(nameformat))
		{
			document.getElementById("first_name").innerHTML="at least 2 <strong>lettters</strong>";
			document.getElementById("first_name").classList.remove("correct");
			document.getElementById("first_name").classList.add("incorrect");
			return false;
		}
		else{
			document.getElementById("first_name").innerHTML="Accepted!";
			document.getElementById("first_name").classList.remove("incorrect");
			document.getElementById("first_name").classList.add("correct");
			return true;
		}
	}
	else{
		document.getElementById("first_name").classList.add("empty");
			
	}
}

function phoneValidate(){
	var phoneformat= /^\+[0-9]{3}\-[0-9]{9}$/;
	var phoneValue=document.getElementById("phone").value;
	if(phoneValue!=""){
		document.getElementById("phone_number").classList.remove("empty");
		if(!phoneValue.match(phoneformat))
		{
			document.getElementById("phone_number").innerHTML="Invalid phone number";
			document.getElementById("phone_number").classList.remove("correct");
			document.getElementById("phone_number").classList.add("incorrect");
			return false;
		}
		else{
			document.getElementById("phone_number").innerHTML="Accepted!";
			document.getElementById("phone_number").classList.remove("incorrect");
			document.getElementById("phone_number").classList.add("correct");
			return true;
		}
	}
	else{
		document.getElementById("phone_number").classList.add("empty");
			
	}
}
