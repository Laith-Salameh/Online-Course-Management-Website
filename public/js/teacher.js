$(document).ready(function() {
  $("#subjects_table").DataTable().destroy();
$(".teacher_table").DataTable(
    {
       "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    });

  $(".enroll").click(function(){
    $(this).hide();
    $(this).parent().addClass("enrolled");
     $(this).parent().html("Enrolled!");


  });
});

var costum_select = document.getElementsByClassName("custom-select");
var select_length = costum_select.length;
for (i = 0; i < select_length; i++) {
 var selElmnt = costum_select[i].getElementsByTagName("select")[0];
  var selElmnt_length = selElmnt.length;
  var a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  costum_select[i].appendChild(a);

  var b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt_length; j++) {
   
    var c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        var s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        var h = this.parentNode.previousSibling;
        for (i = 0; i <  s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            var y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  costum_select[i].appendChild(b);
  a.addEventListener("click", function(e) {
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {

  var arrNo = [];
  var items = document.getElementsByClassName("select-items");
  var selected = document.getElementsByClassName("select-selected");
  for (i = 0; i < selected.length; i++) {
    if (elmnt == selected[i]) {
      arrNo.push(i)
    } else {
      selected[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i <items.length; i++) {
    if (arrNo.indexOf(i)) {
      items[i].classList.add("select-hide");
    }
  }
}
document.addEventListener("click", closeAllSelect);
document.title = "Teacher";