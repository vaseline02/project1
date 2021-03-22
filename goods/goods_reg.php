<?
include "../_header.php";

$page_title='상품등록';

$popup_chk=1; //메뉴 컨트롤

$QUERY_STRING = $_SERVER['QUERY_STRING'];
$brandList=get_brand_info();

if($_POST['mode']=='ins'){
	try{
		$db->beginTransaction();
		$sqry="select * from goods where goodsnm='".$_POST['goodsnm']."'";
		$sres=$db->query($sqry);
		$gdata=$sres->results[0];

		if($gdata['no']){
			msg('같은이름의 상품이 존재합니다.',"goods_reg.php");
		}else{
			//상품 신규 등록
			$qry="insert into goods set 
			brandno='".$_POST['brandno']."'	
			,goodsnm='".$_POST['goodsnm']."'
			,goodsnm_sub='".$_POST['goodsnm_sub']."'
			,reg_date=now()
			";

			if($db->query($qry)){		
				$insert_id_goods = $db->lastId();

				//스펙 테이블,재고위치테이블 디비추가
				$db->query("insert into goods_cnt_loc set goodsno=:insert_id",array(":insert_id"=>$insert_id_goods));
				$db->query("insert into goods_info set goodsno=:insert_id",array(":insert_id"=>$insert_id_goods));
			}
		}
		
		//$db->rollBack();
		$db->commit();
		MsgViewCloseReload('등록되었습니다.');

//		msg('처리되었습니다.',"bad_list.php?".$QUERY_STRING);
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage().":".$e->getFile());	
	}

	
}

/*
// 1차카테고리
$qry="select * from menu order by sort asc";
$res = $db->query($qry,$param);


foreach($res->results as $v){

	$cateLoop[]=$v;
}

$tpl->assign(array(	
'cateLoop' => $cateLoop
));
$tpl->assign($data);
*/
$tpl->print_('tpl');
?>
