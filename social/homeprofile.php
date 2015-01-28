<?php

//Include MySQL login vars
include 'details.php';

//Connect to DB and catch errors
$dbc = new mysqli($mhost, $muser, $mpass, $mdb);

if($dbc->connect_errno) echo "An error has occured. <a href=\"home.php?choice=editprofile\">Try again</a>";

//Sanitize input before using in query
$user = $dbc->real_escape_string(htmlspecialchars($_SESSION['user']));

//Perform query and fetch result
$result = $dbc->query("SELECT * FROM Profiles WHERE username='" . $_SESSION['user'] . "'");
$result = $result->fetch_row();

//Close DB
$dbc->close();

//If fetching result returns null then something when wrong
if(!$result) {
  echo "An error has occured. <a href=\"home.php?choice=editprofile\">Try again</a>";
//Otherwise process the result
} else {

//Create array for handling result
$selected = array('','','','','','');

//Check sex and change one of the selected vars to set the dropdown menu
switch ($result[2]){
case 'Male':
$selected[0] = " selected";
break;
case 'Female':
$selected[1] = " selected";
break;
case 'Other':
$selected[2] = " selected";
}

//Remove MySQL sanatization
$result[1] = stripslashes($result[1]);
$result[4] = stripslashes($result[4]);
$result[5] = stripslashes($result[5]);
$result[6] = stripslashes($result[6]);

echo <<<END
<script src="jquery-1.10.2.min.js"></script>
<script src="homeprofile.js"></script>

<!-- Edit Profile Form -->
<form name="proform" action="saveprofile.php" method="post">
Name: <input type="text" name="name" value="$result[1]" maxlength="30"><br>
<p class="maxlength">Max length: 30 Characters</p><br>
Sex: <select name="sex"><option value="Male"$selected[0]>Male</option>
<option value="Female"$selected[1]>Female</option><option value="Other"$selected[2]>Other</option></select><br>
D.O.B.: <select name="year">
END;

//Extract year from DoB result
$year = substr($result[3], 0, 4);

//Populate year menu and select current year of birth
for ($i = 1900; $i < Date('Y'); $i++) {
  if ($i == $year) {
    $selected[3] = " selected";
  }
  echo "<option value=\"$i\"$selected[3]>$i</option>";
  $selected[3] = "";
}

echo <<<END
</select>
<select id="month" onfocus="dayNumber()" onchange="dayNumber()" name="month">
END;

//Extract month from DoB result
$month = substr($result[3], 5, 2);

//Populate month menu and select current month of birth
for ($i = 1; $i <= 12; $i++) {
  if ($i == $month) {
    $selected[4] = " selected";
  }
  $i2 = ($i<10) ? '0'.$i : $i;
  echo "<option value=\"$i2\"$selected[4]>$i2</option>";
  $selected[4] = "";
}

echo <<<END
</select>

<select id="day" onfocus="dayNumber()" name="day">
END;

//Extract day from DoB result
$day = substr($result[3], 8, 2);

//Set number of days in month
switch ($month) {
case '02':
  $daynum = 28;
  break;
case '04': case '06': case '09': case '11':
  $daynum = 30;
  break;
default:
  $daynum = 31;
}

//Populate day menu and select current day of birth
for ($i = 1; $i <= $daynum; $i++) {
  if ($i == $day) {
    $selected[5] = " selected";
  }
  $i2 = ($i<10) ? '0'.$i : $i;
  echo "<option value=\"$i2\"$selected[5]>$i2</option>";
  $selected[5] = "";
}

echo <<<END
</select><br>

About me:<br>
<textarea name="about" rows="4" columns="30" maxlength="100">$result[4]</textarea><br>
<p class="maxlength">Max length: 100 Characters</p><br>
Favourite books/films/music:<br>
<textarea name="media" rows="4" columns="30" maxlength="100">$result[5]</textarea><br>
<p class="maxlength">Max length: 100 Characters</p><br>
Hobbies and interests:<br>
<textarea name="hobbies" rows="4" columns="30" maxlength="100">$result[6]</textarea><br>
<p class="maxlength">Max length: 100 Characters</p><br>

<input type="submit" value="Save">

</form>

END;

}

?>