<?
include "../_header.php";

$page_title='모델명 매칭';
ini_set('memory_limit', -1);
#ini_set('max_execution_time',0);
$GOODS=new goods();
$ORDER=new order();		

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_POST['chk_no']){

	if($_POST['mode']=='goodsnm_chg'){
		try{
			
			$db->beginTransaction();

			foreach($_POST['chk_no'] as $v){
				$chk_goodsnm=$GOODS->get_goodsno($_POST['mod_goodsnm'][$v]);

				if($chk_goodsnm){

					$arr_model[]=$_POST['mod_goodsnm'][$v];

					$qry="update order_list set goodsnm=:goodsnm,goodsno=:goodsno where no=:no";
					$param[':goodsno']=$chk_goodsnm;
					$param[':goodsnm']=$_POST['mod_goodsnm'][$v];
					$param[':no']=$v;

					$db->query($qry,$param);
				}
			}
			
			/*전체 재고부족주문 체크하여 등급변경 */
			$qry="select goodsnm,ifnull(sum(order_num),0) sumN from order_list 
			where 1
			and goodsnm in ('".implode("','",$arr_model)."')
			and step in('".implode("','",$order_before_stock_step)."')
			and step2='0'
			group by goodsnm";
			
			$res=$db->query($qry);
			foreach($res->results as $v){
				$goods_order_num[$v['goodsnm']]=$v['sumN'];
			}

			//발송가능 재고수량
			$res=$GOODS->get_stock_deli_av($arr_model);
			foreach($res->results as $v){

				if($goods_order_num[$v['goodsnm']] && $goods_order_num[$v['goodsnm']] <= $v['totstock'])$step='1';
				else $step='2';

				$goods_step[$v['goodsnm']]=$step;
			}

			foreach($goods_step as $k=>$v){
			
				if($step=='2')$add_set_step2=",step2=1";
				else $add_set_step2='';

				$qry="update order_list set
				mod_date=now()
				,step='".$v."'
				".$add_set_step2."
				where goodsnm='".$k."'
				and step in ('".implode("','",$order_before_stock_step)."')
				and step2 in('0','1')
				and step_fixed='0'
				";
				$db->query($qry);
			}
			
			$ORDER->sortOrderSoldout();//품절주문 재정렬

			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다","chk_order_info.php");
			
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());	
		}
	}else if($_POST['mode']=='outside_deli'){/*외부상품 분리*/
		try{
			
			$db->beginTransaction();
			foreach($_POST['chk_no'] as $v){

				$qry="select oobm.*, ml.d_code from order_outside_brand_mat oobm
				left join mall_brand mb on (oobm.brandno=mb.brand_no)
				left join mall_list ml on (mb.mall_no=ml.no)
				where oobm.goodsnm='".$_POST['mod_goodsnm'][$v]."' order by oobm.no desc limit 1
				";
				$res=$db->query($qry);
				$matData=$res->results[0];
				$set_data="";
				if($matData){
					$set_data=", outside_brand='".$matData['brandno']."', ent_code='".$matData['d_code']."', consumer_price='".$matData['consumer_price']."', purchase_price='".$matData['purchase_price']."'";
				}
				
				$qry="update order_list set step='6', step2='0', goodsnm='".$_POST['mod_goodsnm'][$v]."', deli_codeno='outside' ".$set_data." where no='".$v."'";
				$res=$db->query($qry);

				/*묶음 수량 변경*/
				if($_POST['hid_bundle'][$v]!=0){
				
					$chg_bundle_cnt=($_POST['hid_bundle'][$v]-1 >1)?$_POST['hid_bundle'][$v]-1:"0";
					
					$qry="update order_list set bundle=:bundle where ordno=:ordno";
					$res=$db->query( $qry,array(":ordno"=>$_POST['hid_ordno'][$v],":bundle"=>$chg_bundle_cnt) );
				}
			}

			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다","chk_order_info.php");
			
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());	
		}
	}else if($_POST['mode']=='cp_order'){
		
		try{
			
			$qry="SHOW FULL COLUMNS FROM order_list";
			$res=$db->query($qry);
			
			foreach($res->results as $v){
				
				if($v['Field']!='no' && $v['Field']!='copy_seq' && $v['Field']!='deli_price' )$col_name[]=$v['Field'];
			}

			$db->beginTransaction();
			foreach($_POST['chk_no'] as $v){
				
				$qry="insert into order_list (".implode(",",$col_name).",copy_seq) select ".implode(",",$col_name).",:copy_seq from order_list where no=:no";
				$res=$db->query($qry,array(":no"=>$v,":copy_seq"=>$v));

				$ORDER->set_bundle_cnt($_POST['hid_ordno'][$v]);
			}

			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다","chk_order_info.php");
			
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());	
		}		
	}else if($_POST['mode']=='del_cp_order'){
		
		try{
			$db->beginTransaction();
			$param=$db->inqry_param($_POST['chk_no']);
			$qry="select no,copy_seq,ordno from order_list where no in (".implode(",",array_keys($param)).")";
			$res=$db->query($qry,$param);
			
			foreach($res->results as $v){
				//if($v['copy_seq']){
					
					$qry="delete from order_list where no='".$v['no']."'";
					if($db->query($qry)){
						$ORDER->set_bundle_cnt($_POST['hid_ordno'][$v['no']],'','m');
					}
					
				//}
			}
			$db->commit();
			msg("처리되었습니다","chk_order_info.php");
			
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());	
		}
	}else if($_POST['mode']=='memoIns'){
		$QUERY_STRING=order_return_url();

		try{
			$db->beginTransaction();
			
			$ORDER->admin_memo($_POST['chk_no'],$_POST['i_memo']);

			$db->commit();
			msg('처리되었습니다.','chk_order_info.php?'.$QUERY_STRING);

		}catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());
			
		}	
	}else if($_POST['mode']=='hold_order'){
		foreach($_POST['chk_no'] as $v){
			$sqry="select * from order_list where no='".$v."'";	
			$sres=$db->query($sqry);
			foreach($sres->results as $sv){
				$step_return=$ORDER->order_step_chg($sv['ordno'],'8','0',$sv['no']);	
			}
		}
		msg('처리되었습니다.','chk_order_info.php');
	}
}


if($_FILES && $_POST['mode']=="memoupdate"){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			if(!$v[0])$err_msg[]=$k."번열 상품명이 존재하지않습니다.";            
			if(!$v[6])$err_msg[]=$k."번열 주문번호가 존재하지않습니다.";            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				memo_indb($excel_data);

				//$db->rollBack();
                $db->commit();
	            msg('처리되었습니다.','chk_order_info.php?'.$QUERY_STRING);

			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}else if($_FILES){
	$excel_data=excel_read('unlink','5');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			if(!$v['0'])$err_msg[]=$k."번열 주문고유코드가 존재하지않습니다.";            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
					$uqry="update order_list set goodsnm='".$v[4]."', order_num='".$v[5]."', order_price='".$v[6]."' where no='".$v[0]."'";
					$db->query($uqry);
				}


				//$db->rollBack();
                $db->commit();
               
				msg('처리되었습니다.','chk_order_info.php');
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}


if($_POST['mode']=='auto_confirm'){

	$codedata=get_codedata('place','1');
	foreach($codedata as $v){
		$place_code[]=$v['no'];
	}
	$qry="select count(*) cnt from order_list where step='0' and step2='0'";
	$res=$db->query($qry);

	if($res->results['0']['cnt']=='0'){

		try{
			$db->beginTransaction();

			/*주문 우선처리. 모델명 매칭까지 끝내고 처리가능*/
			//주문 자동승인순서
			$qry="select mos.*,ml.mall_name from mall_order_seq mos
			left join mall_list ml on mos.mall_no = ml.no
			order by sort
			";
			$res=$db->query($qry);
			foreach($res->results as $v){

				$order_autocomp[]=$v;
			}
			
			$cnt_autocomp=count($order_autocomp);
			for($i=0;$i<=$cnt_autocomp;$i++){//묶음 상품과 일반상품 자동완료처리.
			unset($order_bundel);
				if($i==0){
					//tydebug('묶음주문처리');
					//1.묶음상품 우선처리
					$qry="select no,ordno,goodsnm,goodsno,order_num,bundle,mall_no,mall_name from order_list 
					where 1
					and bundle>1 
					and step in ('1','2')
					order by bundle desc
					";
				}else if($i>0){

					
					//2.설정 몰 순서대로 단품처리
					
					unset($param);
					$mall_data=$order_autocomp[$i-1];

					//tydebug($mall_data['upload_form_type']." ".$mall_data['mall_name'].' 단품처리');

					if($mall_data['mall_no']){
						$add_where=" and mall_no=:mall_no";
						$param[':mall_no']=$mall_data['mall_no'];
					}else{
						$add_where="";
					}



					$qry="select no,ordno,goodsnm,goodsno,order_num,bundle,mall_no,mall_name from order_list 
					where 1
					and bundle='0' 
					and step in ('1','2')
					and upload_form_type=:upload_form_type
					".$add_where."
					order by bundle desc
					";
					
					
					$param[':upload_form_type']=$mall_data['upload_form_type'];
					
				}

				$res=$db->query($qry,$param);
				
				//묶음 수량이 많은 것부터 우선처리
				foreach($res->results as $v){
					$order_bundel[$v['bundle']][$v['mall_no']."__".$v['ordno']][]=$v;
				}
				foreach($order_bundel as $key=>$val){
					foreach($val as $k=>$v){
						$goods_order_cnt=$tmp_goods=$goods_ord=array();

						foreach($v as $k2=>$v2){
							
							$goods_ord[$v2['no']]=$v2['goodsnm'];
							$goods_ord_seq[$v2['goodsnm']]=$v2['no'];
							$goods_order_cnt[$v2['goodsnm']]+=$v2['order_num'];
							
						}
						
						$tmp_goods=array_unique($goods_ord);
						$stock_deli_av=$GOODS->get_stock_deli_av($tmp_goods);//배송가능재고
						
						foreach($stock_deli_av->results as $dv){
							
							if($dv['totstock']>=$goods_order_cnt[$dv['goodsnm']]){
								$stock_chk=1;
								
							}else{
								$stock_chk=0;
								break;
							}
						}
						//tydebug("chk".$stock_chk);

						if($stock_chk){//옵션 모두 재고가 있으면 
							//foreach($goods_ord as $dk=>$dv){
							foreach($v as $dk=>$dv){

								$use_codeno=$deli_codeno=array();
								$now_stock=now_stock($dv['goodsno'],$place_code);
								
								foreach($now_stock as $nk=>$nv){ //한곳에서 출고 가능한지.
									
									if($dv['order_num']<=$nv){
										$deli_codeno[$nk]=$nv;
										break;
									}
								}
								
								if($deli_codeno)$use_codeno=$deli_codeno;
								else break;//$use_codeno=$now_stock; 위치별로 재고가 부분부분있는주문은 패스

								$loop=0;
								foreach($use_codeno as $uk=>$uv){
									
									if($dv['order_num']<=0)break; //수량이 끝이면 중지.

									$stock_loc=str_replace("codeno_","",$uk);
									if($dv['order_num']>$uv){
										$order_num=$uv;	
										$dv['order_num']-=$uv;
									}else{
										$order_num=$dv['order_num'];
										$dv['order_num']=0;
									}

									
									//tydebug("num".$order_num);

									//한곳에서 배송 불가하다면 주문 복사
									
									if($loop>0){ //현재 복사기능 막혀있음. 359번 라인과 연계

										//tydebug("loop".$loop);
										$qry="SHOW FULL COLUMNS FROM order_list";
										$res=$db->query($qry);
										
										foreach($res->results as $v){
											
											if($v['Field']!='no' && $v['Field']!='copy_seq' && $v['Field']!='order_num')$col_name[]=$v['Field'];
										}
										
										
										$qry="insert into order_list (".implode(",",$col_name).",order_num,copy_seq) select ".implode(",",$col_name).",:order_num,:copy_seq from order_list where no=:no";

										$res=$db->query($qry,array(":no"=>$dv['no'],":order_num"=>$order_num,":copy_seq"=>$dv['no']));	
										
										$dv['no']=$res->lastId;
										$ORDER->set_bundle_cnt($dv['ordno'],$dv['mall_no']);

									}

									//입고순으로 재고차감처리후 원가 리턴
									$order_cost= $GOODS->calc_stock($dv['goodsno'],$order_num);	

									$qry="update order_list set 
									step='4'
									,deli_codeno=:deli_codeno
									,order_cost='".$order_cost."'
									,order_num=:order_num
									,mod_date=now()
									where no=:no
									";

									$param=array(":no"=>$dv['no'],":order_num"=>$order_num,":deli_codeno"=>$stock_loc);
									$db->query($qry,$param);		

									$okd=stock_io('order',$dv['goodsno'],$dv['goodsnm'],-$order_num,$dv['ordno'],$_SERVER['REQUEST_URI'],$stock_loc);
									$loop++;
									
								}
							}
							//tydebug($stock_deli_av);
							//tydebug($goods_order_cnt);
							//tydebug($stock_chk);
							//tydebug($dv['mall_name'].' '.$dv['ordno']." ok");
						}
					}
				}
				
			}
			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다","chk_order_info.php");
			
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());	
		}


		}else{
			msg('모델명 매칭이 모두 끝난 후 처리 가능합니다.');
		}



}

/*리스트*/
$data_search = $ORDER->order_search_where();

if($_GET['gubunb']==0){
	$add_where.=" and ol.step2=0";
}else{
	$add_where.=" and ol.step2!=0";
}


$qry="select * from order_list ol where step='0'
".$add_where."
".$data_search['where']."
order by ordno,no
";


$res = $db->query($qry,$data_search['param']);

foreach($res->results as $v){
	$v = infoMasking($v, 'order_list'); //마스킹
	if($v['bundle']>0)$v['bundle_color']="red";
	$orderType=orderType($v['no']);
	$v['order_type']=$orderType;

	//if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
	$loop[]=$v;
}


$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
