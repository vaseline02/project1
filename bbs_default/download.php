<?
include "../_header.php";

$sn = $_GET['sn'];
$board_id = $_GET['board_id'];
//$table = "wd_board_".$board_id;
$table = "board_default";


$qry = "select r_file,v_file,subject from ".$table." where sn = ".$sn." ";
$res = $db->query($qry);
$row = $res->results['0'];

tydebug($row);

$tmp[file]=explode("|",$row['v_file']);
$tmp[r_file]= explode("|",$row['r_file']);

$subject = str_replace("|","_",$row[subject] );
$subject = preg_replace("/[\/\?\*\']/i","",$subject);
//파일이 있는경로로 이동

$dir_tar = "../bbs_default/img/";
chdir($dir_tar);

foreach( $tmp[file] as $k => $v){

	$c_file = $tmp[r_file][$k];

	exec("cp '$v' '../tmp/$c_file'");

}
/*
echo getcwd();
$tttt =  scandir("./");

print_r($tttt);

die;
*/
$dir_tar = "../tmp/";
chdir($dir_tar);

$dir_file = "./";		// 압축한 파일이 있는 디렉토리
//$subject	= iconv("UTF-8","EUC-KR",urldecode( str_replace(" ","",$subject) ) );

$tarname =  $board_id."_".date('Y-m-d').".tar.gz" ;			// 묶은 파일명

$gz_files	= implode( "' '" ,$tmp[r_file] ) ;

//debug('$gz_files',$gz_files);



echo getcwd();

exec("tar cvzf '$dir_file$tarname' '$gz_files'");
sleep( 3 );	//파일이 많거나 용량이 큰경우, gzip으로 압축할 경우 1초 정도 대기
chdir($dir_file);


header("Content-Type:application/octet-stream");
Header("Content-Disposition:attachment;filename=$tarname");
header("Content-Transfer-Encoding:binary");
Header("Content-Length:".(string)(filesize($tarname)));
Header("Cache-Control:cache,must-revalidate");		header("Pragma:no-cache");		header("Expires:0");

ob_clean();
flush();
readfile( $tarname );

unlink( $tarname );
exec("rm -rf ../tmp/*");

/*
$n_tmp_files	= count( $tmp[file] );
for( $lap = 0 ; $lap < $n_tmp_files	; $lap++ ){
	debug( 'unlink' ,$tmp[file][$lap] );
	unlink( $tmp[file][$lap] );
}
for( $lap = 0 ; $lap < $n_tmp_files	; $lap++ ){
	debug( 'rmdir' ,$tmp[dir][$lap] );
	rmdir( $tmp[dir][$lap] );
}
*/
?>