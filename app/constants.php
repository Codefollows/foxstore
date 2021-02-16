<?php
/**
 * Your mission, should you choose to accept it, is to configure
 * this without breaking on the first try. This message will
 * self destruct after 10 seconds. (not rly)
 */

/**
 * Shows up in a few places, like the footer, 
 * and in the card above the products.
 */
define('site_title', 'Foxtrot Studios');

/**
 * The path of this script. Likely /store/
 */
define('web_root', '/foxtrot-studios/store/');

/**
 * Database details.
 */
define('MYSQL_HOST', 'localhost');
define('MYSQL_DATABASE', 'foxtrot_store');
define('MYSQL_USERNAME', 'root');
define('MYSQL_PASSWORD', 'root');

/**
 * Shows or hides the button to the admin panel in the top-right.
 * if you're paranoid, set it to false.
 */
define("show_admin_link", true);

/**
 * Admin login username and password.
 * Pretty imperative that you do NOT share this with anyone or ninjas will attack you.
 * DO NOT LEAVE THIS DEFAULT!!!!!!!!!
 */
define("admin_username", "admin");
define("admin_password", "admin");

/**
 * Paypal Options. Setting DEBUG to 0 will disable the log file. good
 * to enable if you think you're not receiving callback from paypal.
 */
define("DEBUG", 1);
define("LOG_FILE", "paypal.log");

/**
 * Enables or disables the use of sandbox. Should be 0 for live use.
 */
define("USE_SANDBOX", 1);

/**
 * Edit business, return, cancel_return, and notify_url
 */
const pp_config = array(
    'business' 			=> "rune.evo2012@gmail.com",
    'no_note' 			=> 1,
    'cmd'				=> "_cart",
    'upload'			=> 1,
    'address_override' 	=> 1,
    'return' 			=> "http://your-website.com/store",
    'cancel_return' 	=> "http://your-website.com/store",
    'notify_url' 		=> "http://your-website.com/store/ipn",
    'cpp_header_image' 	=> "http://your-website.com/logo.png"
);
