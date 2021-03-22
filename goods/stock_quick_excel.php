<?
include "../_header.php";

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);

$qry="select sq.*, b.brandnm, (select barcode from goods_barcode gb where gb.goodsno=sq.goodsno order by reg_date desc limit 1) as barcode from 
stock_quick sq
left join goods g on (sq.goodsno=g.no)
left join brand b on (g.brandno=b.no)
where sq.no in (".implode(",",array_keys($param)).")
order by sq.reg_date desc
";

$res = $db->query($qry,$param);


foreach($res->results as $v){

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>