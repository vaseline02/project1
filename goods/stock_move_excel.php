<?
include "../_header.php";
$codedata=get_codedata('place');

/*리스트*/
$qry="select sml.*, g.goodsnm as g_goodsnm from 
stock_move_log sml
left join goods g on (sml.goodsno=g.no)
where DATE_FORMAT(sml.reg_date,'%Y-%m-%d') between '".$_POST['s_date']."' and '".$_POST['e_date']."'
order by sml.reg_date desc
";

$res = $db->query($qry);


foreach($res->results as $v){
	$v['s_name']="";
	$v['e_name']="";
	foreach($codedata as $cv){
		if($cv['no']==$v['s_move']) $v['s_name']=$cv['cd'];
		if($cv['no']==$v['e_move']) $v['e_name']=$cv['cd'];
	}
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>