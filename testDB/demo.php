<?php

define ('DB_NAME', 'testDB');
define ('DB_USER', 'root');
define ('DB_PASSWORD', 'password');
define ('DB_HOST', 'localhost');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if (!$link) {
	die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db(DB_NAME, $link);

if (!$db_selected) {
	die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
}

$value = $_POST['input1'];

$sql = "INSERT INTO form (input1) VALUES ('$value')";

if(!mysql_query($sql)) {
	die('Error: ' . mysql_error());
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Test DB</title>
	<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<link rel="stylesheet" href="styles/main.css">
</head>
<body>
	<div class= "container">
		<div class="jumbotron">Thanks for submitting data. You'll be contacted by us soon.</div>
	</div>
</body>
</html>