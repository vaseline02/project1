<?
include "../_header.php";

	$board_id = $_GET['board_id'];
	$board_name=array("se"=>"기능추가/수정내역");

	$page_title=$board_name[$board_id];
	//$table = "board_".$board_id;
	$table = "board_default";

	//카테고리 쿼리
	$cate_qry = "select distinct cate_name from board_cate where board_id = '".$board_id."' and state = 'none'";
	$cate_res = $db->query($cate_qry);

	foreach($cate_res->results as $v){
		$cate_arr[] = $v[cate_name];
	}

	$search_cate = ($_POST['search_cate']!='')?$_POST['search_cate']:$_POST['search_cate2'];
	if($search_cate){
		$where[]=" bc.cate_name = '".$search_cate."' ";
	}

	$search = ($_POST['search']!='')?$_POST['search']:$_POST['search2'];
	if($search){
		$where[]= " concat(subject,contents) like '%".$search."%' ";
	}
	$selected[cate][$search_cate] = 'selected';

	$where[]=" board_table.board_id = '".$board_id."' ";

	
	$_GET[page_num]=30;
	$_GET[sort]='regdt desc';
	$db_table=" ".$table." board_table 
	join board_cate bc on bc.sn = board_table.cate_sn
	";
	$field=" board_table.*,bc.cate_name ";
	
	$where[]="board_table.status = 'none'";
	$where[]="bc.state = 'none'";


	$pg = new page($_GET[page],$_GET[page_num],$no_limit);
	$pg->field = $field;
	$pg->setQuery($db_table,$where,$_GET[sort]);
	
	$pg->exec();
	$qry=$pg->query;
	$res = $db->query($qry);


	foreach($res->results as $v){

		$v['img'] =  explode("|",$v['v_file']);

		$v['regdt'] = reset(explode(" ",$v['regdt']));
		$data[] = $v;
	}
$tpl->assign(array(	
	'data' => $data
	,'pg' => $pg
));
    

$tpl->print_('tpl');
?>


