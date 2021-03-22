<?
include "../_header.php";member_chk();

$page_title='입고완료목록(상세)';

$group_id=$_GET['group_id'];


if($_FILES){	
	ini_set('memory_limit', -1);
	ini_set('max_execution_time',0);
	
	$excel_data=excel_read('unlink','5');

	$qry="select goodsno,goodsnm from stock_list where group_id=:group_id";
	$res=$db->query($qry,array(":group_id"=>$group_id));
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
				
				//$db->query("delete from import_licence where group_id=:group_id",array(":group_id"=>$group_id));
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
							$t_cnt++;
								$var_str[':type'.$k]='import_licence';
								$var_str[':goodsnm'.$k]=$v['2'];
								$var_str[':img_name'.$k]=$v['3'];
								$var_str[':cnt'.$k]=$v['4'];
								$var_str[':list_no'.$k]=$v['5'];
								$var_str[':import_no'.$k]=$v['6'];
								$var_str[':gabji'.$k]=(trim($v['7'])=='갑지모델')?"y":"n";
								$var_str[':group_id'.$k]=$group_id;
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
							$t_cnt++;
								$var_str[':typei'.$k]='invoice';
								$var_str[':goodsnmi'.$k]=$v['13'];
								$var_str[':img_namei'.$k]=$v['14'];
								$var_str[':cnti'.$k]=$v['15'];
								$var_str[':list_noi'.$k]=$v['16'];
								$var_str[':import_noi'.$k]=$v['17'];
								$var_str[':gabjii'.$k]=(trim($v['18'])=='갑지모델')?"y":"n";
								$var_str[':group_idi'.$k]=$group_id;
								$var_str[':goodsnoi'.$k]=$stock_model_sn[$v['13']];
								$var_str[':memoi'.$k]=$v['18'];

								$qry_str[]='(:typei'.$k.',:group_idi'.$k.',:goodsnoi'.$k.',:goodsnmi'.$k.',:img_namei'.$k.',:cnti'.$k.',:list_noi'.$k.',:import_noi'.$k.',:memoi'.$k.',now(),:gabjii'.$k.')';
							}
						}
					}


					if($qry_str){
						
						$qry="insert into import_licence (type,group_id,goodsno,goodsnm,img_name,cnt,list_no,import_no,memo,reg_date,gabji) 
						values ".implode(",",$qry_str)." 
						";
						
						$db->query($qry,$var_str);
					}

					//tydebug($qry);
				}
				
				//$db->rollBack();
				$db->commit();
				msg(count($t_cnt).'건 처리되었습니다.','stock_comp_detail.php?group_id='.$group_id);
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	

				die;
			}
		}
	}		
}

if($_POST['mode']=="confirm"){

	$uqry="update calendar set confirm_chk='1' where group_id='".$group_id."'";
	$db->query($uqry);
	msg('완료 처리되었습니다.','stock_comp_detail.php?group_id='.$group_id);
}else if($_POST['mode']=="date_change"){

	//상태변경
	$qry="update stock_list set ".$_POST['date_type']."='".$_POST['input_date']."' where group_id='".$group_id."'";
	$db->query($qry);
	msg('변경 되었습니다.','stock_comp_detail.php?group_id='.$group_id);
}else if($_POST['mode']=="f_group_id"){

	//최종그룹추가
	$qry="update stock_list set f_group_id='".$_POST['f_group_id']."' where no in ('".implode("','",$_POST['chk_no'])."')";
	$db->query($qry);
	msg('처리 되었습니다.','stock_comp_detail.php?group_id='.$group_id);
}

//면장
$qry="select * from import_licence where group_id=:group_id and group_id!=''";
$res=$db->query($qry,array(":group_id"=>$group_id));

foreach($res->results as $v){
	$import_data[$v['type']][] =$v;

	$import_model_cnt[$v['goodsno']][$v['type']]+=$v['cnt'];
}


$_POST[page_num]=1200;

$field="sl.*,b.brandnm,b.brand_img_folder,c.catenm,cal.title,g.goodsnm_sub,g.img_name,cal.date_from cal_date";
$db_table="stock_list sl
left join goods g on sl.goodsnm=g.goodsnm
left join brand b on sl.brandno = b.no
left join category c on sl.cateno = c.no
left join calendar cal on sl.group_id = cal.group_id";

$where[]="sl.group_id!=''";
$where[]="sl.group_id='".$group_id."'";

$sort="sl.no asc";

$pg = new page($_POST[page],$_POST[page_num],$no_limit);
$pg->field = $field;

$pg->setQuery($db_table,$where,$sort);
$pg->exec();

$res = $db->query($pg->query);

foreach($res->results as $v){
	$iqry="select * from import_licence li where group_id='".$v['group_id']."' and goodsnm='".$v['goodsnm']."' order by reg_date desc";
	//$iqry="select * from import_licence li where group_id='2020-11-13 16:49:50' and goodsnm='WAY1111.BA0928' order by reg_date desc";
	$ires=$db->query($iqry);
	foreach($ires->results as $iv){
		$v[$iv['type']][]=$iv['import_no'];
	}
	$title[$v['group_id']]=$v["title"];

	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']); 
	$loop[str_replace(' ','',$v['group_id'])][]=$v;

	$ins_model_cnt[$v['goodsno']]+=$v['stock_num'];

	if($v['pass_date'])$pass_date=$v['pass_date'];
	if($v['license_date'])$license_date=$v['license_date'];

	$cost_mod=$v['cost_mod'];
	$state=$v['state'];
}
//tydebug($loop);

$tpl->assign(array(	
'loop' => $loop
,'import_data' => $import_data
,'pg'=> $pg	));

$tpl->print_('tpl');
?>

