<?php
require __DIR__ . "/../../src/models/Pemasok.php";

if (isset($_POST['submit'])) {
	$pemasok = new Pemasok();

	switch ($_POST['submit']) {
		case 'list':
			// List all suppliers
			$suppliers = $pemasok->list();
			echo json_encode(['data' => $suppliers]);
			break;

		case 'new':
			// Create new item
			$pemasok->setAttribute('NamaPemasok', $_POST['pemasok']);
			$pemasok->setAttribute('AlamatPemasok', $_POST['alamat']);
			$pemasok->setAttribute('NoTelepon', $_POST['telepon']);
			$pemasok->setAttribute('Email', $_POST['email']);
			$pemasok->add();
			break;

		case 'find':
			// Find item by id
			$item = $pemasok->find($_POST['IdPemasok']);
			echo json_encode($item);
			break;

		case 'update':
			// Update item data
			$pemasok->setAttribute('NamaPemasok', $_POST['pemasok']);
			$pemasok->setAttribute('AlamatPemasok', $_POST['alamat']);
			$pemasok->setAttribute('NoTelepon', $_POST['telepon']);
			$pemasok->setAttribute('Email', $_POST['email']);
			$pemasok->update($_POST['idpemasok']);
			break;

		case 'delete':
			// Delete specific supplier
			$pemasok->delete($_POST['idpemasok']);
			break;

		case 'search':
			// Search by name
			$suppliers = $pemasok->search($_POST['search']);
			echo json_encode($suppliers);
			break;

		default:
			header('Location: ' . url('index.php'));
			break;
	}
}