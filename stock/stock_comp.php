<?
include "../_header.php";member_chk();

$page_title='입고진행중관리';

$codedata = get_codedata('IN');
foreach($codedata as $v){
	$codedata_no[$v['no']]=$v['cd'];
}

if(!$_POST['search_stock_title'])$_POST['search_stock_title']=$_REQUEST['excel_group_id'];
$_GET['chk_no']=unserialize(urldecode($_GET['chk_no']));
foreach($_GET['chk_no'] as $cv){
	$checked['chk_no'][$cv]="checked";
}

if($_FILES){
		
	if($_POST['excel_chk_num_up']){

		$excel_data=excel_read('unlink','6');

		try{
				
			$db->beginTransaction();

			foreach($excel_data as $k=>$v){
				$qry="update stock_list set 
				chk_num=:chk_num 
				,memo=:memo
				where no=:no and stock_num_reg>stock_num";
				unset($param);
				$param[':chk_num']=$v['9'];
				$param[':memo']=$v['10'];
				$param[':no']=$v['0'];

				$db->query($qry,$param);
			}

			$db->commit();
			msg('처리되었습니다.','stock_comp.php?excel_group_id='.$_REQUEST['excel_group_id']);
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage().":".$e->getFile());	
		}

	}else{


		ini_set('memory_limit', -1);
		ini_set('max_execution_time',0);
		
		$excel_data=excel_read('unlink','5');

		$qry="select goodsno,goodsnm from stock_list where group_id=:group_id";
		$res=$db->query($qry,array(":group_id"=>$_POST['search_stock_title']));
		foreach($res->results as $v){
			$stock_model[]=$v['goodsnm'];
			$stock_model_sn[$v['goodsnm']]=$v['goodsno'];
		}
		
		
		//데이터 검증
		if(count($excel_data)>0){
			
			foreach($excel_data as $k=>$v){
				
				if( $v['2'] &&!in_array($v['2'],$stock_model))$err_msg[]=$k."[수입면장] 입고예정모델없음";
				//if( $v['13'] && !in_array($v['13'],$stock_model))$err_msg[]=$k."[인보이스] 입고예정모델없음";  //인보이스는 없을수도있음
				
			}

			if (sizeof($err_msg) > 0) {
				tydebug($err_msg);
			}else{
				//tydebug('등록시작');		
				try{
					
					$db->beginTransaction();
					

					//$db->query("delete from import_licence where group_id=:group_id",array(":group_id"=>$_POST['search_stock_title']));
					//tydebug(($excel_data));
					$loop100=array_chunk($excel_data,50);
					unset($excel_data);

					foreach($loop100 as $key=>$val){
						unset($qry_str);
						unset($var_str);
						foreach($val as $k=>$v){
							
							if($v['2']){
								
								$chk_qry='select no from import_licence where 
								type=:type'.$k.'
								and goodsnm=:goodsnm'.$k.'
								and img_name=:img_name'.$k.'
								and cnt=:cnt'.$k.'
								and list_no=:list_no'.$k.'
								and import_no=:import_no'.$k.'
								and gabji=:gabji'.$k.'
								';
								unset($chk_str);
								$chk_str[':type'.$k]='import_licence';
								$chk_str[':goodsnm'.$k]=$v['2'];
								$chk_str[':img_name'.$k]=$v['3'];
								$chk_str[':cnt'.$k]=$v['4'];
								$chk_str[':list_no'.$k]=$v['5'];
								$chk_str[':import_no'.$k]=$v['6'];
								$chk_str[':gabji'.$k]=(trim($v['7'])=='갑지모델')?"y":"n";

								$chk_res=$db->query($chk_qry,$chk_str);

								if(!$chk_res->results['0']['no']){
								
									$var_str[':type'.$k]='import_licence';
									$var_str[':goodsnm'.$k]=$v['2'];
									$var_str[':img_name'.$k]=$v['3'];
									$var_str[':cnt'.$k]=$v['4'];
									$var_str[':list_no'.$k]=$v['5'];
									$var_str[':import_no'.$k]=$v['6'];
									$var_str[':gabji'.$k]=(trim($v['7'])=='갑지모델')?"y":"n";
									$var_str[':group_id'.$k]=$_POST['search_stock_title'];
									$var_str[':goodsno'.$k]=$stock_model_sn[$v['2']];
									$var_str[':memo'.$k]=$v['7'];

									$qry_str[]='(:type'.$k.',:group_id'.$k.',:goodsno'.$k.',:goodsnm'.$k.',:img_name'.$k.',:cnt'.$k.',:list_no'.$k.',:import_no'.$k.',:memo'.$k.',now(),:gabji'.$k.')';
								}


							}
							
							if($v['13']){
								
								$chk_qry='select no from import_licence where 
								type=:type'.$k.'
								and goodsnm=:goodsnm'.$k.'
								and img_name=:img_name'.$k.'
								and cnt=:cnt'.$k.'
								and list_no=:list_no'.$k.'
								and import_no=:import_no'.$k.'
								and gabji=:gabji'.$k.'
								';

								unset($chk_str);
								$chk_str[':type'.$k]='invoice';
								$chk_str[':goodsnm'.$k]=$v['13'];
								$chk_str[':img_name'.$k]=$v['14'];
								$chk_str[':cnt'.$k]=$v['15'];
								$chk_str[':list_no'.$k]=$v['16'];
								$chk_str[':import_no'.$k]=$v['17'];
								$chk_str[':gabji'.$k]=(trim($v['18'])=='갑지모델')?"y":"n";

								$chk_res=$db->query($chk_qry,$chk_str);

								if(!$chk_res->results['0']['no']){
								
									$var_str[':typei'.$k]='invoice';
									$var_str[':goodsnmi'.$k]=$v['13'];
									$var_str[':img_namei'.$k]=$v['14'];
									$var_str[':cnti'.$k]=$v['15'];
									$var_str[':list_noi'.$k]=$v['16'];
									$var_str[':import_noi'.$k]=$v['17'];
									$var_str[':gabjii'.$k]=(trim($v['18'])=='갑지모델')?"y":"n";
									$var_str[':group_idi'.$k]=$_POST['search_stock_title'];
									$var_str[':goodsnoi'.$k]=$stock_model_sn[$v['13']];
									$var_str[':memoi'.$k]=$v['18'];

									$qry_str[]='(:typei'.$k.',:group_idi'.$k.',:goodsnoi'.$k.',:goodsnmi'.$k.',:img_namei'.$k.',:cnti'.$k.',:list_noi'.$k.',:import_noi'.$k.',:memoi'.$k.',now(),:gabjii'.$k.')';
								}
							}
						}


						if($qry_str){
							$t_cnt++;
							$qry="insert into import_licence (type,group_id,goodsno,goodsnm,img_name,cnt,list_no,import_no,memo,reg_date,gabji) 
							values ".implode(",",$qry_str)." 
							";
							
							$db->query($qry,$var_str);
						}

						//tydebug($qry);
					}
					
					//$db->rollBack();
					$db->commit();
					msg(count($t_cnt).'건 처리되었습니다.','stock_comp.php?excel_group_id='.$_POST['search_stock_title']);
				}
				catch( Exception $e ){
					tydebug('err');
					$db->rollBack();
					tydebug($e->getMessage().":".$e->getFile());	
				}
			}
		}		
	}
}


if($_POST['mode']=='cost_modify'){

	$qry="update stock_list set cost=cost_ori*:cost_mod1, cost_mod=:cost_mod where group_id!='' and group_id=:group_id";
	
	unset($param);
	$param[':cost_mod']=round($_POST['cost_modify'],3);
	$param[':cost_mod1']=round($_POST['cost_modify'],3);
	$param[':group_id']=$_POST['excel_group_id'];

	$db->query($qry,$param);

	msg('처리되었습니다.','stock_comp.php?excel_group_id='.$_REQUEST['excel_group_id']);

}else if($_POST['mode']=='stock_comp'){
	//승인,삭제등

	try{			
		$db->beginTransaction();
		$qry="select * from stock_list where no in ('".implode("','",$_POST['chk_no'])."')  and (state='0' or comp_chk='n') and group_id!=''";
		$res=$db->query($qry);
		
		if($db->count<=0){ $db->rollBack(); msg('선택한 데이터가 없습니다.','stock_comp.php?excel_group_id='.$_REQUEST['excel_group_id'].'&chk_no='.urlencode(Serialize($_POST['chk_no']))); }

		$add_qry =",cost=ROUND(cost),chk_num=:chk_num";

		$add_qry.=",stock_num=:stock_num,now_cnt=:now_cnt ,admin_no=:admin_no ,admin_name=:admin_name,comp_chk=:comp_chk ";
		

		$qry="update stock_list set f_group_id=group_id, state='1', comp_date=now() ".$add_qry." where no =:no";
		$db->prepare($qry);

		foreach($res->results as $v){

			unset($param);
			
			$param[':admin_no']=$_SESSION['sess']['m_no'];
			$param[':admin_name']=$_SESSION["sess"]["name"];
			//$param[':chk_num']=$_POST['stock_num_add'][$v['no']];
			$_POST['stock_num_add'][$v['no']]=intval($_POST['stock_num_add'][$v['no']]);
			$param[':chk_num']="0";
			$param[':no']=$v['no'];
			$param[':now_cnt']=$v['now_cnt']+$_POST['stock_num_add'][$v['no']];
			$param[':stock_num']=$v['stock_num']+$_POST['stock_num_add'][$v['no']];
			
			$stock_add_memo='';
			if($v['stock_num_reg']>$param[':stock_num']){//입고예정수량이 실입고수량보다 많으면 목록에 대기.

				$param[':comp_chk']='n';
				$stock_add_m=$_POST['stock_num_add'][$v['no']];
			}else if($v['stock_num_reg']<$param[':stock_num']){//입고 수량에 오버되서 입고시 입예에서는 남은수량만큼만 빼준다	

				$param[':comp_chk']='y';
				
				$stock_add_m=$v['stock_num_reg']-$v['stock_num']; //남은 수량만큼만 차감
				$stock_add_memo=$stock_add_m.'개 초과입고';
			}else if($v['stock_num_reg']==$param[':stock_num']){

				$param[':comp_chk']='y';
				$stock_add_m=$_POST['stock_num_add'][$v['no']];
			}
			
			//$param[':multi']=$v['cost_mod'];
		
			if($db->execute($param)){

				//가용재고체크
				$psd_stock=goods_psd_stock($v['goodsno']);
				if($psd_stock<=0){
					if($v['new_chk']=="y"){
						goods_soldout_log("1",$v['goodsno'],$_POST['stock_num_add'][$v['no']]);
					}else{
						goods_soldout_log("2",$v['goodsno'],$_POST['stock_num_add'][$v['no']]);
					}				
				}
				
				$okd=stock_io('move',$v['goodsno'],$v['goodsnm'],-$stock_add_m,$v['no'],$_SERVER['REQUEST_URI'],'3',$_POST['stock_comp_loc']);

				$okd=stock_io('move',$v['goodsno'],$v['goodsnm'],$_POST['stock_num_add'][$v['no']],$v['no'],$_SERVER['REQUEST_URI']."|".$stock_add_memo,$_POST['stock_comp_loc'],'3');
				

				/*기타비용정산 등록*/
				if($v['d_code']!=0){
				
				$qry2="insert into other_cost_calcu set
				goodsno=:goodsno
				,d_code=:d_code
				,num=:num
				,price=:price
				,memo=:memo
				,place_codeno=:place_codeno
				,stock_seq=:stock_seq
				,admin_no=:admin_no
				,reg_date=now()
				,comp_date=now()
				";

				unset($param2);
				$param2[':goodsno']=$v['goodsno'];
				$param2[':d_code']=($v['d_code'])?$v['d_code']:0;
				$param2[':num']=$_POST['stock_num_add'][$v['no']];
				$param2[':price']=$v['cost'];
				$param2[':memo']=$v['memo'];
				$param2[':place_codeno']=$_POST['stock_comp_loc'];
				$param2[':stock_seq']=$v['no'];
				$param2[':admin_no']=$_SESSION['sess']['m_no'];

				$db->query($qry2,$param2);
				
				}
			}
		}
	
		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.','stock_comp.php?excel_group_id='.$_REQUEST['excel_group_id'].'&chk_no='.urlencode(Serialize($_POST['chk_no'])));
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}

}else if($_POST['mode']=='del'){ //입고완료와 패턴은 비슷하지만 수정시 상태값별로 처리를 잘못하면 양쪽에 영향을 줄수있으니 분리
	
	try{			
		$db->beginTransaction();
		$qry="select * from stock_list where no in ('".implode("','",$_POST['chk_no'])."')  and (state='0' or comp_chk='n') and group_id!=''";
		$res=$db->query($qry);

		if($db->count<=0){ $db->rollBack(); msg('선택한 데이터가 없거나 삭제가 불가능합니다.','stock_comp.php'); }

		$qry="update stock_list set state='2' where no =:no";
		$db->prepare($qry);
		foreach($res->results as $v){

			$param[':no']=$v['no'];
			
			if( $v['stock_num']==0 ){
				if($db->execute($param)){
					//입고예정재고삭제
					$okd=stock_io('stock',$v['goodsno'],$v['goodsnm'],-$v['stock_num_reg'],$v['no'],$_SERVER['REQUEST_URI'],'3');				

					//모델삭제
					$chk_qry="select count(*) cnt from stock_list where goodsno='".$v['goodsno']."' and state!='2' ";
					$chk_res=$db->query($chk_qry);
					
					if($chk_res->results['0']['cnt']==0){ //입고내역이 없으면 모델도 삭제(필요없는데이터기 때문에 삭제)
						
						$delqry1="delete from goods where no='".$v['goodsno']."'";						
						$db->query($delqry1);
						$delqry2="delete from goods_cnt_loc where goodsno='".$v['goodsno']."'";
						$db->query($delqry2);
						$delqry3="delete from goods_cnt_loc where goodsno='".$v['goodsno']."'";
						$db->query($delqry3);
					}
				}
			}else{
				throw new Exception('개발팀에 문의(입고처리중 삭제) : '.$v['no']." ".$v['goodsno'].":".$v['goodsnm'], 1); 
			}
			$del_group_id=$v['group_id'];
			
		}
	
		//해당 그룹에 제품이 없다면 달력 삭제
		unset($param);
		$qry="select count(*) cnt from stock_list where group_id=:group_id and state!=2";
		$param[':group_id']=$del_group_id;
		$res=$db->query($qry,$param);
		
		if($res->results['0']['cnt']==0){
			$qry="delete from calendar where group_id=:group_id";
			$db->query($qry,$param);
		}


		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.','stock_comp.php?excel_group_id='.$_REQUEST['excel_group_id']);
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
}else if($_POST['mode']=='stock_end'){ //입고완료처리
	try{			
		$db->beginTransaction();
	
	//	$qry="select * from stock_list where group_id=:group_id and  group_id!='' ";
	//	$param['group_id']=$_POST['excel_group_id'];
	//	$res=$db->query($qry,$param);
		$qry="select * from stock_list where no in ('".implode("','",$_POST['chk_no'])."')";
		$res=$db->query($qry);


		foreach($res->results as $v){
			if($v['stock_num_reg']>$v['stock_num']){// 입고량 부족시 나머지를 예약재고에서 빼줌
				$num_cha=$v['stock_num_reg']-$v['stock_num'];
				$okd=stock_io('stock_deficient',$v['goodsno'],$v['goodsnm'],-$num_cha,$v['no'],$_SERVER['REQUEST_URI']."|입고량부족",'3');
			}else if($v['stock_num_reg']<$v['stock_num']){
				//$num_cha=$v['stock_num']-$v['stock_num_reg'];
				//$okd=stock_io('stock_exceed',$v['goodsno'],$v['goodsnm'],$num_cha,$v['no'],$_SERVER['REQUEST_URI']."|입고량초과",'51');
			}
			$qry="update stock_list set comp_chk='y', comp_date=now(), state='1' where no='".$v['no']."' ";
			$db->query($qry,$param);
			
			//입고횟수증가
			$db->query("update goods set stock_num_cnt=stock_num_cnt+1 where no=:goodsno",array(":goodsno"=>$v['goodsno']));
		}
		
		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.','stock_comp.php?excel_group_id='.$_REQUEST['excel_group_id']);
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
}else if($_POST['mode']=='group_change'){ //
	try{			
		$db->beginTransaction();

		$group_id=trim($_POST['group_id']);
		$cqry="select date_from from calendar where group_id='".$group_id."'";
		$cres=$db->query($cqry);
		$calendar_date=$cres->results[0]['date_from'];

		$uqry="update stock_list set calendar_date='".$calendar_date."', group_id='".$group_id."' where no in ('".implode("','",$_POST['chk_no'])."')";
		$db->query($uqry);

		$oqry="select count(*) cnt from stock_list where group_id='".$_POST['search_stock_title']."'";
		$ores=$db->query($oqry);
		if($ores->results['0']['cnt']==0){
			$dqry="delete from calendar where group_id='".$_POST['search_stock_title']."'";
			$db->query($dqry);
		}

		$db->commit();
		msg('처리되었습니다.','stock_comp.php?excel_group_id='.$_REQUEST['excel_group_id']);		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
}

$_POST[page_num]=1200;
if($print_xls || $_POST['paste_name']) $no_limit=1;

//면장
if($_POST['search_stock_title']){
	$qry="select * from import_licence where group_id=:group_id and group_id!=''";
	$res=$db->query($qry,array(":group_id"=>$_POST['search_stock_title']));

	foreach($res->results as $v){
		$import_data[$v['type']][] =$v;

		$import_model_cnt[$v['goodsno']]+=$v['cnt'];
	}
}

//$import_model_cnt['20793']=11; test

//면장end

$qry="select sl.group_id,cal.title from stock_list sl
left join calendar cal on sl.group_id = cal.group_id
where sl.group_id!=''
and sl.comp_chk='n'
and sl.state!='2'
group by sl.group_id
order by reg_date desc
";
$res=$db->query($qry);

foreach($res->results as $k=>$v){
	if(!$v['title'])$v['title']='이름없음'.$k;
	$title[$v['group_id']]=$v['title'];
}

$field="sl.*,b.brandnm,b.brand_img_folder,c.catenm,cal.title,g.goodsnm_sub,g.img_name,cal.date_from cal_date,cdata.cd cd";
$db_table="stock_list sl
left join goods g on sl.goodsnm=g.goodsnm
left join brand b on sl.brandno = b.no
left join category c on sl.cateno = c.no
left join calendar cal on sl.group_id = cal.group_id
left join codedata cdata on cdata.no=sl.customer
";

#$where[]="(sl.state='0' or sl.comp_chk='n' ) ";
$where[]="sl.group_id!=''";
$where[]="sl.group_id='".$_POST['search_stock_title']."'";
$where[]="sl.comp_chk!='y'";
$where[]="sl.state!='2'";

$sort="sl.no asc";

$pg = new page($_POST[page],$_POST[page_num],$no_limit);
$pg->field = $field;

$pg->setQuery($db_table,$where,$sort);
$pg->exec();

$res = $db->query($pg->query);
$state=1;
foreach($res->results as $v){

	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']); 
	$loop[str_replace(' ','',$v['group_id'])][]=$v;

	$ins_model_cnt[$v['goodsno']]+=$v['stock_num_reg'];

	$cost_mod=$v['cost_mod'];
	if($v['state']=='0')$state=0;
}

$selected['search_stock_title'][$_POST['search_stock_title']]='selected';


$tpl->assign(array(	
'loop' => $loop
,'import_data' => $import_data
,'pg'=> $pg	));

$tpl->print_('tpl');
?>

