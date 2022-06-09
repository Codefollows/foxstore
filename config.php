<?php
	if (count(get_included_files()) <= 1) {
		exit;
	}

	/**
	 * The name of your site/server. Displays in the page header as the logo,
	 * and in the tab as the page title.
	 */
	define("site_title", "Store - Lunite");

	/**
	 * Displays in the header, just under the logo
	 */
	define("sub_title", "Website Design & Development");

	/**
	 * At the very top right of the page. Leave blank to not show.
	 */
	define("contact_email", "Contact@Lunite.com");

	/**
	 * Disables the thin bar at the top. Kinda looks dumb without it..but it's
	 * here just incase :D
	 */
	define("disable_topbar", false);

	/**
	 * Admin login credentials.
	 * site.com/admin/
	 */
	define("admin_user", "admin23"); // admin user
	define("admin_pass", "admin12"); // admin pass


	/**
	 * Database information
	 */
	$config = array(
		"db_host" => "localhost",
		"db_user" => "pilfirgk_store",
		"db_pass" => "5advg?lts9qqn",
		"db_database" => "pilfirgk_store",

		"allowed_ip" => "" // optional, for added security. leave blank to not use
	);

	/**
	 * Paypal configuation. 'business' is your paypal email. Edit the links
	 * accordingly!
	 */
	$pp_config = array(
		'business' 			=> "lunitersps@gmail.com",
		'no_note' 			=> 1,
		'cmd'				=> "_cart",
		'upload'			=> 1,
		'address_override' 	=> 1,
		'return' 			=> "http://lunite.io/store/index.php",
		'cancel_return' 	=> "http://lunite.io/store/index.php",
		'notify_url' 		=> "http://lunite.io/store/pp_ipn.php",
		'cpp_header_image' 	=> "http://lunite.io/store/assets/img/logo.png"
	);

	/**
	 *Do not edit below this
	 */
	$pp_keys = array_keys($pp_config);
	$dir = count(explode("/", $_SERVER['PHP_SELF'])) > 3 ? "../" : "";

	/**
	 * Makes the first letter of every word uppercase and replaces underscores
	 * with spaces where necessary
	 */
	function formatName($string) {
		return cleanString(ucwords(str_replace("_", " ", $string)));
	}

	/**
	 * Purges non-alphanumeric characters from a string
	 */
	function cleanString($string) {
		return filter_var(trim(preg_replace("/[^A-Za-z0-9_ ]/", '', $string)), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
	}

	/**
	 * Purges non-numerical characters from a string
	 */
	function cleanInt($string) {
		return filter_var(trim(preg_replace("/[^0-9+]/", '', $string)), FILTER_SANITIZE_NUMBER_INT);
	}

	function clearCookies() {
		foreach($_COOKIE as $key => $value) {
			setcookie($key, '', time() - 1000);
		}
	}
?>
