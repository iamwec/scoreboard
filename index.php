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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Smash Camp! Standings</title>
	<meta charset="utf-8">
	<meta name="author" content="William Carson">
	<meta name="creation-date" content="5 July 2015">

	<style>
		body {
			background-color:#3c657e;;
		}
		table {
			border-collapse:collapse;
		}
		thead th {
			padding:10px;
			text-align:center;
			background-color:#272749;
			color:#fff;
			font-size:15px;
			font-family: "Helvetica", "Arial", "Bitstream Vera Sans", "Verdana", sans-serif;
		}
		tbody td {
			padding:10px;
			background-color:#474F79;
			color:#fff;
			font-size:17px;
			font-family: "Helvetica", "Arial", "Bitstream Vera Sans", "Verdana", sans-serif;
		}
	</style>
</head>

<body>
	<table>
		<thead>
			<tr>
				<th>Cabin</th>
				<th>Score</th>
			</tr>
		</thead>

		<tbdody>
<?php
foreach ($Scores as $currScore) { ?>
			<tr>
				<td style="font-weight:bold; color:#<?php echo $currScore['color']; ?>;"><?php echo $currScore['name']; ?></td>
				<td><?php echo $currScore['score']; ?></td>
			</tr>
<?php } ?>
		</tbdody>
	</table>
</body>
</html>
