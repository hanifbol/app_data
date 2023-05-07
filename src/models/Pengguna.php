<?php
require_once __DIR__ . "/HakAkses.php";
require_once __DIR__ . "/Model.php";

class Pengguna extends Model {
	protected $table = "Pengguna";
	protected $primary_key = "IdPengguna";
	protected $attributes = [
		"NamaPengguna",
		"Password",
		"NamaDepan",
		"NamaBelakang",
		"NoHp",
		"Alamat",
		"IdAkses",
	];

	public function add() 
	{
		try {
			$query = "
				INSERT INTO $this->table (NamaPengguna, Password, NamaDepan, NamaBelakang, NoHp, Alamat, IdAkses) 
				VALUES (:NamaPengguna, :Password, :NamaDepan, :NamaBelakang, :NoHp, :Alamat, :IdAkses)
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaPengguna', $this->getAttribute('NamaPengguna'), PDO::PARAM_STR);
			$statement->bindValue(':Password', password_hash($this->getAttribute('Password'), PASSWORD_BCRYPT), PDO::PARAM_STR);
			$statement->bindValue(':NamaDepan', $this->getAttribute('NamaDepan'), PDO::PARAM_STR);
			$statement->bindValue(':NamaBelakang', $this->getAttribute('NamaBelakang'), PDO::PARAM_STR);
			$statement->bindValue(':NoHp', $this->getAttribute('NoHp'), PDO::PARAM_STR);
			$statement->bindValue(':Alamat', $this->getAttribute('Alamat'), PDO::PARAM_STR);
			$statement->bindValue(':IdAkses', $this->getAttribute('IdAkses'), PDO::PARAM_INT);
			$statement->execute();
			return $this->conn->lastInsertId();
		} catch (Exception $e) {
			throw $e;
		}
	}

	public function update($id)
	{
		try {
			$query = "
				UPDATE $this->table
				SET 
					NamaDepan = :NamaDepan,
					NamaBelakang = :NamaBelakang,
					NoHp = :NoHp,
					Alamat = :Alamat,
					IdAkses = :IdAkses
			";
			if ($this->getAttribute('Password') != "") {
				$query .= ", Password = :Password ";
			}
			$query .= "WHERE $this->primary_key = :IdPengguna";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaDepan', $this->getAttribute('NamaDepan'), PDO::PARAM_STR);
			$statement->bindValue(':NamaBelakang', $this->getAttribute('NamaBelakang'), PDO::PARAM_STR);
			$statement->bindValue(':NoHp', $this->getAttribute('NoHp'), PDO::PARAM_STR);
			$statement->bindValue(':Alamat', $this->getAttribute('Alamat'), PDO::PARAM_STR);
			$statement->bindValue(':IdAkses', $this->getAttribute('IdAkses'), PDO::PARAM_INT);
			$statement->bindValue(':IdPengguna', $id, PDO::PARAM_INT);
			if ($this->getAttribute('Password') != "") {
				$statement->bindValue(':Password', password_hash($this->getAttribute('Password'), PASSWORD_BCRYPT), PDO::PARAM_STR);
			}
			$statement->execute();
		} catch (\Throwable $th) {
			// throw $th;
			var_dump($th);
		}
	}

	public function login($username, $password) 
	{
		// Check if user exist
		$user = $this->findUserByUsername($username);

		// if user found, check the password
		if ($user && password_verify($password, $user['Password'])) {

			// prevent session fixation attack
			session_regenerate_id();
	
			// set username in the session
			$_SESSION['IdPengguna'] = $user['IdPengguna'];
			$_SESSION['NamaPengguna'] = $user['NamaPengguna'];
			$_SESSION['NamaDepan'] = $user['NamaDepan'];
			$_SESSION['NamaBelakang'] = $user['NamaBelakang'];
	
	
			return true;
		}
	
		return false;
	}

	public function findUserByUsername($username)
	{
		$query = "
			SELECT IdPengguna, NamaPengguna, Password, NamaDepan, NamaBelakang, IdAkses
			FROM $this->table 
			WHERE NamaPengguna = :username;
		";
		$statement = $this->conn->prepare($query);
		$statement->bindValue(':username', $username, PDO::PARAM_STR);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function find($id)
	{
		$user = parent::find($id);
		$hakAkses = new HakAkses();
		$userAkses = $hakAkses->find($user['IdAkses']);
		$user['HakAkses'] = $userAkses;
		unset($user['IdAkses']);
		return $user;
	}

	public function list()
	{
		$hakAkses = new HakAkses();
		$users = parent::list();
		for ($i=0; $i < sizeof($users); $i++) { 
			$userAkses = $hakAkses->find($users[$i]['IdAkses']);
			$users[$i]['HakAkses'] = $userAkses;
			unset($users[$i]['Password']);
			unset($users[$i]['IdAkses']);
		}
		return $users;
	}
}