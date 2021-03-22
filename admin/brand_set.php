<?
include "../_header.php";

$page_title='브랜드관리';

$type=$_GET['type']?$_GET['type']:"";
$checked['type'][$type]="checked";

if($type)$where[]="type='".$type."'";

$_GET[page_num]=1000;
$field="*";
$db_table="brand";
$_GET[sort]="brandnm";

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
,'pg' => $pg
));

$tpl->print_('tpl');
?>
