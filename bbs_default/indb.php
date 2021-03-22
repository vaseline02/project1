<?
include "../_header.php";


	$mode = $_REQUEST['mode'];
	$link = "img";
	$file =  new file($link);

	if($_FILES){
		$upfile =  $file->upFiles();
	}

	//$table = "wd_board_".$_REQUEST['board_id'];
	$table = "board_default";

	for($i=0;$i<count($upfile['board_file']);$i++){

		if($upfile['board_file'][$i]['v_file']){
			$up_file_r[] = $upfile['board_file'][$i]['r_file'];
			$up_file[] = $upfile['board_file'][$i]['v_file'];
		}
	}

	$up_file_r = implode("|",$up_file_r);
	$up_file = implode("|",$up_file);
	$link = implode("|",array_filter($_POST['link']));


	//tydebug($up_file_r);

	$bcdt = $_POST['bcdt']." ".implode(":",$_POST['hour']);

	if($mode == 'ins'){

		$qry = "insert into ".$table." set
		cate_sn = '".$_POST['cate']."'
		,board_id  = '".$_REQUEST['board_id']."'
		,m_sn = '".$_SESSION['sess']['m_no']."'
		,subject = '".$_POST['subject']."'
		,contents = '".addslashes($_POST['contents'])."'
		,r_file = '".$up_file_r."'
		,v_file = '".$up_file."'
		,alarm_mw = '".$_POST['alarm_mw']."'
		,alarm_d = '".implode("|",$_POST['alarm_d'])."'
		,alarm_team = '".implode("|",$_POST['alarm_team'])."'
		,regdt = now()
		";

		$msg = "등록되었습니다.";

	}else if($mode == 'mod'){

		$qry = "select v_file from ".$table." where sn = '".$_POST['sn']."' ";
		$res = $db->query($qry);
		$before_img = $res->results['0'];

		if($upfile['board_file'][0]['v_file']){

			$arr_before_img = explode("|",$before_img['v_file']);

			foreach($arr_before_img as $biv){
				$file->removeFile($biv);
			}

			$add_qry = " ,r_file = '".$up_file_r."' ,v_file = '".$up_file."'";
		}

		$qry = "update ".$table." set
		cate_sn = '".$_POST['cate']."'
		,m_sn = '".$_SESSION['sess']['m_no']."'
		,alarm_mw = '".$_POST['alarm_mw']."'
		,alarm_d = '".implode("|",$_POST['alarm_d'])."'
		,alarm_team = '".implode("|",$_POST['alarm_team'])."'
		,subject = '".$_POST['subject']."'
		,contents = '".addslashes($_POST['contents'])."'
		$add_qry
		where sn = '".$_POST['sn']."'
		";

		$msg="수정되었습니다";


	}else if($mode == 'del'){

		$qry = "update ".$table." set
		status = 'deleted'
		where sn = '".$_GET['sn']."'
		";

		$msg="삭제완료";
	}


if($db->query($qry)){

	msg($msg);
	echo "<script>opener.location.reload();self.close();</script>";

}else{
	tydebug('오류. 관리자에게 문의해주세요.',-1);
	tydebug("err");
	tydebug($qry);
}

?>