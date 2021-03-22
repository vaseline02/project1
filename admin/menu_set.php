<?
include "../_header.php";

$page_title='메뉴관리';


$_GET[page_num]=100;
$field="m.*,ms.sn as subSn, ms.menu_snm,ms.link,ms.state as subState, ms.reg_date as subRegdate";
$db_table="menu m 
left join menu_set ms on (m.sn=ms.menu_sn) 
";
$_GET[sort]="m.sort asc, ms.sort asc";

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);
$pg->exec();
$qry=$pg->query;


// $qry="select m.*,ms.sn as subSn, ms.menu_snm,ms.link,ms.state as subState, ms.reg_date as subRegdate from menu m 
// left join menu_set ms on (m.sn=ms.menu_sn) 
// order by m.sort asc, ms.sort asc";

//$param=array(":a"=>$id,":b"=>$pwd);
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
