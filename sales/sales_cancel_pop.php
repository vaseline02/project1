<?
include "../_header.php";

$page_title='취소주문';

$popup_chk=1; //메뉴 컨트롤
//취소
$qry="select ol.* from order_list ol 
where ol.mod_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59' and ol.mall_no='".$_GET['mall_no']."' and step2 between 39 and 100 
order by mod_date desc
";				
$res = $db->query($qry);
foreach($res->results as $v){
    $loop[]=$v;
}

$tpl->assign(array(
   'loop'=>$loop    
));
$tpl->print_('tpl');
?>
