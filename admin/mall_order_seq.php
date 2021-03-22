<?
include "../_header.php";

$page_title='주문 우선발송 등록';

$popup_chk=1; //메뉴 컨트롤


if($_GET['del']){
	
	$qry="delete from mall_order_seq where no=:no";
	$param[":no"]=$_GET['del'];
	$res=$db->query($qry,$param);

	msg('삭제되었습니다.','mall_order_seq.php');
}

if($_POST['mode']=='reg'){
 
	$param[':upload_form_type']=$_POST['upload_form_type'];
	$param[':mall_no']=$_POST['mallno'];

	$qry="select no from mall_order_seq where upload_form_type=:upload_form_type and mall_no=:mall_no";
	$res=$db->query($qry,$param);

	
	if(!$res->results['0']['no']){
		
		
		$qry="insert into mall_order_seq set
		upload_form_type=:upload_form_type
		,mall_no=:mall_no
		,sort='100'
		";
		
		$res=$db->query($qry,$param);

		msg('등록되었습니다','mall_order_seq.php');
	}else{
		msg('이미 등록된 데이터 입니다.','mall_order_seq.php');
	}
}else if($_POST['mode']=='sort'){
	unset($param);
	foreach($_POST['sort'] as $k=>$v){
		$qry="update mall_order_seq set
		sort=:sort
		where no=:no
		";
		
		$param[":sort"]=$k;
		$param[":no"]=$v;
		
		$db->query($qry,$param);
	}
	msg('처리되었습니다','mall_order_seq.php');
}

$qry="select upload_form_type from mall_list where upload_form_type!='' group by upload_form_type order by upload_form_type";
$res=$db->query($qry);

foreach($res->results as $v){
	$data[]=$v['upload_form_type'];
}



if($_POST['upload_form_type']){
	$add_where=" and upload_form_type=:upload_form_type";
	$param[':upload_form_type']=$_POST['upload_form_type'];
}
$selected['upload_form_type'][$_POST['upload_form_type']]='selected';

$qry="select no,upload_form_type,mall_name from mall_list where upload_form_type!='' ".$add_where." group by upload_form_type,mall_name order by upload_form_type,mall_name ";
$res=$db->query($qry,$param);

foreach($res->results as $v){
	$data_mall[$v['no']]=$v['upload_form_type']."-".$v['mall_name'];
}


$qry="select mos.*,ml.mall_name from mall_order_seq mos
left join mall_list ml on mos.mall_no=ml.no
order by sort";
$res=$db->query($qry);

foreach($res->results as $v){
	$data_list[]=$v;
}


$tpl->assign(
array(
'data'=>$data
,'data_mall'=>$data_mall
,'data_list'=>$data_list
));

$tpl->print_('tpl');
?>
