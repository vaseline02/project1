<?
include "../_header.php";member_chk();
require_once("../lib/page.class.php");
require_once("../lib/file.class.php");

$page_title='카테고리 등록';
$popup_chk=1; //메뉴 컨트롤


if($_POST['code'] && $_POST['name']){
	$qry="insert into market_solution_code set
	sol_type='sabangnet'
	,code=:code
	,name=:name
	";
	
	$param[':code']=$_POST['code'];
	$param[':name']=$_POST['name'];

	$db->query($qry,$param);
}

if($_POST['del_menu']){
	
	$db->inqry_param($_POST['del_menu']);
	$_POST['del_menu']=$db->inparam;


	$qry="delete from market_solution_code where no in (".implode(",",array_keys($_POST['del_menu'])).")";
	
	$db->query($qry,$_POST['del_menu']);

	msg("삭제되었습니다.","outside_reg_cate.php");
}


//메뉴구성
$qry="select * from market_solution_code where sol_type='sabangnet'";
$res=$db->query($qry);

foreach($res->results as $v){

	$arr_menu[$v['code']][]=$v;
}

$tpl->assign(array('arr_menu'=>$arr_menu));
$tpl->assign($data);


$tpl->print_('tpl');
?>
