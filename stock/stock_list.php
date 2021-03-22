<?
include "../_header.php";member_chk();

$page_title='입고완료목록';

$s_date_value=$_REQUEST['s_date'];
$e_date_value=$_REQUEST['e_date'];

//phpinfo();
$_GET[page_num]=100;
$field="sl.*,b.brandnm,b.brand_img_folder,g.img_name";
$db_table="stock_list sl
left join goods g on g.no = sl.goodsno
left join brand b on g.brandno = b.no
";

$s_res=get_search_where();
if($s_res['where'])$where=$s_res['where'];
if($_POST['s_paste'])$no_limit=1;

if($s_date_value && $e_date_value){
	$where[]="sl.reg_date between '".$s_date_value."' and '".$e_date_value."' ";
}

$orderby="sl.reg_date desc,sl.goodsnm";

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$orderby);

$pg->exec();
$qry=$pg->query;

$res = $db->query($qry);

foreach($res->results as $v){
	
	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);

	$loop[$v['goodsnm']]=$v;
}


$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
