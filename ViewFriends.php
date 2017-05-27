<?php
include_once('support.php');
include_once('connectDB.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "View Workout Friends";
$body = "<fieldset><legend> $title </legend>";
$name_of_table = 'workoutFriends';
$thisUser = $_GET['userEmail'];

echo $thisUser;
//$thisUser = $_GET['userEmail'];
//require_once('LoginPage.php');
//$thisUser = $inputemail;

// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {
	// Prepare a SQL query
	$sqlQuery = "SELECT firstname, lastname FROM users
	WHERE email IN (SELECT email2 FROM " . $name_of_table . " WHERE email1 = :email1;";
	//NEED SET EMAIL1 EQUAL TO THE NAME OF THE PERSON WHO IS LOGGED IN? POSSIBLE TO GET THAT
	//VARIABLE? PERHAPS DECLARE PUBLIC?
	//email "IN" or "EQUAL TO"
	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':email1', $thisUser, PDO::PARAM_STR);
	$result = $statement1->execute();

	if (!$result) {
		$body .= "Listing records failed.";
	} else {
		$numberOfRows = $statement1->fetchAll(PDO::FETCH_ASSOC);
		if($numberOfRows) {
			$body .="<table style= \"border-collapse:collapse;\">";
			$body .= "<tr><th>Activity Name</th><th>Date</th><th>Time</th><th>Description</th></tr>";
			foreach ($numberOfRows as $multipleRows)
					{
					$firstname = $multipleRows['firstname'];
					$lastname = $multipleRows['lastname'];
					$body .= "<tr><td>$actName</td>";
					$body .= "<td>$firstname</td><td>$lastname</td>";
					$body .= "</tr>";
					}
			$body .="</table>";
		} else {
			$body .= "Table is empty.";
		}
	}
	// Closing query connection
	$statement1->closeCursor();
} else {
	// Table does not exist in db.
	$body .= "Table does not exist in the database.";
}

//$body .= "<a href=\"LoginPage.php\"><input type=\"submit\" value = \"Main Menu\"/></a>";
//Will the login page take us to the right html page?
$body.= "</fieldset>";

echo generatePage($title,$body);

?>
