<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);

if($_FILES){
	$excel_data=excel_read('unlink','2');

	try{
		$db->beginTransaction();
		foreach($excel_data as $k=>$v){
			$sqry="select * from goods g
			where g.goodsnm='".$v[0]."'";
			$sres=$db->query($sqry);
			$goodsno=$sres->results[0]['no'];

			$cost='^'.$v[5].'^';	
			$repair_date='';
			//$cost=1;

			//if($v[20] || $v[20]!='수리완료') $repair_date=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($v[20]));

			$iqry="insert into cs_bad set
			goods_no='".$goodsno."'
			,goodsnm='".$v['0']."'
			,order_no='".$v['6']."'
			,quantity=1
			,cost='".$cost."'
			,memo='".$v[16]."'
			,admin_memo='".$v[13]."'
			,step=1
			,reg_date=now()
			,upload_type=2
			";			
			$db->query($iqry);

			/*
			$sqry="select * from goods g
			where g.goodsnm='".$v[18]."'";
			$sres=$db->query($sqry);
			$goodsno=$sres->results[0]['no'];

			$cost='';	
			$repair_date='';
			//$cost=1;

			//if($v[20] || $v[20]!='수리완료') $repair_date=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($v[20]));

			$iqry="insert into cs_bad set
			goods_no='".$goodsno."'
			,goodsnm='".$v['18']."'
			,repair_type='".$v['15']."'
			,order_no='".$v['8']."'
			,quantity=1
			,cost='".$cost."'
			,memo='".$v[6]."'
			,admin_memo='".$v[9]."'
			,step=60
			,repair_date='".date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($v[20]))."'
			,reg_date='".date('Y-m-d H:i:s',time_convert_EXCEL_to_PHP($v[16]))."'
			,upload_type=1
			";			
			$db->query($iqry);
			*/

		}
		
		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.',"test_file_upload.php");
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage().":".$e->getFile());	
	}
	
}

function time_convert_EXCEL_to_PHP($time){
	$t=($time-25569)*86400-60*60*9;
	$t=round($t*10)/10;
	return $t;
}


$tpl->print_('tpl');
?>
