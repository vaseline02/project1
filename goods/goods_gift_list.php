<?
include "../_header.php";

$page_title='사은품관리';

$mode=$_POST["mode"];

if($mode=='del'){
    $no=$_POST["no"];

    $dqry="delete from goods_freegift where no='".$no."'";
    $db->query($dqry);

    msg("삭제되었습니다.","goods_gift_list.php");
}

$_GET[page_num]=100;
$field="gf.*, g.goodsnm as giftgoodsnm, gg.goodsnm as goodsnm, b.brandnm, c.catenm
,IF(c.depth_1!='000',(select catenm from category c1 where c1.depth_1=c.depth_1 and c1.depth_2='000' and c1.depth_3='000' and c1.depth_4='000'),'') as cate_1
,IF(c.depth_2!='000',(select catenm from category c2 where c2.depth_1=c.depth_1 and c2.depth_2=c.depth_2 and c2.depth_3='000' and c2.depth_4='000'),'') as cate_2
,IF(c.depth_3!='000',(select catenm from category c3 where c3.depth_1=c.depth_1 and c3.depth_2=c.depth_2 and c3.depth_3=c.depth_3 and c3.depth_4='000'),'') as cate_3
,IF(c.depth_4!='000',(select catenm from category c4 where c4.depth_1=c.depth_1 and c4.depth_2=c.depth_2 and c4.depth_3=c.depth_3 and c4.depth_4=c.depth_4),'') as cate_4
";
$db_table="goods_freegift gf
left join goods g on (g.no=gf.gift_goodsno)
left join goods gg on (gg.no=gf.goodsno)
left join brand b on (gf.brandno=b.no)
left join category c on (gf.categoryno=c.no)
";
$_GET[sort]="reg_date desc";

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);
$pg->exec();
$qry=$pg->query;

$res = $db->query($qry);

foreach($res->results as $v){
	$loop[]=$v;
}


$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	
));

$tpl->print_('tpl');
?>
