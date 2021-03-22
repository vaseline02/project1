<?
include "../_header.php";member_chk();
$page_title='입고예정등록(수입)';

if($_FILES){
	$excel_data=excel_read('unlink');

	//데이터 검증
	if(count($excel_data)>0){
		$GOODS=new goods();
		$brand_info = $GOODS->get_brand_info();
		$cate_info = $GOODS->get_cate_info();
		$codedata = get_codedata('IN');
		
		

		foreach($brand_info as $v){
			$brand_name[]=$v['brandnm'];
			$brand_no[$v['brandnm']]=$v['no'];
		}
		foreach($cate_info as $v){
			$cate_name[]=$v['catenm'];
			$cate_no[$v['catenm']]=$v['no'];
		}
		foreach($codedata as $v){
			$codedata_name[]=$v['cd'];
			$codedata_no[$v['cd']]=$v['no'];
		}

		foreach($excel_data as $k=>$v){
			if(!in_array(trim($v['0']),$brand_name))$err_msg[]=$k."번열 등록되지않은 브랜드";
			#if( $v['1'] && !in_array(trim($v['1']),$cate_name))$err_msg[]=$k."번열 등록되지않은 카테고리";
			if(!in_array(trim($v['9']),$codedata_name))$err_msg[]=$k."번열 등록되지않은 거래처";
		}


		if (sizeof($err_msg) > 0) {
			tydebug($codedata);
			tydebug($err_msg);
		}else{
			//tydebug('등록시작');			
			try{
				
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
					
					for($i=0;$i<11;$i++){
						$v[$i]=trim($v[$i]);
					}

					$chk_goods=$GOODS->get_goodsno($v['1'],'',$brand_no[$v['0']]);
					if(!$chk_goods){
						
						//$new_chk='y';
						//상품 신규 등록
						$qry="insert into goods set 
						brandno='".$brand_no[$v['0']]."'
						,cateno=''
						,goodsnm='".$v['1']."'
						,goodsnm_sub='".$v['2']."'
						,reg_date=now()
						";
						if($db->query($qry)){
							
							$insert_id_goods = $db->lastId();
							//스펙 테이블,재고위치테이블 디비추가
							$db->query("insert into goods_cnt_loc set goodsno=:insert_id",array(":insert_id"=>$insert_id_goods));
							
							$db->query("insert into goods_info set goodsno=:insert_id,origin=:origin,consumer_price=:consumer_price",array(":insert_id"=>$insert_id_goods,":origin"=>$v['9'],":consumer_price"=>$v['10']));
						}
					}else{
						$insert_id_goods = $chk_goods;
						if($v['11'] || $v['10']){
							$uset="";
							if($v['10']) $uset[]="origin='".$v['10']."'";
							if($v['11'])	$uset[]="consumer_price='".$v['11']."'";
							$db->query("update goods_info set ".implode(",",$uset)." where goodsno='".$insert_id_goods."'");
						}
						//$new_chk='n';
					}

					$chk_qry="select sum(stock_num) cnt from stock_list where goodsno='".$insert_id_goods."'";
					$chk_res=$db->query($chk_qry);
					
					if($chk_res->results['0']['cnt']==0)$new_chk='y';
					else $new_chk='n';

					$cost=$GOODS->cal_stock_price($v);
					
				
					if($insert_id_goods){
						unset($param);
						$qry="insert into stock_list set
						brandno='".$brand_no[$v['0']]."'
						,cateno=''
						,goodsno='".$insert_id_goods."'
						,goodsnm='".$v['1']."'
						,stock_num_reg='".str_replace(",","",$v['3'])."'
						,stock_num='0'
						,now_cnt='0'
						#,currency=''
						,cost_std='".str_replace(",","",$v['4'])."'
						,cost='".$cost."'
						,cost_ori='".$cost."'
						,customer='".$codedata_no[$v['9']]."'
						,origin=''
						,memo='".$v['12']."'
						,reg_date=now()
						,admin_no=:admin_no
						,admin_name=:admin_name
						,new_chk='".$new_chk."'
						,extra_expense='".$v['8']."'
						,charge='".$v['7']."'
						,duty_per='".$v['6']."'
						,rate='".$v['5']."'
						";
						$param[':admin_no']=$_SESSION['sess']['m_no'];
						$param[':admin_name']=$_SESSION["sess"]["name"];
						$db->query($qry,$param);
					}
				}


				//$db->rollBack();
				$db->commit();
				msg('처리되었습니다.','stock_schedule_import.php');
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		}
	}	
}

//승인,삭제등
if($_POST['mode']=='stock_comp'){

	try{			
		$db->beginTransaction();

		$group_id=date('YmdHi'.$_POST['chk_no']['0']);	

		$qry="select * from stock_list where no in ('".implode("','",$_POST['chk_no'])."') and state='0' and group_id=''";
		$res=$db->query($qry);

		if($db->count<=0){ $db->rollBack(); msg('선택한 데이터가 없습니다.','stock_schedule_import.php'); }

		/* 3번위치에 재고추가 (입고예정)*/

		$qry="update stock_list set group_id=:group_id,calendar_date=:calendar_date,d_code=:d_code  where no=:no";
		$db->prepare($qry);
		unset($param);
		unset($hide_goods);
		foreach($res->results as $v){
			
			$param[':group_id']=$group_id;
			$param[':calendar_date']=$_POST['cal_date'];
			$param[':d_code']=($_POST['d_code'])?$_POST['d_code']:0;
			$param[':no']=$v['no'];
		    if($db->execute($param)){
				$okd=stock_io('stock',$v['goodsno'],$v['goodsnm'],$v['stock_num_reg'],$v['no'],$_SERVER['REQUEST_URI'],'3');

				$hide_goods[]=$v['goodsno'];
			}
		}
		
		//입고 처리되면 모델 숨김처리 해지
		$hqry="update goods set hidden_yn='n' where no in ('".implode("','",$hide_goods)."') ";
		$db->query($hqry);

		/*달력등록*/
		unset($param);
		if($_POST['cal_date']){
			$qry="insert into calendar set u_id=:u_id,group_id=:group_id,date_from=:cal_date ,date_to=:cal_date2,type=:type,title=:title,save_time=now()";
			$param=array(":u_id"=>$sess['m_id'],":group_id"=>$group_id,":type"=>$_POST['cal_type'],":title"=>$_POST['cal_text']
				,":cal_date"=>$_POST['cal_date'],":cal_date2"=>$_POST['cal_date']);
			$db->query($qry,$param);
		}
		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.','stock_schedule_import.php');
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}

}else if($_POST['mode']=='del'){
	
	try{			
		$db->beginTransaction();
		$qry="select * from stock_list where no in ('".implode("','",$_POST['chk_no'])."') and state='0' and group_id=''";
		$res=$db->query($qry);

		if($db->count<=0){ $db->rollBack(); msg('선택한 데이터가 없습니다.','stock_schedule_import.php'); }

		$qry="update stock_list set state='2' where no =:no";
		$db->prepare($qry);
		unset($param);
		foreach($res->results as $v){

			$param[':no']=$v['no'];
			$db->execute($param);

			$sqry="select count(*) cnt from stock_list where state!='2' and goodsno='".$v["goodsno"]."'";
			$sres=$db->query($sqry);
			$sdata=$sres->results['0']['cnt'];
			
			if($sdata==0){//신규입고였으면 상품정보 같이 삭제
				
				$db->query("delete from goods where no='".$v["goodsno"]."'");
				$db->query("delete from goods_cnt_loc where goodsno='".$v["goodsno"]."'");
				$db->query("delete from goods_info where goodsno='".$v["goodsno"]."'");
			}
		}

		//내역삭제
		$qry="delete from stock_list where state='2'";
		$db->query($qry);

	
	
		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.','stock_schedule_import.php');
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
}else if($_POST['mode']=='mod'){
	
	try{			
		$db->beginTransaction();
		$qry="select sl.*, g.no as gno, g.goodsnm as g_goodsnm, g.brandno as g_brandno, g.goodsnm_sub from stock_list sl 
		left join goods g on (sl.goodsno=g.no)
		where sl.no in ('".implode("','",$_POST['chk_no'])."')";
		$res=$db->query($qry);
		if($db->count<=0){ $db->rollBack(); msg('선택한 데이터가 없습니다.','stock_schedule_import.php'); }
		
		foreach($res->results as $v){
		
			$after_goodsnm=trim($_POST['m_goodsnm'][$v['no']]);

			//변경될 상품 조회
			$gqry="select * from goods where goodsnm='".$after_goodsnm."'";
			$gres=$db->query($gqry);
			$gdata=$gres->results[0];

			if($gdata){
				//변경될 상품이 있을경우 goods->no 를 가져온다.
				$after_goodsno=$gdata['no'];	
				$add_qry=", brandno='".$gdata['brandno']."' ";
			}else{
				$add_qry="";
				//변경될 상품이 없을경우 신규 등록
				$iqry="insert into goods set 
				brandno='".$v['brandno']."'
				,cateno=''
				,goodsnm='".$after_goodsnm."'
				,goodsnm_sub='".$v['goodsnm_sub']."'
				,reg_date=now()
				";

				if($db->query($iqry)){
					$after_goodsno = $db->lastId();
					//스펙 테이블,재고위치테이블 디비추가
					$db->query("insert into goods_cnt_loc set goodsno=:insert_id",array(":insert_id"=>$after_goodsno));
					$db->query("insert into goods_info set goodsno=:insert_id,origin=:origin",array(":insert_id"=>$after_goodsno,":origin"=>''));
				}

			}

			//입고예정될 재고를 변경될 상품으로 업데이트 한다.
			$uqry="update stock_list set goodsno='".$after_goodsno."', goodsnm='".$after_goodsnm."' ".$add_qry." where no='".$v['no']."'";
			$db->query($uqry);

			//변경전의 상품의 입고내역이 있는지 확인한다.
			$sqry="select * from stock_list where state!='2' and goodsno='".$v["gno"]."'";
			$sres=$db->query($sqry);
			$sdata=$sres->results[0];

			//입고내역이없을경우 상품 삭제
			if(!$sdata){
				$db->query("delete from goods where no='".$v["gno"]."'");
				$db->query("delete from goods_cnt_loc where goodsno='".$v["gno"]."'");
				$db->query("delete from goods_info where goodsno='".$v["gno"]."'");
			}
		}	

		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.','stock_schedule_import.php');
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
}




$_POST[page_num]=1000;
if($print_xls || $_POST['paste_name']) $no_limit=1;

$field="sl.*,b.brandnm,b.brand_img_folder,c.catenm,g.goodsnm_sub,g.img_name,g.goodsnm, g.reg_date as gdate";
$db_table="stock_list sl
left join goods g on sl.goodsno=g.no
left join brand b on sl.brandno = b.no
left join category c on sl.cateno = c.no
";
$where[]="sl.state='0'";
$where[]="sl.group_id=''";

$pg = new page($_POST[page],$_POST[page_num],$no_limit);
$pg->field = $field;

$pg->setQuery($db_table,$where,$_POST[sort]);
$pg->exec();
$res = $db->query($pg->query);


//tydebug($codedata);

foreach($res->results as $v){
	$stock_sum+=$v['stock_num_reg'];
	$sqry="select reg_date from stock_list sl where goodsno='".$v['goodsno']."' order by reg_date desc limit 1";
	$sreg=$db->query($sqry);
	$stockdate=$sreg->results[0]['reg_date'];

	$codedata = get_codedata('IN','',$v['customer']);
	$v['codename']=$codedata[0]['cd'];

	$v['stock_date']=$stockdate;
	if($v['gdate']==$stockdate)$v['newgoods']="y";
	if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	$loop[]=$v;
}


//$tpl->assign($data);

$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
