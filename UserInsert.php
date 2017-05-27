<?php
include_once('support.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
include_once('connectDB.php');
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "Create a User Account";
$body = "<fieldset><legend> $title </legend>";

// Initialize variables with values for the name of the table ($name_of_table)
$name_of_table = "users";
// and the 6 fields - firstname, lastname, address, email, password and plan.
$email = $_GET['email'];
$firstname = $_GET['firstname'];
$lastname = $_GET['lastname'];
$password = $_GET['password'];  


$sqlQuery = "INSERT INTO $name_of_table 
				VALUES (:email, :firstname, :lastname, :password)"; 

// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {

	// Prepare a SQL query and bind all 6 variables. 
	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':email', $email, PDO::PARAM_STR);
	$statement1->bindValue(':firstname', $firstname, PDO::PARAM_STR); 
	$statement1->bindValue(':lastname', $lastname, PDO::PARAM_STR);
	$statement1->bindValue(':password', $password, PDO::PARAM_STR);
	
	// Execute the SQL query using $statement1->execute(); and assign the value
	$result = $statement1->execute();
	// that is returned  to $result.

	if(!$result) {
		// Query fails.
		$body .= "Inserting entry into table $name_of_table failed.<br/>";
	} else {
		// Query is successful.
		$body .= "<h3>Your user account has been successfully created!";
	}
	// Closing query connection
	$statement1->closeCursor();	
} else {
// Table does not exist in db.
	$body .= "Table $name_of_table does not exist.<br/>";
}

//$body .= "<br/><a href=\"http://bmgt406.rhsmith.umd.edu/~bmgt406_02/406FinalProject_V.4%20/LoginPage.php?email=mf%40gmail.com&password=02&Login=Login\"/></a>";
$body .= "</fieldset>";
echo generatePage($title,$body);
?>
