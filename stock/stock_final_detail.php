<?
include "../_header.php";member_chk();

$page_title='최종입고관리(상세)';

$group_id=$_GET['group_id'];


$qry="select * from stock_final_set where f_group_id=:f_group_id";
$param[':f_group_id']=$group_id;
$res=$db->query($qry,$param);

$column_arr=array("송금액"=>"send_money"
,"송금환율"=>"send_rate"
,"운임(선)"=>"freight"
,"수수료"=>"charge"
,"관세"=>"duty_per"
,"특소세"=>"spe_tax"
,"교육세"=>"edu_tax"
,"부대비용"=>"extra_expense"
,"운임(후)"=>"freight_f"
,"환불"=>"refund");


foreach($res->results as $v){

	$set_no=$v['no'];
	
	foreach($column_arr as $cv){
		$d_arr[$cv]=explode("|",$v[$cv]);

		$base[$cv]=array_sum($d_arr[$cv]);	
	}
	$comp_yn=$v['comp_yn'];
	$base['freight_h']=$base['freight'];
	$base['freight_t']=$base['freight_f'];

}

//평균환율계산
foreach($d_arr['send_money'] as $k=>$v){
	$avg_rate_totp+=$v*$d_arr['send_rate'][$k];
	$avg_rate_cost+=$v;
}
$base['avg_rate']=round($avg_rate_totp/$avg_rate_cost,1);

if($_POST['mode']=="del"){

	$uqry="update stock_list set f_group_id='0' where no in ('".implode("','",$_POST['chk_no'])."')";
	$db->query($uqry);
	msg('삭제 처리되었습니다.','stock_final_detail.php?group_id='.$group_id);

}else if($_POST['mode']=="mod"){

	
	$uqry="update stock_list set f_group_id=:mod_f_group_id where no in ('".implode("','",$_POST['chk_no'])."')";
	$db->query($uqry,array(":mod_f_group_id"=>$_POST['mod_f_group_id']));
	msg('처리되었습니다.','stock_final_detail.php?group_id='.$group_id);
	

	tydebug($_POST);

}else if($_POST['mode']=="comp"){

	try{			
		$db->beginTransaction();
		
		foreach($_POST['ea_price'] as $k=>$v){

			if($v && $_POST['ea_price_ori'][$k]) {
				
				$qry="select no,cost,cost_ori,goodsno from stock_list where no='".$k."' ";
				$res=$db->query($qry);
				$data_stock=$res->results;
				
				$qry="select cost,cost_ori from cost_chg_log where stock_seq='".$data_stock['no']."' order by no limit 1 ";
				$res=$db->query($qry);
				$data_log=$res->results;

				if($data_log['cost']){
					$b_cost=$data_log['cost'];
					$b_cost_ori=$data_log['cost_ori'];
				}else{
					$b_cost=$data_stock['cost'];
					$b_cost_ori=$data_stock['cost_ori'];
				}
				$stock_seq=$data_stock['no'];
				$goodsno=$data_stock['goodsno'];


				$qry="insert into cost_chg_log set
				stock_seq='".$stock_seq."'
				,goodsno='".$goodsno."'
				,cost_ori_b='".$b_cost_ori."'
				,cost_b='".$b_cost."'
				,cost_ori='".$_POST['ea_price_ori'][$k]."'
				,cost='".$v."'
				,admin_no='".$sess['m_no']."'
				,reg_date=now()
				";
				$db->query($qry);
				
				
				$qry="update stock_list set 
				cost_f='".$_POST['ea_price_ori'][$k]."'
				where no='".$k."' ";
				$db->query($qry);
			}
		}
		
		//완료기록
		$qry="update stock_final_set set comp_yn='y' where f_group_id=:f_group_id";
		$db->query($qry,array(":f_group_id"=>$group_id));


		//$db->rollBack();
		$db->commit();
		msg('등록 되었습니다.','stock_final_detail.php?group_id='.$group_id);
		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
	
}else if($_POST['mode']=="calcu"){

	try{			
		$db->beginTransaction();
		unset($param);
		foreach($column_arr as $cv){
			$qr[]=$cv."=:".$cv;

			$param[":".$cv]=implode("|",array_filter($_POST[$cv]));
		}
		$qr=implode(",",$qr);
		
		$qr.=",reg_date=now()
		,admin_no=:admin_no
		";

		foreach($_POST as $k=>$v){
			
			$_POST[$k]=str_replace(",","",$v);
		}

		$param[":f_group_id"]=$_POST['f_group_id'];
		$param[":admin_no"]=$sess['m_no'];

		if($set_no){
			$qry_type="update";
			$add_qry=" where f_group_id=:f_group_id";	
		}else{
			$qry_type="insert into";
			$add_qry=",f_group_id=:f_group_id";	
		}
		
		$qry=$qry_type." stock_final_set set
		".$qr."
		".$add_qry."
		";

		$db->query($qry,$param);

		$qlog="insert into stock_final_set_log set
		".$qr."
		,f_group_id=:f_group_id
		,memo=:memo
		";

		$param[":memo"]=$_POST['calcu_memo'];

		$db->query($qlog,$param);

		$db->commit();
		msg('등록 되었습니다.','stock_final_detail.php?group_id='.$group_id);
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
	

}


//등록로그
$qry="select sfsl.*,m.name from stock_final_set_log sfsl
left join member m on m.no=sfsl.admin_no
where f_group_id=:f_group_id
";
$res = $db->query($qry,array(":f_group_id"=>$group_id));
foreach($res->results as $k=>$v){
	$cal_log[]=$v;
}

$_POST[page_num]=1200;

$field="sl.*,b.brandnm,b.brand_img_folder,c.catenm,g.goodsnm_sub,g.img_name";
$db_table="stock_list sl
left join goods g on sl.goodsnm=g.goodsnm
left join brand b on sl.brandno = b.no
left join category c on sl.cateno = c.no
";

$where[]="sl.f_group_id!='0'";
$where[]="sl.f_group_id='".$group_id."'";

$sort="sl.no asc";
$no_limit=1;
$pg = new page($_POST[page],$_POST[page_num],$no_limit);
$pg->field = $field;

$pg->setQuery($db_table,$where,$sort);
$pg->exec();
$res = $db->query($pg->query);

//계산항목
$calcu_part=array("freight_h","duty_per","charge","extra_expense","freight_t","refund");  

foreach($res->results as $v){

	//$title[$v['group_id']]=$v["title"];

	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']); 
	$loop[str_replace(' ','',$v['f_group_id'])][]=$v;


	$calcu[$v['goodsno']]=$v['cost_std']*$base['avg_rate'];
	$goods_stock_num[$v['goodsno']]=$v['stock_num'];

	if($calcu[$v['goodsno']]>2000000){//특소세,교육세
		
		$tmp=($calcu[$v['goodsno']]-2000000)*$v['stock_num'];

		$price_set['spe_tax']['tot']+=$tmp;
		$price_set['spe_tax']['model'][$v['goodsno']]=$tmp;

		$price_set['edu_tax']['tot']+=$tmp;
		$price_set['edu_tax']['model'][$v['goodsno']]=$tmp;
	}
	
	//최초입금총 외화
	$sum_cost+=$v['cost_std']*$v['stock_num'];

	//각 가격 유무구분
	foreach($calcu_part as $cv){
		
		$calcu_chk[$cv][$v['goodsno']]=(is_numeric($v[$cv]))?$v[$cv]:1;
		$goods_per[$cv][$v['goodsno']]=$v[$cv];
	}
}

//특소세 교육세 계산
foreach($price_set as $k=>$v){
	
	foreach($v['model'] as $k2=>$v2){
	
		$p_divide[$k][$k2]=($v2/$v['tot'])*$base[$k];
	}
}

//총 기준금액 계산
foreach($calcu as $k=>$v){
	$std_price[$k]=$v*$goods_stock_num[$k]+$p_divide['spe_tax'][$k]+$p_divide['edu_tax'][$k];
}

unset($tot);
foreach($calcu_part as $val){

	//총합
	foreach($std_price as $k=>$v){
		
		$tmp=($calcu_chk[$val][$k]!=0)?$v:0;
		$tot[$val][$calcu_chk[$val][$k]]+=$tmp;
		$goods[$val][$k]=$tmp;
	}
	
	//세금적용되는금액
	foreach($tot[$val] as $k=>$v){
		$segum_price[$val][$k]=$v*($k/100);
		
		$segum_sum[$val]+=$v*($k/100);
	}

	//세금적용되는금액의 비중
	foreach($segum_price[$val] as $k=>$v){
		$segum_per[$val][$k]=$v/$segum_sum[$val];
	}
	
	//실비용의 분배
	foreach($segum_per[$val] as $k=>$v){
		$segum_silbi[$val][$k]=$v*$base[$val];
	}

	//tydebug($val);
	//if(!$tmp_std_price)$tmp_std_price=$std_price; //누적없이 원가 기준으로 계산.
	foreach($std_price as $k=>$v){
		$tmp_std_price[$k]=$v+($goods[$val][$k]/$tot[$val][$calcu_chk[$val][$k]]*$segum_silbi[$val][$calcu_chk[$val][$k]]);
	}

	$std_price=$tmp_std_price;
	//tydebug($std_price);

	/*
	//총합
	foreach($std_price as $k=>$v){
		
		$tmp=($calcu_chk[$val][$k]!=0)?$v:0;
		$tot[$val]+=$tmp;
		$goods[$val][$k]=$tmp;
	}
	
	tydebug($val);
	//if(!$tmp_std_price)$tmp_std_price=$std_price; //누적없이 원가 기준으로 계산.
	foreach($std_price as $k=>$v){

		$tmp_std_price[$k]=$v+($goods[$val][$k]/$tot[$val]*$base[$val]);
	}

	$std_price=$tmp_std_price;
	tydebug($std_price);
	*/
}

//부가세 추가
foreach($std_price as $k=>$v){

	$ea_price[$k]=ceil($v*1.1/$goods_stock_num[$k]);
	$ea_price_ori[$k]=ceil($v/$goods_stock_num[$k]);
}


$tpl->assign(array(	
'loop' => $loop
,'import_data' => $import_data
,'pg'=> $pg	));

$tpl->print_('tpl');
?>

