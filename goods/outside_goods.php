<?
include "../_header.php";

$page_title='외부연동상품관리-상품목록';





$_GET[page_num]=200;
$field="*";
$db_table="outside_goods og";

if($_POST['chk_no']){

	$db->inqry_param($_POST['chk_no']);
	$_POST['chk_no']=$db->inparam;

	$qry="update ".$db_table." set sync_confirm=1 where no in (".implode(",",array_keys($_POST['chk_no'])).")";
	$db->query($qry,$_POST['chk_no']);
}



if($_POST['reg_date'])$where[]="reg_date='".$_POST['reg_date']."'";


if($_POST['h_s_condi'] && !$_POST['s_condi'])$_POST['s_condi']=$_POST['h_s_condi'];
if($_POST['s_condi']=='1')$where[]="sync_confirm=0";
else $_POST['s_condi']=0;
$checked['s_condi'][$_POST['s_condi']]='checked';

if($_POST['s_paste'])$no_limit=1;

$pg = new page($_GET[page],$_GET[page_num],$no_limit);

$_GET[sort]="reg_date desc";
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);
$pg->exec();

$res = $db->query($pg->query);
foreach($res->results as $v){
	
	$v['images']=explode("|",$v['images']);
	$v['opt1_val']=explode(",",$v['opt1_val']);

	$v['sync_chk']=($v['sync_chk']==0)?"품절":"판매가능";
	$v['sync_confirm']=($v['sync_confirm']==0)?"미승인":"승인완료";

	if(!$_POST['search_noimg'])$v['img_url']="<img src='".$v['images']['0']."' >";
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
