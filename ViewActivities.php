<?php
include_once('support.php');
include_once('connectDB.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "View Available Activities";
$body = "<fieldset><legend> $title </legend>";
$name_of_table = 'activities';
// Initialize variables with values for the name of the table ($name_of_table)

// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) { 
	// Prepare a SQL query
	$sqlQuery = "SELECT * FROM " . $name_of_table;
	$statement1 = $db->prepare($sqlQuery);
	$result = $statement1->execute();
	// Execute the SQL query using $statement1->execute(); and assign the value
	// that is returned  to $result.

	if (!$result) {
		// Query fails.
		$body .= "Listing records failed.";
	} else {
		// Query is successful.
		// Convert sqlQuery result to an array and store it in $numberOfRows using $statement1->fetchAll(PDO::FETCH_ASSOC);
		$numberOfRows = $statement1->fetchAll(PDO::FETCH_ASSOC);
		if($numberOfRows) {
			// Using a foreach loop to iterate through each row of result that is returned.
			$body .="<table style= \"border-collapse:collapse;\">";
			$body .= "<tr><th>Activity ID</th>";
			$body .= "<th>Activity Name</th><th>Date</th><th>Time</th><th>Description</th></tr>";
			foreach ($numberOfRows as $multipleRows)
					{
					$actID = $multipleRows['AID'];
					$actName = $multipleRows['actName'];
					$actDate = $multipleRows['actDate'];
					$actTime = $multipleRows['actTime'];
					$actDescription = $multipleRows['actDescription'];
	
					// Display the user information (firstname, lastname, address, email, plan)
					$body .= "<tr><td>$actID</td>";
					$body .= "<td>$actName</td><td>$actDate</td><td>$actTime</td><td>$actDescription</td>";
					$body .= "<form  class=\"addF\" action=\"InsertActSignUp.php\" methods=\"GET\">";
					$body .= "<td>
					<input type=\"text\" name=\"AID\" value=". $actID . " style=\"display: none\" readonly>
					<input type=\"text\" name=\"userEmail\">
					<input class=\"button\" type=\"submit\" name=\"insertSignUp\" value=\"Sign Up\"/></td>";
					$body .= "</form>";
					$body .= "</tr>";
					}	
			$body .="</table>";
					
		} else {
			// Invalid email address is provided and nothing is returned from the SQL query
			$body .= "Table is empty.";
		}
	}

	// Closing query connection
	$statement1->closeCursor();
} else {
	// Table does not exist in db.
	$body .= "Table does not exist in the database.";
}

//$body .= "<a href=\"http://bmgt406.rhsmith.umd.edu/~bmgt406_02/406FinalProject_V.4%20/LoginPage.php?email=mf%40gmail.com&password=02&Login=Login\"><input type=\"submit\" value = \"Main Menu\"/></a>";
$body.= "</fieldset>";

echo generatePage($title,$body);

?>
