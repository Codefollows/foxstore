<?php
	include 'config.php';
	include 'classes/class.database.php';
	include 'classes/CSRF_Protect.php';
	include 'classes/class.auth.php';

	$csrf 	= new CSRF_Protect();
	$db 	= new Database($config);
	$auth 	= new Auth();

	if (!$db->connect())
		exit;

	$home = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	$full = explode("/", $home.$_SERVER['REQUEST_URI']);

	$curDir = $full[count($full) - 2];

	$base = $curDir == "admin" ? "../" : "";
?>
