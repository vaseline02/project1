<?//필요없는페이지 인듯.
include "../_header.php";

$qry="select id from mp_member where ".$_POST['chk']."='".$_POST['val']."'";
$res=$db->query($qry);
$row=$db->fetch($res);

if($row['id'])echo "1";
?>
