<?
include "../_header.php";

$page_title='사진촬영관리';
//$popup_chk=1; //메뉴 컨트롤
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


$db->inqry_param($_POST['chk_no']);
$_POST['chk_no']=$db->inparam;


$qry="update ".$db_table." set sync_confirm=1 where no in (".implode(",",array_keys($_POST['chk_no'])).")";
$db->query($qry,$_POST['chk_no']);

nameMasking('이름');
*/

//phpinfo();
$_GET[page_num]=100;
$field="g.*,b.brandnm,b.brand_img_folder,c.catenm";
$db_table="goods g
left join brand b on g.brandno = b.no
left join category c on g.cateno = c.no
";

$s_res=get_search_where();
if($s_res['where'])$where=$s_res['where'];
if($_POST['s_paste'])$no_limit=1;

$pg = new page($_GET[page],$_GET[page_num],$no_limit);

//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);
$pg->exec();


$res = $db->query($pg->query);
foreach($res->results as $v){

	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
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
