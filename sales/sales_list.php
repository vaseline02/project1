<?
include "../_header.php";member_chk();

$page_title='매출관리';
$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("now", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

$mqry="select ml.upload_form_type from mall_list ml where ml.upload_form_type!='' and ml.d2_code!='' group by ml.upload_form_type 
order by 
CASE
WHEN ml.upload_form_type = '셀피아'
THEN 1
WHEN ml.upload_form_type = '타임메카'
THEN 2
WHEN ml.upload_form_type = '스토어팜'
THEN 3
WHEN ml.upload_form_type = 'B2B'
THEN 4
WHEN ml.upload_form_type = '오피셜'
THEN 5
WHEN ml.upload_form_type = '사방넷'
THEN 6
WHEN ml.upload_form_type = '방송'
THEN 7
WHEN ml.upload_form_type = '자체'
THEN 8
ELSE 9
END , mall_name";
$mres=$db->query($mqry);
foreach($mres->results as $v){
	$upload_form_type_loop[]=$v['upload_form_type'];	
}
if($_GET['upload_form_type']){
	foreach($_GET['upload_form_type'] as $uv){
		$checked['upload_form_type'][$uv]="checked";
	}
}
if($_GET['s_date'] && $_GET['e_date']){

	if($_GET['upload_form_type']) $where=" and ml.upload_form_type in ('".implode("','",$_GET['upload_form_type'])."')";
	else  $where=" and ml.upload_form_type in ('".implode("','",$upload_form_type_loop)."')";
	
	$order_where=" and ol.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59' and ol.mall_no=ml.no";
	$cance_where=" and ol.mod_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59' and ol.mall_no=ml.no and step2 >= 40";
	$return_where=" and cd.end_reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59' and ol.mall_no=ml.no  and ci.return_type in ('60','70') and ci.add_type='1' and cd.send_type='4'";

	$mqry="select 
	ml.no
	,ml.mall_name
	,ml.upload_form_type
	,(select if(sum(ol.settle_price),sum(ol.settle_price),0) from order_list ol where 1=1 ".$order_where.") as order_price #주문금액
	,(select if(sum(ol.order_num),sum(ol.order_num),0) from order_list ol where 1=1 ".$order_where.") as order_quantity #주문수량
	,(select if(sum(ol.settle_price),sum(ol.settle_price),0) from order_list ol where 1=1 ".$cance_where.") as cancel_price #취소금액
	,(select if(sum(ol.order_num),sum(ol.order_num),0) from order_list ol where 1=1 ".$cance_where.") as cancel_quantity #취소수량
	
	,(select if(sum(ol.settle_price),sum((ol.settle_price/ol.order_num)*cd.exchange_goods_num),0) from cs_info ci 
	join cs_detail cd on (ci.no=cd.cs_info_no)
	join order_list ol on (ol.no=cd.order_list_no) where 1=1 ".$return_where.") as return_price #반품금액
	,(select if(sum(cd.exchange_goods_num),sum(cd.exchange_goods_num),0) from cs_info ci 
	join cs_detail cd on (ci.no=cd.cs_info_no)
	join order_list ol on (ol.no=cd.order_list_no) where 1=1 ".$return_where.") as return_quantity #반품수량

	from mall_list ml 
	where ml.upload_form_type!=''
	and ml.d2_code!=''
	".$where."
	order by 
	CASE
	WHEN ml.upload_form_type = '셀피아'
	THEN 1
	WHEN ml.upload_form_type = '타임메카'
	THEN 2
	WHEN ml.upload_form_type = '스토어팜'
	THEN 3
	WHEN ml.upload_form_type = 'B2B'
	THEN 4
	WHEN ml.upload_form_type = '오피셜'
	THEN 5
	WHEN ml.upload_form_type = '사방넷'
	THEN 6
	WHEN ml.upload_form_type = '방송'
	THEN 7
	WHEN ml.upload_form_type = '자체'
	THEN 8
	ELSE 9
	END , order_price desc, mall_name ";	
	$mres=$db->query($mqry);

	$sumOrderPrice=0;
	$sumOrderQuantity=0;
	$sumCancelPrice=0;
	$sumCancelQuantity=0;
	foreach($mres->results as $k=>$v){				
		$loop[$v['upload_form_type']][$v['mall_name']]['no']=($k+1);
		$loop[$v['upload_form_type']][$v['mall_name']]['mall_no']=$v['no'];
		$loop[$v['upload_form_type']][$v['mall_name']]['order_price']=$v['order_price'];
		$loop[$v['upload_form_type']][$v['mall_name']]['order_quantity']=$v['order_quantity'];
		$loop[$v['upload_form_type']][$v['mall_name']]['cancel_price']=$v['cancel_price'];
		$loop[$v['upload_form_type']][$v['mall_name']]['cancel_quantity']=$v['cancel_quantity'];
		$loop[$v['upload_form_type']][$v['mall_name']]['return_price']=$v['return_price'];
		$loop[$v['upload_form_type']][$v['mall_name']]['return_quantity']=$v['return_quantity'];


		//합계금액
		$sumOrderPrice+=$v['order_price'];
		$sumOrderQuantity+=$v['order_quantity'];
		$sumCancelPrice+=$v['cancel_price'];
		$sumCancelQuantity+=$v['cancel_quantity'];
		$sumReturnPrice+=$v['return_price'];
		$sumReturnQuantity+=$v['return_quantity'];
	}

/*

	$mqry="select ml.upload_form_type from mall_list ml where ml.upload_form_type!='' group by ml.upload_form_type 
	order by 
	CASE
	WHEN ml.upload_form_type = '셀피아'
	THEN 1
	WHEN ml.upload_form_type = '타임메카'
	THEN 2
	WHEN ml.upload_form_type = '스토어팜'
	THEN 3
	WHEN ml.upload_form_type = 'B2B'
	THEN 4
	WHEN ml.upload_form_type = '오피셜'
	THEN 5
	WHEN ml.upload_form_type = '사방넷'
	THEN 6
	WHEN ml.upload_form_type = '방송'
	THEN 7
	WHEN ml.upload_form_type = '자체'
	THEN 8
	ELSE 9
	END , mall_name";
	$mres=$db->query($mqry);
	$sumOrderPrice=0;
	$sumOrderQuantity=0;
	$sumCancelPrice=0;
	$sumCancelQuantity=0;
	foreach($mres->results as $v){
		$upload_form_type_loop[]=$v['upload_form_type'];
		$mmqry="select ml.no,ml.mall_name from mall_list ml where ml.upload_form_type='".$v['upload_form_type']."' order by ml.mall_name";
		$mmres=$db->query($mmqry);	
		foreach($mmres->results as $vv){
			//주문
			$qry="select if(sum(ol.settle_price),sum(ol.settle_price),0) as price, if(sum(ol.order_num),sum(ol.order_num),0) as quantity from order_list ol 
			where ol.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59' and ol.mall_no='".$vv['no']."'		
			";				
			$res = $db->query($qry);
			$sumData=$res->results[0];
			$loop[$v['upload_form_type']][$vv['mall_name']]['order_price']=$sumData['price'];
			$loop[$v['upload_form_type']][$vv['mall_name']]['order_quantity']=$sumData['quantity'];

			$sumOrderPrice+=$sumData['price'];
			$sumOrderQuantity+=$sumData['quantity'];

			//취소
			$qry="select if(sum(ol.settle_price),sum(ol.settle_price),0) as price, if(sum(ol.order_num),sum(ol.order_num),0) as quantity from order_list ol 
			where ol.mod_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59' and ol.mall_no='".$vv['no']."' and step2 between 39 and 100 
			";				
			$res = $db->query($qry);
			$sumData=$res->results[0];
			$loop[$v['upload_form_type']][$vv['mall_name']]['cancel_price']=$sumData['price'];
			$loop[$v['upload_form_type']][$vv['mall_name']]['cancel_quantity']=$sumData['quantity'];

			$sumCancelPrice+=$sumData['price'];
			$sumCancelQuantity+=$sumData['quantity'];

			//반품
			
			//순매출
			
			//총이익

			//판매수수료

			//금액별로 sort
			array_multisort($loop[$v['upload_form_type']], SORT_DESC);
		}
		
	}	
*/
}
	
	//arsort($loop);
	//arsort($loop[$v['upload_form_type']]);
//	tydebug($loop);
	/*
foreach ((array) $loop as $key => $value) {
	foreach ((array) $value as $key2 => $value2) {
		$sort[$key][$key2] = $value2['price'];
	}
}
tydebug($sort);

array_multisort($sort, SORT_ASC, $loop);

tydebug($loop);
*/
//tydebug($loop);
//$upload_form_type=get_mall_info();

//tydebug($upload_form_type);
/*
if($_GET['s_date'] && $_GET['e_date']){
	$qry="select ol.*, ml.upload_form_type, ml.mall_name from order_list ol 
	left join mall_list ml on (ol.mall_no=ml.no)
	where ol.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'
	order by ml.upload_form_type, ml.mall_name
	";		
	$res = $db->query($qry);

	foreach($res->results as $v){		
		$loop[$v['upload_form_type']][$v['mall_name']]['price']+=$v['settle_price'];
		$loop[$v['upload_form_type']][$v['mall_name']]['quantity']+=$v['order_num'];
	}
}
foreach($loop as $k=>$v){
	Arrays.sort($v);
	
}
Arrays.sort($loop); //오름차순 정렬
tydebug($loop);
*/
$tpl->assign(array(	
'loop' => $loop
,'upload_form_type_loop' => $upload_form_type_loop
));

$tpl->print_('tpl');
?>