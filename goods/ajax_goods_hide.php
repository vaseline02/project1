<?
include "../_header.php";

$qry="select no,hidden_yn from goods where no in ('".implode("','",$_POST['chk_no'])."')";
$res=$db->query($qry);

foreach($res->results as $v){
	
	if($v['hidden_yn']=='y')$toggle_h='n';
	else $toggle_h='y';
	
	$qryh="update goods set hidden_yn='".$toggle_h."' where no='".$v['no']."'";
	$db->query($qryh);
}

echo "1";

?> 