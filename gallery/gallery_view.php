<?
include "../_header.php";

$db->query('set names euckr');

$qry = "select * from wd_board_ppl
where sn = '".$_GET['sn']."'
";

$res = $db->query($qry);
$row = $db->fetch($res);

$row[img_url] = explode("|",$row['b_file']);

$arr_list_title = explode("|",$row['subject']);

if($row['cate_sn']=='26'){

	$subject_len = strlen($arr_list_title[0]);
	
	$tmp_list_title = array();
	
	for($i=0;$i<$subject_len;$i=$i+2){
		
		$tmp_list_title[] =  substr($arr_list_title[0],$i,2);
	}
		
	$tmp_list_title_cnt = count($tmp_list_title);

	if($tmp_list_title_cnt<=3){
		$tmp_list_title[1] = '*';
		$arr_list_title[0] = implode("",$tmp_list_title);
	}else{
		$arr_list_title[0] = $tmp_list_title[0].$tmp_list_title[1].'***';
	}
}

$row['subject'] = implode(" ",$arr_list_title);



$data = $row;

$tpl->assign($data);

$tpl->print_('tpl');
?>