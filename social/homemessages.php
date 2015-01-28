<?php

//JS functions and mail buttons
echo <<<END
<script src="jquery-1.10.2.min.js"></script>
<script src="homemessages.js"></script>

<span id="inboxtype" class="floatr">inbox</span>
<input type="button" value="Compose" onclick="openCompose()">
<input type="button" value="Inbox" onclick="showInbox('inbox')">
<input type="button" value="Sent" onclick="showInbox('sent')"><br>
END;

//Include MySQL login vars
include 'details.php';

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if ($dbc->connect_errno) echo "An error has occured. <a href=\"home.php?choice=messages\">Try again</a>";

//Select user's messages
$result = $dbc->query("SELECT * FROM Messages WHERE recipient='" . $_SESSION['user'] . "'");

//Catch error
if (!$result) {
echo "An error has occured. <a href=\"home.php?choice=messages\">Try again</a> ";
exit;
}

//Put messages in array
while ($row = $result->fetch_row()) {
  $rows[] = $row;
}

//If no messages, add a blank row to set var
if (empty($rows)) {
  $rows[0] = array('No messages','','','','','');
}

//Close DB
$dbc->close();

//Open and head inbox table
echo <<<END
<table id="messagetable">
<tr><th>TO:</th><th>FROM:</th><th>DATE:</th><th>HEADING:</th></tr>
END;

//Populate table with messages
foreach ($rows as $row) {
  echo "<tr><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href=\"#\" onclick=\"displayMessage($row[0])\">$row[4]</a></td></tr>";
}

echo "</table>";

//Compose message div and display message div
echo <<<END
<section id="compose" class="popup">
<input class="floatr" type="button" value="Cancel" onclick="composeCancel()">
<input class="floatr" type="button" value="Send" onclick="composeSend()"><h4 id="msgtitle">Send a message...</h4>
<table><tr><td class="bold">Recipient:</td><td><input id="recipient" type="text" maxlength="20"></td>
<td><p class="maxlength">Max length: 20 characters.</p></td></tr>
<tr><td class="bold">Heading:</td><td><input id="heading" type="text" maxlength="30"></td>
<td><p class="maxlength">Max length: 30 characters.</p></td></tr></table>
<span class="bold">Message:</span><br>
<textarea id="bodytext" rows="10" cols="47" maxlength="100"></textarea>
<p class="maxlength">Max length: 100 characters</p>
</section>
<section id="messagebox" class="popup">
<input class="floatr" type="button" value="Cancel" onclick="cancelMessage()">
<input class="floatr" type="button" value="Delete" onclick="messageDelete()">
<input class="floatr" type="button" value="Reply" onclick="messageReply()"><h4>Message</h4>
<table><tr><td class="bold">Recipient:</td><td><span id="msgrecipient"></span></td><td>(<span class="usernames" id="msgrecipuser"></span>)</td></tr>
<tr><td class="bold">Sender:</td><td><span id="msgsender"></span></td><td>(<span class="usernames" id="msgsenduser"></span>)</td></tr>
<tr><td class="bold">Date:</td><td><span id="msgdate"></span></td></tr>
<tr><td class="bold">Heading:</td><td><span id="msgheading"></span></td></tr></table>
<span class="bold">Message:</span><br>
<p id="msgbody"></p>
<span id="msgno" class="invis"></span>
</section>
END;

?>