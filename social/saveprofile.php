<?php
session_start();
?>

<html>

<head>

  <title>SocialNetwork - Home</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

<!-- Add header menu to top of page -->
<?php include 'header.php'; ?>

<section class="content">

<?php

//Include MySQL login vars
include 'details.php';

//If details are not sent catch error
if(!isset($_POST['name'])) {
  echo "An error has occured.";
} else {

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if($dbc->connect_errno) echo "An error has occured.";

//Make MySQL compatible date from DoB menu results
$dob = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];

//Sanitize inputs
$name = $dbc->real_escape_string(htmlspecialchars($_POST['name']));
$sex = $dbc->real_escape_string(htmlspecialchars($_POST['sex']));
$dob = $dbc->real_escape_string(htmlspecialchars($dob));
$about = $dbc->real_escape_string(htmlspecialchars($_POST['about']));
$media = $dbc->real_escape_string(htmlspecialchars($_POST['media']));
$hobbies = $dbc->real_escape_string(htmlspecialchars($_POST['hobbies']));
$user = $dbc->real_escape_string(htmlspecialchars($_SESSION['user']));

//Update DB with details
$result = $dbc->query("UPDATE Profiles SET name = '" . $name . "', sex = '" . $sex . "', dob = '" . $dob . "', about = '" . $about . "', media = '" . $media . "', hobbies = '" . $hobbies . "' WHERE username = '" . $user . "'");

//Close DB
$dbc->close();

//Catch save error
if(!$result) {
echo "An error has occured whilst saving profile.";
} else {
echo "Profile saved.";
}

}

?>

</section>

</body>

</html>