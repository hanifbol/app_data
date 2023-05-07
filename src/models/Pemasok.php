<?php
require_once __DIR__ . "/Model.php";

class Pemasok extends Model {
	protected $table = "Pemasok";
	protected $primary_key = "IdPemasok";
	protected $attributes = [
		"NamaPemasok",
		"AlamatPemasok",
		"NoTelepon",
		"Email",
	];

	public function add()
	{
		try {
			$query = "
				INSERT INTO $this->table (NamaPemasok, AlamatPemasok, NoTelepon, Email)
				VALUES (:NamaPemasok, :AlamatPemasok, :NoTelepon, :Email)
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaPemasok', $this->getAttribute('NamaPemasok'), PDO::PARAM_STR);
			$statement->bindValue(':AlamatPemasok', $this->getAttribute('AlamatPemasok'), PDO::PARAM_STR);
			$statement->bindValue(':NoTelepon', $this->getAttribute('NoTelepon'), PDO::PARAM_STR);
			$statement->bindValue(':Email', $this->getAttribute('Email'), PDO::PARAM_STR);
			$statement->execute();
			return $this->conn->lastInsertId();
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function update($id)
	{
		try {
			$query = "
				UPDATE $this->table
				SET
					NamaPemasok = :NamaPemasok,
					AlamatPemasok = :AlamatPemasok,
					NoTelepon = :NoTelepon,
					Email = :Email
				WHERE IdPemasok = :IdPemasok
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaPemasok', $this->getAttribute('NamaPemasok'), PDO::PARAM_STR);
			$statement->bindValue(':AlamatPemasok', $this->getAttribute('AlamatPemasok'), PDO::PARAM_STR);
			$statement->bindValue(':NoTelepon', $this->getAttribute('NoTelepon'), PDO::PARAM_STR);
			$statement->bindValue(':Email', $this->getAttribute('Email'), PDO::PARAM_STR);
			$statement->bindValue(':IdPemasok', $id, PDO::PARAM_INT);
			$statement->execute();
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function search($search)
	{
		try {
			$query = "
				SELECT *
				FROM $this->table
				WHERE NamaPemasok LIKE :NamaPemasok
				ORDER BY NamaPemasok
				LIMIT 10
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaPemasok', '%' . $search . '%', PDO::PARAM_STR);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_ASSOC);
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}