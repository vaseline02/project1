<?
include "../_header.php";member_chk();
require_once("../lib/page.class.php");
require_once("../lib/file.class.php");

$qry="select * from member order by join_time desc";

//$param=array(":a"=>$id,":b"=>$pwd);
$res = $db->query($qry,$param);

foreach($res->results as $v){

	$loop[]=$v;
}

/*
$ttt=strpos($_SERVER['PHP_SELF'],"admin");

if($ttt!==false)tydebug($ttt);
*/


$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
