<?php
require __DIR__ . "/../../src/models/Penjualan.php";

if (isset($_POST['submit'])) {
	$penjualan = new Penjualan();

	switch ($_POST['submit']) {
		case 'list':
			// List all sales
			$sales = $penjualan->list();
			echo json_encode(['data' => $sales]);
			break;

		case 'new':
			// Create new sale
			$penjualan->setAttribute('IdPelanggan', $_POST['idpelanggan']);
			$penjualan->setAttribute('IdBarang', $_POST['idbarang']);
			$penjualan->setAttribute('JumlahPenjualan', $_POST['jumlah']);
			$penjualan->setAttribute('HargaJual', $_POST['harga']);
			$penjualan->setAttribute('IdPengguna', $_SESSION['IdPengguna']);
			$penjualan->add();
			break;

		case 'find':
			// Find sale by id
			$item = $penjualan->find($_POST['IdPenjualan']);
			echo json_encode($item);
			break;

		case 'update':
			// Upate sale data
			$penjualan->setAttribute('IdPelanggan', $_POST['idpelanggan']);
			$penjualan->setAttribute('IdBarang', $_POST['idbarang']);
			$penjualan->setAttribute('JumlahPenjualan', $_POST['jumlah']);
			$penjualan->setAttribute('HargaJual', $_POST['harga']);
			$penjualan->setAttribute('IdPengguna', $_SESSION['IdPengguna']);
			$penjualan->update($_POST['idpenjualan']);
			break;

		case 'delete':
			// Delete specific sale
			$penjualan->delete($_POST['idpenjualan']);
			break;

		case 'total':
			// Get total of transaction
			$data = $penjualan->total();
			echo json_encode($data);
			break;
		
		default:
			header('Location: ' . url('index.php'));
			break;
	}
}