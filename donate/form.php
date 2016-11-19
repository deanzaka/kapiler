<?php

define ('DB_NAME', 'kapiler_production');
define ('DB_USER', 'kapiler_donasi');
define ('DB_PASSWORD', 'password');
define ('DB_HOST', 'localhost');

date_default_timezone_set("Asia/Bangkok");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if (!$link) {
	die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db(DB_NAME, $link);

if (!$db_selected) {
	die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
}

// echo 'db_connected';

if( isset($_POST['NAME']) )
{
  $name = $_POST['NAME'];
	$email = $_POST['EMAIL'];
	$phone = $_POST['PHONE'];
	$val = preg_replace('~[^0-9]~', '',$_POST['VAL']);
	$conv = $val * 12500;
	$uniq = rand(100,999);
	$sum = $conv + $uniq;

	$val_msg = $_POST['VAL'];
	$conv_msg = preg_replace('~\B(?=(\d{3})+(?!\d))~', '.', $sum);

	$time = time();
	$date_msg = date('d M', strtotime('+1 days'));
	$time_msg = date('G:i', strtotime('+1 days'));

	$arr = explode(' ',trim($name));
	$name_msg = $arr[0];

	// echo $name . ' ' . $email . ' ' . $phone . ' ' . $val . ' ' . $conv . ' ' . $val_msg . ' ' . $conv_msg . ' ' . $time_msg;

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

		$sql = "INSERT INTO donasi_beras (name, email, phone, val, conv, create_time, platform_id, unique_code, payment_status) VALUES ('$name','$email','$phone','$val', '$conv', '$time', 1, '$uniq', 0)";

		if(!mysql_query($sql)) {
			die('Error: ' . mysql_error());
		}

		$select = "SELECT * FROM donasi_beras ORDER BY id DESC LIMIT 1";
		$result = mysql_query($select, $link);
		if(! $result ) {
			die('Error: ' . mysql_error());
		}

		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$prefix = $row['prefix'];
			$id = $row['id'];
		}

		$userkey='wgxrq6'; // userkey lihat di zenziva
		$passkey='admin'; // set passkey di zenziva
		$message='Hai, ' . $name_msg . '. Anda berdonasi beras ' . $val_msg . ' kg. Segera transfer Rp ' . $conv_msg . ' ke salah satu pilihan bank yg tersedia untuk donasi ' . $prefix . $id . ' sebelum ' . $date_msg . ', pukul ' . $time_msg . ' WIB';

		$url = 'http://reguler.zenziva.net/apps/smsapi.php';
		$curlHandle = curl_init();
		curl_setopt($curlHandle, CURLOPT_URL, $url);
		curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$phone.'&pesan='.urlencode($message));
		curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
		curl_setopt($curlHandle, CURLOPT_POST, 1);
		$results = curl_exec($curlHandle);
		curl_close($curlHandle);

		$data = true;
		$confirm = false;
	} 


} else if ( isset($_POST['UNIQ']) &&  ! isset($_POST['BANK'])) {
	$prefid = strtoupper($_POST['UNIQ']);
	$prefix = substr($prefid, 0, 4);
	$id = substr($prefid, 4);
	$name = null;

	$select = "SELECT * from donasi_beras where prefix='$prefix' and id='$id'";
	$result = mysql_query($select, $link);
	if(! $result ) {
		die('Error: ' . mysql_error());
	}

	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$name = $row['name'];
		$email = $row['email'];
		$phone = $row['phone'];
		$val = $row['val'];
		$conv = $row['conv'];
		$time = $row['create_time'];
		$code = $row['unique_code'];
		$bank = $row['bank'];
	}

	if ( $name != null ) {
		$sum = $conv + $code;
		$val_msg = preg_replace('~\B(?=(\d{3})+(?!\d))~', '.', $val);
		$conv_msg = preg_replace('~\B(?=(\d{3})+(?!\d))~', '.', $sum);
		$date_msg = date('d M', strtotime('+1 day', $time));
		$time_msg = date('G:i', $time);	
	}
	
	// echo $name . ' ' . $email . ' ' . $phone . ' ' . $val . ' ' . $conv . ' ' . $val_msg . ' ' . $conv_msg . ' ' . $bank;	

	if ( $name != null) {
		$data = true;
		$confirm = false;	
	} else {
		$data = false;
		$confirm = false;
		$na = true;
	}
	

} else if (isset($_POST['BANK'])) {
	$bank = $_POST['BANK'];
	$prefid = strtoupper($_POST['UNIQ']);
	$prefix = substr($prefid, 0, 4);
	$id = substr($prefid, 4);

	$select = "SELECT * from donasi_beras where prefix='$prefix' and id='$id'";
	$result = mysql_query($select, $link);
	if(! $result ) {
		die('Error: ' . mysql_error());
	}

	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$name = $row['name'];
		$email = $row['email'];
		// $phone = $row['phone'];
		$phone = '087880762046';
		$val = $row['val'];
		$conv = $row['conv'];
		$code = $row['unique_code'];
	}

	$sum = $conv + $code;
	$val_msg = preg_replace('~\B(?=(\d{3})+(?!\d))~', '.', $val);
	$conv_msg = preg_replace('~\B(?=(\d{3})+(?!\d))~', '.', $sum);

	// echo $name . ' ' . $email . ' ' . $phone . ' ' . $val . ' ' . $conv . ' ' . $val_msg . ' ' . $conv_msg . ' ' . $bank;

	$sql = "UPDATE donasi_beras SET bank='$bank', payment_status=1 where prefix='$prefix' and id='$id'";
		
	if(!mysql_query($sql)) {
		die('Error: ' . mysql_error());
	}

	$userkey='wgxrq6'; // userkey lihat di zenziva
	$passkey='admin'; // set passkey di zenziva
	$message=$name . ' dengan id: ' . $prefix . $id . ' telah melakukan transfer sebesar: Rp ' . $conv_msg . ' ke ' . $bank;

	$url = 'http://reguler.zenziva.net/apps/smsapi.php';
	$curlHandle = curl_init();
	curl_setopt($curlHandle, CURLOPT_URL, $url);
	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$phone.'&pesan='.urlencode($message));
	curl_setopt($curlHandle, CURLOPT_HEADER, 0);
	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
	curl_setopt($curlHandle, CURLOPT_POST, 1);
	$results = curl_exec($curlHandle);
	curl_close($curlHandle);

	$data = false;
	$confirm = true;

} else {
	$data = false;
	$confirm = false;
	$na = false;
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
		<?php if($data && !$confirm) : ?>
			<h3 class="form-title text-center">Silahkan melakukan konfirmasi bila anda telah melakukan transfer:</h3>
			<!-- <form class="form-header" action="http://moxdesign.us10.list-manage.com/subscribe/post" role="form" method="POST" id="#"> -->
			<form class="form-header" action="form.php" role="form" method="POST" id="confirm-form">
			<input type="hidden" name="u" value="503bdae81fde8612ff4944435">
			<input type="hidden" name="id" value="bfdba52708">
				<div class="form-group">
					<div class="col-sm-3">
						<h2>NAMA:</h2>
					</div>
					<div class="col-sm-9">
						<h2 class="konversi" type="text" name="NAME" id="name"><?php echo $name ?></h2>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-3">
						<h2>ID TRANSAKSI:</h2>
					</div>
					<div class="col-sm-9">
						<h2 class="konversi" type="text" name="UNIQ" id="uniq"><?php echo $prefix . $id ?></h2>
						<input class="uniq" type="hidden" name="UNIQ" id="uniq" value="<?php echo $prefix . $id ?>"></input>
					</div>
				</div>
				<div class="form-group"">
					<div class="col-sm-3"></div>
					<div class="col-sm-9">
						<p style="color: red; font-weight: bold;">Harap simpan ID Transaksi anda untuk melakukan konfirmasi</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-3">
						<h2>DONASI:</h2>
					</div>
					<div class="col-sm-9">
						<h2 class="konversi" type="text" name="CONV" id="converse"><?php echo 'Rp ' . $conv_msg ?></h2>
					</div>
				</div>
				<div class="form-group"">
					<div class="col-sm-3"></div>
					<div class="col-sm-9">
						<p style="color: red; font-weight: bold;">Harap melakukan transfer sesuai jumlah yang tertera di atas (sudah ditambah dengan tiga angka kode unik). Jika sudah Transfer, silahkan kirim bukti pembayaran via WA ke +6285785761947</p>
					</div>
				</div>
				<div class="form-group"">
					<div class="col-sm-3">
						<h2>BANK TUJUAN:</h2>
					</div>
					<div class="col-sm-9">
						<input type="radio" name="BANK" value="BNI" required>
							BNI Syariah<br/>
  						No. Rek : 0333006662<br/>
  						A./N : YYS DD REPUBLIKA - IK<br/>
					</div>
				</div>
				<div class="form-group"">
					<div class="col-sm-3"></div>
					<div class="col-sm-9">
						<input type="radio" name="BANK" value="Mandiri" required>
							Bank Mandiri<br/>
							No. Rek : 101.000.5968.266<br/>
							A./N : Yayasan DOMPET DHUAFA REPUBLIKA<br/>
					</div>
				</div>
				<div class="form-group last">
					<div class="col-sm-12">		
						<input type="submit" class="btn btn-warning btn-block btn-lg" value="Saya Sudah Transfer">
					</div>
				</div>
				<br>
				<br>
				<p></p>
			</form>
		
		<?php elseif (!$data && !$confirm) : ?>
			<h3 class="form-title text-center">Silahkan masukan Kode Transaksi Anda: </h3>
			<!-- <form class="form-header" action="http://moxdesign.us10.list-manage.com/subscribe/post" role="form" method="POST" id="#"> -->
			<form class="form-header" action="form.php" role="idform" method="POST" id="submit-form">
				<input type="hidden" name="u" value="503bdae81fde8612ff4944435">
				<input type="hidden" name="id" value="bfdba52708">
				<div class="form-group">
					<div class="col-sm-6" style="font-color: red;">
						<input class="uniq" type="text" name="UNIQ" id="uniq"></input>
					</div>
					<div class="col-sm-6">		
						<input type="submit" class="btn btn-warning btn-block btn-lg" value="Submit">
					</div>
				</div>
				<?php if ($na) : ?>
				<div class="form-group"">
					<div class="col-sm-3"></div>
					<div class="col-sm-9">
						<p style="color: red; font-weight: bold;">Error: Kode Transaksi Salah. Silahkan masukan kode transaksi dengan benar.</p>
					</div>
				</div>
				<?php endif; ?>
				<br>
				<br>
				<p></p>
			</form>
		
		<?php else : ?>
			<h3 class="form-title text-center">Konfirmasi transfer anda telah kami terima. Selanjutnya, mohon tunggu kami mengkonfirmasi transfer anda. Terima kasih!</h3>
		<?php endif; ?>
	</div>

	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.sticky.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/events.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script>
		new WOW().init();
	</script>
</body>
</html>
