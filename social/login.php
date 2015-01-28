<?php
session_start();
?>

<html>

<head>

  <title>SocialNetwork - Log in</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

  <section class="splash">

    <h1>SocialNetwork</h1>

<?php

//Include MySQL login vars
include 'details.php';

//If not logged in and not currently logging in display login form
if(!isset($_SESSION['user']) AND !isset($_POST['user'])) {

echo <<<END
  <form action="login.php" method="post">
  Username:<input type="text" name="user" required><br>
  Password:<input type="password" name="pass" required><br>
  <input type="submit">
  </form>
END;

//If logged in, display error
} else if(isset($_SESSION['user'])) {

  echo "You are already logged in.<br><a href=\"index.php\">Home page</a>";

//Else user must be currently logging in
} else {

  //Connect to DB and catch errors
  $dbc = new mysqli($mhost, $muser, $mpass, $mdb);

  if($dbc->connect_errno) echo "An error has occured. <a href=\"login.php\">Try again</a>";

  //Sanitize login details
  $user = $dbc->real_escape_string(htmlspecialchars($_POST['user']));
  $pass = $dbc->real_escape_string(htmlspecialchars($_POST['pass']));

  //Find the user in the DB
  $result = $dbc->query("SELECT * FROM Users WHERE username='" . $user . "' AND password='" . hash('md5', $pass) . "'");
  $user = $result->fetch_row();

  //Close DB
  $dbc->close();

  //If user exists login and redirect to home page, if not call error.
  if (!$user) {
    echo "No such username/password.<br><a href=\"login.php\">Try again</a>";
    session_destroy();
  }
  else {
    $_SESSION['user'] = $user[0];
echo <<<END
<script>
window.location = "./home.php"
</script>
END;
  }
  
}

?>

  </section>

</body>

</html>	