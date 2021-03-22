<?php

class BOARD{

	function __construct(){
		global $cfg, $db ,$_SESSION;

		$this->cfg = $cfg;
		$this->db = $db;
		$this->sess = $_SESSION['sess'];
	}

	function load_data($board_id='se',$limit){
		
		if($limit)$limit=" limit ".$limit;
		$qry="select * from board_default where board_id=:board_id and status='none' order by regdt desc ".$limit." ";
		$param[":board_id"]=$board_id;
		$res=$this->db->query($qry,$param);

		return $res->results;
	}
}

?>