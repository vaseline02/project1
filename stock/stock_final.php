<?
include "../_header.php";member_chk();

$page_title='최종입고관리';

$QUERY_STRING = $_SERVER['QUERY_STRING'];

$_GET[page_num]=20;

$field="sl.f_group_id, sl.calendar_date, sl.reg_date, sl.comp_date, sl.pass_date, sl.license_date
,(select title from calendar where group_id=sl.group_id limit 1) title
";
$db_table="stock_list sl
join goods g on g.no=sl.goodsno
";

#$where[]="(sl.state='0' or sl.comp_chk='n' ) ";
$where[]="sl.f_group_id!='0'";
#$where[]="sl.comp_chk='y'";
if($_GET['search_group']) $where[]="sl.f_group_id='".$_GET['search_group']."'";
if($_GET['search_model']) $where[]="sl.goodsnm='".$_GET['search_model']."'";


$_GET[sort]="sl.calendar_date desc";

$pg = new page($_GET[page],$_GET[page_num],$no_limit);

$pg->cntQuery="select count(*) cnt from (select distinct f_group_id from stock_list sl join goods g on g.no=sl.goodsno";
if($where) $pg->cntQuery.=" where ".implode(" and ",$where); 
$pg->cntQuery.=") v";

$pg->field = $field;


$pg->setQuery($db_table,$where,$_GET[sort],"group by sl.f_group_id ".$having_where);
$pg->exec();
$qry=$pg->query;
$res = $db->query($qry);

foreach($res->results as $v){
	$v['confirmNm']=$v['confirm_chk']=='1'?"완료":"미완료";
	$group[]=$v;
}
//}

$tpl->assign(array(	
'group' => $group
,'pg'=> $pg));

$tpl->print_('tpl');
?>

