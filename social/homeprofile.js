//Function to set correct no. of days for month
function dayNumber() {
  //Var to modify for loop var into MySQL date format
  var imod
  //Var containing currently selected month
  var x = $("#month").prop("selectedIndex")
  //Empty the dropdown menu
  $("#day").children().remove()
  //If month is February add 28 days
  switch (x) {
  case 1:
    for (var i = 1; i <= 28; i++) {
      //Append 0 if day is less than 10
      imod = (i < 10) ? "0" + i : i
      $("#day").append($("<option>", { "value" : imod }).text(imod))
    }
      break
    //If month is April, June, September or November add 30 days
  case 3: case 5: case 8: case 10:
    for (var i = 1; i <= 30; i++) {
      imod = (i < 10) ? "0" + i : i
      $("#day").append($("<option>", { "value" : imod }).text(imod))
    }
      break
    //Otherwise add 31 days
  default:
    for (var i = 1; i <= 31; i++) {
      imod = (i < 10) ? "0" + i : i
      $("#day").append($("<option>", { "value" : imod }).text(imod))
    }
      break
  }
}