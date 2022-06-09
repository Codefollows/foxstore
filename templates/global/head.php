<?php
	if (count(get_included_files()) <= 1) {
		exit;
	}
?>
<head>
	<meta charset="utf-8">
	<title><?php echo site_title; ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="stylesheet" href="<?php echo $base; ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $base; ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $base; ?>assets/css/stylesheet.css">
	<link rel="stylesheet" href="<?php echo $base; ?>assets/css/sweetalert.css">
    <link rel="shortcut icon" href="http://lunite.io/home/images/icon_small.png">
    <link rel="icon" type="image/png" href="http://lunite.io/home/images/icon_small.png">
    <link href="https://fonts.googleapis.com/css?family=Anton%7cMuli:300,400,400italic,300italic%7cOswald" rel="stylesheet" type="text/css">
</head>

