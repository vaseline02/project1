<?
include "../_header.php";

$page_title='외부발송추가';

$popup_chk=1; //메뉴 컨트롤
$s_ordno=$_POST['s_ordno'];

$ORDER=new order();

if($_POST['mode']=='ins'){
	try{
				
		$db->beginTransaction();

		$qry="select * from order_list where no='".$_POST['chk_no']."'";
		$res=$db->query($qry);
		$data=$res->results[0];
		$ins_set="";
//tydebug($data);
		//스탭, 상품명, 수량
		if($_POST['outside_type']=="반품"){
			$column_not_ins=array("no","settle_price","purchase_price","step","step2","reg_date","mod_date","comp_date","ent_deli_price","order_num","consumer_price");
			foreach($data as $k=>$v){
				if(!in_array($k,$column_not_ins)){
					$ins_set[]=$k."='".$v."'";
				}
				//if($k=='settle_price') $ins_set[]="settle_price=(".$v."*-1)";
				if($k=='purchase_price') $ins_set[]="purchase_price=(".$v."*-1)";		
				if($k=='settle_price') $ins_set[]="settle_price=Ceil((((".$v."/".$data['order_num'].")*".$_POST['order_num'].")*-1))";
				//if($k=='purchase_price') $ins_set[]="purchase_price=(((".$v."/".$data['order_num'].")*".$_POST['order_num'].")*-1)";			
				//추가
				if($k=='consumer_price') $ins_set[]="consumer_price=Ceil(((".$v."/".$data['order_num'].")*".$_POST['order_num']."))";			
			}
			$ins_set[]="order_num='".$_POST['order_num']."'";
			$ins_set[]="step='61'";
		}else{

			$column_not_ins=array("no","goodsnm","settle_price","purchase_price","step","step2","reg_date","mod_date","comp_date","ent_deli_price","order_num","consumer_price");
			foreach($data as $k=>$v){
				if(!in_array($k,$column_not_ins)){
					$ins_set[]=$k."='".$v."'";
				}
				if($k=='goodsnm') $ins_set[]="goodsnm='".$v."-".$_POST['outside_type']."'";
				//추가
				if($k=='consumer_price') $ins_set[]="consumer_price=Ceil(((".$v."/".$data['order_num'].")*".$_POST['order_num']."))";			
			}			
			//$ins_set[]="settle_price='".$_POST['ent_deli_price']."'";
			$ins_set[]="settle_price=Ceil(((".$_POST['ent_deli_price']."/".$data['order_num'].")*".$_POST['order_num']."))";
			$ins_set[]="purchase_price='0'";
			$ins_set[]="order_num='".$_POST['order_num']."'";
			$ins_set[]="step='60'";
		}

		
		$ins_set[]="step2='0'";
		$ins_set[]="reg_date=now()";
		$ins_set[]="mod_date=now()";
		$ins_set[]="comp_date='".$_POST['comp_date']."'";
		//$ins_set[]="ent_deli_price='".$_POST['ent_deli_price']."'";		
		$ins_set[]="ent_deli_price=Ceil(((".$_POST['ent_deli_price']."/".$data['order_num'].")*".$_POST['order_num']."))";		

		$iqry="insert into order_list set
		".implode(",",$ins_set)."
		";
		//tydebug($iqry);
		//exit;
		$db->query($iqry);

		
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

if($s_ordno){

	$qry="select ol.* from order_list ol
	where deli_codeno='outside'
	and ol.ordno='".$s_ordno."'
	";

	$res = $db->query($qry);
	
	foreach($res->results as $v){
//		tydebug($v);

		//주문단계,링크로드
		$order_step_view=order_step_view($v);

		$v['step_lv']=$order_step_view['step_lv'];
		$v['step_lv_link']=$order_step_view['step_lv_link'];

		$loop[]=$v;		
	}

	$tpl->assign('loop',$loop);
}

$tpl->print_('tpl');
?>
