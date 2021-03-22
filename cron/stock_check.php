<?
include "../_header.php";

$qry="select gcl.goodsno, gcl.cur_cnt  from goods_cnt_loc gcl limit 1000";
$res=$db->query($qry);

foreach($res->results as $v){
    $sqry="select sum(sl.now_cnt) as sumcnt, count(goodsno) as gcnt, sl.goodsno as slgoodsno  from stock_list sl where goodsno='".$v['goodsno']."' group by goodsno";
    $sres=$db->query($sqry);
    $data=$sres->results[0];
    $data["gcl_goodsno"]=$data["slgoodsno"];
    $data["goodsno"]=$v["goodsno"];
// tydebug($data);
    if(($v['cur_cnt']!=$data['sumcnt']) || !$data['gcnt']){
        tydebug($data);
    }

}

//$qry="select * from goods_cnt_loc gcl ";

?>