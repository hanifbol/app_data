<?php
require_once __DIR__ . "/Barang.php";
require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/Pemasok.php";

class Pembelian extends Model {
	protected $table = 'Pembelian';
	protected $primary_key = "IdPembelian";
	protected $attributes = [
		"IdBarang",
		"JumlahPembelian",
		"HargaBeli",
		"IdPemasok",
		"IdPengguna",
	];

	public function add()
	{
		try {
			$query = "
				INSERT INTO $this->table (IdBarang, JumlahPembelian, HargaBeli, IdPemasok, IdPengguna)
				VALUES (:IdBarang, :JumlahPembelian, :HargaBeli, :IdPemasok, :IdPengguna)
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(":IdBarang", $this->getAttribute('IdBarang'), PDO::PARAM_INT);
			$statement->bindValue(":JumlahPembelian", strval($this->getAttribute('JumlahPembelian')), PDO::PARAM_STR);
			$statement->bindValue(":HargaBeli", strval($this->getAttribute('HargaBeli')), PDO::PARAM_STR);
			$statement->bindValue(":IdPemasok", $this->getAttribute('IdPemasok'), PDO::PARAM_INT);
			$statement->bindValue(":IdPengguna", $this->getAttribute('IdPengguna'), PDO::PARAM_INT);
			$statement->execute();
			return $this->conn->lastInsertId();
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function list()
	{
		$barang = new Barang();
		$pemasok = new Pemasok();
		$purchases = parent::list();
		for ($i=0; $i < sizeof($purchases); $i++) { 
			$item = $barang->find($purchases[$i]['IdBarang']);
			$purchases[$i]['Barang'] = $item;
			unset($purchases[$i]['IdBarang']);

			$supplier = $pemasok->find($purchases[$i]['IdPemasok']);
			$purchases[$i]['Pemasok'] = $supplier;
			unset($purchases[$i]['IdPemasok']);
		}
		return $purchases;
	}

	public function find($id)
	{
		try {
			$barang = new Barang();
			$pemasok = new Pemasok();
			$purchase = parent::find($id);

			$item = $barang->find($purchase['IdBarang']);
			$purchase['Barang'] = $item;
			unset($purchase['IdBarang']);

			$supplier = $pemasok->find($purchase['IdPemasok']);
			$purchase['Pemasok'] = $supplier;
			unset($purchase['IdPemasok']);

			return $purchase;
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
					IdBarang = :IdBarang,
					JumlahPembelian = :JumlahPembelian,
					HargaBeli = :HargaBeli,
					IdPemasok = :IdPemasok,
					IdPengguna = :IdPengguna
				WHERE IdPembelian = :IdPembelian
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(":IdBarang", $this->getAttribute('IdBarang'), PDO::PARAM_INT);
			$statement->bindValue(":JumlahPembelian", strval($this->getAttribute('JumlahPembelian')), PDO::PARAM_STR);
			$statement->bindValue(":HargaBeli", strval($this->getAttribute('HargaBeli')), PDO::PARAM_STR);
			$statement->bindValue(":IdPemasok", $this->getAttribute('IdPemasok'), PDO::PARAM_INT);
			$statement->bindValue(":IdPengguna", $this->getAttribute('IdPengguna'), PDO::PARAM_INT);
			$statement->bindValue(":IdPembelian", $id, PDO::PARAM_INT);
			$statement->execute();
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function total()
	{
		try {
			$query = "
				SELECT 
					COUNT(IdPembelian) JumlahTransaksi, 
					SUM(JumlahPembelian * HargaBeli) TotalNilai
				FROM Pembelian
			";
			$statement = $this->conn->prepare($query);
			$statement->execute();
			return $statement->fetch(PDO::FETCH_ASSOC);
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}