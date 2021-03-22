<?
include "../_header.php";

$page_title='상품속성명칭설정';
$formType='cs';

$rqry="select ol.mall_name, ol.receiver, ol.goodsnm, ol.ordno, ol.mall_no, ol.no, m.name, m.id from cs_receipt cr
join order_list ol on (cr.order_list_no=ol.no)
left join member m on (cr.admin_no=m.no)
where cr.complete_yn='N' and cr.receipt_type='0' and cr.order_list_no!='0' and cr.return_type in ('1','2','4')
order by cr.no desc";
$rres=$db->query($rqry);
foreach($rres->results as $rv){
	$rloop[]=$rv;
}

foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}
$checked['aslist'][$aslist]="checked";
$checked['cslist'][$cslist]="checked";
$checked['call_type1'][$_GET['call_type1']]="checked";
$checked['call_type2'][$_GET['call_type2']]="checked";
$checked['handlist'][$handlist]="checked";
$checked['returnlist'][$returnlist]="checked";

$selected['ing_type'][$_GET['s_ing_type']]="selected";

$tpl->assign(array(	
	'mall_list' => $mall_list
	,'delivery_list'=>$delivery_list
	,'rloop'=>$rloop
));
    
$tpl->print_('tpl');
?>
