<?php
include "../_header.php";
//load.php

$qry = "SELECT * FROM calendar where date_from <= '".$_POST['date_to']."' and date_to >= '".$_POST['date_from']."' ";

$res=$db->query($qry);


foreach($res->results as $row){
	$data[]=$row;
}
echo json_encode($data);

?>