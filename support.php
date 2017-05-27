<?php
function tableExists($pdo, $table) {

    // Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}

function generatePage($title, $body) {
$page = <<<EOPAGE
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>$title</title>
		<link type="text/css" href='layout.css' rel="stylesheet" type="text/css">
	</head>
	<body>
	<header>
    <div id="logo">
      <a href="./" title="Home" rel="home"><img src="iconRun.png" alt="Logo" /></a>
    </div>
    <div id="site-name">
      Fitness Friends
    </div>
    <div id="site-slogan">
      Get together with your friends!
    </div>
	<nav id="navbar">
      <ul>
        <li><a href="./" title="Home" rel="home">Home</a></li>
      </ul>
	  </nav>
	  </header>
	   <article>
	   		<div class="article-border">
				$body
			</div>
		</article>
</body>	
</html>
EOPAGE;

return $page;
}
?>
