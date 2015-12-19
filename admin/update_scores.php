<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'databasename');
define('DB_USER', 'username');
define('DB_PASS', 'password');

$DBH = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

$ids = $_POST['id'];
$names = $_POST['name'];
$scores = $_POST['score'];
$hidden_scores = $_POST['hidden_score'];
$colors = $_POST['color'];
$freeze = $_POST['freeze'];
$former_freeze = $_POST['former_freeze'];

$freezeID = 1;
$QString = "UPDATE settings SET freeze = ? WHERE id = ?";
$STH = $DBH->prepare($QString);
$STH->execute(array($freeze, $freezeID));

$QString = "UPDATE scores SET name = ?, score = ?, hidden_score = ?, color = ? WHERE id = ?";
$STH = $DBH->prepare($QString);

for ($i = 1 ; $i <= count($names); $i ++) {
	if ($freeze == 1 && $former_freeze == 0) { // Freezing
		$STH->execute(array($names[$i], $scores[$i], $scores[$i], $colors[$i], $ids[$i]));
	}
	else if ($freeze == 0 && $former_freeze == 1) { // Unfreezing
		$STH->execute(array($names[$i], $hidden_scores[$i], $hidden_scores[$i], $colors[$i], $ids[$i]));
	}
	else {
		$STH->execute(array($names[$i], $scores[$i], $hidden_scores[$i], $colors[$i], $ids[$i]));
	}
}

header("Location: ./");
?>
