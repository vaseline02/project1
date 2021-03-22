<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
$page_title='반품리스트';

//몰명리스트 함수
$mall_list=get_mall_info();

$mode=$_POST["mode"];
$no=$_POST["no"];
$QUERY_STRING = $_SERVER['QUERY_STRING'];

$selected['date_type'][$_GET['date_type']]="selected";

if($_GET['s_date'] && $_GET['e_date']){
    $where[]="DATE_FORMAT(ssl2.reg_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
	
    $qry="select * from (select ssl2.type, ssl2.reg_date, gcl.*, 
    g.goodsnm as goodsnm,
    CASE
        WHEN (DATE_FORMAT(ssl2.reg_date, '%H')>'00' && DATE_FORMAT(ssl2.reg_date, '%H')<'12' )
        THEN '오전'
        ELSE '오후'
    END as time_group
    from stock_soldout_log ssl2
    left join goods g on (ssl2.goodsno=g.no)
    left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
    where ".implode(" and ", $where)."
    group by DATE_FORMAT(ssl2.reg_date,'%Y-%m-%d'), ssl2.type, ssl2.goodsno, time_group 
    ) v order by v.reg_date desc
    ";

    $res=$db->query($qry);
    foreach($res->results as $v){
        if($v['type']=="0")$v['typenm']="주문등록품절";
        elseif($v['type']=="1")$v['typenm']="출고후품절";

        $v['psd_stock']=goods_psd_stock($v['goodsno']);

        $loop[]=$v;
    }
}

$tpl->assign(array(	
	'loop' => $loop
));
    
$tpl->print_('tpl');
?>
