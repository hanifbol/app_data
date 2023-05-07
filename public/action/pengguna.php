<?php
require __DIR__ . "/../../src/models/HakAkses.php";
require __DIR__ . "/../../src/models/Pengguna.php";

if (isset($_POST['submit'])) {
	$pengguna = new Pengguna();

	switch ($_POST['submit']) {
		case 'register':
			// New user from registration page
			$pengguna->setAttribute('NamaPengguna', $_POST['username']);
			$pengguna->setAttribute('Password', $_POST['password']);
			$pengguna->setAttribute('NamaDepan', $_POST['firstname']);
			$pengguna->setAttribute('NamaBelakang', $_POST['lastname']);
			$pengguna->setAttribute('NoHp', $_POST['phone']);
			$pengguna->setAttribute('Alamat', $_POST['address']);
			$pengguna->setAttribute('IdAkses', 2);
			$user_id = $pengguna->add();

			$user = $pengguna->find($user_id);
			$_SESSION['IdPengguna'] = $user['IdPengguna'];
			$_SESSION['NamaPengguna'] = $user['NamaPengguna'];
			$_SESSION['NamaDepan'] = $user['NamaDepan'];
			$_SESSION['NamaBelakang'] = $user['NamaBelakang'];
			$_SESSION['HakAkses'] = $user['HakAkses']['NamaAkses'];
			break;

		case 'login':
			// Check if user exist
			$user = $pengguna->findUserByUsername($_POST['username']);

			// if user found, check the password
			if ($user && password_verify($_POST['password'], $user['Password'])) {
				// prevent session fixation attack
				session_regenerate_id();
		
				// set username in the session
				$_SESSION['IdPengguna'] = $user['IdPengguna'];
				$_SESSION['NamaPengguna'] = $user['NamaPengguna'];
				$_SESSION['NamaDepan'] = $user['NamaDepan'];
				$_SESSION['NamaBelakang'] = $user['NamaBelakang'];

				// Set access in the session
				$akses = new HakAkses();
				$hakAkses = $akses->find($user['IdAkses']);
				$_SESSION['HakAkses'] = $hakAkses['NamaAkses'];
			} else {
				// send error message
				if (!$isLogin) {
					header('HTTP/1.1 500 Username atau password salah');
					header('Content-Type: application/json; charset=UTF-8');
					die(json_encode(array('message' => 'Username atau password salah')));
				}
			}
			break;

		case 'list':
			// List all users
			$users = $pengguna->list();
			echo json_encode(['data' => $users]);
			break;

		case 'new':
			// Create new user
			$pengguna->setAttribute('NamaPengguna', $_POST['username']);
			$pengguna->setAttribute('Password', $_POST['password']);
			$pengguna->setAttribute('NamaDepan', $_POST['firstname']);
			$pengguna->setAttribute('NamaBelakang', $_POST['lastname']);
			$pengguna->setAttribute('NoHp', $_POST['phone']);
			$pengguna->setAttribute('Alamat', $_POST['address']);
			$pengguna->setAttribute('IdAkses', $_POST['accessid']);
			$user_id = $pengguna->add();
			break;

		case 'find':
			// Find user by id
			if (isset($_POST['IdPengguna'])) {
				$user = $pengguna->find($_POST['IdPengguna']);
				unset($user['Password']);
				echo json_encode($user);
			}
			break;

		case 'update':
			// Update user data
			$pengguna->setAttribute('Password', $_POST['password']);
			$pengguna->setAttribute('NamaDepan', $_POST['firstname']);
			$pengguna->setAttribute('NamaBelakang', $_POST['lastname']);
			$pengguna->setAttribute('NoHp', $_POST['phone']);
			$pengguna->setAttribute('Alamat', $_POST['address']);
			$pengguna->setAttribute('IdAkses', $_POST['accessid']);
			$pengguna->update($_POST['userid']);
		
			$user = $pengguna->find($_POST['userid']);
			echo json_encode($user);
			break;

		case 'delete':
			// Delete specific user
			$pengguna->delete($_POST['userid']);
			break;
		
		default:
			header('Location: ' . url('index.php'));
			break;
	}
}