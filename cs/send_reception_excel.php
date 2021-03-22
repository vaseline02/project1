<?
include "../_header.php";

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);

$qry="select 
o.*
,ml.mall_code,ml.wms_mallnm company_name
,ci.contents as cs_memo, ci.reg_date as cs_reg_date, m.name as admin_name, ci.return_type, ci.return_type_sub, ci.receiver as cs_receiver
,ci.delivery_type, ci.delivery_type2, ci.delivery_price, ci.delivery_price2 
from 
cs_detail cd
join cs_info ci on cd.cs_info_no=ci.no
join order_list o on cd.order_list_no=o.no
join mall_list ml on o.mall_no=ml.no
left join member m on (ci.admin_no=m.no)
where cd.no in (".implode(",",array_keys($param)).")
";

$res = $db->query($qry,$param);


foreach($res->results as $v){
    
    $v['return_type_nm']=$cfg_retrun_type_sub[$v['return_type']][$v['return_type_sub']];
    $delivery_price=$v['delivery_price']?$v['delivery_price']:"";
    $delivery_price2=$v['delivery_price2']?$v['delivery_price2']:"";

    $v['delivery_info']=$delivery_price2.$cfg_return_delivery_type[$v['delivery_type']]."/".$delivery_price2.$cfg_return_delivery_type2[$v['delivery_type2']];
    $v['tot_price']=$v['settle_price'];

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>