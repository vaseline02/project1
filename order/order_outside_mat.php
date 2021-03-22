<?
include "../_header.php";

$page_title='본사상품공급가관리';

//$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];

$_GET[page_num]=$_GET[pagelimit]=="y"?"9999999":"100";

$brandList=get_brand_info();

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_FILES){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
		foreach($excel_data as $k=>$v){			
			$qry="select * from brand b where brandnm='".$v[1]."'";
			$res=$db->query($qry);
			$bno=$res->results[0]['no'];
			if(!$bno){
				$err_msg[]=$k."번열 브랜드가 존재하지않습니다.";	
			}else{
				$brandno[$k]=$bno;
			}
		}

		if (!sizeof($err_msg)) {
			try{
				
				$db->beginTransaction();

				foreach($excel_data as $k=>$v){		

					$qry="select * from order_outside_brand_mat b where goodsnm='".$v[0]."'";
					$res=$db->query($qry);
					$matData=$res->results[0];
					if($matData){
						$uqry="update order_outside_brand_mat set
						brandno='".$brandno[$k]."'
						,consumer_price='".$v['2']."'
						,purchase_price='".$v['3']."'
						,mod_admin_no='".$_SESSION['sess']['m_no']."'
						,mod_reg_date=now()
						where no='".$matData['no']."'
						";
						$db->query($uqry);

					}else{
						$iqry="insert into order_outside_brand_mat set
						goodsnm='".$v['0']."'
						,brandno='".$brandno[$k]."'
						,consumer_price='".$v['2']."'
						,purchase_price='".$v['3']."'
						,admin_no='".$_SESSION['sess']['m_no']."'
						,reg_date=now()
						";
						$db->query($iqry);
					}					
				}
				

				//$db->rollBack();
				$db->commit();
			   
				msg('처리되었습니다.','order_outside_mat.php?'.$QUERY_STRING);
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		}
	}
}



if($mode=="ins"){
    try
    {
        $db->beginTransaction();

		$qry="select * from order_outside_brand_mat
		where goodsnm='".$_POST['goodsnm']."'
		";
		$res=$db->query($qry);
		$matData=$res->results[0];

		if(!$matData){

			$iqry="insert into order_outside_brand_mat set
			goodsnm='".$_POST['goodsnm']."'
			,brandno='".$_POST['brandno']."'
			,admin_no='".$_SESSION['sess']['m_no']."'
			,reg_date=now()
			";
			$db->query($iqry);
			
			$db->commit();
			msg('등록되었습니다.',"order_outside_mat.php?".$QUERY_STRING);
		
		}else{
			msg('이미등록되있는 상품입니다.',"order_outside_mat.php?".$QUERY_STRING);
		}
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"order_outside_mat.php?".$QUERY_STRING);
    }  
}else if($mode=="del"){
    $no=$_POST["no"];

    $dqry="delete from order_outside_brand_mat where no='".$no."'";
    $db->query($dqry);

    msg("삭제되었습니다.","order_outside_mat.php?".$QUERY_STRING);

}else if($mode=="mod"){

}

//if($_POST['s_goodsnm'] || $_POST['s_multi_goodsnm']){
	if($_REQUEST['s_multi_goodsnm']){
		$s_multi_goodsnm_paste=paste_to_arr($_REQUEST['s_multi_goodsnm']);
		if($s_multi_goodsnm_paste){
			$s_multi_goodsnm_paste_imp=implode("','",$s_multi_goodsnm_paste);
			$where[]="oobm.goodsnm in ('".$s_multi_goodsnm_paste_imp."')";	
		}		
	}

	if($_REQUEST['s_goodsnm']){
		$where[]="oobm.goodsnm like '%".$_REQUEST['s_goodsnm']."%'";	
	}
	if($_REQUEST['s_brand']){
		$where[]="b.brandnm like '%".$_REQUEST['s_brand']."%'";	
	}

	$field="oobm.*, b.brandnm";
	$db_table="order_outside_brand_mat oobm
	left join brand b on (oobm.brandno=b.no)
	";

	$sort="oobm.no desc";

	$pg = new page($_GET[page],$_GET[page_num],$no_limit);
	$pg->field = $field;

	$pg->setQuery($db_table,$where,$sort);
	$pg->exec();
	$res = $db->query($pg->query);

	//tydebug($pg->query);

/*
	$qry="select oobm.*, b.brandnm from order_outside_brand_mat oobm
	left join brand b on (oobm.brandno=b.no)
	";
	if($where) $qry.=" where ".implode(" and ", $where);
	$qry.=" order by oobm.no desc";

	$res=$db->query($qry);
	*/
	foreach($res->results as $k=>$v){
		$sqry="select * from mall_brand mb
		left join mall_list ml on (mb.mall_no=ml.no)
		where mb.brand_no='".$v['brandno']."'
		order by mb.no desc limit 1
		";
		$sres=$db->query($sqry);
		$mallData=$sres->results[0];

		$v['mall_name']=$mallData['mall_name'];
		$v['mall_name']=$mallData['mall_name'];

		$selected['outside_brand'][$v['no']][$v['brandno']]="selected";
		$loop[]=$v;
	}
//}

$checked['pagelimit'][$_GET['pagelimit']]="checked";

$tpl->assign(array(
    'loop'=>$loop    
	,'pg'=> $pg	
));

$tpl->print_('tpl');
?>
