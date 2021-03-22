<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
$page_title='재고조정';

$time = time(); 

$_GET['s_date']=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 day", $time)); 
$_GET['e_date']=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

$mode=$_POST["mode"];
$no=$_POST["no"];
$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_GET['s_date'] && $_GET['e_date'])$add_where[]="DATE_FORMAT(scl.reg_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
if($_GET['s_goodsnm'])$add_where[]="scl.goodsnm like '%".$_GET['s_goodsnm']."%' ";

if($_GET){
	/*리스트*/
	if($add_where) $sum_where.=" and ".implode(" and ", $add_where)."";
		
	//증가쿼리
	$qry="select scl.*, c.cd, g.goodsnm as g_goodsnm from stock_change_log scl
	left join codedata c on (scl.code_no=c.no)
	left join goods g on (scl.goodsno=g.no)
	where 1=1 ".$sum_where." order by reg_date desc";
	$res = $db->query($qry);
	foreach($res->results as $v){         
		if($v['stock_type']==0)$v['typenm']="증가";
		else if($v['stock_type']==1)$v['typenm']="차감";

        $loop[]=$v;
	}

	$tpl->assign(array(	
	'loop' => $loop
	,'pg'=> $pg	
	));
}
    
$tpl->print_('tpl');
?>
