var current= '#page0';
$(document).ready(function(){
  function givefocus( child ){
    $( child).nextAll().removeClass('focused');
    $( child).nextAll().addClass('blured');
    $( child).prevAll().removeClass('focused');
    $( child).prevAll().addClass('blured');
    $( child).addClass('focused');
    $(child).removeClass('blured');
  }

  $("#subjects_table").DataTable().destroy();
  $(".teacher_t").DataTable(
    {
       "scrollY":        "60vh",
        "scrollCollapse": true,
        "paging":         true
    });

    $("#sessions_table").DataTable(
      {
    "scrollY":        "60vh",
    "scrollCollapse": true,
    "paging":         true
      }
    );

    $('#page2').hide();
    $('#page3').hide();
    $('#page1').hide();
    $('#page4').hide();
    $('#page5').hide();
    givefocus($('#CloseBook'));

    $('#CloseBook').on('click',function(){
      givefocus($(this));
      if("#page0" !== current){
        $('#page0,'+current ).fadeToggle(50); 
      }
      current="#page0";
    });
    $('#Friends').on('click',function() {
        givefocus($(this));
        if( "#page1" !== current){
          $('#page1,'+current ).fadeToggle(50); 
        }
        current="#page1";    
    });
    $('#Teachers').on('click', function() {
        givefocus($(this));
        if( "#page2" !== current){
        $('#page2,'+current).fadeToggle(50);
        }
        current="#page2";
    });
    $('#Sessions').on('click',function() {
        givefocus($(this));
        if( "#page4" !== current){
        $('#page4,'+current).fadeToggle(50);
        }
        current="#page4";
    });
    $('#messages').on('click',function() {
        givefocus($(this));
        if( "#page3" !== current){
        $('#page3,'+current).fadeToggle(50);
        }
        current="#page3";
    });
    $('#SessionsTeacher').on('click',function() {
        givefocus($(this));
        if( "#page5" !== current){
        $('#page5,'+current).fadeToggle(50);
        }
        current="#page5";
    });

      $("[class^=star]").bind( 'full', function(){
        $(this).addClass("oj");
        $(this).removeClass("far");
        $(this).addClass("fa");
      } );
      $("[class^=star]").bind( 'selected', function(){
        $(this).addClass("selected");
        $(this).removeClass("oj");
        $(this).removeClass("far");
        $(this).addClass("fa");
      } );
      $("[class^=star]").bind( 'empty', function(){
        $(this).removeClass("oj");
        $(this).addClass("far");
        $(this).removeClass("fa");
      } );
      $("[class^=star]").bind( 'noselected', function(){
        $(this).removeClass("selected");
        $(this).removeClass("oj");
        $(this).addClass("far");
        $(this).removeClass("fa");
        
      } );
      $("[class^=star]").bind( 'keepselected', function(){
        if( $(this).hasClass("selected") ){
          $(this).removeClass("far");
          $(this).addClass("fa");
        }
      });
      $("[class^=star]").on('mouseenter', function(){
        $(this).trigger('full');
        $(this).nextAll().trigger('empty');
        $(this).prevAll().trigger('full');
      });
      $("[class^=star]").on('click', function(){
        $(this).trigger('selected');
        $(this).nextAll().trigger('noselected');
        $(this).prevAll().trigger('selected');
        var starnumber = $(this).index() + 1 ;
        var sessionid= $(this).parent().children().eq(5);
        $('#rating').val(starnumber) ;
        $('#ratingID').val(sessionid.val());
        $('#send_rating').submit();
        //alert( starnumber );
        //alert( sessionid.val() );
      });
      $(".rating").on('mouseleave' , function(){ 
         $(this).children().trigger("empty");
         $(this).children().trigger("keepselected");
      } );

      


      });
      document.title = "Profile";