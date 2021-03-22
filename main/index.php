<?
include "../_header.php";

// $qry="select b.brandnm, ifnull(sum(sl.now_cnt),0) as sumcnt, ifnull(sum(sl.cost*sl.now_cnt),0) as sumprice from brand b
// left join stock_list sl on (b.no=sl.brandno)
// group by sl.brandno";
// $res=$db->query($qry);
// foreach($res->results as $v){
//     $loop[]=$v;
// }
 
// $tpl->assign(array(	
// 'loop' => $loop
// ));
    
//phpinfo();

//개발게시판
$BOARD=new board();
$se_data=$BOARD->load_data('se','10');

//품절후입고
$qry="select gsl.*,g.goodsnm, gcl.cur_cnt from goods_soldout_log gsl
left join goods g on (gsl.goodsno=g.no)
left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
where DATE_FORMAT(gsl.reg_date, '%Y-%m-%d')='".date("Y-m-d",time())."'
order by gsl.no desc";

$res=$db->query($qry);
foreach($res->results as $v){
	if($v['log_type']=="1"){
		$v['lognm']="신규입고";
		$type="1";
	}elseif($v['log_type']=="2"){
		$v['lognm']="품절입고";
		$type="2";
	}elseif($v['log_type']=="3"){
		$v['lognm']="품절후반품입고";
		$type="2";
	}

	$v['psd_stock']=goods_psd_stock($v['goodsno']);

	$goodsloop[$type][]=$v;
}

//출고후품절
$qry="select * from (select ssl2.type, ssl2.reg_date, gcl.*, 
g.goodsnm as goodsnm,
CASE
	WHEN (DATE_FORMAT(ssl2.reg_date, '%H')>'00' && DATE_FORMAT(ssl2.reg_date, '%H')<'12' )
	THEN '오전'
	ELSE '오후'
END as time_group
from stock_soldout_log ssl2
left join goods g on (ssl2.goodsno=g.no)
left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
where DATE_FORMAT(ssl2.reg_date, '%Y-%m-%d')='".date("Y-m-d",time())."'
#where DATE_FORMAT(ssl2.reg_date, '%Y-%m-%d')='2021-01-21'
group by ssl2.type, ssl2.goodsno, time_group 
) v order by v.reg_date desc
";

$res=$db->query($qry);
foreach($res->results as $v){
	if($v['type']=="0")$v['typenm']="주문등록품절";
	elseif($v['type']=="1")$v['typenm']="출고후품절";

	$v['psd_stock']=goods_psd_stock($v['goodsno']);

	$stockloop[]=$v;
}

//tydebug($stockloop);
$tpl->assign(array(
'se_data'=> $se_data
,'goodsloop'=>$goodsloop
,'stockloop'=>$stockloop
));
$tpl->print_('tpl');

?>