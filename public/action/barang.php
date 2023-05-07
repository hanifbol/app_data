<?php
require __DIR__ . "/../../src/models/Barang.php";

if (isset($_POST['submit'])) {
	$barang = new Barang();

	switch ($_POST['submit']) {
		case 'list':
			// List all items
			$items = $barang->list();
			echo json_encode(['data' => $items]);
			break;
		
		case 'new':
			// Create new item
			$barang->setAttribute('NamaBarang', $_POST['barang']);
			$barang->setAttribute('Keterangan', $_POST['keterangan']);
			$barang->setAttribute('Satuan', $_POST['satuan']);
			$barang->setAttribute('IdPengguna', $_SESSION['IdPengguna']);
			$barang->add();
			break;

		case 'find':
			// Find item by id
			$item = $barang->find($_POST['IdBarang']);
			echo json_encode($item);
			break;

		case 'update':
			// Update item data
			$barang->setAttribute('NamaBarang', $_POST['barang']);
			$barang->setAttribute('Keterangan', $_POST['keterangan']);
			$barang->setAttribute('Satuan', $_POST['satuan']);
			$barang->setAttribute('IdPengguna', $_SESSION['IdPengguna']);
			$barang->update($_POST['idbarang']);
			break;

		case 'delete':
			// Delete specific data
			$barang->delete($_POST['idbarang']);
			break;

		case 'search':
			// Search by name
			$items = $barang->search($_POST['search']);
			echo json_encode($items);
			break;

		case 'stock':
			// Check item stock
			$stock = $barang->stock($_POST['idbarang'], $_POST['idpenjualan']);
			echo $stock;
			break;

		case 'dashboard';
			// Show data for dashboard
			$data = $barang->dashboard();
			echo json_encode(['data' => $data]);
			break;
		
		default:
			header('Location: ' . url('index.php'));
			break;
	}
}