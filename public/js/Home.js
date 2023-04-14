
$(document).ready(function(){

	$(".des").click(function(){
	$(".design").show();
	$.fn.showChildren(".design");
	$(".development").hide();
	$(".IT").hide();
	$(".business").hide();
	$(".des").addClass("selected");
	$(".all").removeClass("selected");
	$(".dev").removeClass("selected");
	$(".bus").removeClass("selected");
	$(".It").removeClass("selected");
});

$.fn.showChildren = function(classtoshow) {
	$("#mix-container").children().children(classtoshow).hide( );
     $("#mix-container").children(".row").each(function(index) {
		 
		$(this).children(classtoshow).each(function(index1) {
		
		  $(this).delay( 50*index1 + 75*index).fadeIn(); 
	  });
	
	}) ;
  }


$(".dev").click(function(){
	$(".development").show();
	$.fn.showChildren(".development");
	$(".design").hide();
	$(".IT").hide();
	$(".business").hide();
	$(".dev").addClass("selected");
	$(".all").removeClass("selected");
	$(".des").removeClass("selected");
	$(".bus").removeClass("selected");
	$(".It").removeClass("selected");
});
$(".bus").click(function(){
	$(".business").show();
	$.fn.showChildren(".business");
	$(".development").hide();
	$(".IT").hide();
	$(".design").hide();
	$(".bus").addClass("selected");
	$(".all").removeClass("selected");
	$(".dev").removeClass("selected");
	$(".des").removeClass("selected");
	$(".It").removeClass("selected");
});
$(".It").click(function(){
	$(".IT").show();
	$.fn.showChildren(".IT");
	$(".development").hide();
	$(".design").hide();
	$(".business").hide();
	$(".It").addClass("selected");
	$(".all").removeClass("selected");
	$(".dev").removeClass("selected");
	$(".bus").removeClass("selected");
	$(".des").removeClass("selected");
});
$(".all").click(function(){
	$(".design").show();
	$(".development").show();
	$(".IT").show();
	$(".business").show();
	$.fn.showChildren(".mix");
	$(".all").addClass("selected");
	$(".des").removeClass("selected");
	$(".dev").removeClass("selected");
	$(".bus").removeClass("selected");
	$(".It").removeClass("selected");
});





});









