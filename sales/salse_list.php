<?
include "../_header.php";member_chk();

$page_title='재고리스트';

//phpinfo();
$_GET[page_num]=100;
$field="g.*,b.brandnm,b.brand_img_folder,gcl.*,gi.prod_type,gi.consumer_price";
$db_table="goods g
left join brand b on g.brandno = b.no
join goods_cnt_loc gcl on g.no=gcl.goodsno
left join goods_info gi on (g.no=gi.goodsno)
";

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

tydebug1($qry);

$res = $db->query($qry);

foreach($res->results as $v){
	$sqry="select * from stock_list where goodsno='".$v['no']."' and now_cnt > 0 and state='1' order by reg_date";
	$sres=$db->query($sqry);
	$v['stock_list']=$sres->results;

	$stock_sumPrice=0;
	$stock_sumNum=0;
	foreach($v['stock_list'] as $sv){
		$stock_sumPrice+=($sv['cost']*$sv['now_cnt']);
		$stock_sumNum+=$sv['now_cnt'];
	}
	$v['total_cost']=$stock_sumPrice;
	$v['stock_average']=round($stock_sumPrice/$stock_sumNum);

	$sqry="select min(cost) as min_cost, max(cost) as max_cost from stock_list where goodsno='".$v['no']."'";
	$sres=$db->query($sqry);
	$v['min_cost']=$sres->results[0]['min_cost'];
	$v['max_cost']=$sres->results[0]['max_cost'];

	
	if($print_xls){
		if($_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}
	


	$loop[$v['goodsnm']]=$v;
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