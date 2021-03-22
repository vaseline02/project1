<?
include "../_header.php";

$page_title='품절목록';
$GOODS=new goods();
$QUERY_STRING = $_SERVER['QUERY_STRING'];

$time = time(); 
$s_date_value=$_GET['sdate']?$_GET['sdate']:date("Y-m-d",strtotime("now", $time)); 
$e_date_value=$_GET['edate']?$_GET['edate']:date("Y-m-d",strtotime("now", $time)); 

if($_POST['chk_no']){
	try{
		
		$db->beginTransaction();	
        if($_POST['mode']=='confirm'){
			foreach($_POST['chk_no'] as $v){
				$uqry="update stock_soldout_log set 
				confirm_admin='".$_SESSION["sess"]["m_no"]."'
				,confirm_date=now()
				where no='".$v."'";

				$db->query($uqry);				
			}			
		}

		
		$db->commit();
		msg("처리되었습니다","stock_soldout_list.php?".$QUERY_STRING);
		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}


}



/*리스트*/
if($_GET['sdate'] && $_GET['edate']){
	$add_where[]="DATE_FORMAT(ssl2.reg_date,'%Y-%m-%d') between '".$_GET['sdate']."' and '".$_GET['edate']."'";
}
if($_GET['goodsnm']){
	$add_where[]="g.goodsnm='".$_GET['goodsnm']."'";
}
if($add_where){
    $qry="select ssl2.*, g.goodsnm as g_goodsnm, m.name as admin_name from stock_soldout_log ssl2
	left join goods g on (ssl2.goodsno=g.no)
	left join member m on (ssl2.confirm_admin=m.no)
    where 
	".implode(" and ", $add_where)."
    order by ssl2.reg_date desc
    ";

    $res = $db->query($qry);
    foreach($res->results as $v){
		$goods_stock=$GOODS->get_stock_deli_av(array($v['g_goodsnm']));
		if($v['type']==0) $v['typename']="주문업로드";
		else $v['typename']="발송확정";

		$v['totalnum']=$goods_stock->results['0']['totstock'];
        $loop[]=$v;
    }

    $tpl->assign(array(	
    'loop' => $loop
    ));
}
$tpl->print_('tpl');
?>
