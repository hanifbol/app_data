<?php
include __DIR__ . "/config.php";

class database {
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbnm = DB_NAME;

	function koneksidatabase() {
		try {
			// buat koneksi dengan database
			$dbh = new PDO("mysql:host=$this->host;dbname=$this->dbnm", $this->user, $this->pass);
			
			// set error mode
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbh;
		} catch (PDOException $e) {
			// tampilkan pesan kesalahan jika koneksi gagal
			echo "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
			die();
		}
	}
}
?>