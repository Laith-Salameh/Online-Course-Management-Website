var current= '#page7';
$(document).ready(function(){
    $('#page8').hide();
    $('#page9').hide();

    function givefocus( child ){
      $( child).nextAll().removeClass('focused');
      $( child).nextAll().addClass('blured');
      $( child).prevAll().removeClass('focused');
      $( child).prevAll().addClass('blured');
      $( child).addClass('focused');
      $(child).removeClass('blured');
      $("tr th:nth-child(1)").click();
      $("tr th:nth-child(2)").click(); 
    }
    $("#subjects_table").DataTable().destroy();
    $("#users-table").DataTable(
        {
           "scrollY":        "60vh",
            "scrollCollapse": true,
            "paging":         true
        });
    
    $("#sessions-table-admin").DataTable(
      {
        "scrollY":        "60vh",
        "scrollCollapse": true,
        "paging":         true
      }
    );
    $("#subjects-table-admin").DataTable(
      {
        "scrollY":        "60vh",
        "scrollCollapse": true,
        "paging":         true
      }
    );
    givefocus($('#view-users'));
    $('#view-users').on('click',function() {
        givefocus($(this));
        if( "#page7" !== current){
        $('#page7,'+current).fadeToggle(50);
        }
        current="#page7";
    });
    $('#sessions-admin').on('click',function() {
        givefocus($(this));
        if( "#page8" !== current){
        $('#page8,'+current).fadeToggle(50);
        }
        current="#page8";
    });
    $('#subjects-admin').on('click',function() {
      givefocus($(this));
      if( "#page9" !== current){
      $('#page9,'+current).fadeToggle(50);
      }
      current="#page9";
  });

});
/*function loadFile(event) {
  var pro_img = document.getElementById('profileimg');
  pro_img.src = URL.createObjectURL(event.target.files[0]);
}*/
document.title = "Admin";