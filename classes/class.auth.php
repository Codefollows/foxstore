<?php
class Auth {

	public function verifyUser() {
		if (isset($_COOKIE['store_user'])) {
			return cleanString($_COOKIE['store_user']);
		}
		return null;
	}

	public function userLogin($csrf) {
		$csrf->verifyRequest();
		clearCookies();
		setcookie("store_user", cleanString($_POST['username']));
		header("Location: index.php");
		exit;
	}

	public function verifyAdmin() {
		if (empty($_COOKIE['admin_user']) || empty($_COOKIE['userkey'])) {
			clearCookies();
			header("location: login.php");
			exit;
		}
		if ($_COOKIE['admin_user'] != admin_user || !password_verify(admin_pass, $_COOKIE['userkey'])) {
			clearCookies();
			header("location: login.php");
			exit;
		}
	}
	
	public function adminLogin($csrf) {
		$csrf->verifyRequest();

		$username = $_POST['username'];
		$password = $_POST['password'];

		if ($username != admin_user || $password != admin_pass) {
			return "Invalid username or password.";
		} else {
			setcookie("admin_user", admin_user);
			setcookie("userkey", password_hash(admin_pass, PASSWORD_BCRYPT));
			header("location: index.php");
			exit;
		}
	}

	public function logout($admin) {
		clearCookies();
		header("location: ".($admin ? "login.php" : "index.php"));
		exit;
	}

}
?>
