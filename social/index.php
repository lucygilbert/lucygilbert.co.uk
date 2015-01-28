<?php
session_start();
?>

<html>

<head>

  <title></title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

  <section class="splash">

    <h1>SocialNetwork</h1><br>
    <?php //Set menu based on log in status
    if (!isset($_SESSION['user'])) {
      echo "<a href=\"login.php\">Log in</a>&nbsp;&#124;&nbsp;";
      echo "<a href=\"signup.php\">Sign up</a>";
    } else {
      echo "<a href=\"home.php\">Home</a>&nbsp;&#124;&nbsp;";
      echo "<a href=\"logout.php\">Log out</a>";
    }
    ?>

  </section>

</body>

</html>