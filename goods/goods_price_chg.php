<?
include "../_header.php";

$page_title='금액변경로그';
$popup_chk=1; //메뉴 컨트롤

$qry="select gil.*, g.goodsnm, m.name from goods g
left join goods_info_log gil on (g.no=gil.goods_no and gil.colum_name='consumer_price')
left join member m on (gil.admin_no=m.no)
where g.no='".$_GET['goodsno']."'
order by gil.reg_date desc limit 30 
";


$res = $db->query($qry);
foreach($res->results as $v){
	$goodsnm_title=$v['goodsnm'];
	$loop[]=$v;	
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
