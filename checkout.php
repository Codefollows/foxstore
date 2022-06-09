<?php
	require 'autoload.php';

	if ($auth->verifyUser() == null) {
		header("location:index.php");
		exit;
	}

	$csrf->verifyRequest();

	$get_keys = array_keys($_POST);
	$pp_keys = array_keys($pp_config);
	$invalid = false;

	// paypal info validation
	for ($i = 0; $i < count($pp_config); $i++) {
		if ($_POST[$get_keys[$i]] != $pp_config[$pp_keys[$i]]) {
			header("location: index.php");
			exit;
		}
	}

	$data = array('custom' => cleanString($_POST['custom']));

	for ($i = 0; $i < count($pp_config); $i++) {
		$data[$pp_keys[$i]] = $pp_config[$pp_keys[$i]];
	}

	for ($i = 1; $i < 11; $i++) {
		if (!isset($_POST['item_number_'.$i])) {
			continue;
		}

		$itemData = $db->getProduct(cleanInt($_POST['item_number_'.$i]));

		if ($itemData == null || !isValid($i, $itemData)) {
			echo('Invalid form data detected! Please go back and make a proper purchase!');
			exit;
		}

		$itemNumber 	= $_POST['item_number_'.$i];
		$itemName		= $_POST['item_name_'.$i];
		$itemQuantity	= $_POST['quantity_'.$i];
		$itemAmount		= $_POST['amount_'.$i];
		$itemDiscount	= $_POST['discount_amount_'.$i];

		$data['item_number_'.$i] = $itemNumber;
		$data['item_name_'.$i] = $itemName;
		$data['amount_'.$i] = $itemAmount - $itemDiscount;
		$data['quantity_'.$i] = $itemQuantity;
	}

	$location = "https://www.paypal.com/cgi-bin/webscr?".http_build_query($data, '', '&');
	header("refresh:1; url=$location");

	function isValid($i, $itemData) {
		$valid = true;

		$itemNumber 	= $_POST['item_number_'.$i];
		$itemName		= $_POST['item_name_'.$i];
		$itemQuantity	= $_POST['quantity_'.$i];
		$itemAmount		= $_POST['amount_'.$i];
		$itemDiscount	= $_POST['discount_amount_'.$i];

		if (!is_numeric($itemNumber) || $itemNumber != $itemData['item_id']) {
			$valid = false;
		}
		if (!is_string($itemName) || $itemName != $itemData['item_name']) {
			$valid = false;
		}
		if (!is_numeric($itemQuantity) || $itemQuantity < 0) {
			$valid = false;
		}
		if ($itemAmount != $itemData['item_price']) {
			$valid = false;
		}
		if ($itemDiscount != $itemData['item_discount']) {
			$valid = false;
		}
		return $valid;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Foxtrot-Studios</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/stylesheet.css">
	<link rel="stylesheet" href="assets/css/sweetalert.css">
	<link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Anton%7cMuli:300,400,400italic,300italic%7cOswald" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container text-center" style="width:750px;padding-top:50px;padding-bottom:50px;margin-top: 150px;">
		<h1><i class="fa fa-paypal"></i></h1>
		<p>Thank you, <?php echo cleanString($_COOKIE['store_user']); ?>
		<h1>Proceeding to Paypal</h1>
		<p>This will only take a moment..</p>
	</div>
</body>
<script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script type="text/javascript" src="assets/js/jquery.cookie.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="assets/js/sweetalert.min.js"></script>
</html>
