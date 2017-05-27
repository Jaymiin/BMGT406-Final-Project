<?php
include_once('support.php');
include_once('connectDB.php');
//connect_database.php contains your connection/creation of a PDO to connect to your MYSQL db on bmgt406.rhsmith.umd.edu/phpmyadmin
ini_set("display_errors","1");
error_reporting(E_ALL);

// Initialize $title and $body.
$title = "Friend's Activities";
$body = "<fieldset><legend> $title </legend>";
$name_of_table = 'actSignUps';
$friendEmail = $_GET['friendEmail'];


// Check if the table exists in the db.
if (tableExists($db, $name_of_table)) {
	// Prepare a SQL query
	$sqlQuery = "SELECT a.actName, a.actDate, a.actTime, a.actDescription
	FROM activities a, actSignUps s
	WHERE 
	a.AID = s.AID
	AND s.email = :friendEmail;";
	
	$statement1 = $db->prepare($sqlQuery);
	$statement1->bindValue(':friendEmail', $friendEmail, PDO::PARAM_STR);
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
				
					$actName = $multipleRows['actName'];
					$actDate = $multipleRows['actDate'];		
					$actTime = $multipleRows['actTime'];
					$actDescription = $multipleRows['actDescription'];
					$body .= "<tr>";
					$body .= "<td>$actName</td>";
					$body .= "<td>$actDate</td>";
					$body .= "<td>$actTime</td>";
					$body .= "<td>$actDescription</td>";
					$body .= "</tr>";
					}
			$body .="</table>";
		} else {
			$body .= " This person hasn't signed up for any activities.";
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
//$body .= "<a href=\"http://bmgt406.rhsmith.umd.edu/~bmgt406_02/406FinalProject_V.4%20/LoginPage.php?email=mf%40gmail.com&password=02&Login=Login\"><input type=\"submit\" value = \"Main Menu\"/></a>";
$body.= "</fieldset>";

echo generatePage($title,$body);

?>
