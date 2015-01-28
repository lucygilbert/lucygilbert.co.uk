<?php

session_start();

//If no recipient is chosen, catch error
if (!isset($_POST['recip'])) {
  echo "No recipient. Try again.";
  exit;
}

//Include MySQL login vars
include 'details.php';

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if ($dbc->connect_errno) {
  echo "Database error. Try again.";
  exit;
}

//If user is trying to send to self, catch error
if ($_POST['recip'] == $_SESSION['user']) {
  echo "Can't send to self. Try again.";
  exit;
}

//Sanitize inputs
$recip = $dbc->escape_string(htmlspecialchars($_POST['recip']));
$send = $_SESSION['user'];
$head = $dbc->escape_string(htmlspecialchars($_POST['head']));
$text = $dbc->escape_string(htmlspecialchars($_POST['body']));

//Check the recipient exists
$result = $dbc->query("SELECT * FROM Users WHERE username='$recip'");

if (!$result->fetch_row()) {
  echo "Recipient does not exist. Try again.";
  exit;
}

//Insert the message into the database
$result = $dbc->query("INSERT INTO Messages (recipient, sender, msgdate, heading, bodytext, msgread) VALUES ('$recip', '$send', CURDATE(), '$head', '$text', 0)");

//Close DB
$dbc->close();

//Catch query errors or return true
if (!$result) {
  echo "Error writing message. Try again.";
  exit;
}

echo "true";

?>