<?
include "../_header.php";

$page_title='AS등록';
$popup_chk=1; //메뉴 컨트롤

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

$now_date=date("Y-m-d");
//$orderno=date("YmdHis")."-".sprintf('%03d',rand('0','999'));

/**GET */
$receipt_no=$_GET['receipt_no']?$_GET['receipt_no']:0;
$as_no=$_GET['as_no'];

/**POST */
$mode=$_POST['mode'];
$befor_as_status=$_POST['befor_as_status'];
//info
$order_no=$_POST['order_no'];//주문번호
$receipt_name=$_POST['receipt_name'];//접수자성함
$receiver=$_POST['receiver'];//구매자성함
$mobile=$_POST['mobile'];//연락처
$zipcode=$_POST['zipcode'];//우편번호
$address=$_POST['address'];//주소
$memo=$_POST['memo'];//내용
$customer_cost=$_POST['customer_cost'];//고객비용
$real_cost=$_POST['real_cost'];//실비용
$order_buy=$_POST['order_buy'];//구매처
$order_reg=$_POST['order_reg'];//구매일
$past_order_no=$_POST['past_order_no'];//과거주문번호
$address_check=$_POST['address_check'];//주소확인
$report_yn=$_POST['report_yn']?$_POST['report_yn']:"y";//결산포함여부


//detail
$order_list_no=$_POST['order_list_no']?$_POST['order_list_no']:"0";
$detail_no=$_POST['detail_no'];//카테고리
$as_cate=$_POST['as_cate'];//카테고리
$as_sub_cate=$_POST['as_sub_cate']?$_POST['as_sub_cate']:"0";//서브카테고리
$mall_no=$_POST['mall_no'];//브랜드코드
$mall_name=$_POST['mall_name'];//브랜드명
$goods_no=$_POST['goods_no'];//상품코드
$goodsnm=$_POST['goodsnm'];//모델명
$serial_number=$_POST['serial_number'];//시리얼번호
$product_point=$_POST['product_point'];//제품특징
$delivery_code=$_POST['delivery_code'];//택배코드
$invoice=$_POST['invoice'];//송장번호
$delivery_price=$_POST['delivery_price'];//송장번호
$return_delivery_price=$_POST['return_delivery_price'];//송장번호
if(count($_POST['as_code'])){
    $as_contents=implode("|",$_POST['as_code']);//수리내용
}else{
    $as_contents='';//수리내용
}

$re_receipt=$_POST['re_receipt']?$_POST['re_receipt']:"n";//재수리유무
$case_yn=$_POST['case_yn'];//케이스유무
$action_yn=$_POST['action_yn'];//동작유무
$progress_company=$_POST['progress_company'];//진행업체명
$send_delivery_code=$_POST['send_delivery_code'];//출고택배코드
$send_invoice=$_POST['send_invoice'];//출고송장번호
$in_regdate=$_POST['in_regdate'];//입고일
$out_regdate=$_POST['out_regdate'];//출고일
$schedule_date=$_POST['schedule_date'];//출고일
$as_status=$_POST['as_status'];//진행단계
$brandnm=$_POST['brandnm'];//진행단계

if($mode=="ins"){
    try
    {
        //throw new Exception('정상처리되지 않았습니다.', 1);
        $db->beginTransaction();

		//====================== cs receipt ===============================
		if($order_list_no){
			$sqry="select ol.*, g.no as goodsno, ml.no as mallno from order_list ol
			left join goods g on (ol.goodsno=g.no)
			left join mall_list ml on (ol.mall_no=ml.no)
			where ol.no='".$order_list_no."'";
			$sres=$db->query($sqry);
			$order_data=$sres->results[0];

			if($order_data) $order_no=$order_data['ordno'];
			else $order_no="0";

			$receipt_type="0";
		}else{
			$order_list_no="0";
			$order_no="";
			$receipt_type="1";
		}

		$receipt_iqry="insert into cs_receipt set
		order_list_no='".$order_list_no."'
		,order_no='".$order_no."'
		,goodsnm='".$goodsnm."'
		,customer_name='".$receiver."'
		,mobile='".$mobile."'
		,delivery_code='".$delivery_code."'
		,invoice='".$invoice."'
		,memo='".$memo."'
		,return_type='3'
		,return_type_sub='0'
		,status='1'
		,admin_no='".$_SESSION["sess"]["m_no"]."'
		,admin_name='".$_SESSION["sess"]["name"]."'
		,receipt_type='".$receipt_type."'
		,reg_date=now()
		";
		$receipt_ires=$db->query($receipt_iqry);
		$lastReceiptNo=$receipt_ires->lastId;
		//====================== cs receipt END ===============================
		
        //====================== as info ===============================
        $qr="order_no='".$order_no."'        
        ,receipt_name='".$receipt_name."'
        ,receiver='".$receiver."'
        ,mobile='".$mobile."'
        ,zipcode='".$zipcode."'
        ,address='".$address."'
        ,memo='".$memo."'
        ,customer_cost='".$customer_cost."'
        ,real_cost='".$real_cost."'
        ,order_buy='".$order_buy."'
        ,order_reg='".$order_reg."'
        ,past_order_no='".$past_order_no."'
		,address_check='".$address_check."'
		,report_yn='".$report_yn."'
        ";

		$qry="insert into as_info set
		".$qr."
		,receipt_no='".$lastReceiptNo."'
		,reg_date=now()
		,admin_no='".$_SESSION["sess"]["m_no"]."'
		,admin_name='".$_SESSION["sess"]["name"]."'
		";	        
		$res=$db->query($qry);
		$lastInfoNo=$res->lastId;
		//====================== as info END ===============================

	    //====================== as detail ===============================
        $dqr="order_no='".$order_no."'
        ,as_cate='".$as_cate."'
        ,as_sub_cate='".$as_sub_cate."'
        ,brandnm='".$brandnm."'
        ,goodsnm='".$goodsnm."'
        ,serial_number='".$serial_number."'
        ,product_point='".$product_point."'
        ,delivery_code='".$delivery_code."'
        ,invoice='".$invoice."'
        ,delivery_price='".$delivery_price."'
        ,return_delivery_price='".$return_delivery_price."'
        ,as_contents='".$as_contents."'
        ,re_receipt='".$re_receipt."'
        ,case_yn='".$case_yn."'
        ,action_yn='".$action_yn."'
        ,progress_company='".$progress_company."'
        ,send_delivery_code='".$send_delivery_code."'
        ,send_invoice='".$send_invoice."'
        ,in_regdate='".$in_regdate."'
        ,out_regdate='".$out_regdate."'
        ,schedule_date='".$schedule_date."'
        ,as_status='".$as_status."'		
        ";

		if(count($goods_no)){
            foreach($goods_no as $k=>$v){               
				$dqry="insert into as_detail set
				".$dqr."
				,mall_no='".$mall_no[$v]."'
				,goods_no='".$v."'
				,mall_name='".$mall_name[$v]."'
				,reg_date=now()
				,info_no='".$lastInfoNo."'
				,order_list_no='".$order_list_no."'
				";	
				
				$dres=$db->query($dqry);
				$lastDetailNo=$dres->lastId;       
            }
        }else{            
			$dqry="insert into as_detail set
			".$dqr."
			,reg_date=now()
			,info_no='".$lastInfoNo."'
			,order_list_no='".$order_list_no."'
			";	
			$dres=$db->query($dqry);
			$lastDetailNo=$dres->lastId;           
        }
		//====================== as detail END ===============================

		//====================== as repair ===============================
		 #수리건 등록
        if(count($_POST['as_code'])){
            foreach($_POST['as_code'] as $rv){
                $as_quantity=$_POST['as_quantity'][$rv]?$_POST['as_quantity'][$rv]:"0";
                $as_price=$_POST['as_price'][$rv]?$_POST['as_price'][$rv]:"0";
                $as_real_price=$_POST['as_real_price'][$rv]?$_POST['as_real_price'][$rv]:"0";
                $as_memo=$_POST['as_memo'][$rv]?$_POST['as_memo'][$rv]:"";
                                                    
                $rqry="insert into as_repair set
				detail_no='".$lastDetailNo."'
                ,as_code='".$rv."'
                ,as_quantity='".$as_quantity."'
                ,as_price='".$as_price."'
                ,as_real_price='".$as_real_price."'
                ,as_memo='".$as_memo."'
                ";
                
                $rres=$db->query($rqry);

            }
        }
		//====================== as repair END ===============================
		
		//====================== sms ===============================
		//sms 발송 (자동발송 중지)
        if($as_status && ($as_status != $befor_as_status)){
            foreach($_POST['as_contents'] as $cv){
                $asContents[]=$cfg_as_contents[$as_cate][$cv];
            }
            
            $qry="select * from sms_info where type='1' and code='".$as_status."'";
            $res=$db->query($qry);
            $smsData=$res->results[0];

            $smscontents=str_replace("[접수자]",$receipt_name,$smsData['contents']);
            $smscontents=str_replace("[수리내용]",implode(", ",$asContents),$smscontents);
            $smscontents=str_replace("[고객비용]",number_format($customer_cost)."원",$smscontents);

            //sms_send($smsData['title'], $smscontents, $mobile, 'as', $as_no, $as_status, $order_no);
            
        }
		//====================== sms END ===============================
        
        $db->commit();        
        MsgViewCloseReload("처리되었습니다");	
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"as_reg.php?".$_POST['return_url']);
    }  
}else if($mode=="mod"){

	 try
    {
        //throw new Exception('정상처리되지 않았습니다.', 1);
        $db->beginTransaction();
		
        //====================== as info ===============================
        $qr="order_no='".$order_no."'        
        ,receipt_name='".$receipt_name."'
        ,receiver='".$receiver."'
        ,mobile='".$mobile."'
        ,zipcode='".$zipcode."'
        ,address='".$address."'
        ,memo='".$memo."'
        ,customer_cost='".$customer_cost."'
        ,real_cost='".$real_cost."'
        ,order_buy='".$order_buy."'
        ,order_reg='".$order_reg."'
        ,past_order_no='".$past_order_no."'
		,address_check='".$address_check."'
		,report_yn='".$report_yn."'
        ";
        
		$qry="update as_info set
		".$qr."
		,mod_reg_date=now()
		,mod_admin_no='".$_SESSION["sess"]["m_no"]."'
		,mod_admin_name='".$_SESSION["sess"]["name"]."'
		where no='".$as_no."'
        ";	        
        
        $res=$db->query($qry);
        
		//====================== as info END ===============================

		//====================== as detail ===============================
        $dqr="order_no='".$order_no."'
        ,as_cate='".$as_cate."'
        ,as_sub_cate='".$as_sub_cate."'
        ,brandnm='".$brandnm."'
        ,goodsnm='".$goodsnm."'
        ,serial_number='".$serial_number."'
        ,product_point='".$product_point."'
        ,delivery_code='".$delivery_code."'
        ,invoice='".$invoice."'
        ,delivery_price='".$delivery_price."'
        ,return_delivery_price='".$return_delivery_price."'
        ,as_contents='".$as_contents."'
        ,re_receipt='".$re_receipt."'
        ,case_yn='".$case_yn."'
        ,action_yn='".$action_yn."'
        ,progress_company='".$progress_company."'
        ,send_delivery_code='".$send_delivery_code."'
        ,send_invoice='".$send_invoice."'
        ,in_regdate='".$in_regdate."'
        ,out_regdate='".$out_regdate."'
        ,schedule_date='".$schedule_date."'
        ,as_status='".$as_status."'
        ";

		if(count($goods_no)){
            foreach($goods_no as $k=>$v){               
				$dqry="update as_detail set
				".$dqr."                
				,mall_no='".$mall_no[$v]."'
				,goods_no='".$v."'
				,mall_name='".$mall_name[$v]."'
				where no='".$detail_no."'
				";	
				$db->query($dqry);
            }
        }else{            
			$dqry="update as_detail set
			".$dqr."                
			where no='".$detail_no."'
			";	
			$db->query($dqry);
        }
		//====================== as detail END ===============================

		//====================== as repair ===============================
		#기존등록되있는것을 삭제.
        $rdqry="delete from as_repair where detail_no='".$detail_no."'";
		$rdres=$db->query($rdqry);           

       
		#수리건 등록
        if(count($_POST['as_code'])){
            foreach($_POST['as_code'] as $rv){
                $as_quantity=$_POST['as_quantity'][$rv]?$_POST['as_quantity'][$rv]:"0";
                $as_price=$_POST['as_price'][$rv]?$_POST['as_price'][$rv]:"0";
                $as_real_price=$_POST['as_real_price'][$rv]?$_POST['as_real_price'][$rv]:"0";
                $as_memo=$_POST['as_memo'][$rv]?$_POST['as_memo'][$rv]:"";
                                                    
                $rqry="insert into as_repair set
				detail_no='".$detail_no."'
                ,as_code='".$rv."'
                ,as_quantity='".$as_quantity."'
                ,as_price='".$as_price."'
                ,as_real_price='".$as_real_price."'
                ,as_memo='".$as_memo."'
                ";
                
                $rres=$db->query($rqry);

            }
        }
		//====================== as repair END ===============================

		//====================== sms ===============================
        //sms 발송 (자동발송 중지)
        if($as_status && ($as_status != $befor_as_status)){
            foreach($_POST['as_contents'] as $cv){
                $asContents[]=$cfg_as_contents[$as_cate][$cv];
            }
            
            $qry="select * from sms_info where type='1' and code='".$as_status."'";
            $res=$db->query($qry);
            $smsData=$res->results[0];

            $smscontents=str_replace("[접수자]",$receipt_name,$smsData['contents']);
            $smscontents=str_replace("[수리내용]",implode(", ",$asContents),$smscontents);
            $smscontents=str_replace("[고객비용]",number_format($customer_cost)."원",$smscontents);

            //sms_send($smsData['title'], $smscontents, $mobile, 'as', $as_no, $as_status, $order_no);
            
        }
		//====================== sms END ===============================
        
        $db->commit();        
        MsgViewCloseReload("처리되었습니다");	
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"as_reg.php?".$_POST['return_url']);
    }  
}

if($as_no){
    $qry="select ai.*
    ,ad.*, ad.no as detail_no
    ,ol.mall_no as order_mall_no, ol.mall_name as order_mall_name, ol.step, ol.step2, ol.mall_goodsnm as order_mall_goodsnm, ol.receiver as order_receiver
    ,ol.mobile as order_mobile, ol.zipcode as order_zipcode, ol.address as order_address, ol.courier_code as order_courier_code, ol.invoice as order_invoice, ol.reg_date as ol_reg
    ,g.no as goods_no, g.goodsnm as g_goodsnm,g.stock_yn
    ,b.brand_img_folder, b.brandnm as b_brandnm
    ,ifnull(DATEDIFF(ad.schedule_date,NOW()),'미등록') as leftDate
    from as_info ai
    left join as_detail ad on (ai.no=ad.info_no) 
    left join order_list ol on (ad.order_list_no=ol.no)
    left join goods g on (ad.goods_no=g.no) 
    left join brand b on (g.brandno = b.no)
    where ai.no='".$as_no."'
    ";

    $res=$db->query($qry);
    foreach($res->results as $v){

		$v = infoMasking($v, 'as_info'); //마스킹 처리

        $checked['re_receipt'][$v['re_receipt']]='checked';
        $checked['case_yn'][$v['case_yn']]='checked';
        $checked['action_yn'][$v['action_yn']]='checked';
		$checked['address_check'][$v['address_check']]='checked';
		$checked['report_yn'][$v['report_yn']]='checked';

        $sqry="select * from as_repair where detail_no='".$v['detail_no']."'";
        $sres=$db->query($sqry);
        foreach($sres->results as $sv){
            $v['repair'][$sv['as_code']]=$sv;
            $checked['as_code'][$sv['as_code']]='checked';            
        }            
        $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['g_goodsnm']);
        $receipt_no=$v['receipt_no'];
        $asData[]=$v;
    }   
}

//접수리스트
$order_list_no=$asData[0]['order_list_no'];
$ordno=$asData[0]['order_no'];
if($order_list_no){
    $cs_info_no=" and (ci.no in (select cs_info_no from cs_detail where order_list_no='".$order_list_no."') or ((ci.return_type >=1 and ci.return_type <=6) or ci.return_type='99'))";
    $as_info_no=" and ai.no in (select info_no from as_detail where order_list_no='".$order_list_no."') ";
        
    /*cs,as 합침 */
    $qry="select v.* from (
        select 'cs' as type, ci.no, ci.reg_date, ci.receipt
        from cs_info ci
        where ci.order_no='".$ordno."' ".$cs_info_no."
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
}

$tpl->assign(array(
    'tloop'=>$tloop,
    'asData'=>$asData,
    'delivery_list'=>$delivery_list,
    'mall_list'=>$mall_list
));

    
$tpl->print_('tpl');

?>