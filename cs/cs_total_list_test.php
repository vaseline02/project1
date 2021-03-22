<?
include "../_header.php";
ini_set('memory_limit', '256M');

$page_title='CS통합리스트';
$formType='cs';
// tydebug($_SERVER);
$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 
$aslist=$_GET['aslist']?$_GET['aslist']:"0";
$cslist=$_GET['cslist']?$_GET['cslist']:"0";
$handlist=$_GET['handlist']?$_GET['handlist']:"0";
$returnlist=$_GET['returnlist']?$_GET['returnlist']:"0";

$_GET['total_search']=trim($_GET['total_search']);
//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();


if($_FILES){
	$excel_data=excel_read('unlink','4');

	foreach($excel_data as $k=>$v){
		//if(!in_array($v['3'],$inv_name))$err_msg[]=$k."번열 등록되지않은 주문번호";
	}
	if (sizeof($err_msg) > 0) {
		tydebug($err_msg);
	}else{
		try{
            //  tydebug($excel_data);
			$db->beginTransaction();
			foreach($excel_data as $k=>$v){
				$sqry="select ol.*, g.no as goodsno, ml.no as mallno from order_list ol
				left join goods g on (ol.goodsno=g.no)
				left join mall_list ml on (ol.mall_no=ml.no)
				where ol.ordno='".$v[3]."' and ol.goodsnm='".$v[4]."'";
				$sres=$db->query($sqry);
				$order_data=$sres->results[0];
				
				if(($v[1]=='60' || $v[1]=='70') && !$order_data){
					$err_msg[]=$k."번열 주문조회 불가";
					continue;
				}

				$memo="모델명 : ".$v[5]."\r\n".$v[9];

				$info_param[':order_no']=$v[3];
				$info_param[':ori_order_no']=$order_data['ori_ordno']?$order_data['ori_ordno']:"";
				$info_param[':receipt_no']='0';
				$info_param[':return_type']=$v[1];
				$info_param[':return_type_sub']=$v[2];
				$info_param[':route_type']=$v[0]?$v[0]:"0";
				$info_param[':call_type']=$v[8]?$v[8]:"0";
				$info_param[':ins_type']=$v[25]?$v[25]:"0";
				$info_param[':contents']=$memo?$memo:"";
				$info_param[':receiver']=$v[18]?$v[18]:"0";
				$info_param[':zipcode']=$v[20]?$v[20]:"";
				$info_param[':address']=$v[21]?$v[21]:"";
				$info_param[':mobile']=$v[19]?$v[19]:"";
				$info_param[':ing_type']='0';
				$info_param[':admin_no']=$_SESSION["sess"]["m_no"];
				$info_param[':admin_name']=$_SESSION["sess"]["name"];
				$info_param[':refund_yn']=$v[23]?$v[23]:"";
				$info_param[':receipt']=$v[24]?$v[24]:"0";
				$info_param[':delivery_type']=$v[10]?$v[10]:"";
				$info_param[':delivery_price']=str_replace(",","",$v[11]);
				$info_param[':delivery_type2']=$v[12]?$v[12]:"";
				$info_param[':delivery_price2']=str_replace(",","",$v[13]);
				$info_param[':return_delivery_code']="";
				$info_param[':return_invoice']="";
				$info_param[':account_code']=$v[14]?$v[14]:"";
				$info_param[':account_name']=$v[15]?$v[15]:"";
				$info_param[':account_number']=$v[16]?$v[16]:"";
				$info_param[':account_price']=str_replace(",","",$v[17]);
				$info_param[':account_etc']=$v[22]?$v[22]:"";
				$info_param[':end_reg_date']="";
				
				$info_iqry="insert into cs_info set 
				order_no=:order_no
				,ori_order_no=:ori_order_no
				,receipt_no=:receipt_no
				,return_type=:return_type
				,return_type_sub=:return_type_sub
				,route_type=:route_type
				,call_type=:call_type
				,ins_type=:ins_type
				,contents=:contents
				,receiver=:receiver
				,zipcode=:zipcode
				,address=:address
				,mobile=:mobile
				,ing_type=:ing_type
				,admin_no=:admin_no
				,admin_name=:admin_name
				,refund_yn=:refund_yn
				,receipt=:receipt
				,delivery_type=:delivery_type
				,delivery_price=:delivery_price
				,delivery_type2=:delivery_type2
				,delivery_price2=:delivery_price2
				,return_delivery_code=:return_delivery_code
				,return_invoice=:return_invoice
				,account_code=:account_code
				,account_name=:account_name
				,account_number=:account_number
				,account_price=:account_price
				,account_etc=:account_etc
				,reg_date=now()
				,end_reg_date=:end_reg_date
				";					
				$info_ires=$db->query($info_iqry,$info_param);
				$lastInfoNo=$info_ires->lastId;
				
				if($v[1]=='60' || $v[1]=='70'){
					$gqry="select * from goods g 
					where g.goodsnm='".$v[5]."'";
					$gres=$db->query($gqry);
					$goods_data=$gres->results[0];

					if($v[1]=='70' && $v[5] && !$goods_data){
						$err_msg[]=$k."번열 교환상품 조회불가";
						continue;
					}

					$detail_param[':order_list_no']=$order_data['no'];
					$detail_param[':order_no']=$v[3];
					$detail_param[':cs_info_no']=$lastInfoNo;
					$detail_param[':goods_no']=$order_data['goodsno'];
					$detail_param[':mall_no']=$order_data['mall_no'];
					$detail_param[':mall_goodsnm']=$order_data['mall_goodsnm'];
					$detail_param[':exchange_goods_no']=$goods_data['no']?$goods_data['no']:"0";
					$detail_param[':exchange_goods_nm']=$v[5]?$v[5]:"";
					$detail_param[':exchange_goods_num']=str_replace(",","",$v[6]);
					$detail_param[':exchange_stock_yn']=$goods_data['stock_yn'];
					$detail_param[':diff_price']=str_replace(",","",$v[7]);
					$detail_param[':send_type']='4';
					$detail_param[':return_delivery_code']="";
					$detail_param[':return_invoice']="";
					$detail_param[':return_confirm']='1';
					$detail_param[':end_reg_date']="";

					$detail_iqry="insert into cs_detail set
					order_list_no=:order_list_no
					,order_no=:order_no
					,cs_info_no=:cs_info_no
					,goods_no=:goods_no
					,mall_no=:mall_no
					,mall_goodsnm=:mall_goodsnm
					,exchange_goods_no=:exchange_goods_no
					,exchange_goods_nm=:exchange_goods_nm
					,exchange_goods_num=:exchange_goods_num
					,exchange_stock_yn=:exchange_stock_yn
					,diff_price=:diff_price
					,send_type=:send_type
					,return_delivery_code=:return_delivery_code
					,return_invoice=:return_invoice
					,return_confirm=:return_confirm
					,reg_date=now()
					,end_reg_date=:end_reg_date
					";
					$detail_ires=$db->query($detail_iqry,$detail_param);
				}
			}
			if($err_msg){
				tydebug($err_msg);
				$db->rollBack();	
				exit;
			}
			//$db->rollBack();
			$db->commit();
			msg('처리되었습니다.','cs_total_list.php');
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage().":".$e->getFile());	
		}
	}
}

$start = get_time();

# 성함(구매자,수령자,접수자), 연락처, 주문번호, 송장번호, 모델명
if($_GET['total_search'] || ($_GET['cslist'] && ($_GET['call_type1']||$_GET['call_type2']) )  ){ //|| ( $_GET['s_date'] && $_GET['e_date'] )
	$middleMasking=preg_replace('/.(?=.$)/u','*',$_GET['total_search']); // 홍○동 
	$endMasking=preg_replace('/.(?!.)/u','*',$_GET['total_search']); // 홍길○
	
	if(!$_GET['aslist'] && !$_GET['handlist'] && !$_GET['cslist'] && !$_GET['returnlist']) $viewCheck="1";
	
	#================================== 주문검색조건 ===========================================
	//구매자,수령자
	$order_where[]="(
		concat(ol.buyer,ol.receiver) like '%".$_GET['total_search']."%' 
		or concat(ol.buyer,ol.receiver) like '%".$middleMasking."%' 
		or concat(ol.buyer,ol.receiver) like '%".$endMasking."%'
		)";

	//연락처
	$order_where[]="ol.mobile like '%".$_GET['total_search']."%'";
	//주문번호
	$order_where[]="ol.ordno like '%".$_GET['total_search']."%'";
	//송장번호
	$order_where[]="ol.invoice like '%".$_GET['total_search']."%'";
	$order_where[]="ol.return_invoice like '%".$_GET['total_search']."%'";
	//모델명
	$order_where[]="ol.goodsnm like '%".$_GET['total_search']."%'";

	#================================== AS ===========================================
	if($_GET['aslist'] || $_GET['handlist'] || $viewCheck){
		//접수자, 구매자
		$as_where[]="(
			concat(ai.receipt_name,ai.receiver) like '%".$_GET['total_search']."%' 
			or concat(ai.receipt_name,ai.receiver) like '%".$middleMasking."%' 
			or concat(ai.receipt_name,ai.receiver) like '%".$endMasking."%'
			)";
		//연락처
		$as_where[]="ai.mobile like '%".$_GET['total_search']."%'";
		//주문번호
		$as_where[]="ai.order_no like '%".$_GET['total_search']."%'";
		//송장번호
		$as_where[]="ad.invoice like '%".$_GET['total_search']."%'";
		$as_where[]="ad.send_invoice like '%".$_GET['total_search']."%'";
		//모델명
		$as_where[]="ad.goodsnm like '%".$_GET['total_search']."%'";


		$as_qry="select ai.order_no, ai.no from as_info ai 
		left join as_detail ad on (ai.no=ad.info_no)
		left join order_list ol on (ad.order_list_no=ol.no)
		where (".implode(" or ", $as_where)." or ".implode(" or ", $order_where).")";
		if($_GET['s_date'] && $_GET['e_date']){
			$as_qry.="and ai.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
		}

		$end = get_time();
		$time = $end - $start;
		echo number_format($time,6) . " 초 걸림";

		$as_res=$db->query($as_qry);
		foreach($as_res->results as $av){
			if($av['order_no'] && ($_GET['aslist'] || $viewCheck)){
				$orderAs[$av['order_no']]=$av['order_no'];
				$order_array[]=$av['order_no'];
			}else if(!$av['order_no'] && ($_GET['handlist'] || $viewCheck)){
				$as_no[]=$av['no'];
			}
			
		}
	}
	#================================ CS =======================================
	if($_GET['cslist'] || $_GET['returnlist'] || $viewCheck){
		//수령자
		$cs_where[]="(
			ci.receiver like '%".$_GET['total_search']."%' 
			or ci.receiver like '%".$middleMasking."%' 
			or ci.receiver like '%".$endMasking."%'
			)";
		//연락처
		$cs_where[]="ci.mobile like '%".$_GET['total_search']."%'";
		//주문번호
		$cs_where[]="ci.order_no like '%".$_GET['total_search']."%'";
		//송장번호
		$cs_where[]="ci.return_invoice like '%".$_GET['total_search']."%'";
		$cs_where[]="cd.return_invoice like '%".$_GET['total_search']."%'";
		//모델명
		$cs_where[]="cd.exchange_goods_nm like '%".$_GET['total_search']."%'";

		
		$cs_qry="select ci.order_no, ci.return_type from cs_info ci 
		left join cs_detail cd on (ci.no=cd.cs_info_no)
		left join order_list ol on (ci.order_no=ol.ordno)
		where (".implode(" or ", $cs_where)." or ".implode(" or ", $order_where).")";
		if($_GET['s_date'] && $_GET['e_date']){
			$cs_qry.=" and ci.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
		}

		if($_GET['cslist'] && $_GET['returnlist']){
			$cs_qry.=" and (ci.return_type between 1 and 10 or ci.return_type between 60 and 70)";
		}else{
			if($_GET['cslist']){
				$cs_qry.=" and ci.return_type between 1 and 10";
			}
			if($_GET['returnlist']){
				$cs_qry.=" and ci.return_type between 60 and 70";
			}
		}
		
		if($_GET['cslist']){
			if($_GET['call_type1'] && $_GET['call_type2']){
				$cs_qry.=" and (call_type=1 or call_type=2)";
			}else{
				if($_GET['call_type1'])	$cs_qry.=" and call_type=1";
				if($_GET['call_type2'])	$cs_qry.=" and call_type=2";
			}
		}

		$cs_res=$db->query($cs_qry);
		foreach($cs_res->results as $cv){
			if($cv['order_no']){
				if($cv['return_type']>=1 && $cv['return_type']<=10){
					$orderCs[$cv['order_no']]=$cv['order_no'];
				}else if($cv['return_type']>=60 && $cv['return_type']<=70){
					$orderReturn[$cv['order_no']]=$cv['order_no'];
				}	
				$order_array[]=$cv['order_no']; 
			}
		}
	}
	#=============================== ORDER ======================================
	//CS,AS,수기접수 모두 체크가안되있을때 주문을 기준으로 불러온다.
	if($viewCheck){

		$order_qry="select ol.ordno from order_list ol	
		where (".implode(" or ", $order_where).")";
		if($_GET['s_date'] && $_GET['e_date']){
			$order_qry.="and ol.reg_date between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
		}
		
		$order_res=$db->query($order_qry);
		foreach($order_res->results as $ov){
			if($ov['ordno']) $order_array[]=$ov['ordno'];
		}
	}
	#================================ QUERY ======================================
	$orderNo=array_unique($order_array);

	$_GET[page_num]=100;
	$field="*";
	$db_table="
	(select 
			'주문' as qry_type
			,ol.no, ol.ordno as orderno, ol.mall_no, ol.mall_name, ol.reg_date as date, ol.order_num as quantity, ol.order_price as price, ol.buyer as name1, ol.receiver as name2
			,ol.buyer_mobile as mobile1, ol.mobile as mobile2, ol.zipcode, ol.address, ol.courier_code as delivery_code, ol.invoice, ol.return_courier_code as return_delivery_code, ol.return_invoice
			,ol.step, ol.step2
			,g.goodsnm
			,b.brand_img_folder
			,ci.no as cs_no, ci.return_type as cs_return_type, ci.return_type_sub as cs_return_type_sub, ci.ing_type as cs_ing_type, ci.admin_no, ci.return_invoice as cs_return_invoice
			,(select sum(ins_type) from cs_info where order_no=ol.ordno ) as sum_ins_type
			,m.id, m.name
		from order_list ol 
		left join goods g on (ol.goodsno=g.no) 
		left join brand b on g.brandno = b.no	
		left join cs_info ci on (ci.no=(select cs_info_no from cs_detail where order_list_no=ol.no and order_no=ol.ordno and goods_no=ol.goodsno order by no desc limit 1))
		left join member m on (m.no=ci.admin_no)
		where ol.ordno in ('".implode("','",$orderNo)."')
		union 
		select 
			'수기접수' as qry_type
			,ai.no, ai.order_no as orderno, '' as mall_no, ad.mall_name, ad.in_regdate as date, '1' as quantity, ai.real_cost as price, ai.receipt_name as name1, ai.receiver as name2
			,'' as mobile1, ai.mobile as mobile2, ai.zipcode, ai.address, ad.delivery_code, ad.invoice, '' as return_delivery_code, '' as return_invoice
			,'' as step, '' as step2
			,ad.goodsnm
			,'' as brand_img_folder
			,'' as cs_no, '' as cs_return_type, '' as cs_return_type_sub, '' as cs_ing_type, ai.admin_no, '' as cs_return_invoice,'' as sum_ins_type
			,m.id, m.name
		from as_info ai
		left join as_detail ad on (ai.no=ad.info_no)
		left join member m on (m.no=ai.admin_no)
		where ai.no in ('".implode("','",$as_no)."')) v 
	";
	$_GET[sort]="date desc,orderno desc";

	$pg = new page($_GET[page],$_GET[page_num],$no_limit);
	$pg->field = $field;
	$pg->setQuery($db_table,$where,$_GET[sort]);
	$pg->exec();
	$qry=$pg->query;

	// $qry="
	// select * from (
	// 	select 
	// 		'주문' as qry_type
	// 		,ol.no, ol.ordno as orderno, ol.mall_no, ol.mall_name, ol.reg_date as date, ol.order_num as quantity, ol.order_price as price, ol.buyer as name1, ol.receiver as name2
	// 		,ol.buyer_mobile as mobile1, ol.mobile as mobile2, ol.zipcode, ol.address, ol.courier_code as delivery_code, ol.invoice, ol.return_courier_code as return_delivery_code, ol.return_invoice
	// 		,ol.step, ol.step2
	// 		,g.goodsnm
	// 		,b.brand_img_folder
	// 		,ci.no as cs_no, ci.return_type as cs_return_type, ci.return_type_sub as cs_return_type_sub, ci.ing_type as cs_ing_type, ci.admin_no, ci.return_invoice as cs_return_invoice
	// 		,(select sum(ins_type) from cs_info where order_no=ol.ordno ) as sum_ins_type
	// 		,m.id, m.name
	// 	from order_list ol 
	// 	left join goods g on (ol.goodsno=g.no) 
	// 	left join brand b on g.brandno = b.no	
	// 	left join cs_info ci on (ci.no=(select cs_info_no from cs_detail where order_list_no=ol.no and order_no=ol.ordno and goods_no=ol.goodsno order by no desc limit 1))
	// 	left join member m on (m.no=ci.admin_no)
	// 	where ol.ordno in ('".implode("','",$orderNo)."')
	// 	union 
	// 	select 
	// 		'수기접수' as qry_type
	// 		,ai.no, ai.order_no as orderno, '' as mall_no, ad.mall_name, ad.in_regdate as date, '1' as quantity, ai.real_cost as price, ai.receipt_name as name1, ai.receiver as name2
	// 		,'' as mobile1, ai.mobile as mobile2, ai.zipcode, ai.address, ad.delivery_code, ad.invoice, '' as return_delivery_code, '' as return_invoice
	// 		,'' as step, '' as step2
	// 		,ad.goodsnm
	// 		,'' as brand_img_folder
	// 		,'' as cs_no, '' as cs_return_type, '' as cs_return_type_sub, '' as cs_ing_type, ai.admin_no, '' as cs_return_invoice,'' as sum_ins_type
	// 		,m.id, m.name
	// 	from as_info ai
	// 	left join as_detail ad on (ai.no=ad.info_no)
	// 	left join member m on (m.no=ai.admin_no)
	// 	where ai.no in ('".implode("','",$as_no)."')
	// ) v order by date desc,orderno desc";
	$res = $db->query($qry);

	$bf_ordno='';
	$color_key=1;
	foreach($res->results as $v){
		if(in_array($v['orderno'], $orderAs)){
			$v['asCheck']="1";
		}
		if(in_array($v['orderno'], $orderCs)){
			$v['csCheck']="1";
		}
		if(in_array($v['orderno'], $orderReturn)){
			$v['returnCheck']="1";
		}
		if($bf_ordno!=$v['orderno']){
			$bf_ordno=$v['orderno'];
			$color_key++;
		}
		$v['line_color']="table_tr".$color_key%2;

		$v['delivery_name']=mb_substr($delivery_list[$v['delivery_code']]['name'],0,2,'utf-8');
		
        if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        
		if($v['bundle']>0)$v['bundle_color']="red";
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
		if(isset($v['ing_type'])) $v['ing_type']=$cfg_ing_type[$v['ing_type']];
		$loop[]=$v;
	}

	//tydebug($loop);

	$tpl->assign(array(	
	'loop' => $loop
	,'pg'=> $pg	
	));

}

foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}
$checked['aslist'][$aslist]="checked";
$checked['cslist'][$cslist]="checked";
$checked['call_type1'][$_GET['call_type1']]="checked";
$checked['call_type2'][$_GET['call_type2']]="checked";
$checked['handlist'][$handlist]="checked";
$checked['returnlist'][$returnlist]="checked";

$selected['ing_type'][$_GET['s_ing_type']]="selected";

$tpl->assign(array(	
	'mall_list' => $mall_list
	,'delivery_list'=>$delivery_list
));
    
$tpl->print_('tpl');
?>
