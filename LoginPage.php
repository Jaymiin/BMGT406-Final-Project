<?php
include_once('support.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
include_once('connectDB.php');
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "Welcome";
$body = "<fieldset><legend> $title </legend><br/>";

// Initialize variables with values for the name of the table ($name_of_table)
$name_of_table = 'users';
$inputemail = $_GET['email'];
$inputpassword = $_GET['password'];


// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {

	// Prepare a SQL query and bind variables.
	$sqlQuery = "SELECT * from $name_of_table where email = :email";
	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':email', $inputemail, PDO::PARAM_STR);

	// Execute your query and store the result in $result.
	$result =  $statement1->execute();

	if(!$result) {
		// Query fails.
		$body = "Login Failed." .$db->errorInfo();
	} else {
		$singleRow = $statement1->fetch();
			if(!$singleRow) {
				// Invalid email.
				$body .= "Invalid email: $inputemail";
			} else {
				if ($singleRow['password'] != $inputpassword) {
					// If the password is not the same as $inputpassword, then an "Invalid Password" has been entered.
					$body .= "Invalid password.";
				} else {
					$firstname=$singleRow['firstname'];
					$email = $singleRow['email'];
					$body.="What would you like to do, $firstname?<br/><br/><br/>";
					$body.= "<form id=\"signup\" action=\"InsertActivity.php\" method=\"GET\">

			<strong>Activity Name</strong><input class=\"ins\" type=\"text\" name=\"actName\" /><br/><br/>
			<strong>Time</strong><input class=\"ins\" type=\"time\" name=\"actTime\" /><br/><br/>
			<strong>Date</strong><input class=\"ins\" type=\"date\" name=\"actDate\" /><br/><br/>
			<strong>Description</strong><input class=\"ins\" type=\"text\" name=\"actDescription\" /><br/><br/>
			<input class=\"button\" type=\"reset\" name=\"reset\" value=\"Reset\" /><br /><br />
			<input  class=\"button\" type=\"submit\" name=\"createAct\" value=\"Create Activity\" /><br /><br />
</form>


<form class=\"view\" action=\"ViewActivities.php\" method=\"GET\">
			<input class=\"button\" class=\"view\" type=\"submit\" name=\"viewAct\" value=\"View All Activities\" /><br /><br />
</form>

<form class=\"view\" action=\"ViewMyActivities.php\" method=\"GET\">
			<input type=\"text\" name=\"userEmail\" value=". $email . " style=\"display: none\" readonly>
			<input class=\"button\" class=\"view\" type=\"submit\" name=\"viewAct\" value=\"My Activities\" /><br /><br />
</form>

<form  class=\"viewF\" action=\"ViewFriends.php\" method=\"GET\">
					<input type=\"text\" name=\"userEmail\" value=". $email . " style=\"display: none\" readonly>
					<input class=\"button\" type=\"submit\" name=\"viewFriends\" value=\"View My Friends\" /><br /><br />
</form>

<form  class=\"addF\" action=\"InsertFriend.php\" methods=\"GET\">
			<input type=\"text\" name=\"userEmail\" value=". $email . " style=\"display: none\" readonly>
			<strong>Friend's Email</strong><input class=\"ins\" type=\"text\" name=\"friendEmail\" /><br/><br/>
			<input class=\"button\" type=\"submit\" name=\"addF\" value=\"Add Friend\" /><br /><br />
</form>

<p>
<br/><a href=\"http://bmgt406.rhsmith.umd.edu/~bmgt406_02/406FinalProject_V.4/login.html\"><input type=\"submit\" value = \"Logout\"/></a>
</p></br>
</fieldset>
<footer>
  		<div id=\"note\">BMGT406 Final Project 2016 - Maron Fasil, Jasmine Yu</div>
  	<div id=\"badges\">
  	<!-- #facebook like button -->
  	<div id=\"fb-like\">
      <iframe src=\"https://www.facebook.com/plugins/like.php?href=http://www.umiacs.umd.edu/~louiqa/2016/BMGT406/\" style=\"border:none; width:450px; height:80px\"></iframe>
  	</div>
	</footer>";
			   }
			}
		}
	// Closing query connection
	$statement1->closeCursor();
} else {
// Table does not exist in db.
	$body .= "Table " . $name_of_table . " does not exist.<br/>";
}

echo generatePage($title,$body);
?>
