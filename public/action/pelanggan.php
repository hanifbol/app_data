<?php
require __DIR__ . "/../../src/models/Pelanggan.php";

if (isset($_POST['submit'])) {
	$pelanggan = new Pelanggan();

	switch ($_POST['submit']) {
		case 'list':
			// List all customers
			$customers = $pelanggan->list();
			echo json_encode(['data' => $customers]);
			break;

		case 'new':
			// Create new item
			$pelanggan->setAttribute('NamaPelanggan', $_POST['pelanggan']);
			$pelanggan->setAttribute('AlamatPelanggan', $_POST['alamat']);
			$pelanggan->setAttribute('NoTelepon', $_POST['telepon']);
			$pelanggan->setAttribute('Email', $_POST['email']);
			$pelanggan->add();
			break;

		case 'find':
			// Find item by id
			$item = $pelanggan->find($_POST['IdPelanggan']);
			echo json_encode($item);
			break;

		case 'update':
			// Update item data
			$pelanggan->setAttribute('NamaPelanggan', $_POST['pelanggan']);
			$pelanggan->setAttribute('AlamatPelanggan', $_POST['alamat']);
			$pelanggan->setAttribute('NoTelepon', $_POST['telepon']);
			$pelanggan->setAttribute('Email', $_POST['email']);
			$pelanggan->update($_POST['idpelanggan']);
			break;

		case 'delete':
			// Delete specific customer
			$pelanggan->delete($_POST['idpelanggan']);
			break;

		case 'search':
			// Search by name
			$customers = $pelanggan->search($_POST['search']);
			echo json_encode($customers);
			break;

		default:
			header('Location: ' . url('index.php'));
			break;
	}
}