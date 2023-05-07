<?php
require_once __DIR__ . "/Model.php";

class Pelanggan extends Model {
	protected $table = "Pelanggan";
	protected $primary_key = "IdPelanggan";
	protected $attributes = [
		"NamaPelanggan",
		"AlamatPelanggan",
		"NoTelepon",
		"Email",
	];

	public function add()
	{
		try {
			$query = "
				INSERT INTO $this->table (NamaPelanggan, AlamatPelanggan, NoTelepon, Email)
				VALUES (:NamaPelanggan, :AlamatPelanggan, :NoTelepon, :Email)
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaPelanggan', $this->getAttribute('NamaPelanggan'), PDO::PARAM_STR);
			$statement->bindValue(':AlamatPelanggan', $this->getAttribute('AlamatPelanggan'), PDO::PARAM_STR);
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
					NamaPelanggan = :NamaPelanggan,
					AlamatPelanggan = :AlamatPelanggan,
					NoTelepon = :NoTelepon,
					Email = :Email
				WHERE IdPelanggan = :IdPelanggan
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaPelanggan', $this->getAttribute('NamaPelanggan'), PDO::PARAM_STR);
			$statement->bindValue(':AlamatPelanggan', $this->getAttribute('AlamatPelanggan'), PDO::PARAM_STR);
			$statement->bindValue(':NoTelepon', $this->getAttribute('NoTelepon'), PDO::PARAM_STR);
			$statement->bindValue(':Email', $this->getAttribute('Email'), PDO::PARAM_STR);
			$statement->bindValue(':IdPelanggan', $id, PDO::PARAM_INT);
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
				WHERE NamaPelanggan LIKE :NamaPelanggan
				ORDER BY NamaPelanggan
				LIMIT 10
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaPelanggan', '%' . $search . '%', PDO::PARAM_STR);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_ASSOC);
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}