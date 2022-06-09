<?php
	require '../autoload.php';

	$auth->verifyAdmin();
	if (isset($_GET['action']) && $_GET['action'] == "logout") {
		$auth->logout(true);
	}

	$error = null;
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../templates/global/head.php'; ?>
<body>

    <?php include '../templates/global/page_header.php'; ?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-3 server-list">
					<?php include '../templates/admin/side_bar.php'; ?>
		        </div>

				<div class="col-md-9 server-list">
		        	<?php
		        		if ($error != null) {
		        			echo '<div class="alert alert-danger">'.$error.'</div>';
		        		}
		        	?>

					<div class="row">
						<div class="col-md-3">
							<a href="payments.php" class="btn btn-success btn-xl portal-btn">
								<i class="fa fa-bar-chart-o fa-4x"></i><br><br>
								Payments
							</a>
						</div>
						<div class="col-md-3">
							<a href="products.php" class="btn btn-success btn-xl portal-btn">
								<i class="fa fa-shopping-cart fa-4x"></i><br><br>
								Products
							</a>
						</div>
						<div class="col-md-3">
							<a href="categories.php" class="btn btn-success btn-xl portal-btn">
								<i class="fa fa-list fa-4x"></i><br><br>
								Categories
							</a>
						</div>
					</div>
		        </div>
			</div>
		</div>
    </div>

	<div class="copyright">
		<div class="container">
		    <div class="row">
		        <div class="col-md-12">
		            Copyright &copy; 2015 Foxtrot Studios | Created by King Fox.<br>
		            We are not affiliated with
		            <a target="_blank" class="color" href="http://www.jagex.com/">Jagex Ltd</a> or
		            <a target="_blank" class="color" href="http://www.runescape.com">Runescape</a>.
		            <a target="_blank" class="color" href="http://www.runescape.com">Runescape</a> is property of
		            <a target="_blank" class="color" href="http://www.jagex.com/">Jagex Ltd</a>.
		            We exist solely for educational purposes.
		        </div>
		    </div>
		</div>
	</div>

</body>
<script type="text/javascript" src="../assets/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript" src="../assets/js/jquery.cookie.js"></script>
<script type="text/javascript" src="../assets/js/custom.js"></script>
<script type="text/javascript" src="../assets/js/sweetalert.min.js"></script>
</html>
