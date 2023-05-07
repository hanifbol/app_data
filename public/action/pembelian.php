<?php
require __DIR__ . "/../../src/models/Pembelian.php";

if (isset($_POST['submit'])) {
	$pembelian = new Pembelian();

	switch ($_POST['submit']) {
		case 'list':
			// List all purchasing
			$purchases = $pembelian->list();
			echo json_encode(['data' => $purchases]);
			break;

		case 'new':
			// Create new purchase
			$pembelian->setAttribute('IdPemasok', $_POST['idpemasok']);
			$pembelian->setAttribute('IdBarang', $_POST['idbarang']);
			$pembelian->setAttribute('JumlahPembelian', $_POST['jumlah']);
			$pembelian->setAttribute('HargaBeli', $_POST['harga']);
			$pembelian->setAttribute('IdPengguna', $_SESSION['IdPengguna']);
			$pembelian->add();
			break;

		case 'find':
			// Find purchase by id
			$item = $pembelian->find($_POST['IdPembelian']);
			echo json_encode($item);
			break;

		case 'update':
			// Upate purchase data
			$pembelian->setAttribute('IdPemasok', $_POST['idpemasok']);
			$pembelian->setAttribute('IdBarang', $_POST['idbarang']);
			$pembelian->setAttribute('JumlahPembelian', $_POST['jumlah']);
			$pembelian->setAttribute('HargaBeli', $_POST['harga']);
			$pembelian->setAttribute('IdPengguna', $_SESSION['IdPengguna']);
			$pembelian->update($_POST['idpembelian']);
			break;

		case 'delete':
			// Delete specific purchase
			$pembelian->delete($_POST['idpembelian']);
			break;

		case 'total':
			// Get total of transaction
			$data = $pembelian->total();
			echo json_encode($data);
			break;
		
		default:
			header('Location: ' . url('index.php'));
			break;
	}
}