<?
include "../_header.php";member_chk();

$page_title='예약재고관리';


if($_POST['mode']=="reserve_release"){

	try
		{
		$db->beginTransaction();
		$qry="select rl.*,g.goodsnm from reserve_list rl 
		join goods g on g.no=rl.goodsno
		where rl.no=:no and state=0";
		$res=$db->query($qry,array(":no"=>$_POST['reserve_seq']));

		$rdata=$res->results['0'];

		$okd=stock_io('reserve_release',$rdata['goodsno'],$rdata['goodsnm'],-$rdata['cnt'],$rdata['no'],$_SERVER['REQUEST_URI'],$cfg['hold_loc'],$rdata['stock_loc']);
		$okd=stock_io('reserve_release',$rdata['goodsno'],$rdata['goodsnm'],$rdata['cnt'],$rdata['no'],$_SERVER['REQUEST_URI'],$rdata['stock_loc'],$cfg['hold_loc']);
	
		$qry="update reserve_list set state=1,rel_date=now(),rel_admin_no=:rel_admin_no where no=:no";
		$db->query($qry,array(":no"=>$rdata['no'],"rel_admin_no"=>$_SESSION['sess']['m_no']));
		
		guadmin_stock_ctl($rdata['goodsno'],$rdata['cnt'],$rdata['stock_loc'],'in',$rdata['reference_no'],'교환예약 해제');

		$db->commit();
		msg("처리되었습니다","reserve_list.php?".$_POST['return_url']);	

	}catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}
}


$codedata=get_codedata('place','1'); 
foreach($codedata as $v){
	$place_nm[$v['no']]=$v['cd'];
}
//phpinfo();
$_GET[page_num]=100;
$field="rl.*,g.goodsnm,g.img_name,b.brandnm,b.brand_img_folder
,(select name from member where no=rl.admin_no) name
,(select name from member where no=rl.rel_admin_no) rel_name
,o.ordno
";
$db_table="reserve_list rl
join goods g on g.no =rl.goodsno
left join order_list o on rl.reference_no=o.no
left join brand b on g.brandno = b.no
";

$_GET[sort]="case when state=0 then 1 else 2 end, no desc";

if($_POST['s_paste'])$no_limit=1;
$s_res=get_search_where();
if($s_res['where'])$where=$s_res['where'];
if($_POST['s_paste'])$no_limit=1;

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);

$pg->exec();
$qry=$pg->query;

$res = $db->query($qry);
foreach($res->results as $v){
	
	if($print_xls){
		if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}
	
	$v['state_val']=($v['state']==0)?"접수":"처리완료";
	$loop[]=$v;
}

//붙여넣기가 있으면 붙여넣기 순서로 재정렬
if($_POST['s_paste']){
	
	$paste_arr = paste_to_arr($_POST['s_paste']);
	foreach($paste_arr as $v){

		if($loop[$v]){
			$tmp_arr[]=$loop[$v];
			unset($loop[$v]);
		}
	}
	$loop=$tmp_arr;
}



$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
