<?php

define ('DB_NAME', 'kapiler');
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

//echo 'db_connected';

$name = $_POST['NAME'];
$email = $_POST['EMAIL'];
$phone = $_POST['PHONE'];
$val = $_POST['VAL'];
$conv = $val * 10000;


//echo $name . $email . $tlpn . $val . $conv;

$name_regex = '~^[a-zA-Z\s\.\']+$~';
$email_regex = '~^[_A-Za-z0-9-\+]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]+)*(\.[A-Za-z]{2,})$~';
$phone_regex = '~^0[0-9]{8,15}$~';

if(!preg_match($name_regex,$name)) {
	$text = 'Error: NAME is invalid';
} else if(!preg_match($email_regex,$email)) {
	$text = 'Error: EMAIL is invalid';
} else if(!preg_match($phone_regex,$phone)) {
	$text = 'Error: PHONE is invalid';
} else {
	$text = 'Thanks for submitting data. You\'ll be contacted by us soon.';

	$sql = "INSERT INTO donate (name, email, tlpn, val, conv) VALUES ('$name','$email','$phone','$val','$conv')";

	if(!mysql_query($sql)) {
		die('Error: ' . mysql_error());
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Donasi</title>
	<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<link rel="stylesheet" href="styles/main.css">
</head>
<body>
	<div class= "container">
		<div class="jumbotron"><?php echo $text ?></div>
	</div>
</body>
</html>