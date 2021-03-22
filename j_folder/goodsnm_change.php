<?
include "../_header.php";
//key : 변경전모델명  value : 변경후모델명
$goodsnm=array(
    "AG683-11"=>"BB98 AG683-11"
   ,"AG056-01"=>"BB06 AG056-01"
   ,"AG682-11"=>"BB88 AG682-11"
   ,"AG682-16"=>"BB88 AG682-16"
   ,"AG421-01"=>"BB88 AG421-01"
   ,"AG421-15"=>"BB88 AG421-15"
 
);
//key : 테이블명 value : 컬럼명
$table_array=array(
    "as_detail"=>"goodsnm"
    ,"cs_bad"=>"goodsnm"
    ,"cs_receipt"=>"goodsnm"
    ,"cs_detail"=>"exchange_goods_nm"
    ,"goods_barcode"=>"goodsnm"
    ,"goods_barcode_print"=>"goodsnm"
    ,"import_licence"=>"goodsnm"
    ,"stock_quick"=>"goodsnm"
    ,"stock_move_log"=>"goodsnm"
    ,"stock_list"=>"goodsnm"
    ,"stock_io_log"=>"goodsnm"
    ,"stock_hold"=>"goodsnm"
    ,"stock_cron"=>"goodsnm"
    ,"stock_change_log"=>"goodsnm"
    ,"outside_return_log"=>"goodsnm"
    ,"outside_goods"=>"goodsnm"
    ,"order_list"=>"goodsnm"
);
try{				
    $db->beginTransaction();
	
    $goodscnt=0;
    $tablecnt=0;
    foreach($goodsnm as $gk=>$gv){
        foreach($table_array as $tk=>$tv){
            $qry="update ".$tk." set ".$tv."='".$gv."' where ".$tv."='".$gk."'";
            $db->query($qry);
            $tablecnt++;
        }
        $goodscnt++;
    }

    //$db->rollBack();
    $db->commit();

    tydebug("총업데이트상품수 : ".$goodscnt.", 총업데이트테이블수 : ".$tablecnt);
   
}
catch( Exception $e ){
    tydebug('err');
    $db->rollBack();
    tydebug($e->getMessage().":".$e->getFile());	
}

?>
