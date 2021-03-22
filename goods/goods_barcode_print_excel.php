<?
include "../_header.php";

/*리스트*/
$qry="select bp.*, b.brandnm, b.brand_img_folder, m.name, (select barcode from goods_barcode gb where gb.goodsno=bp.goodsno and gb.sort='1' order by no limit 1) as barcode from goods_barcode_print bp
left join goods g on (bp.goodsno=g.no)
left join brand b on (g.brandno=b.no)	
left join member m on (bp.admin_no=m.no)
where 1=1 and bp.no in ('".implode("','",$_POST['chk_no'])."')
order by no desc";

$res = $db->query($qry);

foreach($res->results as $v){
    $v['reg_date']=reset(explode(" ",$v['reg_date']));
    if($v['print_date']!='0000-00-00') $v['print_date']="출력완료(".$v['print_date'].")";
    else $v['print_date']="";       
    
    $loop[]=$v;
}
$tpl->assign(array(	
'loop' => $loop
));


$tpl->print_('tpl');
?>
