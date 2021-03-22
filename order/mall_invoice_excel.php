<?
include "../_header.php";

$sel_invo_mall=$_POST['sel_invo_mall'];


/*

CJGLS
KGB
HANJIN
EPOST
HYUNDAI

CJ대한통운 :  055
로젠택배 : 007
한진택배 : 004
우체국 : 009
롯데택배 :  002
*/

$deli_to_code=array("CJGLS"=>"055","KGB"=>"007","HANJIN"=>"004","EPOST"=>"009","HYUNDAI"=>"002")

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);	

$qry="select o.*,ml.mall_code,ml.wms_mallnm company_name from order_list o
join mall_list ml on o.mall_no=ml.no

where o.no in (".implode(",",array_keys($param)).")
and o.upload_form_type=:upload_form_type
".$add_where."
";

$param[':upload_form_type']=$_POST['sel_invo_mall'];
$res = $db->query($qry,$param);

foreach($res->results as $v){

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>