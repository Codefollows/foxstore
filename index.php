<?php
	require 'autoload.php';

	$username = $auth->verifyUser();

	if (isset($_GET['action']) && $_GET['action'] == "logout") {
		$auth->logout(false);
	}

	if (isset($_POST['username']) && !empty($_POST['username']) && trim($_POST['username']) != '') {
		$auth->userLogin($csrf);
	}

	if (isset($_POST['name'], $_POST['itemid'], $_POST['price'], $_POST['discount'], $_POST['quantity'])) {
		if ($username == null) {
			header("Location: index.php");
			exit;
		}

		$csrf->verifyRequest();

		$product = $db->getProduct(cleanInt($_POST['itemid']));

		if (isset($_COOKIE['item_'.$product['item_id']])) {
			header("Location: index.php");
			exit;
		}

		if ($product == null) {
			header("location: index.php");
			exit;
		}

		$pdata = array(
			"item_id" => $product['item_id'],
			"item_name" => $product['item_name'],
			"item_price" => $product['item_price'],
			"item_discount" => $product['item_discount'],
			"quantity" => cleanInt($_POST['quantity'])
		);

		setcookie('item_'.$product['item_id'], serialize($pdata));
		header("Location: index.php");
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'templates/global/head.php'; ?>
<body>


	<div class="wrapper">
		<div class="container">
			<?php if ($username == null) : ?>
			<div class="row">
				<div class="col-md-12 server-list">
					<div class="alert alert-danger">You must enter a username to purchase items from the store.</div>
		        </div>
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="col-md-3 server-list">
					<?php
						if ($username == null):
							include 'templates/side_panel/login_box.php';
						else:
							include 'templates/side_panel/user_box.php';
						endif;
					?>

					<div class="panel panel-default">
						<div class="list-group">
							<a class="list-group-item" href="index.php">
									<span class="badge"><?php echo $db->countAllProducts(); ?></span>
									Show All Items
								</a>
							<?php
							$categories = $db->getCategories();
							foreach($categories as $cat) {
								echo '<a class="list-group-item" href="?category='.$cat['cid'].'">
										<span class="badge">'.$db->countProductsInCat($cat['cid']).'</span>
										'.$cat['cat_title'].'
									</a>';
							}
							?>
						</div>
					</div>

    <p>By using this online store, you agree to the TERMS OF SERVICE:</p>
    <p>- There is a no refund policy on any item purchased from the online store</p>
    <p>- Attempting to charge back any purchases made on this online store will result in a ban of your account on the game.</p>
		        </div>
		        
		        <div class="col-md-9 server-list">
					<?php include 'templates/index/product_index.php'; ?>
		        </div>
		        
			</div>

</div>
</body>
<?php include 'templates/global/scripts.php'; ?>
</html>
