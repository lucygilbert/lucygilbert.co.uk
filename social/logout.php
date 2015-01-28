<?php
//Destroy session, logging out user
session_start();
session_destroy();
?>

<html>

<head>

  <title></title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

  <section class="splash">

    <h1>SocialNetwork</h1><br>
    You have been successfully logged out.<br>
    <a href="index.php">Back to Main</a>

  </section>

</body>

</html>