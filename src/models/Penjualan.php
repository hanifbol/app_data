<?php
require_once __DIR__ . "/Barang.php";
require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/Pelanggan.php";

class Penjualan extends Model {
	protected $table = 'Penjualan';
	protected $primary_key = "IdPenjualan";
	protected $attributes = [
		"IdBarang",
		"JumlahPenjualan",
		"HargaJual",
		"IdPelanggan",
		"IdPengguna",
	];

	public function add()
	{
		try {
			$query = "
				INSERT INTO $this->table (IdBarang, JumlahPenjualan, HargaJual, IdPelanggan, IdPengguna)
				VALUES (:IdBarang, :JumlahPenjualan, :HargaJual, :IdPelanggan, :IdPengguna)
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(":IdBarang", $this->getAttribute('IdBarang'), PDO::PARAM_INT);
			$statement->bindValue(":JumlahPenjualan", strval($this->getAttribute('JumlahPenjualan')), PDO::PARAM_STR);
			$statement->bindValue(":HargaJual", strval($this->getAttribute('HargaJual')), PDO::PARAM_STR);
			$statement->bindValue(":IdPelanggan", $this->getAttribute('IdPelanggan'), PDO::PARAM_INT);
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
		$pelanggan = new Pelanggan();
		$sales = parent::list();
		for ($i=0; $i < sizeof($sales); $i++) { 
			$item = $barang->find($sales[$i]['IdBarang']);
			$sales[$i]['Barang'] = $item;
			unset($sales[$i]['IdBarang']);

			$customer = $pelanggan->find($sales[$i]['IdPelanggan']);
			$sales[$i]['Pelanggan'] = $customer;
			unset($sales[$i]['IdPelanggan']);
		}
		return $sales;
	}

	public function find($id)
	{
		try {
			$barang = new Barang();
			$pelanggan = new Pelanggan();
			$sale = parent::find($id);

			$item = $barang->find($sale['IdBarang']);
			$sale['Barang'] = $item;
			unset($sale['IdBarang']);

			$customer = $pelanggan->find($sale['IdPelanggan']);
			$sale['Pelanggan'] = $customer;
			unset($sale['IdPelanggan']);

			return $sale;
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
					JumlahPenjualan = :JumlahPenjualan,
					HargaJual = :HargaJual,
					IdPelanggan = :IdPelanggan,
					IdPengguna = :IdPengguna
				WHERE IdPenjualan = :IdPenjualan
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(":IdBarang", $this->getAttribute('IdBarang'), PDO::PARAM_INT);
			$statement->bindValue(":JumlahPenjualan", strval($this->getAttribute('JumlahPenjualan')), PDO::PARAM_STR);
			$statement->bindValue(":HargaJual", strval($this->getAttribute('HargaJual')), PDO::PARAM_STR);
			$statement->bindValue(":IdPelanggan", $this->getAttribute('IdPelanggan'), PDO::PARAM_INT);
			$statement->bindValue(":IdPengguna", $this->getAttribute('IdPengguna'), PDO::PARAM_INT);
			$statement->bindValue(":IdPenjualan", $id, PDO::PARAM_INT);
			$statement->execute();
		} catch (\Throwable $th) {
			// throw $th;
			var_dump($th);
		}
	}
}