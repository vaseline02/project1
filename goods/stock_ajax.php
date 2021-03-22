<?php
include "../_header.php";


$mode=$_POST['mode'];
if($mode=="goodsCheck"){
	$goodsnm=$_POST['goodsnm'];
	
	$codedata=get_codedata('place','1');
    $cntArray="";
    foreach($codedata as $v){
        $cntArray[]="gcl.codeno_".$v['no'];        
    }
    if(count($cntArray)) $sumCnt=", (".implode("+",$cntArray).") as totalCnt";

	$qry="select count(g.no) as cnt, g.stock_yn, g.no ".$sumCnt."  from goods g left join goods_cnt_loc gcl on (g.no=gcl.goodsno) where g.goodsnm='".$goodsnm."'";
    $res = $db->query($qry);
    $data=$res->results[0];


    echo json_encode($data);
}else if($mode=="stockCheck"){

	$goodsnm=$_POST['goodsnm'];
	$place_code=$_POST['place_code'];

	$qry="select count(g.no) as cnt, g.stock_yn, g.no, gcl.codeno_".$place_code." as stockno from goods g left join goods_cnt_loc gcl on (g.no=gcl.goodsno) where g.goodsnm='".$goodsnm."'";
    $res = $db->query($qry);
    $data=$res->results[0];


    echo json_encode($data);
}
?>