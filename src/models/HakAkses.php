<?php
require_once __DIR__ . "/Model.php";

class HakAkses extends Model {
	protected $table = "HakAkses";
	protected $primary_key = "IdAkses";
	protected $attributes = [
		"NamaAkses",
		"Keterangan",
	];
}