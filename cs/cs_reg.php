<?
include "../_header.php";

$page_title='CS관리';
$receipt_view_type="mod";

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';
$route=$_GET['route']?$_GET['route']:'1';
$no=$_GET['no'];
$ordno=$_GET['ordno'];
$order_seq=$_GET['order_seq'];
$mall_no=$_GET['mall_no'];
$view_type=$_GET['view_type'];
$order_list_no=$_GET['order_list_no'];
$receipt_no=$_GET['receipt_no'];

//해당값이 넘어오면 order_list db memo 컬럼에 cs내용값 추가
$order_memo_add=$_REQUEST['order_memo_add'];

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

if(!$ordno || !$mall_no){
    msg('잘못된 접근입니다.','close');
}

if($_POST['mode']=="ins" || $_POST['mode']=="mod"){   
    try
    {
        $db->beginTransaction();
		
		//로그 등록
		if($_POST['mode']=="ins") reportLog($_POST, $ordno, '1');

		//cs등록
		csIns($_POST, $ordno, '1');

		$db->commit();
		/*
        if($_POST['mode']=='ins' && $receipt_no){
            MsgViewCloseReload("처리되었습니다");	
        }else{
            msg("처리되었습니다","cs_reg.php?".$_POST['return_url']);	
		}
		*/
		MsgViewCloseReload("처리되었습니다");	

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"cs_reg.php?".$_POST['return_url']);
    }  
   
}else if($_POST['mode']=="can"){
    $qry="update cs_detail set
    send_type=:send_type
    where cs_info_no=:cs_info_no
    ";	
    $param[':send_type']="90";
    $param[':cs_info_no']=$_POST['cs_info_no'];
    if($db->query($qry,$param)){
        msg("철회요청되었습니다.","cs_reg.php?".$_POST['return_url']);	
    }

}else if($_POST['mode']=="receipt_ins" || $_POST['mode']=="cs_ing"){
	$return_type['60']='1';//반품
	$return_type['70']='2';//교환
	$return_type['4']='3';//as
	$return_type['90']='4';//상품입고
	$add_type=0;
	$route=1; //접수된건을 재접수시 색표시되던것 없애달라고 요청해서 route 초기화
	
	try
	{
		$db->beginTransaction();
		
		//접수 등록
		if($_POST['return_type']=='60' || $_POST['return_type']=='70' || $_POST['return_type']=='90'){
			$add_qry=",return_type_sub='".$_POST['return_type_sub']."'";
		}
		if($_POST['mode']=="cs_ing"){
			$add_type=2;
			$route=2;
			$add_qry=",memo='".$_POST['account_etc']."'";
		}

		

		foreach($_POST['order_list_no'] as $k=>$v){
			//진행중일경우 기존에 등록된 내용을 삭제후 재등록
			//if($_POST['mode']=="cs_ing"){
				if($_POST['return_type']=='60' || $_POST['return_type']=='70' || $_POST['return_type']=='90'){
					$dqry="delete from cs_receipt where order_no='".$ordno."' and order_list_no='".$v."' and complete_yn='N'";
					$db->query($dqry);
				}               
			//}

			$qry="select ol.* from order_list ol where no='".$v."'";
			$res=$db->query($qry);
			$orderData=$db->results[0];
			
			$iqry="insert into cs_receipt set
			order_list_no='".$v."'
			,order_no='".$_POST['order_no']."'
			,goodsnm='".$orderData['goodsnm']."'
			,customer_name='".$orderData['receiver']."'
			,mobile='".$orderData['mobile']."'
			,return_type='".$return_type[$_POST['return_type']]."'
			".$add_qry."
			,admin_no='".$_SESSION["sess"]["m_no"]."'
			,admin_name='".$_SESSION["sess"]["name"]."'
			,reg_date=now()
			,route='".$route."'
			";

			$ires=$db->query($iqry);
			$lastReceiptNo[]=$ires->lastId;

			
		}
		//로그 등록
		if($_POST['mode']=="receipt_ins") reportLog($_POST, $ordno, '0');

		//cs등록
		csIns($_POST, $ordno, $add_type);
	

		$db->commit();
		//$db->rollBack();
		//msg("접수되었습니다.","cs_reg.php?".$_POST['return_url']);
		MsgViewCloseReload("접수되었습니다");	

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"cs_reg.php?".$_POST['return_url']);
    }  
       


	//msg("접수되었습니다.","cs_reg.php?".$_POST['return_url']);	

}else if($_POST['mode']=="reserve_release"){
	try
		{
		$db->beginTransaction();
		$qry="select rl.*,g.goodsnm from reserve_list rl 
		join goods g on g.no=rl.goodsno
		where rl.no=:no";
		$res=$db->query($qry,array(":no"=>$_POST['reserve_seq']));

		$rdata=$res->results['0'];
		
		$okd=stock_io('reserve_release',$rdata['goodsno'],$rdata['goodsnm'],-$rdata['cnt'],$rdata['no'],$_SERVER['REQUEST_URI'],$cfg['hold_loc'],$rdata['stock_loc']);
		$okd=stock_io('reserve_release',$rdata['goodsno'],$rdata['goodsnm'],$rdata['cnt'],$rdata['no'],$_SERVER['REQUEST_URI'],$rdata['stock_loc'],$cfg['hold_loc']);
	
		$qry="update reserve_list set state=1,rel_date=now(),rel_admin_no=:rel_admin_no where no=:no";
		$db->query($qry,array(":no"=>$rdata['no'],"rel_admin_no"=>$_SESSION['sess']['m_no']));
		
		guadmin_stock_ctl($rdata['goodsno'],$rdata['cnt'],$rdata['stock_loc'],'in',$rdata['reference_no'],'교환예약 해제');

		$db->commit();
		msg("처리되었습니다","cs_reg.php?".$_POST['return_url']);	

	}catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}
}

function reportLog($val, $ordno, $add_type='0'){
	global $db;
	if($val['return_type']!='60' && $val['return_type']!='70' && $val['return_type']!='90') return false;

	foreach($val['order_list_no'] as $k=>$v){
		if($add_type=='0'){
			$sqry="select count(no) cnt from cs_report_log crl where order_list_no='".$v."' and add_type='0'";
			
			$sres=$db->query($sqry);
			$logCnt=$sres->results[0]['cnt'];

			if($logCnt){
				continue;
			}
		}
		$iqry="insert into cs_report_log set 
		ins_date=now()
		,admin_no='".$_SESSION["sess"]["m_no"]."'
		,add_type='".$add_type."'
		,order_list_no='".$v."'
		,mall_no='".$val['mall_no'][$v]."'
		,order_no='".$val['order_no']."'
		,goods_no='".$val['goods_no'][$v]."'
		,reg_date=now()
		";
		$db->query($iqry);		
	}
}

function csIns($val, $ordno, $add_type='1'){
	global $db;

	if($val['return_type_mod']){
		$return_type=$val['return_type_mod'];
        $return_type_sub=$val['return_type_sub_mod'];
    }else{        
        $return_type=$val['return_type'];
        $return_type_sub=$val['return_type_sub'];
    }
	
	//cs info            
	$qr="order_no=:order_no
	,ori_order_no=:ori_order_no
	,contents=:contents
	,call_type=:call_type
	,ins_type=:ins_type
	,admin_no=:admin_no
	,admin_name=:admin_name
	";

	$param=array(
		":order_no"=>$ordno
		,":ori_order_no"=>$val['ori_order_no']?$val['ori_order_no']:""
		,":contents"=>$val["contents"]?$val["contents"]:""            
		,":call_type"=>$val["call_type"]?$val["call_type"]:"0"            
		,":ins_type"=>$val["ins_type"]?$val["ins_type"]:"0"            
		,":admin_no"=>$_SESSION["sess"]["m_no"]
		,":admin_name"=>$_SESSION["sess"]["name"]    
		);	

  
	//교환 반품 상품입고 일경우만 들어가야되는 항목
	if($return_type=='40' || $return_type=='60' || $return_type=='70' || $return_type=='90'){
		$qr.=",delivery_type=:delivery_type
			,delivery_price=:delivery_price
			,delivery_type2=:delivery_type2
			,delivery_price2=:delivery_price2
			,return_delivery_code=:return_delivery_code
			,return_invoice=:return_invoice
			,refund_yn=:refund_yn
			,receipt=:receipt
			,account_code=:account_code
			,account_name=:account_name
			,account_number=:account_number
			,account_price=:account_price
			,account_etc=:account_etc
			,goods_bad_yn=:goods_bad_yn
			,goods_bad_memo=:goods_bad_memo
			";
		
			$param[':delivery_type']=$val['delivery_type']?$val['delivery_type']:"";
			$param[':delivery_price']=$val['delivery_price']?$val['delivery_price']:"0";
			$param[':delivery_type2']=$val['delivery_type2']?$val['delivery_type2']:"";
			$param[':delivery_price2']=$val['delivery_price2']?$val['delivery_price2']:"0";
			$param[':return_delivery_code']=$val['return_delivery_code']?$val['return_delivery_code']:"";
			$param[':return_invoice']=$val['return_invoice']?$val['return_invoice']:"";
			$param[':refund_yn']=$val['refund_yn']?$val['refund_yn']:"n";
			$param[':receipt']=$val['receipt']?$val['receipt']:"0";
			$param[':account_code']=$val['account_code']?$val['account_code']:"";
			$param[':account_name']=$val['account_name']?$val['account_name']:"";
			$param[':account_number']=$val['account_number']?$val['account_number']:"";
			$param[':account_price']=$val['account_price']?$val['account_price']:"0";
			$param[':account_etc']=$val['account_etc']?$val['account_etc']:"";
			$param[':goods_bad_yn']=$val['goods_bad_yn']?$val['goods_bad_yn']:"n";
			$param[':goods_bad_memo']=$val['goods_bad_memo']?$val['goods_bad_memo']:"";
		//교환 상품입고
		if($return_type=='40' || $return_type=='70' || $return_type=='90'){
			$qr.=",receiver=:receiver
			,zipcode=:zipcode
			,address=:address
			,mobile=:mobile                
			";
			$param[':receiver']=$val['receiver']?$val['receiver']:"";
			$param[':zipcode']=$val['zipcode']?$val['zipcode']:"";
			$param[':address']=$val['address']?$val['address']:"";
			$param[':mobile']=$val['mobile']?$val['mobile']:"";

		}

	}

	if($val['mode']=='ins' || $val['mode']=='receipt_ins' || $val['mode']=='cs_ing'){

		  	
		//cs접수에서 넘어온데이터 
		/*
		if($receipt_no){
			
			foreach($receipt_no as $rv){
				$qr.=",receipt_no=:receipt_no";
				$param[':receipt_no']=$rv;

				$rqry="update cs_receipt set status='1' where no=:no";
				$rparam[':no']=$rv;
					
				$db->query($rqry,$rparam);
			}
		}
		*/		
		$qry="insert into cs_info set
		".$qr."
		,route_type=:route_type
		,return_type=:return_type
		,return_type_sub=:return_type_sub
		,add_type=:add_type
		,mall_no=:mall_no
		,reg_date=now()		
		";	
		$param[':route_type']=$val['route_type']?$val['route_type']:'0';
		$param[':return_type']=$return_type;
		$param[':return_type_sub']=$return_type_sub?$return_type_sub:"0";
		$param[':add_type']=$add_type;
		$param[':mall_no']=$_GET['mall_no'];

		if($order_memo_add==1){//주문탭에서 누를때 넘겨주는 파라미터값으로 , 해당값이 있을때 order_list db 에도 내용을 동일하게 추가
			$param2=array();		
			$qry2="update order_list ol
			set memo=concat(ifnull(memo,''),'//','".$val["contents"]."')
			where 1
			and ol.ordno='".$ordno."' 
			and ol.mall_no='".$mall_no."'
			";

			$db->query($qry2,array());

		}

	}else if ($val['mode']=='mod'){
		$qry="update cs_info set
		".$qr."
		where no=:no
		";	
		$param[':no']=$val['cs_info_no'];
	} 

	$res=$db->query($qry,$param);
		
	$lastInfoNo=$res->lastId;

	//cs detail
	if(count($val['order_list_no']) && $return_type && ($val['mode']=="ins" || $val['mode']=="receipt_ins" || $val['mode']=="cs_ing")){
		
		$dqr="order_list_no=:order_list_no
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
		,return_delivery_code=:return_delivery_code
		,return_invoice=:return_invoice
		";
		foreach($val['order_list_no'] as $k=>$v){
			$dparam=array(
				":order_list_no"=>$v
				,":order_no"=>$ordno
				,":cs_info_no"=>$lastInfoNo
				,":goods_no"=>$val['goods_no'][$v]
				,":mall_no"=>$val['mall_no'][$v]
				,":mall_goodsnm"=>$val['mall_goodsnm'][$v]
				,":exchange_goods_no"=>$val["exchange_goods_no"][$v]
				,":exchange_goods_nm"=>$val["exchange_goods_nm"][$v]
				,":exchange_goods_num"=>$val["exchange_goods_num"][$v]
				,":exchange_stock_yn"=>$val["exchange_stock_yn"][$v]
				,":diff_price"=>$val['diff_price'][$v]
				,":return_delivery_code"=>$val['return_delivery_code']
				,":return_invoice"=>$val['return_invoice']                    
			);	

				
			$qry="insert into cs_detail set
			".$dqr."
			,send_type=:send_type
			,reg_date=now()
			";	
			$dparam[':send_type']="1";
		  

			if($res=$db->query($qry,$dparam)){
				if(($return_type=='50' || $return_type=='60' || $return_type=='70' || $return_type=='90') && $add_type=='1'){
					$ruqry="update cs_receipt set complete_yn='Y' where order_no='".$ordno."' and order_list_no='".$v."' ";
					$db->query($ruqry);
				}              
				if($return_type=='60' && $val['mode']=="ins"){
					wholesale_payment_ins("return",$v,$val["exchange_goods_num"][$v],$val['wholesale_price'][$v]);
				}
			}else{
				throw new Exception('정상처리되지 않았습니다.', 1);
			}    
		}
	}
}

if($order_list_no){
    $oi_no=" and ol.no = '".$order_list_no."'";
    $cs_info_no=" and (ci.no in (select cs_info_no from cs_detail where order_list_no='".$order_list_no."') or ((ci.return_type >=1 and ci.return_type <=6) or ci.return_type='99'))";
    $as_info_no=" and ai.no in (select info_no from as_detail where order_list_no='".$order_list_no."') ";
}
/*기본주문정보*/
$qry="select * from order_list ol
where 1 
and ol.ordno='".$ordno."' and ol.mall_no='".$mall_no."' 
#and ol.no='".$order_seq."'
".$oi_no." 
order by ol.no desc limit 1";

$res = $db->query($qry);
//$data=$res->results[0];

foreach($res->results as $v){
	$data = infoMasking($v, 'order_list'); //마스킹	
}

$data['comp_date']=($data['comp_date']!='0000-00-00 00:00:00' && $data['step2']<40)?$data['comp_date']:"";	


$res = $db->query($qry);

/*주문상품리스트*/
$qry="select ol.*,g.img_name,g.stock_yn,b.brand_img_folder from order_list ol 
left join goods g on (ol.goodsno=g.no) 
left join brand b on g.brandno = b.no
where 1
and ol.ordno='".$ordno."' and ol.mall_no='".$mall_no."' 
#and ol.no='".$order_seq."'
".$oi_no." 
";
$res = $db->query($qry);
foreach($res->results as $v){

	//주문단계,링크로드
	$order_step_view=order_step_view($v);
	$v['step_lv']=$order_step_view['step_lv'];


    $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
    if($v['step2']>=40) $v['cancel_text']=$cfg_order_step2[$v['step2']];
    $goodsList[]=$v;

	$reserve_seq[]=$v['no'];
}

/*예약재고*/
$qry="select rl.*,g.goodsnm,g.img_name,b.brand_img_folder,m.name from reserve_list rl
join goods g on rl.goodsno=g.no
left join brand b on g.brandno = b.no
left join member m on rl.admin_no=m.no
where rl.reference_no in ('".implode("','",$reserve_seq)."')
and rl.state=0
";

$res = $db->query($qry);
foreach($res->results as $v){
	$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	$reserve_data[]=$v;
}

/*택배상품접수 메모*/
$qry="select memo from cs_receipt cr
where cr.no='".$receipt_no."'";
$res = $db->query($qry);
$receipt_data=$res->results[0];

/*접수내용 */
 $qry="select ci.*, m.id from cs_info ci
 left join member m on (ci.admin_no=m.no)
 where ci.order_no='".$ordno."' ".$cs_info_no."
 order by ci.receipt desc,ci.reg_date desc";

$res = $db->query($qry);

foreach($res->results as $v){
    $dqry="select cd.*, IF(g.goodsnm, g.goodsnm, cd.mall_goodsnm) as g_goodsnm from cs_detail cd 
    left join goods g on (cd.goods_no=g.no)
    where cd.cs_info_no='".$v['no']."'";
    $dres=$db->query($dqry);
    $sendCount='0';
    foreach($dres->results as $dv){
		

        if($dv['send_type']!='1') $sendCount++;
        
        $v['cs_detail'][]=$dv;

    }
    $v['send_count']=$sendCount;
    $v['cs_detail']=$dres->results;

    if($v['ing_type']=='1'){
        $v['ingColorType']="ingBlue";
    }else{
        $v['ingColorType']="ingRed";
    }

    $loop[]=$v;    

}

/**as접수내용 */
$aqry="select ai.*
, ad.*, ad.no as detail_no
, m.id
from 
as_info ai 
left join as_detail ad on(ai.no=ad.info_no)
left join member m on (ai.admin_no=m.no)
where ai.order_no='".$ordno."'";
$ares=$db->query($aqry);
foreach($ares->results as $ak=>$av){

    $av['ex_as']=explode("|",$av['as_contents']);
    $rqry="select * from as_repair where detail_no='".$av['detail_no']."'";
    $rres=$db->query($rqry);
    foreach($rres->results as $rv){
        $av['as_repair'][]=$rv;
    }

    $asloop[]=$av;
}
//작성중체크 쿼리
$qry="select count(no) as cnt from cs_info ci
where ci.order_no='".$ordno."'";
$res=$db->query($qry);
$csCount=$res->results[0]['cnt'];

$tpl->assign($data);
$tpl->assign($csCount);

/*cs,as 합침 */
$qry="select v.* from (
    select 'cs' as type, ci.no, ci.reg_date, ci.receipt
    from cs_info ci
    where ci.order_no='".$ordno."' and ci.mall_no='".$_GET['mall_no']."' ".$cs_info_no."
    union 
    select 'as' as type, ai.no, ai.reg_date, '0' as receipt
    from as_info ai 
    where ai.order_no='".$ordno."' ".$as_info_no."
    union
    select 'sms' as type, sl.no, sl.reg_date, '0' as receipt
    from sms_send_log sl
    where sl.order_no='".$ordno."'    
    ) v 
    order by receipt desc, reg_date desc
    ";
$res=$db->query($qry);

foreach($res->results as $uv){

    if($uv['type']=='cs'){
        /*접수내용 */
        $qry="select ci.*, cr.memo as receipt_memo, m.id from cs_info ci
        left join cs_receipt cr on (ci.receipt_no=cr.no)
        left join member m on (ci.admin_no=m.no)
        where ci.no='".$uv['no']."'
        ";
        $res = $db->query($qry);
		//$data=$res->results[0];
		foreach($res->results as $v){
			$data = infoMasking($v, 'cs_info'); //마스킹 처리
		}
        
        $dqry="select cd.*, IF(g.goodsnm, g.goodsnm, cd.mall_goodsnm) as g_goodsnm from cs_detail cd 
        left join goods g on (cd.goods_no=g.no)
        where cd.cs_info_no='".$data['no']."'";
        $dres=$db->query($dqry);
        $sendCount='0';
        foreach($dres->results as $dv){
            
            if($dv['send_type']!='1') $sendCount++;
            $data['cs_detail'][]=$dv;
        }

        if($data['ins_type']=='1'){
            $data['ins_color']="background-color:#eecccc;";
        }
        $data['send_count']=$sendCount;
        $data['cs_detail']=$dres->results;

    }else if($uv['type']=='as'){
         /**as접수내용 */
        $aqry="select ai.*
        , ad.*, ad.no as detail_no
        , m.id
        from 
        as_info ai 
        left join as_detail ad on(ai.no=ad.info_no)
        left join member m on (ai.admin_no=m.no)
        where ai.no='".$uv['no']."'";
        $ares=$db->query($aqry);
        //$data=$ares->results[0];

		foreach($ares->results as $v){
			$data = infoMasking($v, 'as_info'); //마스킹 처리
		}

        $rqry="select * from as_repair where detail_no='".$data['detail_no']."'";
        $rres=$db->query($rqry);
        foreach($rres->results as $rv){
            $data['as_repair'][]=$rv;
        }

        $data['ex_as']=explode("|",$data['as_contents']);
    }else if ($uv['type']=='sms'){
        /**sms로그 */
        $sqry="select sl.*
        , m.id
        from 
        sms_send_log sl
        left join member m on (sl.admin_no=m.no)
        where sl.no='".$uv['no']."'";

        $sres=$db->query($sqry);
        $data=$sres->results[0];
    }
    $data['type']=$uv['type'];

    $tloop[]=$data;    
}

//이전 접수건 확인
$sqry="select * from cs_info ci where ci.order_no='".$ordno."' and ci.return_type in ('60','70','90') and ci.add_type in ('0','2') order by ci.no desc limit 1";
$sres=$db->query($sqry);
$content_info=$sres->results[0];
//tydebug($tloop);
$tpl->assign(array(
    'loop'=>$loop,
    'tloop'=>$tloop,
    'asloop'=>$asloop,
    'goodsList'=>$goodsList,
    'delivery_list'=>$delivery_list,
    'mall_list'=>$mall_list,
	'content_info'=>$content_info,
	'reserve_data'=>$reserve_data
));

    
$tpl->print_('tpl');
?>
