<?php

//Standardized header for main pages
echo <<<END
<header>

  <h1>SocialNetwork</h1><br>

  <nav>
  
    <a href="home.php">Home</a>&nbsp;&#124;&nbsp;
    <a href="profile.php?user=me">My profile</a>&nbsp;&#124;&nbsp;
    <a href="members.php">Members</a>&nbsp;&#124;&nbsp;
    <a href="logout.php">Log out</a>

  </nav>

</header>
END;
?>