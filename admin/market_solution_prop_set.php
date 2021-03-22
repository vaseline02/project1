<?
include "../_header.php";

$page_title='상품정보고시 설정';



if($_POST['code']){

	$qry="select * from market_solution_prop_name where code='".$_POST['code']."' order by no,prop_no";
	$res=$db->query($qry);

	foreach($res->results as $v){
		$loop[]=$v;
	} 

}
$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	
));

$tpl->print_('tpl');
?>
