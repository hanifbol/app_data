-- HakAkses definition

CREATE TABLE `HakAkses` (
  `IdAkses` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NamaAkses` varchar(100) NOT NULL,
  `Keterangan` text,
  PRIMARY KEY (`IdAkses`),
  UNIQUE KEY `HakAkses_UN` (`NamaAkses`)
);


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