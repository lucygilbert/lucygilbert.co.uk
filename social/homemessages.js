//Display compose div on click
function openCompose() {
  $("#compose").show()
}

//Send a message
function composeSend() {
  //Create AJAX request and send parameters
  $.post("sendmessages.php", { recip:$("#recipient").val(), head:$("#heading").val(), body:$("#bodytext").val() },
    function (status) {
      //If sending was successful, hide compose div
      if (status == "true") {
        $("#compose").hide()
        $("#recipient").val("")
        $("#heading").val("")
        $("#bodytext").val("")
      //If not successful, change header to error message
      } else {
        $("#msgtitle").html(status)
      }
    });
}

//Hide compose div on click
function composeCancel(){
  $("#compose").hide()
  $("#msgtitle").html("Send a message...")
  $("#recipient").val("")
  $("#heading").val("")
  $("#bodytext").val("")
}

//Show inbox/sentbox
function showInbox(str) {
  //Create AJAX request
  $.post("getmessages.php?box="+str,
    function (inboxtable) {
      //Fill message table with list of messages
      $("#messagetable").html(inboxtable)
      $("#inboxtype").html(str)
    });
}

//Display a message
function displayMessage(msgnumber) {
  //Create AJAX request and wait for response
  $.post("getmessages.php?num="+msgnumber,
    function (data) {
      $("#messagebox").show()
      $("#msgrecipient").html('<a href="profile.php?user='+$(data).find("recipuser").text()+'" target="_blank">'+$(data).find("recipient").text()+'</a>')
      $("#msgrecipuser").html($(data).find("recipuser").text())
      $("#msgsender").html('<a href="profile.php?user='+$(data).find("senduser").text()+'" target="_blank">'+$(data).find("sender").text()+'</a>')
      $("#msgsenduser").html($(data).find("senduser").text())
      $("#msgdate").html($(data).find("msgdate").text())
      $("#msgheading").html($(data).find("heading").text())
      $("#msgbody").html($(data).find("bodytext").text())
      $("#msgno").html($(data).find("message_id").text())
    }, "xml");
}

//Hide and empty message box
function cancelMessage() {
  $("#messagebox").hide()
  $("#msgrecipient").html("")
  $("#msgrecipuser").html("")
  $("#msgsender").html("")
  $("#msgsenduser").html("")
  $("#msgdate").html("")
  $("#msgheading").html("")
  $("#msgbody").html("")
  $("#msgno").html("")
}

//Reply to received messages
function messageReply() {
  //Get other user and heading from message
  var recip
  //If in sentbox, use recipient not sender
  if ($("#inboxtype").html() == "inbox") recip = $("#msgsenduser").html()
    else recip = $("#msgrecipuser").html()
  var head = $("#msgheading").html()
  //Close message
  cancelMessage()
  //Set recipient and heading fields in compose
  $("#recipient").val(recip)
  $("#heading").val("RE:"+head)
  //Open compose
  openCompose()
}

//Delete a message
function messageDelete() {
  //Get message number from hidden field
  var msgnumber = $("#msgno").html()
  $.post("deletemessages.php?num="+msgnumber,
    function (status) {
      if (status == "true") {
        //If successful alert, close message and refresh the inbox
        alert("Deleted successfully.")
        cancelMessage()
        //Refresh inbox with hidden field recording Inbox or Sentbox
        showInbox($("#inboxtype").html())
      //If failed alert but don't close message or refresh inbox
      } else alert("Delete failed. ("+status+")")
    });
}