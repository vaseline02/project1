<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
$page_title='딜등록';

/*
$time = time(); 
$_GET['s_date']=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$_GET['e_date']=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 
*/
//몰명리스트 함수
$mall_glist=get_mall_group();

$mode=$_POST["mode"];
$no=$_POST["no"];
$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($mode=="deal_ins"){
	try{
		$db->beginTransaction();

		$deal_color=($_POST['deal_type']==1)?"important":"success";

		$qry="insert into goods_deal_info set
		mall_no='".$_POST['mall_no']."'
		,location='".$_POST['location']."'
		,deal_type='".$_POST['deal_type']."'
		,deal_color='".$deal_color."'
		,sales_target='".$_POST['sales_target']."'
		,s_date='".$_POST['s_date']."'
		,e_date='".$_POST['e_date']."'
		,delivery_type='".$_POST['delivery_type']."'
		,delivery_chk_price='".$_POST['delivery_chk_price']."'
		,delivery_price='".$_POST['delivery_price']."'
		,event_url='".$_POST['event_url']."'
		,etc='".$_POST['etc']."'
		,deal_name='".$_POST['deal_name']."'
		,admin_no='".$_SESSION['sess']['m_no']."'
		,reg_date=now()
		";
		$db->query($qry);

		$db->commit();
		msg("등록 되었습니다","goods_deal_list.php");		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());		
	}	
}else if($mode=="deal_del"){
	try{
		$db->beginTransaction();

		$qry="delete from goods_deal_detail where info_no='".$_POST['no']."'";
		$db->query($qry);

		$qry="delete from goods_deal_info where no='".$_POST['no']."'";
		$db->query($qry);
		
		$db->commit();
		msg("삭제 되었습니다","goods_deal_list.php");		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());		
	}	
}

$qry="select gdi.*,ml.upload_form_type, ml.mall_name, m.name as admin_name from goods_deal_info gdi
left join mall_list ml on (gdi.mall_no=ml.no)
left join member m on (gdi.admin_no=m.no)
order by reg_date desc
";
$res=$db->query($qry);
foreach($res->results as $v){
	if($v['delivery_type']=="1"){
		$v['delivery_price']="무료배송";
	}else if($v['delivery_type']=="2"){
		$v['delivery_price']=number_format($v['delivery_chk_price'])."이하".number_format($v['delivery_price']);
	}else if($v['delivery_type']=="3"){
		$v['delivery_price']=number_format($v['delivery_price']);
	}
	$v['deal_type_name']=$v['deal_type']=='1'?"빅딜":"일반딜";
	$loop[]=$v;
}


$tpl->assign(array(	
	'loop' => $loop
	,'mall_glist' => $mall_glist
));
    
$tpl->print_('tpl');
?>
