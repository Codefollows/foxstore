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
								<a href="add.php?type=product" class="btn btn-success btn-xs">Add Product</a>
							</div>
							<h4 style="margin-top: 0;">Products</h4>
							<hr>
						</div>
					</div>

					<div class="panel panel-default">
						<table class="table">
						<tr>
							<td>Id</td>
							<td class="hidden-xs">Image</td>
							<td>Name</td>
							<td class="hidden-xs">Category</td>
							<td class="hidden-xs">Price</td>
							<td class="hidden-xs">Discount</td>
						</tr>
						<?php
							$products = $db->getAllProducts();
							foreach ($products as $product) {
								$category = $db->getCategory($product['category']);
								echo '
								<tr style="vertical-align:middle;">
									<td>'.$product['item_id'].'</td>
									<td class="hidden-xs"><img src="'.$product['image_url'].'" width=20></td>
									<td>'.$product['item_name'].'</td>
									<td class="hidden-xs">'.$category['cat_title'].'</td>
									<td class="hidden-xs">$'.number_format($product['item_price'], 2).'</td>
									<td class="hidden-xs">$'.number_format($product['item_discount'], 2).'</td>
									<td class="text-right">
										<a href="edit.php?id='.$product['item_id'].'&type=product" class="btn btn-xs btn-success" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw"></i></a>
										<a href="delete.php?id='.$product['item_id'].'&type=product" class="btn btn-xs btn-success" data-toggle="tooltip" title="Delete"><i class="fa fa-times fa-fw"></i></a>
									</td>
								</tr>';
							}
						?>
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
