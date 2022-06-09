<?php
	if (count(get_included_files()) <= 1)
		exit;
?>
<div class="panel panel-default">
	<div class="panel-body">
		<form action="index.php" method="post" id="login">
			<div class="form-group">
				<label>Enter your username:</label>
				<input type="text" name="username" id="username" class="form-control" placeholder="">
			</div>
			<?php $csrf->echoInputField(); ?>
			<div class="form-group">
				<button type="submit" class="btn btn-success btn-block">Continue</button>
			</div>
		</form>
	</div>
</div>
