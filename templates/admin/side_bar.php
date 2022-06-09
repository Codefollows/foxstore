<?php
	if (count(get_included_files()) <= 1) {
		exit;
	}
?>

<div class="panel panel-default">
	<div class="panel-body text-center">
		Hello,<br>
		<h3 class="no-margin"><?php echo formatName(admin_user); ?></h3><br>
		<a href="?action=logout">Sign Out</a>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body text-center">
		<h4>Sales for <?php echo date("F"); ?></h4>
		<?php
			$stats = $db->getMonthlySales();

			$earned = number_format($stats['total'], 2);
			$noPayments =  number_format($stats['payments']);
			
			echo '<h2 style="margin-bottom: 0;">$'.$earned.'</h2>';
			echo '<h4 style="margin-top: 0;"><small>'.$noPayments.' Payment(s)</small></h4>';
		?>
	</div>
</div>
