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

	$sql = "INSERT INTO donate (name, email, tlpn, val, conv, platform_id) VALUES ('$name','$email','$phone','$val','$conv', 1)";

	if(!mysql_query($sql)) {
		die('Error: ' . mysql_error());
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Donasi</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="fonts/icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet" media="screen">
	<link href="css/owl.theme.css" rel="stylesheet">
	<link href="css/owl.carousel.css" rel="stylesheet">

	<!-- Colors -->
	<link href="css/css-index-orange.css" rel="stylesheet" media="screen">
	<!-- <link href="css/css-index-green.css" rel="stylesheet" media="screen"> -->
	<!-- <link href="css/css-index-purple.css" rel="stylesheet" media="screen"> -->
	<!-- <link href="css/css-index-red.css" rel="stylesheet" media="screen"> -->
	<!-- <link href="css/css-index-orange.css" rel="stylesheet" media="screen"> -->
	<!-- <link href="css/css-index-yellow.css" rel="stylesheet" media="screen"> -->

	<!-- Google Fonts -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" />
</head>
<body>
	<div class= "container">
		<div class="col-md-10 col-md-offset-1 col-sm-12 feature-title"><h2><?php echo $text ?></h2></div>
	</div>
</body>
</html>