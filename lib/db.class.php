<?php

class DB {

    private static $instance = null;
    private $pdo;
    private $query;
    public $results;
    public $count = 0;
	public $inparam = array();
    private $error = false;

    private $query_string = "";
    private $bindValues = array();
	private $bindqry;
    public $lastId;

	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;

	protected $stmt;

	function __construct($iniFile) {
		include $iniFile;
		
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_name = $db_name;

		$options = [
		  PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
		  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
		  //PDO::ATTR_ERRMODE            => PDO::ERRMODE_WARNING , //turn on errors in the form of exceptions
		  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
		];



        try {
            // Put your database information
            $this->pdo = new PDO("mysql:host=$this->db_host;dbname=$this->db_name","$this->db_user","$this->db_pass",$options);
			$this->pdo->exec("set names utf8");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
		
    }
	
	
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
	
    public function query($sql, $parameters = array(),$own='') {
        $this->error = false;
		
        if ($this->query = $this->pdo->prepare($sql)) {

			//파라미터 갯수가 맞지 않으면 에러남.
            foreach ($parameters as $key=>$param) {	
                $this->query->bindValue($key, $param);
            }
			//$st->setFetchMode(PDO::FETCH_ASSOC); 패치 모드로 설정
			
            if ($this->query->execute()) {
				$this->qry_log('qry',$sql,$parameters,$own);
				
               // You can PDO::FETCH_OBJ instad of assoc, or whatever you like
				$this->results = $this->query->fetchAll();
                $this->count = $this->query->rowCount();
                $this->lastId = $this->pdo->lastInsertId();
			
            } else {
				
                $this->error = true;
				tydebug("class:".$this->error());
            }
        }
			
        return $this;
    }

	function inqry_param($arr_inqry){ //배열을 받아 pdo bindvalue 형태로 변경해줌.
		
		$this->inparam = array_combine(
			array_map(function($i){ return ':id'.$i; }, array_keys($arr_inqry)),
			$arr_inqry
		);

		return $this->inparam;
	}


	function qry_log( $VarName ,$contents,$contents2 ,$file_id = '' ){
		
		global $_SERVER;

		$arr_chk = explode(" ",trim( $contents ) );
		//tydebug($contents);
		if( strtolower($arr_chk[0]) != "select"){
		//tydebug('log');
			$filename = dirname(__FILE__)."/../logs/debug".date("ymd")."_".$file_id.".txt";
			//$filename = "/ukk/logs/debug".date("ymd")."_".$file_id.".txt";
			
			$fileHandler = fopen($filename , "a");
			fwrite ($fileHandler, date("y-m-d H:i:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$_SESSION['sess']['m_id'] ."\t".$_SERVER['HTTP_USER_AGENT']
				."\r\n"		.$_SERVER['PHP_SELF']	."\t"	.$_SERVER['HTTP_REFERER'] 	."\t".$VarName."\t" );
			@fwrite ($fileHandler, "\r\n");
			@fwrite ($fileHandler, $contents );
			@fwrite ($fileHandler, "\r\n");
			@fwrite ($fileHandler, implode(":",$contents2) );
			@fwrite ($fileHandler, "\r\n");
			@fclose ($fileHandler);
			//chown($filename,'apache');
		}
	}

    public function prepare($query){
		
		$this->bindqry=$query;
        $this->stmt = $this->pdo->prepare($query);
    }

	public function bindValue(array $params)
    {
        if (!empty($params)) {

            foreach ($params as $key => $val) {
               $this->stmt->bindValue($key, $val);
            }
        }
    }
    public function execute(array $param = array())
    {
        if (is_array($param) && !empty($param)) {
					
			$this->qry_log('execute',$this->bindqry,$param);

            foreach ($param as $key => $val) {
                $this->stmt->bindValue($key, $val);
            }
        }
        return $this->stmt->execute();
    }


    public function fetchAll($args = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetchAll($args);
    }
    public function fetch($args = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetch($args);
    }


    public function getQueryString() {
        return $this->query_string;
    }

    public function results() {
        return $this->results;
    }
    public function first() {
        return $this->results[0];
    }
    public function last() {
        return $this->results[$this->count-1];
    }
    public function row($id) {
        return $this->results[$id];
    }
    public function error() {
        //return $this->error();
		return $this->query->errorInfo();
    }
    public function count() {
        return $this->count;
    }
    public function lastId() {
        return $this->lastId;
    }
	
	public function beginTransaction(){
        return $this->pdo->beginTransaction();
    }
    public function commit(){
        return $this->pdo->commit();
    }
    public function rollBack(){
        return $this->pdo->rollBack();
    }

    public function errorInfo()
    {
        $error = $this->stmt->errorInfo();
        $this->error = $error[0] . ' ' . $error[2];
    }
    public function close()
    {
        $this->pdo = null;
    }

/*
    public function bindValue($placeholder, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($placeholder, $value, $type);
    }
*/

}

