<?
include "../_header.php";member_chk();

$page_title='주문정보 수정';
$popup_chk=1; //메뉴 컨트롤

if(strpos($_SERVER['HTTP_REFERER'],'order_settle'))$mod_able="readonly style=color:red";

//택배사 함수
$delivery_list=get_delivery_info();

if($_POST['mode']=='mod'){
	
	#상품goodsno업데이트 쿼리
	$gsql="select no from goods where goodsnm='".$_POST['goodsnm']."'";
	$gres=$db->query($gsql);
	$goodsno=$gres->results[0]['no'];

	if($goodsno=='' && $_POST['model_chk']!='n'){
		$add_qry=",step=0,step2=0,step_fixed=0 ";
	}

	$qry="update order_list set
	mall_goodsnm=:mall_goodsnm
	,goodsnm=:goodsnm
	,goodsno=:goodsno
	,order_num=:order_num
	,order_price=:order_price
	,settle_price=:settle_price
	,deli_price=:deli_price
	,buyer=:buyer
	,receiver=:receiver
	,buyer_mobile=:buyer_mobile
	,mobile=:mobile
	,zipcode=:zipcode
	,address=:address
	,courier_code=:courier_code
	,invoice=:invoice
	,order_memo=:order_memo
	,memo=:memo
	,cha_su=:cha_su
	,wms_ordno=:wms_ordno
	".$add_qry."
	where no=:no
	";

	$param=array(
		":mall_goodsnm"=>$_POST['mall_goodsnm'],
		":goodsnm"=>$_POST['goodsnm'],
		":goodsno"=>$goodsno?$goodsno:"0",
		":order_num"=>$_POST['order_num'],
		":order_price"=>$_POST['order_price'],
		":settle_price"=>$_POST['settle_price'],
		":deli_price"=>$_POST['deli_price'],
		":buyer"=>$_POST['buyer'],
		":receiver"=>$_POST['receiver'],
		":buyer_mobile"=>$_POST['buyer_mobile'],
		":mobile"=>$_POST['mobile'],
		":zipcode"=>$_POST['zipcode'],
		":address"=>$_POST['address'],
		":courier_code"=>$_POST['courier_code'],
		":invoice"=>$_POST['invoice'],
		":order_memo"=>$_POST['order_memo'],
		":memo"=>$_POST['memo'],
		":cha_su"=>$_POST['cha_su'],
		":wms_ordno"=>$_POST['wms_ordno'],
		":no"=>$_POST['no']
	);

	if($db->query($qry,$param)){
		MsgViewCloseReload("처리되었습니다.");
//		msg("처리되었습니다","order_mod_pop.php?no=".$_POST['no']);
	}
}


//메뉴구성
$no=$_REQUEST['no'];
$model_chk=$_REQUEST['model_chk'];

$qry="select * from order_list where no=:no";

$param=array(":no"=>$no);

$res=$db->query($qry,$param);

foreach($res->results as $v){
	
	$v = infoMasking($v, 'order_list'); //마스킹

	$data=$v;
}

$tpl->assign(array(
    'delivery_list'=>$delivery_list
));

$tpl->assign($data);

$tpl->print_('tpl');
?>
