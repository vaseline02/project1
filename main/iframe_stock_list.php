<?
include "../_header.php";member_chk();

$page_title='입고예정내역';
$popup_chk2=1; //메뉴 컨트롤
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
*/
$GOODS=NEW goods();
$group_id=$_POST['calendar_group_id'];

$qry="select sl.*,b.brandnm,b.brand_img_folder,c.catenm,g.img_name,g.goodsnm from stock_list sl
left join brand b on sl.brandno = b.no
left join category c on sl.cateno = c.no
left join goods g on g.no=sl.goodsno
where group_id=:group_id and group_id!=''
order by no
";
$res = $db->query($qry,array(":group_id"=>$group_id));
foreach($res->results as $v){
	$sqry="select cost from stock_list where goodsno='".$v['goodsno']."' and state='1' order by reg_date desc limit 3";
	$sres=$db->query($sqry);
	$v['stock_list']=$sres->results;
	/*
	$sumCost=0;
	foreach($v['stock_list'] as $sv){
		$sumCost+=$sv['cost'];		
	}

	$v['average']=round($sumCost/count($v['stock_list']));
	*/
	$v['average']=$GOODS->avg_price($v['goodsno']);
	
	// if(!$print_xls){}
	//$v['img_url']="<img width='80' src='".$glb_img_url."Design/web19/web/product/big/LUMINOX/A.1927.jpg' alt=''>"; 
	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	$loop[]=$v;
}



$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
