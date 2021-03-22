<?
include "../_header.php";

$page_title='코드데이터(PLACE) 등록/수정';

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];
$codeno=$_GET['codeno'];

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($mode=='ins'){
    try
    {
        $db->beginTransaction();

		$qry="select no from codedata where cd='".$_POST['cd']."'";
		$res=$db->query($qry);

		if(!$res->results['0']['no']){

			$qry="insert into codedata set
			type='PLACE'
			,cd='".$_POST['cd']."'
			,place_type='".$_POST['place_type']."'
			,v='".$_POST['v']."'
			,v2='".$_POST['v2']."'
			,v3='99'
			,v4='0'
			,place_code='".$_POST['place_code']."'
			,view_yn='".$_POST['view_yn']."'
			#,stock_include_yn='".$_POST['stock_include_yn']."'
			,save_time=now()
			";
			if($res=$db->query($qry)){
				$lastNo=$res->lastId;

				//컬럼생성
				$tqry="alter table goods_cnt_loc add codeno_".$lastNo." int default 0;";
				$tres=$db->query($tqry);				
			}
			
		    $db->commit();
	        MsgViewCloseReload("등록되었습니다.");	
		}else{
			$db->rollBack();
			 msg("중복된 이름이 있습니다","codedata_place_reg.php");	
		}
       
        
    }
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage().":".$e->getFile());	
	} 

}else if($mode=='mod'){

    try
    {
        $db->beginTransaction();

		$qry="select no from codedata where no='".$_POST['no']."'";
		$res=$db->query($qry);

		if($res->results['0']['no']){

			//노출 변경 로그등록
			codedata_viewchg_log($_POST['no'],$_POST['view_yn']);

			$qry="update codedata set
			place_type='".$_POST['place_type']."'
			,v='".$_POST['v']."'
			,place_code='".$_POST['place_code']."'
			,v2='".$_POST['v2']."'
			,view_yn='".$_POST['view_yn']."'
			#,stock_include_yn='".$_POST['stock_include_yn']."'
			where no='".$_POST['no']."'
			";

			$res=$db->query($qry);						

		    $db->commit();

	        MsgReload("수정되었습니다.","codedata_place_reg.php?".$QUERY_STRING);	
		}else{
			$db->rollBack();
			msg("등록에 실패하였습니다.","codedata_place_reg.php?".$QUERY_STRING);	
		}
       
        
    }
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage().":".$e->getFile());	
	} 

}else if($mode=='del'){

    $qry="delete from codedata where no=:no";
    $param[":no"]=$no;

    if($db->query($qry,$param)){
        msg("삭제되었습니다.","codedata_set.php");	
    }

}

if($codeno){
	$qry="select c.* from codedata c 
	where no='".$codeno."'";
	$res = $db->query($qry);
	$codeData=$res->results[0];

	$v2=$codeData['v2']==""?0:$codeData['v2'];
	
	$selected['place_type'][$codeData['place_type']]="selected";
	$checked['v2'][$v2]="checked";
	$checked['view_yn'][$codeData['view_yn']]="checked";
	$checked['stock_include_yn'][$codeData['stock_include_yn']]="checked";

	$tpl->assign($codeData);
}



$tpl->print_('tpl');
?>
