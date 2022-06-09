<?php
	if (count(get_included_files()) <= 1) {
		exit;
	}

	$products = null;
	$category = null;

	if (isset($_GET['category']) && !empty($_GET['category'])) {
		if (!is_numeric($_GET['category'])) {
			header("Location: index.php");
			exit;
		}

		$category = cleanInt($_GET['category']);
		$products = $db->getProducts($category);
	} else {
		$products = $db->getAllProducts();
	}

	$productCount = count($products);
	$count = 0;
?>
<div class="row">
	<div class="col-md-12">
		<?php
			if ($category != null) {
				$catData = $db->getCategory($category);
				echo '<h3 class="cathead">'.$catData['cat_title'].'</h3>';
			} else {
				echo '<h3 class="cathead">All Items</h3>';
			}
		?>
		<hr class="catsep">
	</div>
</div>
<?php
if ($productCount == 0) {
	echo 'There are no products to display in this category.';
} else {
	foreach($products as $product):
		if ($count == 0):
			echo '<div class="row">';
		endif;

		$title = $product['item_name'];
		$desc = $product['description'];
		$item_id = $product['item_id'];
		$image = $product['image_url'];
		$value = $product['item_price'];
		$discount = $product['item_discount'];
	?>

	<div class="col-md-3 text-center">
		<div class="item">
			<div class="product-image">
				<div class="image-inner">
					<img src="<?php echo $image; ?>">
				</div>
			</div>
			<h5><?php echo $title; ?></h5>
			<div class="item-price">
				<?php
					if ($discount != 0) {
						echo '<span class="text-success">$'.number_format($value-$discount, 2).'</span>
							 <strike class="text-danger">$'.number_format($value, 2).'</strike>';
					} else {
						echo '$'.number_format($value, 2).'';
					}
				?>
			</div>
			<form action="index.php" method="post" id="itemform">
				<input type="hidden" name="name" value="<?php echo $title; ?>">
				<input type="hidden" name="itemid" value="<?php echo $item_id; ?>">
				<input type="hidden" name="price" value="<?php echo $value; ?>">
				<input type="hidden" name="discount" value="<?php echo $discount; ?>">
				<?php $csrf->echoInputField(); ?>
				<div class="input-group text-center input-custom" id="amount_input" style="width: 100%">
				    <input type="number" class="form-control input-sm quantity" name="quantity" value="1" min=1 max=100>
				    <span class="input-group-btn">
				      	<button class="btn btn-xs btn-default add-btn">Add</button>
				    </span>
				</div>
			</form>
		</div>
	</div>

	<?php
	$count++;
	if ($count == 4 || $count == $productCount || $productCount == 0):
		$count = 0;
		echo '</div>';
	endif;
	endforeach;
}
?>

