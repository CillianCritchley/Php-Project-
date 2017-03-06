/*
	Group Javascript file.
	Craig Lawlor
	Craig Doyle
	Cillian
	Helmuts
*/

/*

 function goto(url){
 document.getElementById("contentframe").src=url;
 }
 */
// when clicked toggle between shown and hidden
function toggle1() {
   document.getElementById("link1").classList.toggle("show");

    //document.getElementById("test").classList.toggle("dropbutclicked");
}


function toggle2() {
    document.getElementById("link2").classList.toggle("show");


}
function toggle3() {

    document.getElementById("link3").classList.toggle("show");

}

function toggle4() {

    document.getElementById("link4").classList.toggle("show");

}

function testfunction(id)
{
    document.getElementById(id).classList.toggle("linkbut2");
}

/*
// Close the link dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbut')) {

    var dropdowns = document.getElementsByClassName("dropdownSide");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
} */