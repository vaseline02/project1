<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);

//tydebug("1");
//stock_io('order','1','YA134501',-1,0,$_SERVER['REQUEST_URI'],'51');

#코드데이터 업데이트
// $qry="SELECT tc.*, c.no as cno FROM timemecca1.codedata tc left join codedata c on(tc.type=c.type and tc.cd=c.cd) where tc.type!='MENU' and c.no is null ";
// $res=$db->query($qry);
// foreach($res->results as $v){
    
// tydebug($v);
// }

// exit;

#LG패션 셀피아, 신규erp재고 공유용 없음
#상품이 없는경우 있음(6295 : 단종, 24152 : 상품없음, 24153 : 상품없음)
$qry="SELECT s.*, g.no as gno, g.goodsnm, cd.no as cdno FROM timemecca_test2.stock s 
left join goods g on (s.m_no=g.no)
left join codedata cd on (s.place=cd.cd and cd.type='PLACE')
where DATE(s.save_time)>='2020-01-01'
and s.no>='2295305'
#and g.no is null
#and cd.no is null
#group by customer
order by s.no asc
";
$res=$db->query($qry);
foreach($res->results as $v){

    if(!$v['gno']) tydebug($v);
    
    $sqry="select count(no) as cnt from stock_io_log where reference_page='timemecca_stock' and reference_no='".$v['no']."'";
    $sres=$db->query($sqry);

    if($sres->results[0]['cnt']) continue;

    if($v['io']=='IN'){
        $cnt=$v['cnt'];
    }else{
        $cnt="-".$v['cnt'];
    }
    $iqry="INSERT INTO stock_io_log SET
    goodsno=:goodsno
    ,goodsnm=:goodsnm
    ,io_type=:io_type
    ,cnt=:cnt
    ,loc_cnt=:loc_cnt
    ,cur_cnt=:cur_cnt
    ,loc_b=:loc_b
    ,loc_f=:loc_f
    ,stock_yn=:stock_yn
    ,reference_page=:reference_page
    ,reference_no=:reference_no
    ,memo=:memo
    ,memo2=:memo2
    ,m_no=:m_no
    ,reg_date=:reg_date
    ";

    $param[":goodsno"]=$v['gno']?$v['gno']:"0";
    $param[":goodsnm"]=$v['goodsnm']?$v['goodsnm']:"";
    $param[":io_type"]='timemecca';
    $param[":cnt"]=$cnt;
    $param[":loc_cnt"]='0';
    $param[":cur_cnt"]='0';
    $param[":loc_b"]='0';
    $param[":loc_f"]=$v['cdno'];
    $param[":stock_yn"]='y';
    $param[":reference_page"]=$v['customer'];
    $param[":reference_no"]=$v['no'];
    $param[":memo"]=$v['invoice'];
    $param[":memo2"]=$v['memo'];
    $param[":m_no"]='0';
    $param[":reg_date"]=$v['save_time'];

    //tydebug($qry);
    //tydebug($param);
    $db->query($iqry,$param);
}
?>