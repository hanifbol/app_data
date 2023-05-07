<?php
require_once __DIR__ . "/Model.php";

class Barang extends Model {
	protected $table = "Barang";
	protected $primary_key = "IdBarang";
	protected $attributes = [
		"NamaBarang",
		"Keterangan",
		"Satuan",
		"IdPengguna",
	];

	public function add()
	{
		try {
			$query = "
				INSERT INTO $this->table (NamaBarang, Keterangan, Satuan, IdPengguna)
				VALUES (:NamaBarang, :Keterangan, :Satuan, :IdPengguna)
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaBarang', $this->getAttribute('NamaBarang'), PDO::PARAM_STR);
			$statement->bindValue(':Keterangan', $this->getAttribute('Keterangan'), PDO::PARAM_STR);
			$statement->bindValue(':Satuan', $this->getAttribute('Satuan'), PDO::PARAM_STR);
			$statement->bindValue(':IdPengguna', $this->getAttribute('IdPengguna'), PDO::PARAM_INT);
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
					NamaBarang = :NamaBarang,
					Keterangan = :Keterangan,
					Satuan = :Satuan,
					IdPengguna = :IdPengguna
				WHERE IdBarang = :IdBarang
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaBarang', $this->getAttribute('NamaBarang'), PDO::PARAM_STR);
			$statement->bindValue(':Keterangan', $this->getAttribute('Keterangan'), PDO::PARAM_STR);
			$statement->bindValue(':Satuan', $this->getAttribute('Satuan'), PDO::PARAM_STR);
			$statement->bindValue(':IdPengguna', $this->getAttribute('IdPengguna'), PDO::PARAM_INT);
			$statement->bindValue(':IdBarang', $id, PDO::PARAM_INT);
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
				WHERE NamaBarang LIKE :NamaBarang
				ORDER BY NamaBarang
				LIMIT 10
			";
			$statement = $this->conn->prepare($query);
			$statement->bindValue(':NamaBarang', '%' . $search . '%', PDO::PARAM_STR);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_ASSOC);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function stock($idBarang, $idPenjualan)
	{
		try {
			// Jumlah pembelian
			$queryPembelian = "
				SELECT SUM(JumlahPembelian) jumlah
				FROM Pembelian
				WHERE IdBarang = :IdBarang
			";
			$stmtPembelian = $this->conn->prepare($queryPembelian);
			$stmtPembelian->bindValue(':IdBarang', $idBarang, PDO::PARAM_INT);
			$stmtPembelian->execute();
			$jumlahPembelian = $stmtPembelian->fetch(PDO::FETCH_ASSOC);

			// Jumlah penjualan
			$queryPenjualan = "
				SELECT SUM(JumlahPenjualan) jumlah
				FROM Penjualan
				WHERE IdBarang = :IdBarang
			";
			if ($idPenjualan != "") {
				$queryPenjualan .= " AND IdPenjualan != :IdPenjualan";
			}
			$stmtPenjualan = $this->conn->prepare($queryPenjualan);
			$stmtPenjualan->bindValue(':IdBarang', $idBarang, PDO::PARAM_INT);
			if ($idPenjualan != "") {
				$stmtPenjualan->bindValue(':IdPenjualan', $idPenjualan, PDO::PARAM_INT);
			}
			$stmtPenjualan->execute();
			$jumlahPenjualan = $stmtPenjualan->fetch(PDO::FETCH_ASSOC);

			// Stok
			$stok = $jumlahPembelian['jumlah'] - $jumlahPenjualan['jumlah'];
			return $stok;
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function dashboard()
	{
		try {
			$query = "
				SELECT 
					b.IdBarang ,
					b.NamaBarang ,
					beli.TotalPembelian,
					beli.TotalHargaBeli,
					jual.TotalPenjualan, 
					jual.TotalHargaJual,
					beli.TotalPembelian - jual.TotalPenjualan Stok,
					jual.TotalHargaJual - beli.TotalHargaBeli Laba
				FROM Barang b 
				LEFT JOIN (
					SELECT
						p.IdBarang, 
						SUM(p.JumlahPembelian) TotalPembelian,
						SUM(p.JumlahPembelian * p.HargaBeli) TotalHargaBeli
					FROM Pembelian p 
					GROUP BY 1
				) beli
				ON b.IdBarang = beli.IdBarang
				LEFT JOIN (
					SELECT
						p.IdBarang, 
						SUM(p.JumlahPenjualan) TotalPenjualan,
						SUM(p.JumlahPenjualan * p.HargaJual) TotalHargaJual
					FROM Penjualan p 
					GROUP BY 1
				) jual
				ON b.IdBarang = jual.IdBarang
				ORDER BY 1
			";
			$statement = $this->conn->prepare($query);
			$statement->execute();
			return $statement->fetchall(PDO::FETCH_ASSOC);
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}