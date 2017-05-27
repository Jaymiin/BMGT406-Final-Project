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

//require_once('LoginPage.php');
//$thisUser = $inputemail;

// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {
	// Prepare a SQL query
	$sqlQuery =
"SELECT email2 
FROM workoutFriends 
WHERE email1 = :userEmail;
";

//join following query to get names?
//SELECT firstname, lastname
//FROM users u, workoutFriends w
//WHERE u.email=w.email2;";

//SELECT users.firstname, users.lastname, users.email, workoutFriends.email1
//FROM users 
//INNER JOIN workoutFriends
//ON users.email = workoutFriends.email1);";

	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':userEmail', $thisUser, PDO::PARAM_STR);
	$result = $statement1->execute();

	if (!$result) {
		$body .= "Listing records failed.";
	} else {
		$numberOfRows = $statement1->fetchAll(PDO::FETCH_ASSOC);
		if($numberOfRows) {
			$body .="<table style= \"border-collapse:collapse;\">";
			foreach ($numberOfRows as $multipleRows)
					{
					$email2 = $multipleRows['email2'];
					//$fname = $multipleRows['firstname'];
					//$lname = $multipleRows['lastname'];		
					//$body .= "<td>$fname</td><td>$lname</td><td>$email2</td>";
					$body .= "<td>$email2</td>";
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
