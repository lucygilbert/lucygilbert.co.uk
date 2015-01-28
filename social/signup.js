function Validate() {
  //If password fields don't match display red cross and stop form send
  var x = $("#pass").val()
  var y = $("#pass2").val()

  if(x!=y) {
    $("#cross").show()
    return false
  }
}