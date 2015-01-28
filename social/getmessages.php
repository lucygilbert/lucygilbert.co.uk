<?php 
//Continue user session
session_start();

//Include MySQL login vars
include 'details.php';

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if ($dbc->connect_errno) {
  echo "Error.";
  exit;
}

//If user requests specific message then return message as XML data
if (isset($_GET['num'])) {
  //Get message details from database
  $result = $dbc->query("SELECT * FROM Messages WHERE message_id=" . $_GET['num']);
  if (!$result) {
    echo "Error. Try again.";
    exit;
  }
  $row = $result->fetch_row();
  //Get real names of users, if it fails, use usernames
  $result = $dbc->query("SELECT name FROM Profiles WHERE username='" . $row[1] . "'");
  $recipname = $result->fetch_row();
  if (!$recipname) $recipname = $row[1];
  $result = $dbc->query("SELECT name FROM Profiles WHERE username='" . $row[2] . "'");
  $sendname = $result->fetch_row();
  if (!$sendname) $sendname = $row[2];
  //Populate an XML element with the message details
  $xml = new SimpleXMLElement("<xml></xml>");
  $xml->addChild("message_id", $row[0]);
  $xml->addChild("recipient", stripslashes($recipname[0]));
  $xml->addChild("recipuser", $row[1]);
  $xml->addChild("sender", stripslashes($sendname[0]));
  $xml->addChild("senduser", $row[2]);
  $xml->addChild("msgdate", $row[3]);
  $xml->addChild("heading", $row[4]);
  $xml->addChild("bodytext", $row[5]);
  $xml->addChild("msgread", $row[6]);
  header("Content-type: text/xml");
  echo $xml->asXML();
  exit;
}

if (isset($_GET['box'])) {
  if ($_GET['box'] == "inbox") {
    //Find user's messages, return 'No messages.' if none
    $result = $dbc->query("SELECT * FROM Messages WHERE recipient='" . $_SESSION['user'] . "'");
  } else if ($_GET['box'] == "sent") {
    //Find user's messages, return 'No messages.' if none
    $result = $dbc->query("SELECT * FROM Messages WHERE sender='" . $_SESSION['user'] . "'");
  }
} else {
  echo "Error.";
  exit;
}

if (!$result) {
  echo "Failed to collect messages.";
  exit;
}

//Populate array with messages
while ($row = $result->fetch_row()) {
  $rows[] = $row;
}

//If no messages, add a blank row to set var
if (empty($rows)) {
  $rows[0] = array('No messages','','','','','');
}

//Close DB
$dbc->close();

//Create response text var
$response = <<<END
<table id="messagetable">
<tr><th>TO:</th><th>FROM:</th><th>DATE:</th><th>HEADING:</th></tr>
END;

//Add each message to response text
foreach ($rows as $row) {
  $response .= "<tr><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href=\"#\" onclick=\"displayMessage($row[0])\">$row[4]</a></td></tr>";
}

echo $response;

?>