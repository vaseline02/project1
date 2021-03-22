<?
include "../_header.php";

$page_title='교환반품입출고관리(입고)';
$returnType='return';
$step='3';
$CANCEL=NEW cancel();

$QUERY_STRING = $_SERVER['QUERY_STRING'];
//몰명
$mall_list=get_mall_info();
/*매장코드*/
$codedata=get_codedata('place','1'); 
//택배사 함수
$delivery_list=get_delivery_info();

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

if($_POST['mode']=="allCancel"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();
			
			foreach($_POST['chk_no'] as $v){                
                //상태변경
				$CANCEL->stepChange($v,$_POST['code']);
				if($_POST['code']=='4'){
					if($_POST['codeSelect']=='bad'){
						$CANCEL->badIns($v, 'cs_return_bad');
						//order_list 교환재고업데이트
						$CANCEL->cancelStock($v);
					}else{
						//재고등록
						$CANCEL->stockChange($v,$_POST['codeSelect'],'cs_return');
						//order_list 교환재고업데이트
						$CANCEL->cancelStock($v);

						//stock_list 복원
						$CANCEL->order_stock_list($v);

					}
				}
			}
			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다.","send_in.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_in.php?".$QUERY_STRING);		
		}  
	}
}else if($_POST['mode']=="cancel"){
	if($_POST['no']){
		try
		{
			$db->beginTransaction();
			$CANCEL->cs_cancel($_POST['no'],$_POST['code']);

			$db->commit();

			msg("철회되었습니다.","send_in.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();

			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';;

			msg($s,"send_in.php?".$QUERY_STRING);		
		}  
		   
	}
}
/**
 * s_mall_no : 몰번호
 * s_receiver : 고객명
 * s_invoice : 송장번호
 * s_date : 주문일자 (시작)
 * e_date : 주문일자 (종료)
 * s_mall_goodsnm : 모델명
 * s_ordno : 주문번호
 */
if($_GET['s_return_invoice'])$add_where[]="ci.return_invoice like '%".$_GET['s_return_invoice']."%' ";
if(count($_GET['s_mall_no']))$add_where[]="ol.mall_no in ('".implode("','",$_GET['s_mall_no'])."')";
if($_GET['s_order_no'])$add_where[]="ci.order_no like '%".$_GET['s_order_no']."%' ";
if($_GET['s_return_type'])$add_where[]="ci.return_type='".$_GET['s_return_type']."' ";
if($_GET['s_return_type_sub'])$add_where[]="(ci.return_type in ('60','70') and ci.return_type_sub='".$_GET['s_return_type_sub']."') ";

if($_GET['s_send_type'])$add_where[]="cd.send_type='".$_GET['s_send_type']."' ";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ci.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
if($_GET['subtype']=="1"){
	$add_where[]="ci.return_type_sub in ('1','4') ";
}else{
	$add_where[]="ci.return_type_sub='".$_GET['subtype']."' ";
}

//$add_where[]="ci.return_type='60'";
$add_where[]="cd.send_type='".$step."'";
//$add_where[]="cd.return_confirm='1'";
$add_where[]="cd.order_list_no > '0'";
$add_where[]="ci.add_type in ('1')";

if(count($add_where)){
    /*리스트*/	
	$selectClaim=$CANCEL->selectClaim($add_where);

	foreach($selectClaim as $v){
		$selectClaim2[] = infoMasking($v, 'order_list'); //마스킹
	}

	$tpl->assign(array(	
	'loop' => $selectClaim2
	,'pg' => $CANCEL->pg_return()
	,'delivery_list' => $delivery_list
	,'mall_list' => $mall_list
	));
}

//if($_GET['subtype']=="1"){
	
	$barcode_where[]="ci.return_type in ('60','70')";
	if($_GET['subtype']=="1"){
		$barcode_where[]="ci.return_type_sub in ('1','4')";
	}else{
		$barcode_where[]="ci.return_type_sub in ('".$_GET['subtype']."')";
	}
	$barcode_where[]="cd.send_type='3'";
	$barcode_where[]="cd.order_list_no > '0'";
	
	if(count($barcode_where)){
		/*리스트*/	    
		$barcode_where=" and ".implode(" and ",$barcode_where);
		
		$bqry="select cd.goods_no, cd.mall_goodsnm, sum(cd.exchange_goods_num) as sum_egn, g.goodsnm, g.img_name, b.brand_img_folder from cs_info ci
		left join cs_detail cd on (ci.no=cd.cs_info_no) 
		left join goods g on (cd.goods_no=g.no) 
		left join brand b on (g.brandno = b.no)	
		where 1=1 ".$barcode_where." group by goods_no";

		$bres=$db->query($bqry);
		$bdata=$bres->results;

		$allClean='0';
		$okNum='0';	
		$tNum='0';
		
		
		foreach($bdata as $bv){
			$bv['img_url']=img_url($cfg['img_600_logo'],$bv['brand_img_folder'],$bv['img_name'],$bv['goodsnm']);
			$bv['confirmNm']="미확인";
			$bv['confirmColor']="red";
			$listArr[$bv['goods_no']]=$bv['sum_egn'];
			$bloop[$bv['goods_no']]=$bv;
			$allClean++;
			$tNum+=$bv['sum_egn'];
		}	
		$notNum=$tNum;
			
		if($_POST['s_barcode']){
			
			$barcode_arr = paste_to_arr($_POST['s_barcode']);
			//송장의 합계수량을 구한다.
			foreach($barcode_arr as $v){
				$qry="select gb.goodsno from goods_barcode gb where gb.barcode='".$v."'";
				$res=$db->query($qry);
				$goodsNo=$res->results[0]['goodsno'];
				
				//리스트의 바코드 상품이 없을떄나 등록되있지않은 바코드일때
				if(!$goodsNo || !$listArr[$goodsNo]){
					$notData[$v]++;
				}else{
					$searchArr[$goodsNo]++;
					$barcodeNum[$goodsNo]=$v;
				}            
			}	
			
			//반품되야될 리스트의 상품과 비교
			foreach($searchArr as $k=>$v){                       
				
				//리스트의 수보다 검색수가 작을때
				if($v<$listArr[$k]){
					$minuNum=$listArr[$k]-$v;
					$bloop[$k]['confirmNm']="수량부족(".$minuNum.")";
					$okNum+=$v;
					$notNum=$notNum-$v;
				//리스트의 수보다 검색수가 클때
				}else if($v>$listArr[$k]){
					$bloop[$k]['confirmNm']="확인";
					$bloop[$k]['confirmColor']="blue";
					$notData[$barcodeNum[$k]]="초과(".($v-$listArr[$k]).")";
					$okNum+=$listArr[$k];
					$notNum=$notNum-$listArr[$k];
					$allClean--;
				//일치할경우
				}else{
					$bloop[$k]['confirmNm']="확인";
					$bloop[$k]['confirmColor']="blue";
					$okNum+=$v;
					$notNum=$notNum-$v;
					$allClean--;
				}
			}
		}
		
		$tpl->assign(array(	
		'bloop' => $bloop
		,'notData' => $notData
		,'allClean' => $allClean
		));
	}

//}

foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}
$selected['ing_type'][$_GET['s_ing_type']]="selected";
$selected['return_type'][$_GET['s_return_type']]="selected";
$selected['send_type'][$_GET['s_send_type']]="selected";
$selected['return_type_sub'][$_GET['s_return_type_sub']]="selected";
    
$tpl->print_('tpl');
?>
