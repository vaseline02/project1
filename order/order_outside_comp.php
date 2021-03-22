<?
include "../_header.php";

$page_title='외부발송완료목록';
$ORDER=new order();

//택배사 함수
$delivery_list=get_delivery_info();
$QUERY_STRING = $_SERVER['QUERY_STRING'];

$mall_list=get_mall_info('y');

$selected['order_search_mall'][$_POST['order_search_mall']]='selected';

foreach($mall_list as $v){
    $uplolad_mall[$v['upload_form_type']][$v['no']]=$v['mall_name']."(".$v['mall_code'].")";
}
$time = time(); 
$s_date_value=$_POST['order_search_comp_sdate']?$_POST['order_search_comp_sdate']:date("Y-m-d",strtotime("now", $time)); 
$e_date_value=$_POST['order_search_comp_edate']?$_POST['order_search_comp_edate']:date("Y-m-d",strtotime("now", $time)); 

if($_POST['chk_no']){
	try{
		
		$db->beginTransaction();	
        if($_POST['mode']=='info_chg'){
			foreach($_POST['chk_no'] as $k=>$v){
				foreach($v as $sk=>$sv){
					if($k=="order"){
						
						$uqry="update order_list set purchase_price=:purchase_price, ent_deli_price=:ent_deli_price where no=:no";

						$uparam[':purchase_price']=$_POST['mod_purchase_price'][$k][$sv];
						$uparam[':ent_deli_price']=$_POST['mod_ent_deli_price'][$k][$sv];
						$uparam[':no']=$sv;
						$db->query($uqry,$uparam);				

					}else if($k=="other"){
						$uqry="update other_cost_calcu set price=:price, deli_price=:deli_price where no=:no";

						$uparam[':price']=$_POST['mod_purchase_price'][$k][$sv];
						$uparam[':deli_price']=$_POST['mod_ent_deli_price'][$k][$sv];
						$uparam[':no']=$sv;
						$db->query($uqry,$uparam);		
					}

				}

			}
			
		}

		/*
		else if($_POST['mode']=='return_order'){
			
			$qry="SHOW FULL COLUMNS FROM order_list";
			$res=$db->query($qry);
			
			foreach($res->results as $v){
				
				if($v['Field']!='no'){
					
					$col_name[]=$v['Field'];
				}
			}



			foreach($_POST['chk_no'] as $v){
				unset($param);
				$qry="insert into order_list (".implode(",",$col_name).") select ".implode(",",$col_name)." from order_list where no=:no";
				$param[':no']=$v;
				
				$res=$db->query($qry,$param);

				$last_ID=$db->lastId;

				unset($param);
				$qry="update order_list set 
				settle_price=(settle_price*-1)
				,purchase_price=(purchase_price*-1)
				,reg_date=now()
				,mod_date=now()
				,comp_date=now()
				,ent_deli_price=:ent_deli_price where no=:no";
				$param[':ent_deli_price']=$_POST['return_deli_price'];
				$param[':no']=$last_ID;
				$res=$db->query($qry,$param);
			}
			
		}else if($_POST['mode']=='comp_change'){
			foreach($_POST['chk_no'] as $v){
				
				$qry="update order_list set 
				comp_date='".$_POST['u_comp_date']."'
				where no='".$v."'";
				
				$res=$db->query($qry);
			}
		}
*/
		$db->commit();
		msg("처리되었습니다","order_outside_comp.php");
		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}


}


$data_search = $ORDER->order_search_where();
/*리스트*/


if(($_POST['order_search_comp_sdate'] && $_POST['order_search_comp_edate']) && !$_POST['order_search_mall'] && !$_POST['order_search_brand'] && !$_POST['order_search_receiver'] && !$_POST['order_search_ordno']){

	if($_POST['order_search_comp_sdate'] && $_POST['order_search_comp_edate']){
		$add_where[]="left(occ.comp_date,10) between '".$_POST['order_search_comp_sdate']."' and '".$_POST['order_search_comp_edate']."'";
	}
		
	if($_POST['order_search_goodsnm']){
		$add_where[]="g.goodsnm='".$_POST['order_search_goodsnm']."'";
	}


	if($_POST['order_search_goodsnm_all']){
		$order_search_goodsnm_all=paste_to_arr($_POST['order_search_goodsnm_all']);
		if($order_search_goodsnm_all){

			if(count($order_search_goodsnm_all)==1){
				$add_where[]="g.goodsnm like '".$order_search_goodsnm_all['0']."%' ";	
			}else{
				$order_search_goodsnm_all_imp=implode("','",$order_search_goodsnm_all);
				$add_where[]="g.goodsnm in ('".$order_search_goodsnm_all_imp."')";	
			}
		}			
	}
	
	$qry="SHOW FULL COLUMNS FROM order_list";
	$res=$db->query($qry);
	foreach($res->results as $cv){
		if($cv['Field']=='no'){ $order_columns[]="occ.no";}
		else if($cv['Field']=='order_num'){ $order_columns[]="occ.num as order_num";}
		else if ($cv['Field']=='purchase_price'){ $order_columns[]="occ.price as purchase_price";}
		else if ($cv['Field']=='ent_deli_price'){ $order_columns[]="occ.deli_price as ent_deli_price";}
		else if ($cv['Field']=='reg_date'){ $order_columns[]="occ.reg_date";}
		else if ($cv['Field']=='mod_date'){ $order_columns[]="occ.reg_date as mod_date";}
		else if ($cv['Field']=='goodsnm'){ $order_columns[]="g.goodsnm";}
		else if ($cv['Field']=='memo'){ $order_columns[]="occ.memo";}
		else{
			if(strpos($cv['Type'], 'int') !== false){
				$order_columns[]="'0' as ".$cv['Field'];
			}else{
				$order_columns[]="'' as ".$cv['Field'];
			}
			
		}
	}

	$union_qry="union 
	select 'other' as stype ,occ.data_type data_type,".implode(',',$order_columns).", b.brandnm, ml.mall_code, ml.c_mem_name, ml.d_code, ml.d_name from other_cost_calcu occ
	left join goods g on (occ.goodsno=g.no)
	left join brand b on (g.brandno=b.no)
	left join mall_list ml on (ml.d_code=occ.d_code)
	where ".implode(" and ",$add_where)."
	";
	
}



if($data_search){
    $qry="select 'order' as stype,'order' as data_type, ol.*, b.brandnm, ml.mall_code, ml.c_mem_name, ml.d_code, ml.d_name from order_list ol
    left join brand b on (ol.outside_brand=b.no)
    left join mall_list ml on (ml.d_code=ol.ent_code)
    where ol.step in ('5','60','61')
    and ol.step2='0'
    and deli_codeno='outside'
    ".$data_search['where']."	
	".$union_qry."
    order by reg_date desc
    ";

	//tydebug($qry);

    $res = $db->query($qry,$data_search['param']);
    foreach($res->results as $v){

		$v = infoMasking($v, 'order_list'); //마스킹

		if($print_xls==1){
			
			$v['purchase_price']=$v['purchase_price']*(-1);
			$v['ent_deli_price']=$v['ent_deli_price']*(-1);
		}

		$mdate=$v['mod_date'];

		$mdate_m=date("n",strtotime($mdate)); 

		$tday_m=date("n"); 
		$tday_d=date("j"); 

		$cha=$tday_m-$mdate_m;

		$v['view_type']='text';
		if($cha==0 || ( $cha==1 && $tday_d<=5 ) ){
			$v['view_type']="input";
		}
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
}
$tpl->print_('tpl');
?>
