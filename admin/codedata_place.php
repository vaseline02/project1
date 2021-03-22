<?
include "../_header.php";

$page_title='코드데이터설정(PLACE)';

$qry="select c.* from codedata c 
where type='PLACE'
order by c.no asc";

$res = $db->query($qry);

foreach($res->results as $v){
	$v['v2nm']=$v['v2']=="1"?"가능":"불가능";
    $loop[]=$v;
	
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
