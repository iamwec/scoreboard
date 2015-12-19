<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'databasename');
define('DB_USER', 'username');
define('DB_PASS', 'password');

$DBH = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

$QString = "SELECT * FROM scores ORDER BY score DESC";
$STH = $DBH->prepare($QString);
$STH->execute();
$Scores = $STH->fetchAll(PDO::FETCH_ASSOC);

$freezeID = 1;
$QString = "SELECT freeze FROM settings WHERE id = ?";
$STH = $DBH->prepare($QString);
$STH->execute(array($freezeID));
$Freeze = $STH->fetch(PDO::FETCH_ASSOC)['freeze'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Smash Camp! Standings</title>
	<meta charset="utf-8">
	<meta name="author" content="William Carson">
	<meta name="creation-date" content="5 July 2015">
</head>

<body>
	<form action="update_scores.php" method="post">
		<input type="hidden" name="former_freeze" value="<?php echo $Freeze; ?>">
		<table>
			<tr>
				<th>Cabin</th>
<?php if ($Freeze) { ?>
				<th>Hidden Score</th>
				<th>Scoreboard Score</th>
<?php } 
else { ?>
				<th>Score</th>
<?php } ?>
			</tr>
<?php
foreach ($Scores as $currScore) { ?>
			<tr>
				<input type="hidden" name="id[<?php echo $currScore['id']; ?>]" value="<?php echo $currScore['id']; ?>">
				<input type="hidden" name="color[<?php echo $currScore['id']; ?>]" value="<?php echo $currScore['color']; ?>">
				<td><input type="text" value="<?php echo $currScore['name']; ?>" name="name[<?php echo $currScore['id']; ?>]"></td>
				<td<?php if (!$Freeze) { echo " style='display:none;'"; } ?>><input type="<?php if($Freeze) { echo 'text'; } else { echo 'hidden'; } ?>" value="<?php echo $currScore['hidden_score']; ?>" name="hidden_score[<?php echo $currScore['id']; ?>]"></td>
				<td><input type="text" value="<?php echo $currScore['score']; ?>" name="score[<?php echo $currScore['id']; ?>]"></td>
			</tr>
<?php } ?>
		</table>
		<div><label for="freeze">Freeze Scoreboard</label>&nbsp;<input type="checkbox" name="freeze" value="1"<?php if ($Freeze) { echo " checked"; } ?> /></div>
		<input type="submit" value="Update">
	</form>
</body>
</html>
