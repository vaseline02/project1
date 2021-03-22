<?php
include "../_header.php";


$mode=$_POST['mode'];
if($mode=='infoCheck'){
    $ordno=$_POST['ordno'];
    
    $qry="select count(no) as cnt from cs_info where order_no='".$ordno."'";
    $res = $db->query($qry);
    $data=$res->results[0];

    echo json_encode($data);
}else if($mode=="returnType"){
    $no=$_POST['no'];
    echo json_encode($cfg_retrun_type_sub[$no]);
}else if($mode=="receiptType"){
    $no=$_POST['no'];
    echo json_encode($cfg_receipt_type_sub[$no]);
}else if($mode=="goodsCheck"){
    $no=$_POST['no'];
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
}else{
    $no=$_POST['no'];

    $qry="select * from cs_info where no='".$no."'";
    $res = $db->query($qry);
    $data=$res->results[0];

    $dqry="select * from cs_detail where cs_info_no='".$data['no']."'";
    $dres = $db->query($dqry);
    $data['detail']=$dres->results;

    echo json_encode($data);
}
?>