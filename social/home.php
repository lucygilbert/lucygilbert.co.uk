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

//If user not logged in redirect to login page
if(!isset($_SESSION['user'])) {
echo <<<END
<script>
window.location = "./login.php"
</script>
END;
}

//If user hasn't selected an option from the dropdown menu
if(!isset($_GET['choice'])) {

//Display dropdown menu
echo <<<END
<form action="home.php" method="get">
<select name="choice">
<option value="editprofile" selected>Edit Profile</option>
<option value="messages">Messages</option>
</select>
<input type="submit" value="Go">
</form>
END;

//If user has selected an option from dropdown menu
} else {

//Include the service they selected on the page, or catch error
switch ($_GET['choice']) {
case 'editprofile':
  include 'homeprofile.php';
  break;
case 'messages':
  include 'homemessages.php';
  break;
default:
  echo "An error has occured.<br><a href=\"home.php\">Back to Home</a>";
}

}

?>

</section>

</body>

</html>