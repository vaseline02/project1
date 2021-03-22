<?
include "../_header.php";member_chk();

$page_title='입고완료목록';

$QUERY_STRING = $_SERVER['QUERY_STRING'];
if($_POST['mode']=="date_change"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();
			
			foreach($_POST['chk_no'] as $v){                
                //상태변경
                $qry="update stock_list set ".$_POST['date_type']."='".$_POST['input_date']."' where group_id='".$v."'";
				$db->query($qry);
			}

			$db->commit();
			msg("처리되었습니다.","stock_comp_list.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"stock_comp_list.php?".$QUERY_STRING);		
		}  
	}
}

$_GET[page_num]=50;

$field="sl.group_id, sl.calendar_date, sl.reg_date, sl.comp_date, sl.pass_date, sl.license_date, cal.no, cal.title, cal.confirm_chk, (select count(no) as licence_cnt from import_licence il where il.group_id=sl.group_id) as licence_cnt";
$db_table="stock_list sl
left join calendar cal on sl.group_id = cal.group_id
join goods g on g.no=sl.goodsno
";

#$where[]="(sl.state='0' or sl.comp_chk='n' ) ";
$where[]="sl.group_id!=''";
$where[]="sl.comp_chk='y'";
if($_GET['search_group']) $where[]="sl.group_id='".$_GET['search_group']."'";
if($_GET['search_model']) $where[]="sl.goodsnm='".$_GET['search_model']."'";
if($_GET['search_title']) $where[]="cal.title like '%".$_GET['search_title']."%'";
if($_GET['licence_chk']=='n'){
	$having_where=" having licence_cnt=0 ";
	$checked['licence_chk'][$_GET['licence_chk']]="checked";
}



$_GET[sort]="sl.calendar_date desc";

$pg = new page($_GET[page],$_GET[page_num],$no_limit);

$pg->cntQuery="select count(v.group_id) cnt from  (";
$pg->cntQuery.=" select sl.group_id, (select count(no) as licence_cnt from import_licence il where il.group_id=sl.group_id) as licence_cnt from stock_list sl
left join calendar cal on sl.group_id = cal.group_id
join goods g on g.no=sl.goodsno";
if($where) $pg->cntQuery.=" where ".implode(" and ",$where); 
$pg->cntQuery.=" group by sl.group_id ".$having_where;
$pg->cntQuery.=" ) v";

$pg->field = $field;


$pg->setQuery($db_table,$where,$_GET[sort],"group by sl.group_id ".$having_where);
$pg->exec();
$qry=$pg->query;
//tydebug($pg);
$res = $db->query($qry);
//tydebug($qry);
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

