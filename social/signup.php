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
    <?php
    //Include MySQL login vars
    include 'details.php';

    //If user not logged in and not currently trying to sign up then display form
    if (!isset($_SESSION['user']) AND !isset($_POST['user'])) {

//Print form
echo <<<END
<form name="suform" action="signup.php" onsubmit="return Validate()" method="post">
<table>
<tr>
<td>Username: </td><td><input type="text" name="user" maxlength="20" required></td><td></td>
</tr>
<tr>
<td colspan="2"><p class="maxlength">Max length: 20 Characters</p></td><td></td>
</tr>
<tr>
<td>Password: </td><td><input type="password" id="pass" required></td><td></td>
</tr>
<tr>
<td style="width:100px">Confirm password: </td><td><input type="password" id="pass2" required></td><td style="width:16px"><img id="cross" src="red-x.png"></td>
</tr>
</table>
<input type="submit">
</form>
END;
    //If currently trying to sign up
    } else if (isset($_POST['user'])){

      //Connect to DB and catch errors
      $dbc = new mysqli($mhost, $muser, $mpass, $mdb);

      if($dbc->connect_errno) echo "An error has occured. <a href=\"signup.php\">Try again</a>";

      //Sanitize input
      $user = $dbc->real_escape_string(htmlspecialchars(strtolower($_POST['user'])));
      $pass = $dbc->real_escape_string(htmlspecialchars($_POST['pass']));

      //Find if username already exists
      $result = $dbc->query("SELECT username FROM Users WHERE username = '" . $user . "'");

      //If it does or the username is a restricted name, catch error
      if($result->fetch_row() OR $user == "me") {
        echo "Username is in-use or restricted.<br><a href=\"signup.php\">Try again</a>";

      //If username is valid and not in use
      } else {

      //Create entry in Users table
      $result = $dbc->query("INSERT INTO Users (username, password) VALUES ('" . $user . "','" . hash('md5', $pass) . "')");
      //Create entry in Profiles table with standard profile information
      $result2 = $dbc->query("INSERT INTO Profiles (username, name, sex, dob, about, media, hobbies) VALUES ('" . $user . "','John Doe','Male','1970-01-01','About me.','Favourite books/films/music.','Hobbies and interests.')");

      //Close DB
      $dbc->close();

      //Catch errors
      if(!$result) echo "Failed to add user.<br><a href=\"signup.php\">Try again</a>";
        else {
          $_SESSION['user'] = $user;
echo <<<END
<script>
window.location = "./home.php"
</script>
END;
        }

      }

    //Else user is currently logged in
    } else {

      echo "You are currently logged into an account.<br>";
      echo "<a href=\"index.php\">Back to Main</a>";

    }
    ?>

  </section>

<script src="jquery-1.10.2.min.js"></script>
<script src="signup.js"></script>

</body>

</html>