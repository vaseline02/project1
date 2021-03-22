<?
include "../_header.php";

$page_title='코드데이터설정';

$code=$_POST['code'];
$mode=$_POST['mode'];
$no=$_POST['no'];
$codedataName=$_POST['codedataName'];

if($mode=='ins'){
    try
    {
        $db->beginTransaction();

		$qry="select no from codedata where cd=:cd";
		$res=$db->query($qry,array(":cd"=>$codedataName));

		if(!$res->results['0']['no']){

			$qry="insert into codedata set
			type=:type
			,cd=:cd
			,save_time=now()
			";

			$param[":type"]=$code;
			$param[":cd"]=$codedataName;
			if($res=$db->query($qry,$param)){
				$lastNo=$res->lastId;
				if($code=='PLACE'){
					$tqry="alter table goods_cnt_loc add codeno_".$lastNo." int default 0;";
					$tres=$db->query($tqry);
				}
			}
			
		    $db->commit();
	        msg("등록되었습니다.","codedata_set.php");	
		}else{
			$db->rollBack();
			 msg("중복된 이름이 있습니다","codedata_set.php");	
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
$qry="select c.* from codedata c 
order by c.no asc";

$res = $db->query($qry);

foreach($res->results as $v){
    $data[$v['type']][]=$v;
	
}
$loop=$data;

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
