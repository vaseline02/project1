<?
include "../_header.php";

$page_title='정보고시설정';

$popup_chk=1; //메뉴 컨트롤
$no=$_GET['no'];

if($_POST['mode']=='ins'){

	$qry="update category set
	sabang_prop_code=:code
	where no=:seq
	";
	$param[':code']=$_POST['code'];
	$param[':seq']=$_POST['seq'];

	$res=$db->query($qry,$param);
	
	MsgReload('처리되었습니다.');
}	

/*사용값 불러오기*/
$qry="select goods_info from category where depth_1=:depth_1";
$res=$db->query($qry,array(":depth_1"=>$_GET['cate_code']));
$goods_info=$res->results['0']['goods_info'];

$cate_code=$_GET['cate_code'];
$qry="select sabang_prop_code from category where no=:no";
$res=$db->query($qry,array(":no"=>$no));
$data=$res->results['0'];

$selected['sel_cate'][$data['sabang_prop_code']]='selected';

if($data['sabang_prop_code']){

	$qry="select colum_name,info_name from category_goods_info 
	#where no in('".str_replace("|","','",$goods_info)."')
	";
	$res=$db->query($qry);
	foreach($res->results as $v){

		if($cfg_goods_info[$cate_code][$v['colum_name']])$v['info_name']=$cfg_goods_info[$cate_code][$v['colum_name']];
		$col_info[$v['colum_name']]=$v['info_name'];
	}

	$qry="select * from market_solution_prop where code='".$data['sabang_prop_code']."' order by prop_no ";
	
	$res=$db->query($qry);
	foreach($res->results as $v){
		$v['col_data']=explode("|",$v['col_name']);
		$prop_list[]=$v;
	}
}


$tpl->assign(array(
'prop_list'=>$prop_list
));

$tpl->assign($data);

$tpl->print_('tpl');
?>

