<?php
	include '../config.php';
	require '../classes/phplot.php';
	include '../classes/class.database.php';

	$db = new Database($config);
	$db->connect();

	$plot = new PHPlot(848, 300);
	$plot->SetTransparentColor('green');
	$plot->SetBackgroundColor(array(51, 54, 57));
	$plot->SetGridColor(array(217, 69, 66));
	$plot->SetTextColor("white");
	$plot->SetTickColor(array(217, 69, 66));
	$plot->SetTitle('Payments for '.date('Y').'');
	$plot->SetTitleColor('white');
	$plot->SetLightGridColor(array(68, 72, 76));
	$plot->SetDataColors(array(array(217, 69, 66)));
	$plot->SetShading(0);
	$plot->SetDrawDataBorders(false);

	if (isset($_REQUEST['type'])) {
		$plot->setPlotType($_REQUEST['type']);
	}

	$stats = $db->getPaymentStats();

	$data = array(
		array('Jan', 0),
		array('Feb', 0),
		array('Mar', 0),
		array('Apr', 0),
		array('May', 0),
		array('June', 0),
		array('July', 0),
		array('Aug', 0),
		array('Sep', 0),
		array('Oct', 0),
		array('Nov', 0),
		array('Dec', 0),
	 );

	foreach ($stats as $stat) {
		$monthId = $stat['month'];
		$data[$monthId - 1][1]= $stat['amount'];
	}

	$plot->SetDataValues($data);
	$plot->DrawGraph();
?>
