<?
include "../_header.php";member_chk();

$page_title='입고완료목록';

if(!$_POST['search_stock_title'])$_POST['search_stock_title']=$_REQUEST['excel_group_id'];

$_POST[page_num]=1200;

//면장
if($_POST['search_stock_title']){
	$qry="select * from import_licence where group_id=:group_id and group_id!=''";
	$res=$db->query($qry,array(":group_id"=>$_POST['search_stock_title']));

	foreach($res->results as $v){
		$import_data[$v['type']][] =$v;

		$import_model_cnt[$v['goodsno']]+=$v['cnt'];
	}
}

//$import_model_cnt['20793']=11; test
//면장end

if($_POST['search_model']){

	$qry="select sl.group_id,cal.title from stock_list sl
	left join calendar cal on sl.group_id = cal.group_id
	join goods g on g.no=sl.goodsno and g.goodsnm='".$_POST['search_model']."'
	where sl.group_id!=''
	and sl.comp_chk='y'
	group by sl.group_id
	";
	$res=$db->query($qry);

	foreach($res->results as $v){
		if(!$v['title'])$v['title']='이름없음';
		$title[$v['group_id']]=$v['title'];
	}

}

$field="sl.*,b.brandnm,b.brand_img_folder,c.catenm,cal.title,g.goodsnm_sub,g.img_name,cal.date_from cal_date";
$db_table="stock_list sl
left join goods g on sl.goodsnm=g.goodsnm
left join brand b on sl.brandno = b.no
left join category c on sl.cateno = c.no
left join calendar cal on sl.group_id = cal.group_id
";

#$where[]="(sl.state='0' or sl.comp_chk='n' ) ";
$where[]="sl.group_id!=''";
$where[]="sl.group_id='".$_POST['search_stock_title']."'";

$pg = new page($_POST[page],$_POST[page_num],$no_limit);
$pg->field = $field;

$pg->setQuery($db_table,$where,$sort);
$pg->exec();

$res = $db->query($pg->query);

foreach($res->results as $v){

	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']); 
	$loop[str_replace(' ','',$v['group_id'])][]=$v;

	$ins_model_cnt[$v['goodsno']]+=$v['stock_num_reg'];

	$cost_mod=$v['cost_mod'];
	$state=$v['state'];
}


$tpl->assign(array(	
'loop' => $loop
,'import_data' => $import_data
,'pg'=> $pg	));

$tpl->print_('tpl');
?>

