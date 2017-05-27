<?php
include_once('support.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
include_once('connectDB.php');
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "Create a New Friendship";
$body = "<fieldset><legend> $title </legend>";

// Initialize variables with values for the name of the table ($name_of_table)
$name_of_table = 'workoutFriends';
// and the 6 fields - firstname, lastname, address, email, password and plan.
$email1 = $_GET['userEmail'];
$email2 = $_GET['friendEmail']; 


$sqlQuery = "INSERT INTO " . $name_of_table . " 
			VALUES (:email1, :email2);"; 

// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {

	// Prepare a SQL query and bind all 6 variables. 
	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':email1', $email1, PDO::PARAM_STR); 
	$statement1->bindValue(':email2', $email2, PDO::PARAM_STR);
	
	// Execute the SQL query using $statement1->execute(); and assign the value
	$result = $statement1->execute();
	// that is returned  to $result.

	if(!$result) {
		// Query fails.
		$body .= "The new friendship could not be made<br/>";
	} else {
		// Query is successful.
		$statement1->closeCursor();	
		$sqlQuery2 = "INSERT INTO " . $name_of_table . " 
			VALUES (:email2, :email1)";
		$statement2 = $db->prepare($sqlQuery2);
		$statement2->bindValue(':email1', $email1, PDO::PARAM_STR); 
		$statement2->bindValue(':email2', $email2, PDO::PARAM_STR);
		$result = $statement2->execute(); 
		$statement2->closeCursor();	
		$body .= "<h3>You made a new friend!</h3>";
	}
	// Closing query connection
} else {
// Table does not exist in db.
	$body .= "Table " . $name_of_table . " does not exist.<br/>";
}

//$body .= "<br/><a href=\"http://bmgt406.rhsmith.umd.edu/~bmgt406_02/406FinalProject_V.4%20/LoginPage.php?email=mf%40gmail.com&password=02&Login=Login\"><input type=\"submit\" value = \"Main Menu\"/></a>";
$body .= "</fieldset>";
echo generatePage($title,$body);
?>
