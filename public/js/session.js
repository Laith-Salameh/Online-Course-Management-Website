
$(document).ready(function() {
	$("#Session_table").DataTable();

    
/*$("#addTopic").click(function(){
    $(this).hide();
    $(this).parent().addClass("accepted");
     $(this).parent().html('<i class="far fa-check-circle big"></i>');
     
  });*/

$(".accept").click(function(){
     $(".editCover1").addClass("displayCover1");
	 $("#topicPop").addClass("Editvisible2");
	 $("#editPop1").removeClass("Editvisible1");
     

  });


  $(".reject").click(function(){
	 $(".editCover1").addClass("displayCover1");
	 $("#editPop1").addClass("Editvisible1");
	 $("#topicPop").removeClass("Editvisible2");


  });

  $("#CancelMessage").click( function(){
    $(".editCover1").removeClass("displayCover1");
	 $("#editPop1").removeClass("Editvisible1");
	  $("#topicPop").removeClass("Editvisible2");
  });

 $("#CancelTopic").click( function(){
    $(".editCover1").removeClass("displayCover1");
	 $("#editPop1").removeClass("Editvisible1");
	  $("#topicPop").removeClass("Editvisible2");
  });

  
$("[id^=student]").on('mouseenter', function(){
	$(this).next().show();
})

$("[id^=student]").on('mouseleave', function(){
	$(this).next().hide();
})

});

document.getElementById("topicForm").onsubmit=function(){return required()};
function required(){
    var filled=true;
    var input= document.getElementById("Topic-name");
    if(input.value.length==0){
        input.focus();
        filled= false;
    }  
    return filled;
  }


  document.title = "Session index";