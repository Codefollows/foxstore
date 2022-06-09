<?php
	require '../autoload.php';

	$auth->verifyAdmin();
	$error = array();

	if (empty($_GET['id']) || empty($_GET['type'])) {
		header("Location: products.php");
		exit;
	}

	$type = cleanString($_GET['type']);

	if ($type != "product" && $type != "category") {
		header("Location: index.php");
		exit;
	}

	$id = cleanInt($_GET['id']);
	$data = null;

	$info = $type == "product" ? $db->getProduct($id) : $db->getCategory($id);

	if ($info == null) {
		array_push($error, "Could not find that $type");
	}

	if (!empty($_POST)) {
		$csrf->verifyRequest();

		if ($type == "product") {
			$data = array(
				"item_name"		=> cleanString($_POST['item_name']),
				"category"		=> cleanInt($_POST['category']),
				"item_price"	=> cleanInt($_POST['item_price']),
				"item_discount"	=> cleanInt($_POST['item_discount']),
				"image_url"		=> filter_var($_POST['image_url'], FILTER_SANITIZE_URL)
			);

			$cat = $db->getCategory($data['category']);

			foreach ($data as $key => $value) {
				if ($key == "item_name" && (strlen($value) < 3 || strlen($value) > 50)) {
					array_push($error, "Item name must be between 3 and 50 characters.");
				}
				if ($key == "category" && $cat == null) {
					array_push($error, "Invalid category.");
				}
				if ($key == "item_price" && ($value < 0 || !is_numeric($value))) {
					array_push($error, "Item price must be a valid positive integer.");
				}
				if ($key == "item_discount" && ($value < 0 || !is_numeric($value))) {
					array_push($error, "Item discount must be a valid positive integer.");
				}
				if ($key == "image_url" && !filter_var($value, FILTER_VALIDATE_URL)) {
					array_push($error, "Invalid image url.");
				}
			}
		} else if ($type == "category") {
			$data = cleanstring($_POST['cat_title']);

			if (strlen($data) < 3 || strlen($data) > 20) {
				array_push($error, "Item name must be between 3 and 50 characters.");
			}
		}

		if (count($error) == 0) {
			if ($type == "product") {
				$db->update("products", $id, $data);
			} else if ($type == "category") {
				$db->updateCategory($id, $data);
			}
			header("location: ".($type == "product" ? "products" : "categories").".php");
			exit;
		}
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
							<h4 style="margin-top: 0;">Edit <?php echo ucwords($type); ?></h4>
							<hr>
						</div>
					</div>

					<div class="panel panel-default">
						<?php
							if (count($error) > 0):
								echo '<div class="alert alert-danger">The following products were detected:';
								echo '<ul>';
								foreach($error as $err) {
									echo '<li>'.$err.'</li>';
								}
								echo '</ul></div>';
							else:
						?>
						<?php if ($type == "product"): ?>
						<div class="panel-body">
							<form action="edit.php?id=<?php echo $id; ?>&amp;type=product" method="post">
								<input type="hidden" class="form-control disabled" name="item_id" value="<?php echo $info['item_id']; ?>" >
								<div class="form-group">
									<label>Item Name</label>
									<input type="text" class="form-control" name="item_name" value="<?php echo $info['item_name']; ?>">
								</div>
								<div class="form-group">
									<label>Category</label>
									<select class="form-control" name="category">
										<?php
											$ccat  = $db->getCategory($info['category']);

											if ($ccat == null) {
												echo '<option value="0">Invalid category</option>';
											} else {
												echo '<option value="'.$ccat['cid'].'">'.$ccat['cat_title'].'</option>';
											}

											$categories = $db->getCategories();

											if ($categories == null) {
												echo '<option value="0">No Categories Available</option>';
											} else {
												foreach ($categories as $cat) {
													if ($ccat['cid'] == $cat['cid'])
														continue;
													echo '<option value="'.$cat['cid'].'">'.$cat['cat_title'].'</option>';
												}
											}
										?>
							        </select>
								</div>
								<div class="form-group">
									<label>Price</label>
									<input type="number" class="form-control" name="item_price" step="0.01" min="0" value="<?php echo $info['item_price']; ?>">
								</div>
								<div class="form-group">
									<label>Discount</label>
									<input type="number" class="form-control" name="item_discount" step="0.01" min="0" value="<?php echo $info['item_discount']; ?>">
								</div>
								<div class="form-group">
									<label>Image URL</label>
									<input type="text" class="form-control" name="image_url" value="<?php echo $info['image_url']; ?>">
								</div>
								<?php $csrf->echoInputField(); ?>
								<div class="form-group">
									<button type="submit" class="btn btn-success" name="button" value="editprod"><i class="fa fa-save"></i> Save Changes</button>
								</div>
							</form>
						</div>
						<?php elseif ($type == "category"): ?>
						<div class="panel-body">
							<form action="edit.php?id=<?php echo $id; ?>&amp;type=category" method="post">
								<div class="form-group">
									<label>Category Title</label>
									<input type="text" class="form-control" name="cat_title" value="<?php echo $info['cat_title']; ?>">
								</div>
								<?php $csrf->echoInputField(); ?>
								<div class="form-group">
									<button type="submit" class="btn btn-success" name="button" value="editprod"><i class="fa fa-save"></i> Save Changes</button>
								</div>
							</form>
						</div>
						<?php endif; ?>
					<?php endif; ?>
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
<?php include '../templates/global/scripts.php'; ?>
</html>
