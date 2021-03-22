<?
include "../_header.php";
/*외부 발송건 엑셀출력*/


if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";

//택배사 함수
$delivery_list=get_delivery_info();

/*리스트*/
foreach($_POST['chk_no'] as $k=>$v){
	if($k=="order"){
		$order_param = $db->inqry_param($v);	
	}else if($k=="other" && $_POST['sel_excel_type']=='in'){

		$other_param = $db->inqry_param($v);	

		$qry="SHOW FULL COLUMNS FROM order_list";
		$res=$db->query($qry);
		foreach($res->results as $cv){
			if($cv['Field']=='no'){ $order_columns[]="occ.no";}
			else if($cv['Field']=='order_num'){ $order_columns[]="occ.num as order_num";}
			else if ($cv['Field']=='purchase_price'){ $order_columns[]="occ.price as purchase_price";}
			else if ($cv['Field']=='ent_deli_price'){ $order_columns[]="occ.deli_price as ent_deli_price";}
			else if ($cv['Field']=='reg_date'){ $order_columns[]="occ.reg_date";}
			else if ($cv['Field']=='mod_date'){ $order_columns[]="occ.reg_date as mod_date";}
			else if ($cv['Field']=='goodsnm'){ $order_columns[]="g.goodsnm";}
			else{
				if(strpos($cv['Type'], 'int') !== false){
					$order_columns[]="'0' as ".$cv['Field'];
				}else{
					$order_columns[]="'' as ".$cv['Field'];
				}
				
			}
		}
		/*
		if($_POST['sel_excel_type']=="in"){
			$other_where=" and occ.data_type='stock' ";
		}else if ($_POST['sel_excel_type']=="out"){
			$other_where=" and occ.data_type='return' ";
		}
		*/

		$other_where=" and occ.data_type in('stock','return')";

		$union_qry="union
		select 'other' as stype,occ.data_type data_type, ".implode(',',$order_columns).",ml.mall_code,ml.wms_mallnm company_name, ml.c_mem_name, ml.d_code, ml.d_name, b.brandnm, '' as sales_code
		from other_cost_calcu occ
		left join goods g on (occ.goodsno=g.no)
		left join brand b on (g.brandno=b.no)
		left join mall_list ml on (ml.d_code=occ.d_code)
		where occ.no in (".implode(",",$other_param).")
		".$other_where."
		";
	}
}

if(!$order_param)$order_param=array(0);

//$param = $db->inqry_param($_POST['chk_no']);

$qry="select 'order' as stype,'order' as data_type,ol.*,ml.mall_code,ml.wms_mallnm company_name, ml.c_mem_name, ml.d_code, ml.d_name, b.brandnm,
(select sales_code from mall_list ml2 where ml2.no=ol.mall_no) as sales_code
from order_list ol
left join goods g on (ol.goodsno=g.no)
left join brand b on (ol.outside_brand=b.no)
left join mall_list ml on (ml.d_code=ol.ent_code)
where ol.no in (".implode(",",$order_param).")
".$add_where."
".$union_qry."
order by reg_date desc,no desc
";

$res = $db->query($qry);

$bf_ordno='';
$color_key=0;
$list_num=1;
foreach($res->results as $v){

    $v['tot_price']=$v['settle_price'];
	if($v['step']=='60'){
		$v['settle_price']='0';
	}
	
	$v['mod_date']=substr($v['mod_date'],0,10);
	//$v['mod_date']=date('Y-m-d',strtotime($v['mod_date']));
	
	$v['ent_deli_price']=round($v['ent_deli_price']/$v['order_num'],2);
	$v['purchase_price']=$v['purchase_price']+$v['ent_deli_price'];

	if(($v['step']=='61' && $v['data_type']=='order')  || $v['data_type']=='return'){
		$v['purchase_price']=$v['purchase_price']*-1;
		$v['settle_price']=$v['settle_price']*-1;
	}

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));


$tpl->print_('tpl');
?>
