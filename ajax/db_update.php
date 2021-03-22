<?

//디비명,컬럼명, 수정 시퀀스값, 받아서 디비 업데이트 
include "../_header.php";

	if($_POST['colname2']){
		$add_set=" ,".$_POST['colname2']."=:colname_data2";
		$param[":colname_data2"]=$_POST['colname_data2'];
	}

	$qry="update ".$_POST['dbname']." set
	".$_POST['colname']."=:colname_data
	".$add_set."
	where ".$_POST['target_colname']."=:no
	";
	$param[":colname_data"]=$_POST['colname_data'];
	$param[":no"]=$_POST['target_data'];
	
	
	if($db->query($qry,$param)){
		echo "1";
	}else{
		echo "수정실패. 개발팀에 문의해주세요.";
	}

?>