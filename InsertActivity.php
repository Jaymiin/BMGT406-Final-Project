<?php
include_once('support.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
include_once('connectDB.php');
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "Create a New Activity";
$body = "<fieldset><legend> $title </legend>";

// Initialize variables with values for the name of the table ($name_of_table)
$name_of_table = 'activities';
// and the 6 fields - firstname, lastname, address, email, password and plan.
$actName = $_GET['actName'];
$actDate = $_GET['actDate'];
$actTime = $_GET['actTime'];
$actDescription = $_GET['actDescription'];

$sqlQuery = "INSERT INTO " . $name_of_table . "(actName, actDate,actTime,actDescription)
				VALUES (:actName, :actDate, :actTime, :actDescription)"; 

// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {

	// Prepare a SQL query and bind all 6 variables. 
	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':actName', $actName, PDO::PARAM_STR); 
	$statement1->bindValue(':actDate', $actDate, PDO::PARAM_STR);
	$statement1->bindValue(':actTime', $actTime, PDO::PARAM_INT);
	$statement1->bindValue(':actDescription', $actDescription, PDO::PARAM_INT);
	
	// Execute the SQL query using $statement1->execute(); and assign the value
	$result = $statement1->execute();
	// that is returned  to $result.

	if(!$result) {
		// Query fails.
		$body .= "Inserting entry into table " . $name_of_table . " failed.<br/>";
	} else {
		// Query is successful.
		$body .= "<h3>Your activity has been successfully uploaded!</h3>";
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
