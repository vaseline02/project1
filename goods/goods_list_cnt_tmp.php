<?
include "../_header.php";member_chk();

$page_title='재고리스트';

$codedata=get_codedata('place');
asort($codedata);

$selected['codedata_sort'][$_REQUEST['codedata_sort']]="selected";
$checked['sort_type'][$_REQUEST['sort_type']]="checked";
$checked['stock_check'][$_REQUEST['stock_check']]="checked";
//phpinfo();

$_GET[page_num]=100;
$field="g.*,b.brandnm,b.brand_img_folder,gcl.*
";
$db_table="goods g
left join brand b on g.brandno = b.no
join goods_cnt_loc gcl on g.no=gcl.goodsno
";

if($_POST['s_paste'])$no_limit=1;
$s_res=get_search_where();
if($s_res['where'])$where=$s_res['where'];
if($_POST['s_paste'])$no_limit=1;


if($_REQUEST['codedata_sort']){
    $_GET[sort]="gcl.codeno_".$_REQUEST['codedata_sort']." ".$_REQUEST['sort_type'];
    if($_REQUEST['stock_check']) $where[]="gcl.codeno_".$_REQUEST['codedata_sort'].">0";
}

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);

$pg->exec();
$qry=$pg->query;
// tydebug($qry);
$res = $db->query($qry);

foreach($res->results as $v){
	
	if($print_xls){
		if($_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}
    
    foreach($codedata as $cv){
        $v["codedata"][]=$v['codeno_'.$cv['no']];
    }
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


// //합계
foreach($codedata as $cv){
    $sumCode[]="sum(codeno_".$cv['no'].") as sumcode_".$cv['no'];
}
$sumStock="";
$sumqry="select sum(cur_cnt) as sum_cur_cnt, ".implode(",",$sumCode)." from ".$db_table." where 1=1";
if($where) $sumqry.=" and ".implode(" and ",$where);
$sumres=$db->query($sumqry);
$sumData=$sumres->results[0];
$sumStock[]=$sumData['sum_cur_cnt'];
foreach($codedata as $cv){
    $sumStock[]=$sumData['sumcode_'.$cv['no']];
}

$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	
,'sumStock'=> $sumStock	
));

$tpl->print_('tpl');
?>