<?php
require __DIR__ . "/../../src/models/HakAkses.php";

if (isset($_POST['submit'])) {
	$hakAkses = new HakAkses();

	switch ($_POST['submit']) {
		case 'list':
			$listAkses = $hakAkses->list();
			echo json_encode($listAkses);
			break;
		
		default:
			header('Location: ' . url('index.php'));
			break;
	}
}