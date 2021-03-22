<?
include "../_header.php";member_chk();

$page_title='재고리스트';

$catelist=get_cate_info();
$GOODS=new goods();

$QUERY_STRING = $_SERVER['QUERY_STRING'];

$category_1=$_REQUEST['category_1']?$_REQUEST['category_1']:"000";
$category_2=$_REQUEST['category_2']?$_REQUEST['category_2']:"000";
$category_3=$_REQUEST['category_3']?$_REQUEST['category_3']:"000";
$category_4=$_REQUEST['category_4']?$_REQUEST['category_4']:"000";
$selected['category_1'][$_POST['category_1']]="selected";
$selected['category_2'][$_POST['category_2']]="selected";
$selected['category_3'][$_POST['category_3']]="selected";
$selected['category_4'][$_POST['category_4']]="selected";

//$add_where[]="gl.category='".$category_1.$category_2.$category_3.$category_4."'";

//tydebug($_POST);

$field="g.*,b.brandnm,b.brand_img_folder,gcl.*,gi.prod_type,gi.consumer_price
,(select cost from stock_list where goodsno=g.no order by no desc limit 1) last_stock_cost
,(select if(comp_date,comp_date,reg_date) from stock_list where goodsno=g.no order by no desc limit 1) last_stock_date
,(select sum(order_num) from order_list where step=2 and step2=1 and goodsno=g.no) stand_cnt
";
$db_table="goods g
left join brand b on g.brandno = b.no
join goods_cnt_loc gcl on g.no=gcl.goodsno
left join goods_info gi on (g.no=gi.goodsno)
";


$_GET[sort]='b.brandnm,g.goodsnm';

$s_res=get_search_where();
if($s_res['where'])$where=$s_res['where'];
if($_REQUEST['s_paste'] || $_REQUEST['s_no_limit']==1)$no_limit=1;


if(!$where)$_GET[page_num]=30;
else $_GET[page_num]=100;

if($_REQUEST['s_search_mode'] || $print_xls){

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);

$pg->exec();
$qry=$pg->query;
$res = $db->query($qry);
//tydebug($qry);
foreach($res->results as $v){
	$sqry="select * from stock_list where goodsno='".$v['no']."' 
	and (now_cnt>0 or state=0)
	and return_order=0
	#and state in('0','1') 
	order by reg_date";
	$sres=$db->query($sqry);
	$v['stock_list']=$sres->results;

	foreach($psb_stock_loc as $psb_v){
		$v['psb_stock']+=$v[$psb_v];
	}	

	$stock_sumPrice=0;
	$stock_sumNum=0;

	foreach($v['stock_list'] as $sv){

		if($sv['state']==0)$calc_cnt=$sv['stock_num_reg'];
		else $calc_cnt=$sv['now_cnt'];

		$stock_sumPrice+=($sv['cost']*$calc_cnt);
		$stock_sumNum+=$calc_cnt;

	}
	
	$v['total_cost']=$stock_sumPrice;
	$v['stock_average']=$GOODS->avg_price($v['no'],'list');
	$v['stock_average2']=$GOODS->avg_price($v['no'],'list','cost_ori');

	$sqry="select min(cost) as min_cost, max(cost) as max_cost from stock_list where goodsno='".$v['no']."'";
	$sres=$db->query($sqry);
	$v['min_cost']=$sres->results[0]['min_cost'];
	$v['max_cost']=$sres->results[0]['max_cost'];
	
	$v['consumer_price']=($v['consumer_price'])?$v['consumer_price']:$v['c_price'];
	
	if($print_xls){
		if($_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}
	
	$v['last_stock_date']=substr($v['last_stock_date'],0,10);

	//딜정보
	
	$dqry="select right(gdi.s_date,5) s_date, right(gdi.e_date,5) e_date, gdi.confirm_admin_no, gdd.price, ml.mall_name from goods_deal_info gdi 
	left join goods_deal_detail gdd on (gdd.info_no=gdi.no)
	left join mall_list ml on (gdi.mall_no=ml.no)
	where 1
	#and gdi.s_date<='".date("Y-m-d",time())."' 
	and gdi.e_date>='".date("Y-m-d",time())."'
	and gdd.goodsno='".$v['no']."'
	order by gdi.s_date,gdi.e_date
	";
	$dres=$db->query($dqry);
	$v['deal_loop']=$dres->results;
//tydebug($dqry);
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

}

$tpl->assign(array(	
'loop' => $loop
,'catelist'=>$catelist
,'pg'=> $pg	));

$tpl->print_('tpl');
?>