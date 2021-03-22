<?
include "../_header.php";

	
	$popup_chk=1;

	if($_GET['view']=='main'){
		$mod_type='readonly';
		$page_title='';
	}else{
		$page_title='등록하기';
	}

	$sn = $_REQUEST['sn'];
	$mode = ($sn)?'mod':'ins';
	$board_id = $_GET['board_id'];
	//$table = "board_".$board_id;
	$table = "board_default";

	$qry = "select * from board_cate where board_id = '".$board_id."' and state!='delete' order by cate_name";
	$res = $db->query($qry);

	foreach($res->results as $v){

		$cate_data[] = $v;
	}

	if($sn){
		$qry = "select * from ".$table." where sn= '".$sn."' ";
		$res = $db->query($qry);
		$data = $res->results['0'];

		$data['img'] =  explode("|",$data['v_file']);
	}

	$selected[cate][$data['cate_sn']] = "selected";
	$checked[alarm_mw][$data['alarm_mw']] = "checked";


	$alarm_team = explode('|',$data['alarm_team']);

	foreach($alarm_team as $v){
		$checked[alarm_team][$v] = "checked";
	}

	$alarm_d = explode('|',$data['alarm_d']);

	foreach($alarm_d as $v){
		$checked[alarm_d][$v] = "checked";
	}

	if($board_id == 'notice')$view_alarm = 1;
	else $view_alarm = 0;


$tpl->assign($data);
$tpl->assign(array(
'cate_data'=>$cate_data
,'mod_type'=>$mod_type
));
    

$tpl->print_('tpl');


?>
