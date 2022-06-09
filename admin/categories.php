<?php
	require '../autoload.php';

	$auth->verifyAdmin();
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
								<a href="add.php?type=category" class="btn btn-success btn-xs">Add Category</a>
							</div>
							<h4 style="margin-top: 0;">Categories</h4>
							<hr>
						</div>
					</div>

					<div class="panel panel-default">

						<table class="table">
							<tr>
								<td class="text-center" style="width: 50px;">Id</td>
								<td>Title</td>
								<td></td>
							</tr>
							<tr>
								<?php
									$categories = $db->getCategories();
									foreach($categories as $cat) {
										echo '<tr>';
										echo '<td class="text-center">'.$cat['cid'].'</td>';
										echo '<td>'.$cat['cat_title'].'</td>';
										echo '<td class="text-right">
										<a class="btn btn-success btn-xs" href="edit.php?id='.$cat['cid'].'&type=category">Edit</a>
										<a class="btn btn-success btn-xs" href="delete.php?id='.$cat['cid'].'&type=category">Delete</a>
										</td>';
										echo '</tr>';
									}
								 ?>
							</tr>
						</table>
					</div>
		        </div>
			</div>
		</div>
    </div>

	<?php include '../templates/global/footer.php'; ?>
</body>
<?php include '../templates/global/scripts.php'; ?>
</html>
