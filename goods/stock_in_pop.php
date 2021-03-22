<?
include "../_header.php";

$page_title='입고리스트';

$popup_chk=1; //메뉴 컨트롤

$goodsno=$_GET["goodsno"];

$qry="select * from goods g 
join stock_list sl on (g.no=sl.goodsno)
left join calendar c on (sl.group_id=c.group_id)
where g.no='".$goodsno."' and (sl.state=0 or sl.comp_chk='n')
order by sl.calendar_date desc
";
$res=$db->query($qry);
foreach($res->results as $v){
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
