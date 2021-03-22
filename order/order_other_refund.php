<?
include "../_header.php";

$page_title='국내입고반품등록';

$popup_chk=1; //메뉴 컨트롤

$time = time(); 
$s_date_value=$_POST['s_date']?$_POST['s_date']:date("Y-m-d",strtotime("now", $time)); 
$e_date_value=$_POST['e_date']?$_POST['e_date']:date("Y-m-d",strtotime("now", $time)); 
$s_goodsnm=$_POST['s_goodsnm'];

$ORDER=new order();

if($_POST['mode']=='ins'){
	try{
				
		$db->beginTransaction();

		$qry="select occ.*, g.goodsnm from other_cost_calcu occ
		left join goods g on (occ.goodsno=g.no)
		where occ.no='".$_POST['chk_no']."'";
		$res=$db->query($qry);
		$data=$res->results[0];
		$ins_set="";
		
		$ins_set[]="data_type='return'";
		$ins_set[]="goodsno='".$data['goodsno']."'";
		$ins_set[]="d_code='".$data['d_code']."'";
		$ins_set[]="num='".$_POST['num']."'";
		$ins_set[]="price=(".$data['price']."*-1)";
		$ins_set[]="deli_price='0'";
		$ins_set[]="memo='".$_POST['memo']."'";
		$ins_set[]="place_codeno='".$data['place_codeno']."'";
		$ins_set[]="stock_seq='".$data['stock_seq']."'";
		$ins_set[]="admin_no='".$_SESSION["sess"]["m_no"]."'";
		$ins_set[]="reg_date=now()";
		$ins_set[]="comp_date='".$_POST['comp_date']."'";

		//$ins_set[]="ent_deli_price=Ceil(((".$_POST['price']."/".$data['num'].")*".$_POST['num']."))";		

		$iqry="insert into other_cost_calcu set
		".implode(",",$ins_set)."
		";
		//tydebug($iqry);
		//exit;
		$res=$db->query($iqry);
		$other_last_id=$res->lastId;

		
		//재고 출고
		$qry="update stock_list set 
		now_cnt=now_cnt-'".$_POST['num']."'
		where no = '".$data['stock_seq']."'
		";

		$db->query($qry);

		stock_io('return',$data['goodsno'],$data['goodsnm'],-$_POST['num'],$other_last_id,$_SERVER['REQUEST_URI'],$data['place_codeno']);

		
		//$db->rollBack();
		$db->commit();
	   
		MsgViewCloseReload('처리되었습니다.');
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage().":".$e->getFile());	
	}
}

if($s_goodsnm && $s_date_value && $e_date_value){

	$qry="select occ.*, g.goodsnm, sl.now_cnt, gcl.* from other_cost_calcu occ
	left join goods g on (occ.goodsno=g.no)
	left join stock_list sl on (occ.stock_seq=sl.no)
	left join goods_cnt_loc gcl on (gcl.goodsno=occ.goodsno)
	where g.goodsnm='".$s_goodsnm."'
	and left(occ.reg_date,10) between '".$s_date_value."' and '".$e_date_value."'
	and data_type='stock'
	";
	
	$res = $db->query($qry);
	
	foreach($res->results as $v){
		$mall_name=get_codedata('place','',$v['place_codeno']);
		$v['mall_name']=$mall_name[0]['cd'];
		$v['mall_stock']=$v['codeno_'.$v['place_codeno']];
		$loop[]=$v;		
	}

	$tpl->assign('loop',$loop);
}

$tpl->print_('tpl');
?>
