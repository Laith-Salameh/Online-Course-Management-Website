$(document).ready(function(){

	$("#two-days").hide();


    $("#create-subject").click(function(){
        $(".cover").addClass("cover1");
        $(".create-form").addClass("create-form1");
        $(".availability-form").removeClass("availability-form1");
    });
    
    $("#cancelSubmit").click(function(){
        $(".cover").removeClass("cover1");
    });
    
    
    
    $("#create-Time").click(function(){
        $(".cover").addClass("cover1");
        $(".availability-form").addClass("availability-form1");
        $(".create-form").removeClass("create-form1");
    
    });
    
    $("#cancelTimeSubmit").click(function(){
        $(".cover").removeClass("cover1");
        
    });
    
    $(".hidden_button").on( "click" , function(){
        $(".cover").addClass("cover1");
        $(".search-form").addClass("search-form1");
        $(".availability-form").removeClass("availability-form1");
        $(".create-form").removeClass("create-form1");
    });
    
    $("#cancelSearch").click(function(){
        $(".cover").removeClass("cover1");
        
    });


    
    window.onclick = function(event) {
        if (event.target == $(".cover")[0] ) {
            $(".cover").removeClass("cover1");
            $(".availability-form").removeClass("availability-form1");
            $(".create-form").removeClass("create-form1");    
            
        }
        if( event.target == $(".editCover")[0]){
            $(".editCover").removeClass("displayCover");
            
        }
      }
    

    

    function twoDays(){
        var from_hour = parseInt( $("#from-time").val(),10);
        var from_minute = parseInt( $("#from-minutes").val(),10);
        var to_hour = parseInt( $("#to-time").val(),10);
        var to_minute = parseInt( $("#to-minutes").val(),10);
        if(to_hour < from_hour || (to_hour == from_hour && to_minute < from_minute) ){
            $("#two-days").show();
        }
        else{
            $("#two-days").hide();
        }
    
    }
    setInterval(twoDays , 100);

});

// document.getElementById("kraken").onclick = function(){window.location.replace("http://127.0.0.1:8081/php-mvc/");}
document.getElementById("subjectForm").onsubmit=function(){return requiredData()};
document.getElementById("availabilityForm").onsubmit=function(){return timeValidation()};


function requiredData(){
    arr=["Subject-name", "Description", "count"]
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

function timeValidation(){
    var from_hour=parseInt(document.getElementById("from-time").value,10);
    var from_minute=parseInt(document.getElementById("from-minutes").value,10);
    var to_hour=parseInt(document.getElementById("to-time").value,10);
    var to_minute=parseInt(document.getElementById("to-minutes").value,10);
    if(to_hour==from_hour && to_minute - from_minute < 30){
       return false;
    }
    else{
       return true;
    }
    
}








