<?php
include_once('support.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
include_once('connectDB.php');
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "Sign Up for an Activity";
$body = "<fieldset><legend> $title </legend>";

// Initialize variables with values for the name of the table ($name_of_table)
$name_of_table = 'actSignUps';
// and the 6 fields - firstname, lastname, address, email, password and plan.
$actID = $_GET['AID'];
$email = $_GET['userEmail'];


$sqlQuery = "INSERT INTO " . $name_of_table . "(AID, email)
				VALUES (:AID, :email)"; 

// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {

	// Prepare a SQL query and bind all 6 variables. 
	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':AID', $actID, PDO::PARAM_INT); 
	$statement1->bindValue(':email', $email, PDO::PARAM_STR);
	$result = $statement1->execute();

	if(!$result) {
		// Query fails.
		$body .= "You could not be sign up for this activity.<br/>";
	} else {
		// Query is successful.
		$body .= "<h3>You have successfully signed up for this activity!</h3>";
	}
	// Closing query connection
	$statement1->closeCursor();	
} else {
// Table does not exist in db.
	$body .= "Table " . $name_of_table . " does not exist.<br/>";
}

//$body .= "<br/><a href=\"http://bmgt406.rhsmith.umd.edu/~bmgt406_02/406FinalProject_V.4%20/LoginPage.php?email=mf%40gmail.com&password=02&Login=Login\"><input type=\"submit\" value = \"Main Menu\"/></a>";
$body .= "</fieldset>";
echo generatePage($title,$body);
?>
