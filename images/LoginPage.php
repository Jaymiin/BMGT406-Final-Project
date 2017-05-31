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
					$body.="What would you like to do, $firstname?<br/><br/>"; 			
			   }
			}
		}
	// Closing query connection
	$statement1->closeCursor();	
} else {
// Table does not exist in db.
	$body .= "Table " . $name_of_table . " does not exist.<br/>";
}

$body.= "<form action=\"InsertActivity.php\" method=\"GET\">
		
			<strong>Activity Name</strong><input type=\"text\" name=\"actName\" /><br/><br/>
			<strong>Time</strong><input type=\"time\" name=\"actTime\" /><br/><br/>
			<strong>Date</strong><input type=\"date\" name=\"actDate\" /><br/><br/>
			<strong>Description</strong><input type=\"text\" name=\"actDescription\" /><br/><br/>
			<input  type=\"submit\" name=\"createAct\" value=\"Create Activity\" /><br /><br />
</form>

<form action=\"ViewActivities.php\" method=\"GET\">
			<input  type=\"submit\" name=\"createAct\" value=\"View Activities\" /><br /><br />
</form>";
$body .= "</fieldset>";
echo generatePage($title,$body);
?>























