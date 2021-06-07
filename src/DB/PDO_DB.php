<?php


namespace App\DB;


use PDO;

class PDO_DB {

	public $dbhost, $dbport, $dbuser, $dbpswd, $dbname, $dbcharset; // Данные по подключению к базе
	public $DB; // Указатель на базу данных
	protected $response;
	public $prepare;

	private function __construct() {
		$this->dbhost    = US_DB_HOST;
		$this->dbuser    = US_DB_USER;
		$this->dbpswd    = US_DB_PASS;
		$this->dbname    = US_DB_NAME;
		$this->dbcharset = US_DB_CHARSET;

		$dsn = "mysql:dbname=$this->dbname;host=$this->dbhost;charset=$this->dbcharset";

		$this->DB = new PDO( $dsn, $this->dbuser, $this->dbpswd );
	}

	public function prepare( $sqlExec ) {
		$this->prepare = $this->DB->prepare( $sqlExec, array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ) );

		return $this;
	}

	public function exec( $arrayParam = array() ) {
		$this->prepare->execute( $arrayParam );

		return $this;
	}

	public function getOne() {
		return $this->prepare->fetch( PDO::FETCH_ASSOC );
	}

	public function getAll() {
		return $this->prepare->fetchAll( PDO::FETCH_ASSOC );
	}

	public function query( $sql ) {
		return $this->DB->query( $sql );
	}


	private static $instance;

	public static function instance(): PDO_DB {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}