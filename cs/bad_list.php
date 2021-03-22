<?
include "../_header.php";

$step=$_GET['step'];

$page_title=$cfg_bad[$step]?$cfg_bad[$step]:"하자리스트";

$CANCEL=NEW cancel();
/*매장코드*/
$codedata=get_codedata('place','1'); 

$QUERY_STRING = $_SERVER['QUERY_STRING'];
$_GET['step_sub']=$_GET['step_sub']?$_GET['step_sub']:"0";

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 
$s_date_search=$_GET['s_date_search']?$_GET['s_date_search']:'reg_date'; 

$selected['s_date_search'][$_GET['s_date_search']]="selected";
$checked['close_yn'][$_GET['close_yn']]="checked";


if($_FILES && $_POST['mode']=="excelupload"){
	$excel_data=excel_read('unlink','2');

	foreach($excel_data as $k=>$v){
		if(!$v['0']){
			$err_msg[]=$k."번열 모델명 없음";
		}else{
			$sqry="select * from goods g
			where g.goodsnm='".$v[0]."'";
			$sres=$db->query($sqry);
			$goodsData[$k]=$sres->results[0];

			if(!$goodsData[$k]){
				$err_msg[]=$k."번열 매칭되는 모델없음";
			}
		}
	}
	if (sizeof($err_msg) > 0) {
		tydebug($err_msg);
	}else{
		try{
			$db->beginTransaction();
			foreach($excel_data as $k=>$v){
				for($i=0;$i<$v[1];$i++){
					$cost=$CANCEL->bad_calc_stock($goodsData[$k]['no'],'1');	
					//$cost=1;

					$iqry="insert into cs_bad set
					goods_no='".$goodsData[$k]['no']."'
					,goodsnm='".$goodsData[$k]['goodsnm']."'
					,quantity=1
					,cost='".$cost."'
					,memo='".$v[2]."'
					,step=1
					,admin_no='".$_SESSION['sess']['m_no']."'
					,mod_admin_no='".$_SESSION['sess']['m_no']."'
					,reg_date=now()
					";
					$db->query($iqry);
				}				
			}
			
			//$db->rollBack();
			$db->commit();
			msg('처리되었습니다.',"bad_list.php?".$QUERY_STRING);
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage().":".$e->getFile());	
		}
	}
}else if($_POST['mode']=="step"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();

			$CANCEL->badMod($_POST['chk_no'],$_POST['mode'],$_POST['step'],$_POST['codeSelect']);
			
			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다.","bad_list.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"bad_list.php?".$QUERY_STRING);		
		}  
	}
}else if($_POST['mode']=="memo" || $_POST['mode']=="admin_memo"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();						
			$CANCEL->badMod($_POST['chk_no'],$_POST['mode'],$_POST['i_memo']);
	
			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다.","bad_list.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"bad_list.php?".$QUERY_STRING);		
		}  
	}	
}

//if($_GET['s_date'] && $_GET['e_date'] && $_GET['s_date_search'])$add_where[]="cb.".$_GET['s_date_search']." between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($s_date_value && $e_date_value && $s_date_search)$add_where[]="cb.".$s_date_search." between '".$s_date_value." 00:00:00' and '".$e_date_value." 23:59:59'";
if($_GET['s_goodsnm'])$add_where[]="cb.goodsnm='".$_GET['s_goodsnm']."' ";
if($_GET['s_mod_admin'])$add_where[]="m.name='".$_GET['s_mod_admin']."'";
//if($_GET['s_mod_date'] && $_GET['e_mod_date'])$add_where[]="cb.mod_date between '".$_GET['s_mod_date']." 00:00:00' and '".$_GET['e_mod_date']." 23:59:59'";
if($_GET['s_no'])$add_where[]="cb.no='".$_GET['s_no']."' ";
if($_GET['s_order_no'])$add_where[]="cb.order_no='".$_GET['s_order_no']."' ";
if($_GET['s_memo'])$add_where[]="cb.memo like '%".$_GET['s_memo']."%' ";
if($_GET['s_repair_memo'])$add_where[]="cb.repair_memo like '%".$_GET['s_repair_memo']."%' ";
if($_GET['s_admin_memo'])$add_where[]="cb.admin_memo like '%".$_GET['s_admin_memo']."%' ";
if($_GET['s_company_name'])$add_where[]="cb.company_name like '%".$_GET['s_company_name']."%' ";

if($step) $add_where[]="cb.step = '".$step."'";
if($_GET['close_yn']=='n') $add_where[]="cb.step != '60'";
if($step=='1'){
	if($_GET['step_sub']){
		$add_where[]="cb.order_no = ''";
	}else{
		$add_where[]="cb.order_no != ''";
	}
}

if(count($add_where)){
    /*리스트*/	
	$qry="select cb.*,m.name, g.img_name, g.goodsnm as g_goodsnm,b.brandnm,b.brand_img_folder from cs_bad cb 
	left join member m on (cb.mod_admin_no=m.no)
	left join goods g on g.goodsnm=cb.goodsnm
	left join brand b on b.no=g.brandno
	where 1=1 ";	
	if($add_where) $qry.=" and ".implode(" and ",$add_where);
	$qry.=" order by no desc ";

	$res=$db->query($qry);
	foreach($res->results as $v){		
		$ex_cost=explode("^",$v['cost']);
		$v['cost']=$ex_cost['1'];
		if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['g_goodsnm']);
		$loop[]=$v;
	}
	$tpl->assign(array(	
	'loop' => $loop
	));
}
    
$tpl->print_('tpl');
?>
