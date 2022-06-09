<?php
	require '../autoload.php';

	$error = null;

	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		$error = $auth->adminLogin($csrf);
	}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../templates/global/head.php'; ?>
<body>

	<div class="panel panel-default admin-login">
		<div class="panel-body">
			<h4>Admin Login</h4>
			<hr>
			<?php
				if ($error != null):
					echo '<p class="text-danger">'.$error.'</p>';
				endif;
			?>
			<form action="login.php" method="post" id="login">
				<div class="form-group">
					<label>Username:</label>
					<input type="text" name="username" id="username" class="form-control" placeholder="">
				</div>
				<div class="form-group">
					<label>Password:</label>
					<input type="password" name="password" id="password" class="form-control" placeholder="">
				</div>
				<?php $csrf->echoInputField(); ?>
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-block">Sign In</button>
				</div>
			</form>
		</div>
	</div>

</body>
<?php include '../templates/global/scripts.php'; ?>
</html>
