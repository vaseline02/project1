<?
include "../_header.php";member_chk();
require '../lib/cla_directzip.php';
$zip = new DirectZip();


if($_GET['invoice']=='1')$add_where="";
else $add_where=" and type='import_licence'";

$qry="select type,img_name from import_licence
where no in('".implode("','",$_POST['chk_no'])."')
".$add_where."
";

$res=$db->query($qry);

foreach($res->results as $v){

	if($v['type']=='import_licence')$data_f[]=reset(preg_split("/[-]{1}[0-9]{2}.jpg/",$v['img_name']));
	else $data_invo_f[]=reset(preg_split("/[-]{1}[0-9]{2}_invoice.jpg/",$v['img_name']));		

	$data[]=$v['img_name'];
}

$data=array_unique($data);
$data_f=array_unique($data_f);
$data_invo_f=array_unique($data_invo_f);

/*
tydebug($data);
tydebug($data_f);
tydebug($data_invo_f);
*/
foreach($data_f as $v){
	if(!in_array($v."-01.jpg",$data))$data[]=$v."-01.jpg";
}
foreach($data_invo_f as $v){
	if(!in_array($v."-01_invoice.jpg",$data))$data[]=$v."-01_invoice.jpg";
}
//tydebug($data);

$tday=date('Ymd');

$zip->open('import_licence'.$tday.'_file.zip');

foreach($data as $k=>$v){
	
	$zip->addFile('../images/import_licence/'.$v);

	$txt_memo[]=$v;
}

sort($txt_memo);
foreach($txt_memo as $k=>$v)$txt_memo2.=($k+1)." ".$v."\n";
$zip->addFromString('파일체크.txt',$txt_memo2);

//$zip->addFile('../images/import_licence/181121-03.jpg');
//$zip->addFile('../images/import_licence/181121-01_invoice.jpg');
//$zip->addFile('/tmp/추가할 파일.jpg', '압축파일 내 파일 이름.jpg');
//$zip->addEmptyDir('압축파일 내 폴더 이름'); // 안 해도 상관없음.
//$zip->addFile('/tmp/추가할 파일2.png', '압축파일 내 폴더 이름/압축파일 내 파일 이름.png');
//$zip->addFile('/tmp/추가할 파일3.jpg'); // 압축파일에 파일을 '추가할 파일3.jpg'로 추가
//$zip->addFromString('바로 글쓰기.txt', '파일 내용'); // 압축파일에 '파일 내용'을 '바로 글쓰기.txt'로 추가
$zip->close();

?>