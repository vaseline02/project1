<?
include "../_header.php";

$page_title='외부발송목록';
$ORDER=new order();

//택배사 함수
$delivery_list=get_delivery_info();
$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_FILES && $_POST['mode']=="memoupdate"){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			if(!$v[0])$err_msg[]=$k."번열 상품명이 존재하지않습니다.";            
			if(!$v[6])$err_msg[]=$k."번열 주문번호가 존재하지않습니다.";            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				$dmsg=memo_indb($excel_data);

				//$db->rollBack();
                $db->commit();
	            msg('처리되었습니다.'.$dmsg,'order_outside.php?'.$QUERY_STRING);

			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}else if($_FILES){
	$excel_data=excel_read('unlink','3');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			if(!$v[5])$err_msg[]=$k."번열 상품명이 존재하지않습니다.";            
			if(!$v[16])$err_msg[]=$k."번열 주문번호가 존재하지않습니다.";            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
					$dqry="select code from delivery_info where name='".$v[24]."'";
					
					$dres=$db->query($dqry);
					$deliverynm=$dres->results[0]['code'];

					$sqry="select * from brand where brandnm='".$v[4]."' and type in ('A','O') limit 1";
					$sres=$db->query($sqry);
					$brandData=$sres->results[0];
					$outside_brand="";
					if($brandData['no']){
						$outside_brand=",outside_brand='".$brandData['no']."'";
					}


					$mod_date = $v[3]; 
					$mod_date = PHPExcel_Style_NumberFormat::toFormattedString($mod_date, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);


					$uqry="update order_list set courier_code='".$deliverynm."'
					,invoice='".$v[25]."'
					,ent_code='".$v[27]."'
					,consumer_price='".$v[7]."'
					,purchase_price='".$v[8]."' 
					".$outside_brand."
					,memo=concat(ifnull(memo,''),' ','".$v[12]."')
					,mod_date='".$mod_date."'
					,ent_deli_price='".$v[9]."'
					where goodsnm='".$v[5]."' and ordno='".$v[16]."' and step='6'
					";
					$db->query($uqry);

				}
				
				if($dupl_key)$dmsg=implode(",",$dupl_key)."열 미적용(변경사항있음)";
				//$db->rollBack();
                $db->commit();
               
				msg('처리되었습니다. '.$dmsg,'order_outside.php');
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}




if($_POST['chk_no']){
	try{
		
		$db->beginTransaction();	
		
		if($_POST['mode']=='goodsnm_chg'){

			$GOODS=new goods();

			foreach($_POST['chk_no'] as $v){
				
				$arr_model[]=$_POST['mod_goodsnm'][$v];

				$qry="update order_list set goodsnm=:goodsnm where no=:no and step=6";

				$param[':goodsnm']=$_POST['mod_goodsnm'][$v];
				$param[':no']=$v;

				$db->query($qry,$param);
			
			}
			
		}else if($_POST['mode']=='goback'){
			
			$ORDER->ctl_step($_POST['chk_no'],'6');
				
		}else if($_POST['mode']=='memoIns'){
			$QUERY_STRING.=order_return_url();

			$ORDER->admin_memo($_POST['chk_no'],$_POST['i_memo']);
	
		}else if($_POST['mode']=='hold_order'){
			
			$ORDER->order_step_chg('','8','0',$_POST['chk_no']);	
			
		}else if($_POST['mode']=='order_comp'){

			foreach($_POST['chk_no'] as $v){
				
				if($_POST['hid_invoice'][$v]!=0){
					
					$qry="update order_list set step='5' ,comp_date=now() where no=:no and invoice!=0 and purchase_price>0 and courier_code!='' and outside_brand!='' and goodsnm!='' 
					#and ent_deli_price>0 
					";
					$res=$db->query($qry,array(":no"=>$v),'test');
				}
			}

		}else if($_POST['mode']=='cancel'){

			$step_return=$ORDER->order_step_chg('','6','46',$_POST['chk_no']);	
		}else if($_POST['mode']=='info_chg'){

			foreach($_POST['chk_no'] as $v){

				$sqry="select b.*, ml.d_code from brand b
				left join (select * from mall_brand group by brand_no) mmb on mmb.brand_no=b.no
			    left join mall_list ml on (ml.no=mmb.mall_no)
				where b.brandnm='".$_POST['mod_brand'][$v]."' and type in ('A','O') limit 1";
				$sres=$db->query($sqry);
				$brandData=$sres->results[0];

				$bqry="update order_list set outside_brand=:outside_brand, ent_code=:ent_code where no=:no and step=6";

				$bparam[':outside_brand']=$brandData['no'];
				$bparam[':ent_code']=$brandData['d_code'];
				$bparam[':no']=$v;

				$db->query($bqry,$bparam);

				$arr_model[]=$_POST['mod_goodsnm'][$v];

				$gqry="update order_list set goodsnm=:goodsnm where no=:no and step=6";

				$gparam[':goodsnm']=$_POST['mod_goodsnm'][$v];
				$gparam[':no']=$v;

				$db->query($gqry,$gparam);
			
			}
			
		}

		$db->commit();
		
		msg("처리되었습니다","order_outside.php?".$QUERY_STRING);
		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}


}


$data_search = $ORDER->order_search_where();
/*리스트*/
$qry="select ol.*, b.brandnm, ml.mall_code, ml.c_mem_name, ml.d_code, ml.d_name from order_list ol
left join brand b on (ol.outside_brand=b.no)
left join mall_list ml on (ml.d_code=ol.ent_code)
where ol.step='6' 
and ol.step2='0'
".$data_search['where']."
order by reg_date desc, no desc
";

$res = $db->query($qry,$data_search['param']);
foreach($res->results as $v){
	$v=infoMasking($v,'order_list'); //마스킹
	$v['deliverynm']=$delivery_list[$v['courier_code']]['name'];
	
	$v['mod_date']=substr($v['mod_date'],0,10);
	//$v['mod_date']=date('Y-m-d',strtotime($v['mod_date']));
	$orderType=orderType($v['no']);
	$v['order_type']=$orderType;
	if($v['bundle']>0)$v['bundle_color']="red";
	$invo_upload_mall[$v['upload_form_type']]=$v['upload_form_type'];
	$loop[]=$v;
}

if($_SESSION['sess']['h_level']<'10'){
	$nav_view="1";	
}

$tpl->assign(array(	
'loop' => $loop
,'delivery_list' => $delivery_list
));

$tpl->print_('tpl');
?>
