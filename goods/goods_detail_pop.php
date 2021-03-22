<?
include "../_header.php";

$page_title='상품상세정보';
$popup_chk=1; //메뉴 컨트롤
/* 데이터 입력시
try{
	
	$db->beginTransaction();
	
	$db->commit();
	msg('처리되었습니다.','stock_schedule.php');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}


$db->inqry_param($_POST['chk_no']);
$_POST['chk_no']=$db->inparam;


$qry="update ".$db_table." set sync_confirm=1 where no in (".implode(",",array_keys($_POST['chk_no'])).")";
$db->query($qry,$_POST['chk_no']);

nameMasking('이름');
*/

//입고이력
if($_GET['s_date2'] && $_GET['e_date2']) $stock_where=" and DATE_FORMAT(reg_date,'%Y-%m-%d') between '".$_GET['s_date2']."' and '".$_GET['e_date2']."'";
$qry="select goodsnm,cost,stock_num_reg,stock_num,reg_date,if(comp_date,LEFT(comp_date,10),LEFT(reg_date,10)) comp_date,state,comp_chk from stock_list where group_id!='' and  state in('1','0') and goodsno=:goodsno ".$stock_where." order by no desc";
if(!$stock_where)$qry.=" limit 20";
$res = $db->query($qry,array(":goodsno"=>$_GET['goodsno']));
foreach($res->results as $v){
	$v['reg_date']=substr($v['reg_date'],0,10);
	$goodsnm_title=$v['goodsnm'];
	$loop_stock[]=$v;	
}


//phpinfo();
//판매이력
if($_GET['s_date'] && $_GET['e_date']) $ord_where=" and DATE_FORMAT(o.reg_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
$qry="select b.brandnm,o.no,o.order_cost,o.mall_name,o.goodsnm,o.settle_price,o.order_num,o.mod_date,o.reg_date,o.ordno from order_list o 
left join goods g on g.no=o.goodsno
left join brand b on b.no=g.brandno
where o.goodsno=:goodsno and o.step in('5','51') and o.step2<40 and csno=0
".$ord_where."
order by o.reg_date desc
";
if(!$ord_where)$qry.=" limit 20";
$res = $db->query($qry,array(":goodsno"=>$_GET['goodsno']));
foreach($res->results as $v){


	$tmp=explode("^",$v['order_cost']);
	$v['order_cost']=$tmp['1'];

	$v['mod_date']=($v['mod_date']!='0000-00-00 00:00:00')?$v['mod_date']:$v['reg_date'];
	$v['mod_date']=substr($v['mod_date'],0,10);
		
	$loop[]=$v;	
}

$tpl->assign(array(	
'loop' => $loop
,'loop_stock'=> $loop_stock	));

$tpl->print_('tpl');
?>
