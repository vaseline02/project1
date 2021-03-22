<?
//몰 상품등록 기능
include "../_header.php";member_chk();

$page_title='몰 상품등록';

$catelist=get_cate_info();
$GOODS=new goods();
$code_prop=market_solution_prop('sabangnet');
$info_en_name=info_en_name();

$qry="select * from market_solution_prop";
$res=$db->query($qry);
foreach($res->results as $v){
	$prop_name[$v['code']][$v['prop_no']]=$v['prop_name'];
}


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

$field="g.*,b.brandnm,b.brand_img_folder,b.brandnm_en,gcl.*,gi.*
,c.sabang_prop_code,c.depth_1
,(select import_no from import_licence where type='import_licence' and goodsno=g.no order by no desc limit 1) import_no
,(select img_name from import_licence where type='import_licence' and goodsno=g.no order by no desc limit 1) import_img
,gl.category
";
$db_table="goods g
left join brand b on g.brandno = b.no
join goods_cnt_loc gcl on g.no=gcl.goodsno
left join goods_info gi on (g.no=gi.goodsno)
left join goods_link gl on g.no=gl.goodsno
left join category c on c.no=gl.cateno
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

foreach($res->results as $v){

	foreach($psb_stock_loc as $psb_v){
		$v['psb_stock']+=$v[$psb_v];
	}	

	
	foreach($code_prop[$v['sabang_prop_code']] as $prop_k=>$prop_v){

		$tmp_prop=$GOODS->goods_prop_style($prop_k,$prop_v,$v,$info_en_name);	

		$v['prop_val'][$prop_name[$v['sabang_prop_code']][$prop_k]]=$tmp_prop;
	}

	$v['invoice_img']=$cfg['img_url']."a/coupang/invoice/".$v['import_img'];

	$v['mall_gnm']=$GOODS->get_mall_goodsnm($v);
	$v['sabang_cate']=str_replace(' ','',$v['brandnm_en'])."=>".$GOODS->get_sabang_cate($v);

	$v['stock_average']=$GOODS->avg_price($v['no'],'list');
	
	$v['consumer_price']=($v['consumer_price'])?$v['consumer_price']:$v['c_price'];
	
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

}

$tpl->assign(array(	
'loop' => $loop
,'catelist'=>$catelist
,'pg'=> $pg	));

$tpl->print_('tpl');
?>