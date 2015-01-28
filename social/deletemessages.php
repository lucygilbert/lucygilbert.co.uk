<?php

//If no message is selected, catch error
if (!isset($_GET['num'])) {
  echo "num not set";
  exit;
}

//Include MySQL login vars
Include 'details.php';

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if ($dbc->connect_errno) {
  echo "connect error";
  exit;
}

//Delete message and catch errors
$result = $dbc->query("DELETE FROM Messages WHERE message_id=" . $_GET['num']);

//Close DB
$dbc->close();

//If failed catch error else return true
if (!$result) {
  echo "query failure";
  exit;
}

echo "true";

?>