<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
$page_title='AS리스트';

$time = time(); 

$_GET['s_date']=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$_GET['e_date']=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

$now_date=date("Y-m-d");

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

//미처리건 카운트 
$leftCount=0;
//미처리 조회기간
$leftNum=3;

$mode=$_POST["mode"];
$no=$_POST["no"];
$returnUrl=$_POST["returnUrl"]?$_POST["returnUrl"]:"as_list.php";
$QUERY_STRING = $_SERVER['QUERY_STRING'];

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();


if($_FILES){

	if($mode=="as_ins"){
		$excel_data=excel_read('unlink','4');

		foreach($excel_data as $k=>$v){
			// if(!in_array($v['0'],$inv_name))$err_msg[]=$k."번열 등록되지않은 택배사명";
		}
		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				//  tydebug($excel_data);
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
					
					$delivery_sqry="select code from delivery_info where name='".$v[13]."' ";
					$delivery_res=$db->query($delivery_sqry);
					$delivery_code=$delivery_res->results[0]['code'];

					$delivery_sqry="select code from delivery_info where name='".$v[28]."' ";
					$delivery_res=$db->query($delivery_sqry);
					$send_delivery_code=$delivery_res->results[0]['code'];

					#cs_receipt
					$receipt_param[':order_list_no']="0";
					$receipt_param[':order_no']="";
					$receipt_param[':goodsnm']=$v[19];
					$receipt_param[':customer_name']=$v[6];
					$receipt_param[':mobile']=$v[5];
					$receipt_param[':delivery_code']=$delivery_code;
					$receipt_param[':invoice']=$v[14];
					$receipt_param[':account_code']="";
					$receipt_param[':account_number']="";
					$receipt_param[':memo']=addslashes($v[24]);
					$receipt_param[':return_type']="3";
					$receipt_param[':return_type_sub']="0";
					$receipt_param[':status']="1";
					$receipt_param[':admin_no']=$_SESSION["sess"]["m_no"];
					$receipt_param[':admin_name']=$_SESSION["sess"]["name"];
					$receipt_param[':receipt_type']="1";

					#as_info
					$info_param[':receipt_no']="0";
					$info_param[':order_no']="";
					$info_param[':receipt_name']=$v[4];
					$info_param[':receiver']=$v[6];
					$info_param[':mobile']=$v[5];
					$info_param[':zipcode']=$v[7];
					$info_param[':address']=addslashes($v[8]);
					$info_param[':memo']=addslashes($v[24]);
					$info_param[':customer_cost']=str_replace(",","",$v[25]);
					$info_param[':real_cost']=str_replace(",","",$v[26]);
					$info_param[':order_buy']=$v[9];
					$info_param[':order_reg']="";
					$info_param[':admin_no']=$_SESSION["sess"]["m_no"];
					$info_param[':admin_name']=$_SESSION["sess"]["name"];
					$info_param[':mod_admin_no']="";
					$info_param[':mod_admin_name']="";
					$info_param[':mod_reg_date']="";
					$info_param[':old_seq']=$v[33];

					$ex_repair=explode("@",$v[22]);
					$array_as_contents="";
					$array_as_repair="";
					foreach($ex_repair as $exv){
						$ex_repair_detail=explode(":",$exv);
						$array_as_contents[]=$ex_repair_detail[0];
						$array_as_repair[]=$ex_repair_detail;
					}
					$as_contents=implode("|",$array_as_contents);
					
					#as_detail
					$detail_param[':info_no']="0";
					$detail_param[':order_list_no']="0";
					$detail_param[':order_no']="";
					$detail_param[':as_cate']=$v[0]?$v[0]:"0";
					$detail_param[':as_sub_cate']=$v[1]?$v[1]:"0";
					$detail_param[':mall_no']="0";
					$detail_param[':mall_name']=$v[9];
					$detail_param[':brandnm']=$v[18];
					$detail_param[':goods_no']="0";
					$detail_param[':goodsnm']=$v[19];
					$detail_param[':serial_number']=$v[20];
					$detail_param[':product_point']=addslashes($v[21]);
					$detail_param[':delivery_code']=$delivery_code;
					$detail_param[':invoice']=$v[14];
					$detail_param[':delivery_price']=str_replace(",","",$v[16]);
					$detail_param[':return_delivery_price']=str_replace(",","",$v[17]);
					$detail_param[':as_contents']=$as_contents;
					$detail_param[':re_receipt']=$v[3];
					$detail_param[':case_yn']=$v[12];
					$detail_param[':action_yn']=$v[15];
					$detail_param[':progress_company']=$v[27];
					$detail_param[':send_delivery_code']=$send_delivery_code;
					$detail_param[':send_invoice']=$v[29];
					$detail_param[':in_regdate']=$v[30];
					$detail_param[':out_regdate']=$v[31];
					$detail_param[':schedule_date']=$v[32];
					$detail_param[':as_status']=$v[2];
					
					if($v['10']){
						$sqry="select ol.*, g.no as goodsno, ml.no as mallno from order_list ol
						left join goods g on (ol.goodsno=g.no)
						left join mall_list ml on (ol.mall_no=ml.no)
						where ol.ordno='".$v[10]."' and ol.goodsnm='".$v[19]."' and ol.mall_name='".$v[9]."'";
						$sres=$db->query($sqry);
						$order_data=$sres->results[0];

						if($order_data){
							$info_param[':order_no']=$v[10];

							$detail_param[':order_list_no']=$order_data['no'];
							$detail_param[':order_no']=$v[10];
							$detail_param[':mall_no']=$order_data['mallno'];
							$detail_param[':goods_no']=$order_data['goodsno'];
							
							$receipt_param[':order_list_no']=$order_data['no'];
							$receipt_param[':order_no']=$v[10];
							$receipt_param[':receipt_type']="0";
						}
					}

					$info_param[':order_reg']=PHPExcel_Style_NumberFormat::toFormattedString($v[11], 'YYYY-MM-DD');
					$detail_param[':in_regdate']=PHPExcel_Style_NumberFormat::toFormattedString($v[30], 'YYYY-MM-DD');
					$detail_param[':out_regdate']=PHPExcel_Style_NumberFormat::toFormattedString($v[31], 'YYYY-MM-DD');
					$detail_param[':schedule_date']=PHPExcel_Style_NumberFormat::toFormattedString($v[32], 'YYYY-MM-DD');
					
					$receipt_iqry="insert into cs_receipt set
					order_list_no=:order_list_no
					,order_no=:order_no
					,goodsnm=:goodsnm
					,customer_name=:customer_name
					,mobile=:mobile
					,delivery_code=:delivery_code
					,invoice=:invoice
					,account_code=:account_code
					,account_number=:account_number
					,memo=:memo
					,return_type=:return_type
					,return_type_sub=:return_type_sub
					,status=:status
					,admin_no=:admin_no
					,admin_name=:admin_name
					,receipt_type=:receipt_type
					,reg_date=now()
					";
					$receipt_ires=$db->query($receipt_iqry,$receipt_param);
					$lastReceiptNo=$receipt_ires->lastId;
					
					$info_param[':receipt_no']=$lastReceiptNo;
					$info_iqry="insert into as_info set
					receipt_no=:receipt_no
					,order_no=:order_no
					,receipt_name=:receipt_name
					,receiver=:receiver
					,mobile=:mobile
					,zipcode=:zipcode
					,address=:address
					,memo=:memo
					,customer_cost=:customer_cost
					,real_cost=:real_cost
					,order_buy=:order_buy
					,order_reg=:order_reg
					,admin_no=:admin_no
					,admin_name=:admin_name
					,mod_admin_no=:mod_admin_no
					,mod_admin_name=:mod_admin_name
					,mod_reg_date=:mod_reg_date
					,old_seq=:old_seq
					,reg_date=now()
					";
					$info_ires=$db->query($info_iqry,$info_param);
					$lastInfoNo=$info_ires->lastId;


					$detail_iqry="insert into as_detail set
					info_no=:info_no
					,order_list_no=:order_list_no
					,order_no=:order_no
					,as_cate=:as_cate
					,as_sub_cate=:as_sub_cate
					,mall_no=:mall_no
					,mall_name=:mall_name
					,brandnm=:brandnm
					,goods_no=:goods_no
					,goodsnm=:goodsnm
					,serial_number=:serial_number
					,product_point=:product_point
					,delivery_code=:delivery_code
					,invoice=:invoice
					,delivery_price=:delivery_price
					,return_delivery_price=:return_delivery_price
					,as_contents=:as_contents
					,re_receipt=:re_receipt
					,case_yn=:case_yn
					,action_yn=:action_yn
					,progress_company=:progress_company
					,send_delivery_code=:send_delivery_code
					,send_invoice=:send_invoice
					,in_regdate=:in_regdate
					,out_regdate=:out_regdate
					,schedule_date=:schedule_date
					,as_status=:as_status
					,reg_date=now()
					";
					$detail_param[':info_no']=$lastInfoNo;
					$detail_ires=$db->query($detail_iqry,$detail_param);
					$lastDetailNo=$detail_ires->lastId;

					#as_repair
					foreach($array_as_repair as $aarv){
					   
						$repair_param[':detail_no']=$lastDetailNo?$lastDetailNo:"0";
						$repair_param[':as_code']=$aarv[0]?$aarv[0]:"0";
						$repair_param[':as_quantity']=$aarv[1]?$aarv[1]:"0";
						$repair_param[':as_price']=str_replace(",","",$aarv[2]);
						$repair_param[':as_memo']="";
						if($aarv[0]=='99'){
							$repair_param[':as_memo']=$v[23];
						} 
						$repair_iqry="insert into as_repair set
						detail_no=:detail_no
						,as_code=:as_code
						,as_quantity=:as_quantity
						,as_price=:as_price
						,as_memo=:as_memo
						";
						$db->query($repair_iqry,$repair_param);
					}
					
				}

				//$db->rollBack();
				$db->commit();
				msg('처리되었습니다.','as_list.php?'.$QUERY_STRING);
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		}
	}else if($mode=='invoice_mod'){
		$excel_data=excel_read('unlink','2');

		foreach($excel_data as $k=>$v){
			// if(!in_array($v['0'],$inv_name))$err_msg[]=$k."번열 등록되지않은 택배사명";
		}
		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				//  tydebug($excel_data);
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
					if($v[5] && $v[7]){
						$uqry="update as_detail set
						send_delivery_code='CJGLS'
						,send_invoice='".$v[7]."'
						,out_regdate='".$v[30]."'
						where info_no='".$v[5]."'
						";
						
						$db->query($uqry);
					}					
				}

				//$db->rollBack();
				$db->commit();
				msg('처리되었습니다.','as_list.php?'.$QUERY_STRING);
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		}
	}		
}




if($mode=='del'){
	$qry="delete from as_info where no=:no";
	$param[':no']=$no;

    $db->query($qry,$param);
    
    $dqry="delete from as_detail where info_no=:info_no";
	$dparam[':info_no']=$no;

	$db->query($dqry,$dparam);
	msg('삭제되었습니다.',$returnUrl);

}else if($mode=='send_sms'){
    if(count($_POST['chk_no'])){
        foreach($_POST['chk_no'] as $v){
            query_smsSend('as', $v);

        }
    }
    if(count($_POST['hand_chk_no'])){
        foreach($_POST['hand_chk_no'] as $v){
            query_smsSend('as', $v);
        }
    }
    msg('발송되었습니다.',$returnUrl);

}else if($mode=='step_change'){
    if(count($_POST['chk_no'])){
        foreach($_POST['chk_no'] as $v){      
			$uqry="update as_detail set
			as_status='".$_POST['as_status']."'
			where info_no='".$v."'
			";
			$db->query($uqry);
        }
    }
    msg('처리되었습니다.','as_list.php?'.$QUERY_STRING);

}else if($mode=='as_del'){
    if(count($_POST['chk_no'])){
        foreach($_POST['chk_no'] as $v){      
			$dqry="delete from as_detail
			where info_no='".$v."'
			";
			$db->query($dqry);

			$dqry="delete from as_info
			where no='".$v."'
			";
			$db->query($dqry);
        }
    }
    msg('처리되었습니다.','as_list.php?'.$QUERY_STRING);
}

function query_smsSend($table, $no){
    global $db;
    global $cfg_as_contents;
    if($table=='as'){
        $qry="select *, ad.no as detail_no from as_info ai 
        left join as_detail ad on (ai.no=ad.info_no)
        where ai.no='".$no."'";
        $res=$db->query($qry);
        $data=$res->results[0];
        if($data['as_status']){
            //sms 발송 (자동발송 중지)
			$mqry="select * from as_repair where detail_no='".$data['detail_no']."'";
			$mres=$db->query($mqry);
			foreach($mres->results as $mv){
				if($mv['as_code']=='98' || $mv['as_code']=='99'){
					if($mv['as_memo']) $asContents[]=$mv['as_memo'];
				}else{
					$asContents[]=$cfg_as_contents[$data['as_cate']][$mv['as_code']];
				}
			}
			/*
            $as_contents=explode("|",$data['as_contents']);//수리내용
            foreach($as_contents as $cv){
                $asContents[]=$cfg_as_contents[$data['as_cate']][$cv];
            }
			*/
            $qry="select * from sms_info where type='1' and code='".$data['as_status']."'";
            $res=$db->query($qry);
            $smsData=$res->results[0];
            
            $smscontents=str_replace("[접수자]",$data['receipt_name'],$smsData['contents']);
            $smscontents=str_replace("[수리내용]",implode(", ",$asContents),$smscontents);
			$smscontents=str_replace("[고객비용]",number_format($data['customer_cost'])."원",$smscontents);
			$smscontents=str_replace("[출고택배정보]",$data['send_invoice'],$smscontents);

            sms_send($smsData['title'], $smscontents, $data['mobile'], 'as', $data['no'], $data['as_status'], $data['order_no']);
        }
    }
}



if($_GET['search_no']){
	$add_where[]="ai.no='".$_GET['search_no']."'";
}else if($_GET['schedule_3']){
	$add_where[]="ad.as_status < 6 and DATEDIFF(ad.schedule_date,NOW()) < 3";
}else{
	if($_GET['s_receiver']) $add_where[]="concat(ai.receiver,' ',ai.receipt_name) like '%".$_GET['s_receiver']."%'";
	if(count($_GET['s_mall_no']))$add_where[]="ad.mall_no in ('".implode("','",$_GET['s_mall_no'])."')";
	if($_GET['s_mobile'])$add_where[]="concat(ai.mobile) like '%".$_GET['s_mobile']."%' ";
	if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ad.in_regdate between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
	if($_GET['s_date2'] && $_GET['e_date2'])$add_where[]="ad.out_regdate between '".$_GET['s_date2']."' and '".$_GET['e_date2']."'";
	if($_GET['s_goodsnm'])$add_where[]="ad.goodsnm like '%".$_GET['s_goodsnm']."%' ";
	if($_GET['s_invoice'])$add_where[]="concat(ad.invoice,ad.send_invoice) like '%".$_GET['s_invoice']."%' ";
	if($_GET['s_ordno'])$add_where[]="ad.order_no like '%".$_GET['s_ordno']."%' ";
	if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
	
	if($_GET['s_total']!=''){
		foreach($cfg_as_contents as $k=>$v){
			foreach($v as $k2=>$v2){
				$as_contents_code[$v2]=$k2;
			}
		}
		$add_where[]="(ad.brandnm like '%".$_GET['s_total']."%' or ad.progress_company like '%".$_GET['s_total']."%' or ad.no in (select detail_no from as_repair where as_code='".$as_contents_code[$_GET['s_total']]."') or ai.past_order_no like '%".$_GET['s_total']."%')";
	}
	if($_GET['s_delivery']!='')$add_where[]="ad.order_list_no > 0  ";
}
/*
if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
*/
if($_GET){
	/*리스트*/
		
	$_GET[page_num]=50;
	$field="ai.*
    , ad.order_list_no, ad.delivery_code, ad.invoice, ad.in_regdate, ad.out_regdate, ad.as_status, ad.brandnm, ad.goodsnm, ad.progress_company, ad.schedule_date, ad.send_invoice, ad.send_delivery_code
    , g.goodsnm as g_goodsnm
    , b.brand_img_folder
    , m.id, m.name
    , (select id from member mm where mm.no=ai.mod_admin_no) as mod_id
    , (select name from member mm where mm.no=ai.mod_admin_no) as mod_name
    , ifnull(DATEDIFF(ad.schedule_date,NOW()),'미등록') as leftDate";
	$db_table="as_info ai 
    left join as_detail ad on (ai.no=ad.info_no)
    left join order_list ol on (ad.order_list_no=ol.no)
    left join goods g on (ad.goods_no=g.no) 
	left join brand b on (g.brandno = b.no)
	left join member m on (m.no=ai.admin_no)
	";

	if($_GET['s_as_status']!='')$add_where[]=" ad.as_status = '".$_GET['s_as_status']."'";

	$pg = new page($_GET[page],$_GET[page_num]);
	//$pg->cntQuery = "select count(distinct m.no) from model";
	$pg->field = $field;
	$pg->setQuery($db_table,$add_where,'reg_date desc');

	$pg->exec();
	$qry=$pg->query;



/*
    $qry="select ai.*
    , ad.order_list_no, ad.delivery_code, ad.invoice, ad.in_regdate, ad.out_regdate, ad.as_status, ad.brandnm, ad.goodsnm, ad.progress_company, ad.schedule_date
    , g.goodsnm as g_goodsnm
    , b.brand_img_folder
    , m.id, m.name
    , (select id from member mm where mm.no=ai.mod_admin_no) as mod_id
    , (select name from member mm where mm.no=ai.mod_admin_no) as mod_name
    , ifnull(DATEDIFF(ad.schedule_date,NOW()),'미등록') as leftDate
    from as_info ai 
    left join as_detail ad on (ai.no=ad.info_no)
    left join order_list ol on (ad.order_list_no=ol.no)
    left join goods g on (ad.goods_no=g.no) 
	left join brand b on (g.brandno = b.no)
	left join member m on (m.no=ai.admin_no)
    where 1=1 ".$add_where."";
	if($_GET['s_as_status']!='')$qry.=" and ad.as_status = '".$_GET['s_as_status']."'";
	$qry.=" order by reg_date desc";
	*/
	$res = $db->query($qry);
	foreach($res->results as $v){

		$v = infoMasking($v, 'as_info'); //마스킹

        if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['g_goodsnm']);
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
        //$v['leftDate']=0;
        //if($v['schedule_date']!='0000-00-00') $v['leftDate'] = intval((strtotime($v['schedule_date']) - strtotime($now_date)) / 86400); 
        if($v['leftDate']!='미등록' && $v['leftDate'] < $leftNum && $v['as_status'] < 6){
            $leftCount++;
        }
        //주문번호 매칭 접수건
        // if($v['order_list_no']){
        //     $receipt_type="order";
        // //수기 접수건
        // }else{
        //     $receipt_type="hand";
        // }
        
        // $loop[$receipt_type][]=$v;
        $loop[]=$v;
	}

	$tpl->assign(array(	
	'loop' => $loop
	,'pg'=> $pg	
	));
}

//네비통계
$nav_qry="select 
ad.as_status,count(ad.no) as cnt
from as_info ai 
left join as_detail ad on (ai.no=ad.info_no)
left join order_list ol on (ad.order_list_no=ol.no)
left join goods g on (ad.goods_no=g.no) 
left join brand b on (g.brandno = b.no)
left join member m on (m.no=ai.admin_no)
where 1=1 ";
if($_GET['schedule_3']){
	$nav_qry.=" and ad.as_status < 6 and DATEDIFF(ad.schedule_date,NOW()) < 3";
}else{
	if($_GET['s_date'] && $_GET['e_date']){
		$nav_qry.=" and ad.in_regdate between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
	}
}
if($_GET['schedule_3']) $nav_parm[]="schedule_3=Y";
if($_GET['s_date'] && $_GET['e_date']){
	$nav_parm[]="s_date=".$_GET['s_date'];
	$nav_parm[]="e_date=".$_GET['e_date'];
}
if($nav_parm) $nav_parm="&".implode("&",$nav_parm);
$nav_qry.=" group by ad.as_status";


$nav_res = $db->query($nav_qry);
foreach($nav_res->results as $v){
    $data_nav[$v['as_status']]=$v['cnt'];
}

foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}

$selected['ing_type'][$_GET['s_ing_type']]="selected";
$selected['as_status'][$_GET['s_as_status']]="selected";
$checked['schedule_3'][$_GET['schedule_3']]="checked";
$checked['s_delivery'][$_GET['s_delivery']]="checked";

$tpl->assign(array(	
	'mall_list' => $mall_list
	,'delivery_list'=>$delivery_list
));
    
$tpl->print_('tpl');
?>
