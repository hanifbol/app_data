-- HakAkses definition

CREATE TABLE `HakAkses` (
  `IdAkses` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NamaAkses` varchar(100) NOT NULL,
  `Keterangan` text,
  PRIMARY KEY (`IdAkses`),
  UNIQUE KEY `HakAkses_UN` (`NamaAkses`)
);

INSERT INTO HakAkses (NamaAkses,Keterangan) VALUES
	 ('Common','Default user access'),
	 ('Admin','Application administrator');

-- Pemasok definition

CREATE TABLE `Pemasok` (
  `IdPemasok` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NamaPemasok` varchar(100) NOT NULL,
  `AlamatPemasok` text,
  `NoTelepon` varchar(32) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IdPemasok`),
  UNIQUE KEY `Pemasok_UN` (`NamaPemasok`)
);

INSERT INTO Pemasok (NamaPemasok,AlamatPemasok,NoTelepon,Email) VALUES
	 ('PT. Makanan Sehat','Jakarta','0879546213','sehat@mail.com');

-- Pelanggan definition

CREATE TABLE `Pelanggan` (
  `IdPelanggan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NamaPelanggan` varchar(100) NOT NULL,
  `AlamatPelanggan` text,
  `NoTelepon` varchar(32) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IdPelanggan`),
  UNIQUE KEY `Pelanggan_UN` (`NamaPelanggan`)
);

INSERT INTO Pelanggan (NamaPelanggan,AlamatPelanggan,NoTelepon,Email) VALUES
	 ('Andi','Jakarta','025847369','andi@mail.com');

-- Pengguna definition

CREATE TABLE `Pengguna` (
  `IdPengguna` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NamaPengguna` varchar(100) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `NamaDepan` varchar(100) DEFAULT NULL,
  `NamaBelakang` varchar(100) DEFAULT NULL,
  `NoHp` varchar(100) DEFAULT NULL,
  `Alamat` text,
  `IdAkses` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdPengguna`),
  UNIQUE KEY `Pengguna_UN` (`NamaPengguna`),
  KEY `Pengguna_FK` (`IdAkses`),
  CONSTRAINT `Pengguna_FK` FOREIGN KEY (`IdAkses`) REFERENCES `HakAkses` (`IdAkses`)
);

INSERT INTO Pengguna (NamaPengguna,Password,NamaDepan,NamaBelakang,NoHp,Alamat,IdAkses) VALUES
	 ('admin','$2y$10$gJdjmV3N2MLw8HgMLnEM2e10bBfUDK4BfeVxc3yrBD7N/B4dZlx4G','Admin','Aplikasi','000','Jakarta',2);

-- Barang definition

CREATE TABLE `Barang` (
  `IdBarang` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NamaBarang` varchar(100) NOT NULL,
  `Keterangan` text,
  `Satuan` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `IdPengguna` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdBarang`),
  UNIQUE KEY `Barang_UN` (`NamaBarang`),
  KEY `Barang_FK` (`IdPengguna`),
  CONSTRAINT `Barang_FK` FOREIGN KEY (`IdPengguna`) REFERENCES `Pengguna` (`IdPengguna`) ON DELETE CASCADE
);

INSERT INTO Barang (NamaBarang,Keterangan,Satuan,IdPengguna) VALUES
	 ('Citato 100gr Original','Makanan','PCE',1),
	 ('Citato 100gr BBQ','Makanan','PCE',1),
	 ('Oreo 75gr Red Valvet','Makanan','PCE',1),
	 ('Oreo 75gr Kacang','Makanan','PCE',1),
	 ('Oreo 75gr Coklat','Makanan','PCE',1),
	 ('Slai 2000gr Jambu','Makanan','PCE',1),
	 ('Slai 2000gr Mangga','Makanan','PCE',1),
	 ('Slai 2000gr Leci','Makanan','PCE',1),
	 ('Pocky 150gr Keju','Makanan','PCE',1),
	 ('Pocky 150gr Coklat','Makanan','PCE',1);

-- Pembelian definition

CREATE TABLE `Pembelian` (
  `IdPembelian` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdBarang` bigint unsigned NOT NULL,
  `JumlahPembelian` double NOT NULL,
  `HargaBeli` double NOT NULL,
  `IdPemasok` bigint unsigned DEFAULT NULL,
  `IdPengguna` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdPembelian`),
  KEY `Pembelian_FK` (`IdBarang`),
  KEY `Pembelian_FK_1` (`IdPengguna`),
  KEY `Pembelian_FK_2` (`IdPemasok`),
  CONSTRAINT `Pembelian_FK` FOREIGN KEY (`IdBarang`) REFERENCES `Barang` (`IdBarang`),
  CONSTRAINT `Pembelian_FK_1` FOREIGN KEY (`IdPengguna`) REFERENCES `Pengguna` (`IdPengguna`),
  CONSTRAINT `Pembelian_FK_2` FOREIGN KEY (`IdPemasok`) REFERENCES `Pemasok` (`IdPemasok`)
);

INSERT INTO Pembelian (IdBarang,JumlahPembelian,HargaBeli,IdPemasok,IdPengguna) VALUES
	 (1,5.0,1000.0,1,1),
	 (2,15.0,2000.0,1,1),
	 (3,20.0,3000.0,1,1),
	 (4,10.0,4000.0,1,1),
	 (5,5.0,5000.0,1,1),
	 (6,5.0,6000.0,1,1),
	 (7,10.0,7000.0,1,1),
	 (8,20.0,8000.0,1,1),
	 (9,25.0,9000.0,1,1),
	 (10,15.0,10000.0,1,1),
	 (1,10.0,1000.0,1,1),
	 (2,15.0,2000.0,1,1),
	 (3,35.0,3000.0,1,1),
	 (4,20.0,40000.0,1,1),
	 (5,25.0,5000.0,1,1),
	 (6,20.0,6000.0,1,1),
	 (7,15.0,7000.0,1,1),
	 (8,15.0,8000.0,1,1),
	 (9,15.0,9000.0,1,1),
	 (10,10.0,10000.0,1,1);

-- Penjualan definition

CREATE TABLE `Penjualan` (
  `IdPenjualan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdBarang` bigint unsigned NOT NULL,
  `JumlahPenjualan` double NOT NULL,
  `HargaJual` double NOT NULL,
  `IdPelanggan` bigint unsigned NOT NULL,
  `IdPengguna` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdPenjualan`),
  KEY `Penjualan_FK` (`IdBarang`),
  KEY `Penjualan_FK_1` (`IdPelanggan`),
  KEY `Penjualan_FK_2` (`IdPengguna`),
  CONSTRAINT `Penjualan_FK` FOREIGN KEY (`IdBarang`) REFERENCES `Barang` (`IdBarang`),
  CONSTRAINT `Penjualan_FK_1` FOREIGN KEY (`IdPelanggan`) REFERENCES `Pelanggan` (`IdPelanggan`),
  CONSTRAINT `Penjualan_FK_2` FOREIGN KEY (`IdPengguna`) REFERENCES `Pengguna` (`IdPengguna`)
);

INSERT INTO Penjualan (IdBarang,JumlahPenjualan,HargaJual,IdPelanggan,IdPengguna) VALUES
	 (1,5.0,2000.0,1,1),
	 (2,20.0,3000.0,1,1),
	 (3,30.0,4000.0,1,1),
	 (4,10.0,5000.0,1,1),
	 (5,15.0,6000.0,1,1),
	 (6,15.0,7000.0,1,1),
	 (7,5.0,8000.0,1,1),
	 (8,15.0,9000.0,1,1),
	 (9,30.0,11000.0,1,1),
	 (10,5.0,10000.0,1,1),
	 (1,5.0,2000.0,1,1),
	 (2,10.0,3000.0,1,1),
	 (3,10.0,4000.0,1,1),
	 (4,20.0,50000.0,1,1),
	 (5,5.0,6000.0,1,1),
	 (6,5.0,7000.0,1,1),
	 (7,15.0,8000.0,1,1),
	 (8,10.0,9000.0,1,1),
	 (9,10.0,10000.0,1,1),
	 (10,15.0,11000.0,1,1);