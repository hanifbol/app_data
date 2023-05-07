<?php session_start();
require_once __DIR__ . "/../../config/db.php";

class Model {
	protected $table = "";
	protected $primary_key = "";
	protected $attributes = [];

	/* Properties */
	protected $conn;

	/* Get database access */
	public function __construct() {
		$db = new database();
		$this->conn = $db->koneksidatabase();
	}

	public function setAttribute($attribute, $value) {
		$this->$attribute = $value;
	}

	public function getAttribute($attribute) {
		return $this->$attribute;
	}

	public function list() {
		$query = "SELECT * FROM $this->table";
		$prepareDB = $this->conn->prepare($query);
		$prepareDB->execute();
		$result = $prepareDB->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function find($id) {
		try {
			$query = "SELECT * FROM $this->table WHERE $this->primary_key = ?";
			$prepareDB = $this->conn->prepare($query);
			$prepareDB->execute([$id]);
			$result = $prepareDB->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (Exception $e) {
			throw $e;
		}
	}

	function delete($id) {
		try {
			$query = "DELETE FROM $this->table WHERE $this->primary_key = ?";
			$prepareDB = $this->conn->prepare($query);
			$RolesDelete = $prepareDB->execute([$id]);
			return $RolesDelete;
		} catch (Exception $e) {
			throw $e;
		}
	}
}