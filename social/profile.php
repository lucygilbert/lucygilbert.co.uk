<?php
session_start();
?>

<html>

<head>

  <title>SocialNetwork - Profile</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

<!-- Add header menu to top of page -->
<?php include 'header.php' ?>

<section>

<?php

//Include MySQL login vars
include 'details.php';

//If no user selected catch error
if(!isset($_GET['user'])) {
  echo "No user selected.";
} else {

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if($dbc->connect_errno) echo "An error has occured. <a href=\"profile.php?user=" . $_GET['user'] . "\">Try again</a>";

//Sanitize input
$user = $dbc->real_escape_string(htmlspecialchars($_GET['user']));

//If input is 'me' then show the user's own profile
if($user == "me") $user = $_SESSION['user'];

//Get user's details
$result = $dbc->query("SELECT * FROM Profiles WHERE username = '" . $user . "'");
$result = $result->fetch_row();

//Close DB
$dbc->close();

//Get age from year of birth
$age = date('Y') - date('Y', strtotime($result[3]));

//If it's not past their birthday then minus 1 year
if(date('z', strtotime($result[3])) > date('z')) {
  $age -= 1;
}

//Desanitize results
$result[1] = stripslashes($result[1]);
$result[4] = stripslashes($result[4]);
$result[5] = stripslashes($result[5]);
$result[6] = stripslashes($result[6]);


//Print table of results
echo <<<END
<table>
<tr>
<td>Name:</td><td>$result[1]</td>
</tr>
<tr>
<td>Sex:</td><td>$result[2]</td>
</tr>
<tr>
<td>Age:</td><td>$age</td>
</tr>
<tr>
<td>About me:</td><td>$result[4]</td>
</tr>
<tr>
<td>Favourite books/films/music:</td><td>$result[5]</td>
</tr>
<tr>
<td>Hobbies and interests:</td><td>$result[6]</td>
</tr>
</table>
END;

}

?>

</section>

</body>

</html>