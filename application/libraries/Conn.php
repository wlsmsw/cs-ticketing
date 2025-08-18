<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* ===================================================
* Database connection class using PDO
* @author Resty Alejo
* @version 1.0.0
* ===================================================
*/

class Conn {

	protected $conn;

	private $_driver;
	private $_host;
	private $_user;
	private $_pass;
	private $_db;

	public function __construct() {
		$this->_conn();
	}

	/**
	* Set database connection credentials
	*/
	private function __config() {
		$path = APPPATH . "config.ini";
		if(!file_exists($path)) {
			throw new Exception("Config file not exist in " . $path, 1);
		} else {
			$config = parse_ini_file($path);
			if($_SERVER['SERVER_NAME'] == 'mswlive.com' || $_SERVER['SERVER_NAME'] == 'affiliate.mswlive.com') {
				$this->_driver = $config['prod_driver'];
				$this->_host = $config['prod_host'];
				$this->_user = $config['prod_user'];
				$this->_pass = $config['prod_pass'];
				$this->_db = $config['prod_db'];
			} elseif($_SERVER['SERVER_NAME'] == 'mswsites.com') {
				$this->_driver = $config['stg_driver'];
				$this->_host = $config['stg_host'];
				$this->_user = $config['stg_user'];
				$this->_pass = $config['stg_pass'];
				$this->_db = $config['stg_db'];
			} else {
				$this->_driver = $config['local_driver'];
				$this->_host = $config['local_host'];
				$this->_user = $config['local_user'];
				$this->_pass = $config['local_pass'];
				$this->_db = $config['local_db'];
			}
		}
	}

	/**
	* Set PDO connection
	* @param string $driver
	* @param string $host
	* @param string $db
	* @param string $user
	* @param string $pass
	*/
	public function _conn() {
		try {
			$this->__config();
			$this->conn = new PDO($this->_driver . ':host=' . $this->_host . ';dbname=' . $this->_db . ';charset=utf8', $this->_user, $this->_pass, array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));

			return $this->conn;
		} catch (Exception $e) {
			//echo "Error!: " . $e->getMessage() . "<br/>";
			echo "<h1>Error establishing a database connection.</h1>";
			die();
		}
	}

	/**
	* Close PDO connection
	*/
	public function _close() {
		$this->conn = null;
	}

	/**
	* Insert/Update of data
	* @param string $query
	* @param array $param
	* @return mixed
	*/
	public function query($query, $param = null, $multiple = false, $fetchmode = PDO::FETCH_ASSOC) {
		try {
			$db = $this->_conn();
			$query = trim($query);

			if($multiple) {
				if(!empty($param)) {
					$count = 0;
					$db->beginTransaction();
					$stmt = $db->prepare($query);
					foreach($param as $row) {
						if($stmt->execute($row)) $count++;
					}
					$db->commit();
					return $count;
				}
			} else {
				$stmt = $db->prepare($query);
				$stmt->execute($param);
			}


			$raw = explode(" ", $query);
			$statement = strtolower($raw[0]);

			if($statement === 'select' || $statement === 'show') {
				return $stmt->fetchAll($fetchmode);
			} elseif($statement === 'insert') {
				return $db->lastInsertId();
				//return $stmt->rowCount();
			} elseif($statement === 'update' || $statement === 'delete') {
				return $stmt->rowCount();
			} else {
				return NULL;
			}
		} catch (Exception $e) {
			echo "There is some problem in connection: " . $e->getMessage();
		}
	}

	/**
	* Clean data
	* @param string $data
	* @return string
	*/
	public function clean($data) {
		$data = htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');

		return $data;
	}

}