<?
include "../_header.php";

$page_title='업체코드';

//택배사 함수
$delivery_list=get_delivery_info();

$mode=$_POST["mode"];
$no=$_POST["no"];

if($mode=='del'){
    if($_POST["no"]){
        $db->query("delete from company_code where no=:no",array(":no"=>$no));
        msg('삭제되었습니다.','company_code.php');
    }else{
        msg('정상처리되지 않았습니다.','company_code.php');
    }    
}
$_GET[page_num]=500;
$field="*";
$db_table="company_code cc";
$_GET[sort]="no desc";

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
,'delivery_list' => $delivery_list
));

$tpl->print_('tpl');
?>
