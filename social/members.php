<?php
session_start();
?>

<html>

<head>

  <title>SocialNetwork - Members</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

<!-- Add header menu to top of page -->
<?php include 'header.php'; ?>

<section class="content">

<?php

//Include MySQL login vars
include 'details.php';

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if($dbc->connect_errno) echo "An error has occured. <a href=\"members.php\">Try again</a>";

//Get list of all usernames and real names
$result = $dbc->query("SELECT username, name FROM Profiles");

//Catch error
if (!$result) {
echo "An error has occured. <a href=\"members.php\">Try again</a> ";
exit;
}

//Populate rows array with results
while($row = $result->fetch_row()) {
  $rows[] = $row;
}

//Close DB
$dbc->close();

//For each user, remove sanatization and create link
foreach($rows as $row) {

  $row[0] = stripslashes($row[0]);
  $row[1] = stripslashes($row[1]);
  echo "<a href=\"profile.php?user=$row[0]\">$row[1]</a><br>";

}

?>

</section>

</body>

</html>