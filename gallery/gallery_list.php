<?
include "../_header.php";
include "../lib/page.class.php";

$db->query('set names euckr');
$pg = new Page($_GET[page],'12');


$db_table = "wd_board_ppl bp
join wd_board_cate bc on bp.cate_sn = bc.sn
";

$pg->field = "bp.*, bc.cate_name";

$where[] = "bp.open = 'y'";
$where[] = "bp.status = 'none'";
$where[] = "bc.sn not in ('9')";
$where[] = "bp.brand_sn = '".$gb_brand_id."'";
if($_GET[cate]) $where[] = "bc.cate_name = '".$_GET[cate]."'";
if($_GET['sword']) $where[] = "concat(subject,goodsname,cate_name,contents,bc.cate_name) like '%".$_GET['sword']."%'";

$pg->setQuery($db_table,$where,'regdt desc');
$pg->exec();


$res = $db->query($pg->query);
while($row = $db->fetch($res)){

	$row['img_url']="http://112.175.245.35/GENE/bbs_ppl/img/".$row[main_img];
	
	$arr_list_title = explode("|",$row['subject']);
	
	if($row['cate_name']=='고객착용' ){
	
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

	if($row['cate_name']=='뉴스기사' ){	
		$row['subject'] = reset(explode("_",$row['subject']));
	}

	$loop[]=$row;
}

$tpl->assign(array(
	'loop' => $loop
	,'pg'  => $pg
));

$tpl->print_('tpl');
?>