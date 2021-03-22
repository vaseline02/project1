<?php
include "../_header.php";

if($_POST['mode']=='chg_img_step'){
	try{
		
		$db->beginTransaction();
		
		$qry="update goods set img_step=:img_step,img_name=:img_name where no=:no";
		$db->prepare($qry);
				
		foreach($_POST['chk_no'] as $v){
			
			$param[":img_step"]=$_POST['img_step'];
			$param[":no"]=$v;
			$param[":img_name"]=$_POST['img_name'][$v];

			$db->execute($param);
		}

		if($db->commit())echo "1";
		else echo "f";
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}
}

?>