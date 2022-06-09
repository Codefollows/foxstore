<?php
	if (count(get_included_files()) <= 1)
		exit;
?>


<div class="panel panel-default">
	<div class="panel-body">
		<h4 style="margin:0;">Hello, <?php echo $username; ?>!</h4>

		<form action="checkout.php" method="post" id="pp_form">
			<?php
				for ($i = 0; $i < count($pp_config); $i++) {
					echo '<input type="hidden" name="'.$pp_keys[$i].'" value="'.$pp_config[$pp_keys[$i]].'">';
				}
			?>

			<input type="hidden" name="custom" value="<?php echo $username; ?>">

			<ul class="list-group" id="products">
				<?php
					$slot = 1;
					$total = 0;

					foreach($_COOKIE as $key => $value) {
						if (!preg_match('/^(item_[\d]+)$/i', $key)) {
							continue;
						}

						$data = unserialize($value);
						$itemData = $db->getProduct(preg_replace("/[^0-9.]/", '', $key));

						$name = cleanString($itemData['item_name']);
						$id = cleanInt($itemData['item_id']);
						$amount = cleanInt($itemData['item_price']);
						$discount = cleanInt($itemData['item_discount']);
						$quantity = cleanInt($data['quantity']);

						$totalPrice = (($amount - $discount) * $quantity);
						echo '
							<li class="cart-item list-group-item">
								<span class="pull-right">$'.(($amount - $discount) * $quantity).'</span>
								'.$name.' x'.$quantity.'
								<input type="hidden" class="form-control" name="item_number_'.$slot.'" value="'.$id.'">
								<input type="hidden" class="form-control" name="item_name_'.$slot.'" value="'.$name.'">
								<input type="hidden" class="form-control" name="amount_'.$slot.'" value="'.$amount.'">
								<input type="hidden" class="form-control" name="quantity_'.$slot.'" value="'.$quantity.'">
								<input type="hidden" class="form-control" name="discount_amount_'.$slot.'" value="'.$discount.'">
							</li>';

						$total += $totalPrice;
						$slot++;
					}

					if ($slot == 1) {
						echo 'You have no products in your shopping cart.';
					}
				?>
			</ul>

			<?php $csrf->echoInputField(); ?>

			<p class="text-right">Total: $<span id="total"><?php echo number_format($total, 2); ?></span></p>

			<div class="form-group">
				<button type="submit" class="btn btn-success btn-block">Checkout with Paypal</button>
			</div>

			<div class="form-group text-center">
				<a href="?action=logout">Change Name</a> |
				<a href="#" id="clear">Empty Cart</a>
			</div>

		</form>

	</div>
</div>
