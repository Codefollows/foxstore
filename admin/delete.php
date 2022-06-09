<?php
	require '../autoload.php';

	$auth->verifyAdmin();
	$error = null;

	if ((empty($_GET['id']) && empty($_GET['confirm'])) || empty($_GET['type'])) {
		header("Location: products.php");
		exit;
	}

	$id = cleanInt(empty($_GET['confirm']) ? $_GET['id'] : $_GET['confirm']);
	$type = cleanString($_GET['type']);

	if ($type != "product" && $type != "category") {
		header("Location: index.php");
		exit;
	}

	$data = null;
	$info = $type == "product" ? $db->getProduct($id) : $db->getCategory($id);

	if ($info == null) {
		$error = array(
			"title" => "Invalid ".ucwords($type)."",
			"message" => "The ".ucwords($type)." you're trying to delete does not exist."
		);
	} else {
		if (isset($_GET['confirm'])) {
			$delete = $type == "product" ? $db->deleteProduct($id) : $db->deleteCategory($id);
			if (!$delete) {
				$error = array(
					"title" => "Invalid ".ucwords($type)."",
					"message" => "The ".ucwords($type)." you're trying to delete does not exist."
				);
			} else {
				header("Location: ".($type == "product" ? "products" : "categories").".php");
				exit;
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/global/head.php'; ?>
<body>

	<div class="panel panel-default confirm-box">
		<div class="panel-body text-center">
			<?php if ($error != null): ?>
				<h4>Error</h4>
				<hr>
				<h3><?php echo $error['title']; ?></h3>
				<h5><?php echo $error['message']; ?></h5>
				<a href="products.php" class="btn btn-success">Go Back</a>
		 	<?php else: ?>
				<h4>Confirm Action</h4>
				<hr>
				<h3><?php echo ($type == "product" ? $info['item_name'] : $info['cat_title']); ?></h3>
				<h5>Are you sure you wish to delete this <?php echo $type; ?>?</h5>
				<a href="products.php" class="btn btn-primary">No</a>
				<?php
					if ($type == "product") {
						echo '<a href="?confirm='.$info['item_id'].'&amp;type=product" class="btn btn-success">Yes</a>';
					} else if ($type == "category") {
						echo '<a href="?confirm='.$info['cid'].'&amp;type=category" class="btn btn-success">Yes</a>';
					}
				?>
			<?php endif; ?>
		</div>
	</div>

</body>
<?php include '../templates/global/scripts.php'; ?>
</html>
