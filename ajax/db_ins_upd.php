<?//일일택배접수관리 페이지  cs/daily_deli_info
include "../_header.php";
	
	$qry="select no from daily_deli_info where courier_name=:courier_name and reg_date=:reg_date";
	$param[':courier_name']=$_POST['courier_name'];
	$param[':reg_date']=$_POST['this_date'];

	$res=$db->query($qry,$param);
	
	if($res->results['0']['no']){
		$qry=$_POST['qry_u'];
	}else{
		$qry=$_POST['qry'];
	}

	if($db->query($qry)){

		if($db->lastId){
			echo $db->lastId; 
		}else{
			echo "ok";
		}
	}else{
		echo "false";
	}

/*
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
*/
?>