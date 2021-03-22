<?
include "../_header.php";

ini_set('memory_limit', -1);
//ini_set('max_execution_time',0);

$page_title='브랜드통계';
$popup_chk="1";
$qry="select b.brandnm, ifnull(sl.now_cnt,0) now_cnt, ifnull(sl.cost,0) cost, ifnull(sl.stock_num_reg,0) stock_num_reg ,ifnull(sl.state,0) state
from brand b
left join stock_list sl on (b.no=sl.brandno) and sl.state!=2
join goods g on g.no=sl.goodsno
#where b.brandnm='디젤 쥬얼리'
order by b.brandnm
";
$res=$db->query($qry);

foreach($res->results as $v){

	if($v['state']=='0'){
	
		$sumcnt[$v['brandnm']]['s']+=$v['stock_num_reg'];
		$sumprice[$v['brandnm']]['s']+=$v['cost']*$v['stock_num_reg'];

		$totcnt[$v['brandnm']]+=$v['stock_num_reg'];
		$totprice[$v['brandnm']]+=$v['cost']*$v['stock_num_reg'];

		$tops_totcnt+=$v['stock_num_reg'];
		$tops_totprice+=$v['cost']*$v['stock_num_reg'];

		$top_totcnt+=$v['stock_num_reg'];
		$top_totprice+=$v['cost']*$v['stock_num_reg'];
	}else{

		$sumcnt[$v['brandnm']]['c']+=$v['now_cnt'];
		$sumprice[$v['brandnm']]['c']+=$v['cost']*$v['now_cnt'];

		$totcnt[$v['brandnm']]+=$v['now_cnt'];
		$totprice[$v['brandnm']]+=$v['cost']*$v['now_cnt'];

		$topc_totcnt+=$v['now_cnt'];
		$topc_totprice+=$v['cost']*$v['now_cnt'];

		$top_totcnt+=$v['now_cnt'];
		$top_totprice+=$v['cost']*$v['now_cnt'];
	}

	
    $loop[$v['brandnm']]=$v['brandnm'];
}

$tpl->assign(array(	
	'loop' => $loop
));
    

$tpl->print_('tpl');
?>
