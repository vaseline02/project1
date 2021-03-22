<?
include "../_header.php";

$page_title='행사가격 로그';

$popup_chk=1; //메뉴 컨트롤
$goodsno=$_GET['goodsno'];

$QUERY_STRING = $_SERVER['QUERY_STRING'];
$qry="select gspl.*, g.goodsnm, m.name, m.id from goods_sale_period_log gspl
left join goods g on (gspl.goodsno=g.no)
left join member m on (gspl.admin_no=m.no)
where goodsno='".$goodsno."' group by reg_date, price, price_type  order by no desc";
$res=$db->query($qry);
foreach($res->results as $v){
    $loop[]=$v;
}

$tpl->assign(array(
    'loop'=>$loop    
));

$tpl->print_('tpl');
?>
