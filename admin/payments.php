<?php
	require '../autoload.php';

	$auth->verifyAdmin();
	$error = null;

	$page = isset($_GET['page']) ? cleanInt($_GET['page']) : 1;
	$start = $page == 1 ? 0 : $page * 50;

	$username = null;
	if (isset($_GET['username'])) {
		$username = cleanString($_GET['username']);
	}


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
					<div class="row">
						<div class="col-md-12">
							<div class="pull-right">
								<a href="index.php" class="btn btn-primary btn-xs">Go Back</a>
							</div>
							<h4 style="margin-top: 0;">Payments</h4>
							<hr>
						</div>
					</div>

					<?php if ($page <= 1 && $username == null): ?>
						<img src="graph.php?type=bars" class="img-responsive" style="margin-bottom: 10px;">
					<?php endif;?>

					<div class="panel panel-default">
						<div class="panel-heading">
							<form action="payments.php" method="get" style="margin-bottom: 5px;width:200px;float:right;margin-top:-3px;">
								<div class="input-group">
									<input class="form-control input-sm" type="text" name="username" placeholder="Search by Username">
									<span class="input-group-btn">
										<button class="btn btn-success btn-xs" type="submit">Search</button>
									</span>
								</div>
							</form>
							<?php
								if ($username != null) {
									echo 'All payments for <strong>'.$username.'</strong>';
								} else {
									echo 'Payment History. Page '.cleanInt($page).'';
								}
							?>
						</div>
						<table class="table">
						<tr>
							<td>Username</td>
							<td>Item Name</td>
							<td>Status</td>
							<td>Paid</td>
							<td>Quantity</td>
							<td>Currency</td>
							<td class="text-right">Date</td>
						</tr>
						<?php
							if ($username != null) {
								$payments = $db->getPayments($username);
							} else {
								$payments = $db->getPayments2($start);
							}

							foreach ($payments as $pay) {

								$date = date("M j, Y - g:i A", strtotime($pay['dateline']));
								echo '
								<tr>
									<td>'.$pay['player_name'].'</td>
									<td>'.$pay['item_name'].'</td>
									<td>'.$pay['status'].'</td>
									<td>$'.number_format($pay['amount'], 2).'</td>
									<td>'.$pay['quantity'].'</td>
									<td>'.$pay['currency'].'</td>
									<td class="text-right">'.$date.'</td>
								</tr>';
							}
						?>
						</table>
					</div>



					<div class="buttons pull-right">
						<a class="btn btn-success btn-xs" href="?action=payments&amp;page=<?php echo $page == 1 ? 1 : ($page - 1); ?>">Prev Page</a>
						<a class="btn btn-success btn-xs" href="?action=payments&amp;page=<?php echo ($page + 1); ?>">Next Page</a>
					</div>
		        </div>
			</div>
		</div>
    </div>

	<?php include '../templates/global/footer.php'; ?>
</body>
<?php include '../templates/global/scripts.php'; ?>
</html>
