<?php

class ORDER{

	private $before_stock_step;

	function __construct(){
		global $cfg, $db ,$order_before_stock_step,$cfg_sum_gcl,$_SESSION;

		$this->before_stock_step=$order_before_stock_step;

		$this->gcl_sum=$cfg_sum_gcl;

		$this->cfg = $cfg;
		$this->db = $db;
		$this->goods = new goods();
		$this->sess = $_SESSION['sess'];

	}

	function getOrderList($wehre,$join_table,$colum){ /*사용하는곳 없음*/
		
		if(is_array($colum))$add_colum =",".implode(",",$wehre);
		if(is_array($wehre))$add_wehre =" and ".implode(" and ",$wehre);

		$qry="select ol.*,b.brandnm,g.no as goodsno 
		".$add_colum."
		from order_list ol
		join goods g on g.no=o.goodsnm
		left join brand b on b.no = g.brandno
		left join category c on c.no = g.cateno
		".$join_table."
		where 1
		".$add_wehre."
		";

		$res=$this->db->query($qry);
		return $res; 
		
	}

	protected function calc_stock_order($order_cost,$ord_seq=0){ //주문에 의한 재고 리턴시 입고내역 복구(선입선출 계산을 위해서)
		
		$ex_cost=explode("^",$order_cost);	
		
		if( $order_cost!='outside' && ($order_cost=='입고내역없음' || $order_cost=='' || !$ex_cost[0]) ) {
			
			$qry="select g.no goodsno,o.goodsnm,g.brandno,o.order_num from order_list o
			left join goods g on g.goodsnm=o.goodsnm
			where o.no=:ord_seq
			";
			$res=$this->db->query($qry,array(":ord_seq"=>$ord_seq));	

			$data=$res->results['0'];

			$cost=$this->goods->avg_price($data['goodsno']);
			
			$qry="insert into stock_list set
			brandno=:brandno
			,goodsno=:goodsno
			,goodsnm=:goodsnm
			,stock_num=:stock_num
			,now_cnt=:now_cnt
			,cost=:cost
			,state=1
			,memo='반품에의한 자동입고'
			,return_order=1
			,reg_date=now()
			,admin_no=:admin_no
			,admin_name=:admin_name
			";
			
			$param[":brandno"]=$data['brandno'];
			$param[":goodsno"]=$data['goodsno'];
			$param[":goodsnm"]=$data['goodsnm'];
			$param[":stock_num"]=$data['order_num'];
			$param[":now_cnt"]=$data['order_num'];
			$param[":cost"]=$cost;
			$param[":admin_no"]=$this->sess['m_no'];
			$param[":admin_name"]=$this->sess['name'];
			
			$this->db->query($qry,$param,'stock_back');
			

		}else{
			$ex_order_cost=explode("|",$order_cost);

			foreach($ex_order_cost as $v){
				$data=explode("^",$v);
				
				$qry="update stock_list set 
				now_cnt=now_cnt+'".$data['2']."'
				where no = '".$data['0']."'
				";

				$this->db->query($qry);

			}
		}
	}
	
	function calc_stock_order_send($order_cost,$ordno=0){

		$this->calc_stock_order($order_cost,$ordno);	
	}

	function sortOrderSoldout(){ //품절주문을 주문네비에 정렬 

		/*묶음상품 부분품절 타입변경*/
		$qry="update order_list set step='2',step2='1' where ordno in ( 
		select * from (  select ol.ordno from order_list ol where ol.step='2' and ol.step2<40 and ol.bundle>0 and reg_date=curdate() ) tmp 
		) and step=1 and step_fixed='0'
		";
		$this->db->query($qry);
		
		/*완전 품절인 주문(입예가 없는) 구분*/
		/*카카오는 입예가 있어도 재고가 부족하면 품절로*/
		$qry="update order_list set
		step2=0
		where ordno in (select *  from (
		select o.ordno from order_list o 
		join goods_cnt_loc gcl on gcl.goodsno = o.goodsno
		where 1
		and (codeno_3=0 || o.mall_name='카카오')
		and (".$this->gcl_sum.")<o.order_num
		and o.step=2 
		and o.reg_date=curdate()
		group by o.ordno
		) tmp ) and step=2 and step2<40 and step_fixed='0' 
		";
		$this->db->query($qry);

		
		
		/*모델명이 없는 주문 묶음 몰아보기*/
		$qry="update order_list set 
		goodsnm=if(step='0',concat(goodsnm,' 모델명 매칭실패'),goodsnm) 
		,step='0'
		,step2='1'
		where ordno in ( 
		select * from ( select ol.ordno from order_list ol where ol.step='0' and ol.step2=0 and ol.reg_date=curdate() and ol.bundle>0 ) tmp )
		and step in('0','1','2') and step_fixed='0' 
		";
		$this->db->query($qry);
		
		/*등록 완료 후 품절주문고정*/
		$qry="update order_list set step_fixed='1' where step='2' and reg_date=curdate() and step_fixed='0'";
		$this->db->query($qry);

	}

	//우선은 4->1로   1에서 -> 2로 이동하는 경우에만 사용중. 다른 단계에 사용할 필요가 있다면 수정필요.
	function ctl_step($order_sn=array(),$bf_step='',$next_step='',$io_type='order_step_back'){
	
		
		//4번 배송확정에서 이동할때만 재고체크를 해야해서 필수로
		if($bf_step==4) $left='';
		else $left='left';

		//묶음상품과 단품 주문번호 구분
		$param = $this->db->inqry_param($order_sn);
		$qry="select o.no,o.mall_name,o.bundle,o.ordno,o.order_num,o.deli_codeno,o.order_cost,g.goodsnm,g.no goodsno from order_list o 
		".$left." join goods g on o.goodsnm=g.goodsnm
		where o.no in (".implode(",",array_keys($param)).") 
		and step=:step
		";


		$param[':step']=$bf_step;
		$res=$this->db->query($qry,$param);
		foreach($res->results as $v){
			
			if($v['bundle']==0){
				$chk_no['single'][]=$v;
				$chk_no['single_sn'][]=$v['no']; 
			}else{
				$chk_no['bundle'][$v['ordno']]=$v; 
				$chk_no['bundle_sn'][]=$v['no']; 
			}
		}

		if($bf_step=='4'){

			if(!$next_step)$next_step=1;

			$qr=",step='".$next_step."'
			,order_cost=''
			,deli_codeno=''
			,wms_ordno=''
			,cha_su=''
			";
		}else if($bf_step=='1'){

			$qr=",step='2'";
		}else if($bf_step=='8'){
			
			if(!$next_step)$next_step=1;

			$qr=",step='".$next_step."'
			,step2='0'
			";
		}else if($bf_step=='6'){
			
			$qr=",step='0'";
		}
		
		if($chk_no['single']){
			
			foreach($chk_no['single'] as $v){
				if($bf_step=='4'){ //발송확정 단계에서 넘어왔을땐 재고 복원
					$this->calc_stock_order($v['order_cost'],$v['no']);
					$okd=stock_io($io_type,$v['goodsno'],$v['goodsnm'],$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$v['deli_codeno']);
				}

				$qry="update order_list set
				mod_date=now()
				".$qr."
				where no='".$v['no']."'
				";

				$this->db->query($qry);
			}
		}

		if($chk_no['bundle']){
			unset($param);

			foreach($chk_no['bundle'] as $val){
				$qry="select o.no,o.mall_name,o.bundle,o.ordno,o.order_num,o.deli_codeno,o.order_cost,g.goodsnm,g.no goodsno from order_list o 
				join goods g on o.goodsnm=g.goodsnm
				where o.ordno='".$val['ordno']."'
				and step=:step
				";
				$param[':step']=$bf_step;
				$res=$this->db->query($qry,$param);
				

				foreach($res->results as $v){
					if($bf_step=='4'){						
						$this->calc_stock_order($v['order_cost'],$v['no']);
						$okd=stock_io($io_type,$v['goodsno'],$v['goodsnm'],$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$v['deli_codeno']);
					}
					
					if($bf_step=='1' && !in_array($v['no'],$chk_no['bundle_sn']))continue; //??
					$qry="update order_list set
					mod_date=now()
					".$qr."
					where no='".$v['no']."'
					";

					$this->db->query($qry);
				
				}

			}
		}

		
	}
	
	//지정번호 품절처리 (묶음이어도 같이 처리되지 않고 선택번호만)
	function order_cancel_seq($order_sn=array(),$now_step='',$step2_val='46'){
		
		$param = $this->db->inqry_param($order_sn);

		$qry="update order_list set
		step2='".$step2_val."'
		,mod_date=curdate()
		where no in (".implode(",",array_keys($param)).")
		";
		$res=$this->db->query($qry,$param);

		$qry="select no,wno,mall_name,mall_no,bundle,ordno,order_num,goodsno,settle_price from order_list where no in (".implode(",",array_keys($param)).")";
		$res=$this->db->query($qry,$param);
				
		foreach($res->results as $v){
			if($v['wno']){
				wholesale_payment_ins('soldout',$v['no'],$v['order_num'],$v['settle_price']);
			}
		}

		/*
		$qry="select no,mall_name,mall_no,bundle,ordno,order_num,goodsno from order_list where no in (".implode(",",array_keys($param)).")";
		$res=$this->db->query($qry,$param);
				
		foreach($res->results as $v){
			if($v['bundle']>0){
				//$this->set_bundle_cnt($v['ordno'],$v['mall_no'],'m');
			}
		}
		*/
		if($now_step=='4'){

			$qry="select o.no,o.order_num,o.deli_codeno,o.order_cost,g.goodsnm,g.no goodsno from order_list o 
			join goods g on o.goodsnm=g.goodsnm
			where o.no in (".implode(",",array_keys($param)).") 
			and step='4'
			";
			$res=$this->db->query($qry,$param);
			foreach($res->results as $v){
				$this->calc_stock_order($v['order_cost'],$v['no']);
				$okd=stock_io('order_cancel',$v['goodsno'],$v['goodsnm'],$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$v['deli_codeno']);
			}
		}
	}

	//주문스탭 변경
	function order_step_chg($ordno,$after_step,$after_step2=0,$ordlistno='',$place_code='all'){
					
		if(!is_array($ordlistno))$ordlistno=array($ordlistno);

		if( !($ordno || $ordlistno)  || !$after_step) return '필수데이터 없음';
		
		$qry="select no,mall_name,mall_no,bundle,ordno,order_num,goodsno,goodsnm,deli_codeno,order_cost,step,step2 from order_list where 1 ";

		if($ordno){
			$qry.=" and ordno = '".$ordno."'";
		}
		if($ordlistno){
			$qry.=" and no in ('".implode("','",$ordlistno)."')";
		}

		$res=$this->db->query($qry);
		foreach($res->results as $v){
			$before_step=$v['step'];
			$before_step2=$v['step2'];
			
			if($before_step>0 && $after_step=='2')$step_fixed=" ,step_fixed='1'";
			//발송확정목록에서 이전스탭으로 변경시(재고복원필요) 단,step2가 40이하이면 재고복원을 하지않는다. (이미 복원이 된상태기에)
			if($before_step=="4" && $before_step2<"40" && (($after_step<$before_step) || $after_step=="8" || $after_step2=="45")){				
				
				if($after_step2>=40)$io_type='order_cancel';
				else if($after_step==8)$io_type='order_d_hold';
				else $io_type='order_step_back';

				$this->calc_stock_order($v['order_cost'],$v['no']);
				$okd=stock_io($io_type,$v['goodsno'],$v['goodsnm'],$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$v['deli_codeno']);		
				
				//step변경
				$uqry="update order_list set step='".$after_step."', step2='".$after_step2."', mod_date=now(), order_cost='', cha_su='', wms_ordno='' where no = '".$v['no']."' ";
				$this->db->query($uqry);

			//발송대기에서 이전스탭으로 변경시(order_hold 재고복원필요) 단,step2가 40이하이면 재고복원을 하지않는다. (이미 복원이 된상태기에)
			}else if($before_step=="3" && $before_step2<"40" && (($after_step<$before_step) || $after_step=="8")){
				//발송대기재고 돌리기
				$sqry="select * from 
				stock_io_log sil where sil.reference_no in (select concat(no) from order_hold_list ohl where ohl.order_list_no='".$v['no']."' and ohl.close_yn='n' group by ohl.order_list_no ) 
				and sil.io_type='order_hold'
				";
				$sres=$this->db->query($sqry);
				foreach($sres->results as $sv){
					stock_io('order_hold_cancel',$sv["goodsno"],$sv["goodsnm"],$sv["cnt"],$sv['reference_no'],$_SERVER['REQUEST_URI'],$sv['loc_b'],$sv['loc_f']);
					$uqry="update order_hold_list set close_yn='y' where no='".$sv['reference_no']."' and ordno='".$v['ordno']."'";
					$this->db->query($uqry);
					//예약재고 업데이트
					$uqry="update reserve_list set state='1', rel_date=now(), rel_admin_no='".$_SESSION['sess']['m_no']."' where reference_no='".$v['no']."' and order_hold_no='".$sv['reference_no']."'";
					$this->db->query($uqry);
					
					if($sv["cnt"]>0){
						//구어드민 재고 복원등록
						guadmin_stock_ctl($v['goodsno'],$v['order_num'],$sv['loc_b'],'in',$v['no'],'교환예약 해제');
					}
				}				

				//step변경
				$uqry="update order_list set step='".$after_step."', step2='".$after_step2."' ".$step_fixed." , mod_date=now() where no = '".$v['no']."' ";
				$this->db->query($uqry);
			//재고부족및 입고예정대기중에서 발송대기로 넘겼을때 
			}else if(($before_step=="2" || $before_step=="8") && $before_step2<"40" && $after_step=="3"){

				$GOODS=new goods();

				$codedata=get_codedata('place','1',array('1','51'));

				$code_array=array();
				foreach($codedata as $cv){
					$code_array[]="codeno_".$cv["no"].">=o.order_num";
					$codesum_array[]="codeno_".$cv["no"];
				}
			
				//해당 묶음 주문의 발송 가능한 주문이 있으면 보류로 넘기고 가능재고 대기상태로 재고 처리. 
				$cqry="select o.no,o.mall_name,o.ordno,o.order_num,g.goodsnm,g.no goodsno from order_list o
				join goods g on o.goodsnm=g.goodsnm
				join goods_cnt_loc gcl on gcl.goodsno=g.no
				where o.no='".$v['no']."' 
				and (".implode(" or ",$code_array).")
				";


				//해당 묶음 주문의 발송 가능한 주문이 있으면 보류로 넘기고 가능재고 대기상태로 재고 처리. 
				/*
				$cqry="select o.no,o.mall_name,o.ordno,o.order_num,g.goodsnm,g.no goodsno from order_list o
				join goods g on o.goodsnm=g.goodsnm
				join goods_cnt_loc gcl on gcl.goodsno=g.no
				where o.no='".$v['no']."' 
				and (gcl.codeno_1+gcl.codeno_51)>=o.order_num
				";
				*/

				$cres=$this->db->query($cqry);
				if($cres->results){
					foreach($cres->results as $val){

						
						//주문 보류재고처리를 확실히 하기위해서 보류 재고를 남긴 정보를 테이블에 따로 정리.( 중복 방지를 위해)
						$hold_qry="insert into order_hold_list set order_list_no=:order_list_no ,ordno=:ordno,reg_date=now()";
						$hold_res=$this->db->query($hold_qry,array("order_list_no"=>$val['no'],"ordno"=>$val['ordno']));
				
						$hold_last_id=$hold_res->lastId;
						//주문발송이 가능한 재고위치 가져오기. step 1은 아직 재고를 뺀것이 아니기 때문에 가능재고 위치에 있는 재고를 보류로 옮겨둔다.
						$deli_codeno='';
						$tmp = now_stock($val['goodsno']);
						foreach($codedata as $cv){							
							if($tmp['codeno_'.$cv['no']] && $tmp['codeno_'.$cv['no']] >=$val['order_num']  ){
								$deli_codeno=$cv['no']; 
								break;
							}
						}
						
						if($deli_codeno){ //발송대기($this->cfg['hold_loc']) 로 재고를 이동
							$okd=stock_io('order_hold',$val['goodsno'],$val['goodsnm'],-$val['order_num'],$hold_last_id,$_SERVER['REQUEST_URI'],$deli_codeno,$this->cfg['hold_loc']);
							$okd=stock_io('order_hold',$val['goodsno'],$val['goodsnm'],$val['order_num'],$hold_last_id,$_SERVER['REQUEST_URI'],$this->cfg['hold_loc'],$deli_codeno);
						}else{
							throw new Exception('주문재고부족 : '.$val['no']." ".$val['goodsno'].":".$val['goodsnm'], 1); 
							//$chk_stock[$val['goodsnm']]+=$val['order_num']; //재고부족
						}

						//예약재고 등록
						reserve_indb($val['no'],$hold_last_id,$val['order_num'],"발송대기 자동등록",$deli_codeno);
						//구어드민 재고 차감등록
						guadmin_stock_ctl($val['goodsno'],$val['order_num'],$deli_codeno,'out',$v['no'],'교환예약');

						//step변경
						$uqry="update order_list set step='".$after_step."', step2='1', mod_date=now() where no = '".$val['no']."' ";
						$this->db->query($uqry);
					}				
				}else{
					
					$cqry="select o.no,o.mall_name,o.ordno,o.order_num,g.goodsnm,g.no goodsno, (".implode(" + ",$codesum_array).") as sumcnt from order_list o
					join goods g on o.goodsnm=g.goodsnm
					join goods_cnt_loc gcl on gcl.goodsno=g.no
					where o.no='".$v['no']."' 					
					";

					$cres=$this->db->query($cqry);
					$codesum_data=$cres->results[0];

					//각 출고별 재고수량이 모자라고 출고합산 재고가 0개일경우 스텝만 변경해준다.
					if($codesum_data['sumcnt']<=0){
						//step변경
						$uqry="update order_list set step='".$after_step."', step2='".$after_step2."', mod_date=now() where no = '".$v['no']."' ";

						$this->db->query($uqry);
					}
				}
				//return $chk_stock;

				
			//발송확정으로 이동할경우 취소건이 아닌주문건은 
			}else if($after_step=="4" && $before_step2<"40" && ($before_step<$after_step)){

				if($before_step=="3"){
					//발송대기재고 돌리기
					$sqry="select * from 
					stock_io_log sil where sil.reference_no in (select concat(no) from order_hold_list ohl where ohl.order_list_no='".$v['no']."' and ohl.close_yn='n' group by ohl.order_list_no ) 
					and sil.io_type='order_hold'
					";
					$sres=$this->db->query($sqry);
					foreach($sres->results as $sv){
						stock_io('order_hold_cancel',$sv["goodsno"],$sv["goodsnm"],$sv["cnt"],$sv['reference_no'],$_SERVER['REQUEST_URI'],$sv['loc_b'],$sv['loc_f']);
						$uqry="update order_hold_list set close_yn='y' where no='".$sv['reference_no']."' and ordno='".$v['ordno']."'";
						$this->db->query($uqry);

						//예약재고 업데이트
						$uqry="update reserve_list set state='1', rel_date=now(), rel_admin_no='".$_SESSION['sess']['m_no']."' where reference_no='".$v['no']."' and  order_hold_no='".$sv['reference_no']."'";
						$this->db->query($uqry);
						
						if($sv["cnt"]>0){
							//구어드민 재고 복원등록
							//guadmin_stock_ctl($v['goodsno'],$v['order_num'],$sv['loc_b'],'in',$v['no'],'교환예약 해제');
						}
					}

				}

				$GOODS=new goods();

				$codedata=get_codedata('place','1');
				/* 재고차감위치 */
				if($place_code=='all'){
					foreach($codedata as $codev){
						$place_code_array[]=$codev['no'];
					}
				}else{
					$place_code_array[]=$place_code;
				}

				$stock_place="";
				foreach($place_code_array as $pcv){
					$stock_deli_av=$GOODS->get_stock_deli_av(array($v['goodsnm']),$pcv);

					if($stock_deli_av->results['0']['totstock']>=$v['order_num']){ 						
						$stock_place=$pcv;
					}
				}

				if($stock_place){
					//입고순으로 재고차감처리후 원가 리턴
					$order_cost= $GOODS->calc_stock($v['goodsno'],$v['order_num']);	

					$okd=stock_io('order',$v['goodsno'],$v['goodsnm'],-$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$stock_place);
			
					$qry="update order_list set 
					step='".$after_step."'
					,step2='".$after_step2."'
					,mod_date=now()
					,deli_codeno='".$stock_place."'
					,order_cost='".$order_cost."'
					where no='".$v['no']."'
					";
					$this->db->query($qry);
				}else{
					$chk_stock[$v['goodsnm']]+=$v['order_num']; //재고부족
				}

				//재고확인해서 품절일경우 로그에넣는다.
				$goods_stock=$GOODS->get_stock_deli_av(array($v['goodsnm']));
				$totstock=$goods_stock->results['0']['totstock'];
													
				//재고이동중도 남은재고에 포함
				$qry="select g.goodsnm, gcl.codeno_130 from goods g 
				join goods_cnt_loc gcl on g.no=gcl.goodsno
				where g.goodsnm = '".$v['goodsnm']."'
				group by g.goodsnm
				";
				$res=$this->db->query($qry);
				$stock_130=$res->results[0]['codeno_130'];

				if($stock_130) $totstock=$totstock+$stock_130;

				if($totstock<=0){
					$this->stock_soldout_log($v['goodsno'],'1');
				}

/*

				foreach($place_code_array as $pcv){

					$stock_deli_av=$GOODS->get_stock_deli_av(array($v['goodsnm']),$pcv);

					if($stock_deli_av->results['0']['totstock']<$v['order_num']){ 
						$chk_stock[$v['goodsnm']]+=$v['order_num']; //재고부족

					}else{
						//입고순으로 재고차감처리후 원가 리턴
						$order_cost= $GOODS->calc_stock($v['goodsno'],$v['order_num']);	

						$okd=stock_io('order',$v['goodsno'],$v['goodsnm'],-$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$pcv);
				
						$qry="update order_list set 
						step='".$after_step."'
						,step2='".$after_step2."'
						,mod_date=now()
						,deli_codeno='".$pcv."'
						,order_cost='".$order_cost."'
						where no='".$v['no']."'
						";
						$this->db->query($qry);
						break;
					}		
				}
*/
				//return $chk_stock;
			}else{
				//step변경
				$uqry="update order_list set step='".$after_step."', step2='".$after_step2."' ".$step_fixed." , mod_date=now() where no = '".$v['no']."' ";
				$this->db->query($uqry);
			}
		}
		if($chk_stock) return $chk_stock;
	}

	//주문단계에서 품절처리.(묶음 일괄)
	function order_cancel($order_sn=array(),$bf_step='',$step2_val='41'){
		
		if($bf_step=='8')$bf_step='2';

		if($bf_step=='2' || $bf_step=='4'){ //2 or 4 . 그외 단계에서 처리하려면 쿼리 확인이 필요하다. 
			
			$codedata=get_codedata('place','1'); 

			$param = $this->db->inqry_param($order_sn);

			$qry="select no,mall_name,bundle,ordno,order_num,goodsno from order_list where no in (".implode(",",array_keys($param)).")";

			$res=$this->db->query($qry,$param);

			foreach($res->results as $v){
				
				if($v['bundle']==0){
					$chk_no['single'][]=$v;
					$chk_no['single_sn'][]=$v['no']; //실제 처리된 우리 재고만 컨트롤 하기 위해서. (체크되지 않은 단품 주문에 묶여있는 외주발송 주문이 있을수있음)
				}else{
					$chk_no['bundle'][$v['ordno']]=$v; //같은 주문번호의 두개의 주문이 넘어와도, 주문번호로 일괄처리할것이기때문에 배열에는 담기지 않지만 문제없음.
					$chk_no['bundle_soldout'][$v['ordno']]=$v;	
				}
			}

			
			

			unset($param);
			if($chk_no['single']){
				
				/*단품제품이지만 외부발송으로 처리되는 동일 주문번호의 상품이 있기 때문에 주문번호로 함께처리. */
				foreach($chk_no['single'] as $v){


					$qry="update order_list set
					step2='".$step2_val."'
					,mod_date=now()
					where ordno='".$v['ordno']."'
					and mall_name='".$v['mall_name']."'
					";
					
					$this->db->query($qry);
				}

				if($bf_step=='4'){ //발송확정 단계에서 넘어왔을땐 재고 복원

					$param = $this->db->inqry_param($chk_no['single_sn']);	
					$qry="select o.no,o.order_num,o.deli_codeno,o.order_cost,g.goodsnm,g.no goodsno from order_list o 
					join goods g on o.goodsnm=g.goodsnm
					where o.no in (".implode(",",array_keys($param)).") 
					and step='4'
					";
					$res=$this->db->query($qry,$param);
					foreach($res->results as $v){
						$this->calc_stock_order($v['order_cost'],$v['no']);
						$okd=stock_io('order_cancel',$v['goodsno'],$v['goodsnm'],$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$v['deli_codeno']);
					}
				}
			}
				

			
			unset($param); 

			if($chk_no['bundle']){
				$GOODS = new goods();
				if($bf_step=='2' && $step2_val=='41'){ 

					//품절취소건은 고객에게 안내 후 부분적으로 발송이 될수있기때문에.
					/*품절요청한 묶음 주문의 동일 주문번호 주문 중 , 재고가 있는 모델은 재고를 뺀 후에 보류리스트로 이동, step2에 1로 표기*/ 

	
					foreach($chk_no['bundle'] as $v){
						//해당 묶음 주문의 발송 가능한 주문이 있으면 보류로 넘기고 가능재고 대기상태로 재고 처리. 
						$cqry="select o.no,o.mall_name,o.ordno,o.order_num,g.goodsnm,g.no goodsno from order_list o
						join goods g on o.goodsnm=g.goodsnm
						join goods_cnt_loc gcl on gcl.goodsno=g.no
						where o.mall_name='".$v['mall_name']."' and o.ordno='".$v['ordno']."' 
						and (gcl.codeno_1+gcl.codeno_51)>=o.order_num
						";

						$cres=$this->db->query($cqry);
						
						foreach($cres->results as $val){
							
							$qry="update order_list set step2='1' where no ='".$val['no']."' ";
							$this->db->query($qry);
							
							//주문 보류재고처리를 확실히 하기위해서 보류 재고를 남긴 정보를 테이블에 따로 정리.( 중복 방지를 위해)
							$hold_qry="insert into order_hold_list set order_list_no=:order_list_no ,ordno=:ordno,reg_date=now()";
							$hold_res=$this->db->query($hold_qry,array("order_list_no"=>$val['no'],"ordno"=>$val['ordno']));

							
							$hold_last_id=$hold_res->lastId;
							//주문발송이 가능한 재고위치 가져오기. step 1은 아직 재고를 뺀것이 아니기 때문에 가능재고 위치에 있는 재고를 보류로 옮겨둔다.
							$deli_codeno='';
							$tmp = now_stock($val['goodsno']);
							foreach($codedata as $cv){							
								if($tmp['codeno_'.$cv['no']] && $tmp['codeno_'.$cv['no']] >=$val['order_num']  ){
									$deli_codeno=$cv['no']; 
									break;
								}
							}
							//tydebug($deli_codeno);
							if($deli_codeno){ //발송대기($this->cfg['hold_loc']) 로 재고를 이동
								$okd=stock_io('order_hold',$val['goodsno'],$val['goodsnm'],-$val['order_num'],$hold_last_id,$_SERVER['REQUEST_URI'],$deli_codeno,$this->cfg['hold_loc']);
								$okd=stock_io('order_hold',$val['goodsno'],$val['goodsnm'],$val['order_num'],$hold_last_id,$_SERVER['REQUEST_URI'],$this->cfg['hold_loc'],$deli_codeno);
							}else{
								throw new Exception('주문재고부족 : '.$val['no']." ".$val['goodsno'].":".$val['goodsnm'], 1); 
								//재고가 있는 발송위치 ( $deli_codeno ) 가 없을 수 없기때문에 이부분은 필요없을듯( step=1 인것을 쿼리한것이기때문에 이미 재고유무 체크가 된것)
							}

							unset($chk_no['bundle_soldout'][$val['ordno']]); //품절을 시도한 전체 배열에서 대기 상태로 변경할 주문을 제거하고, 완전품절처리할 주문만 남긴다
							$chk_no['bundle_hold'][$val['ordno']]=$val; //재고부족에서 품절처리시에만. 
						}					
					}

					if($chk_no['bundle_hold']){ //선별한 제품을 주문대기상대로.

						foreach($chk_no['bundle_hold'] as $v){

							$qry="update order_list set
							step='3'
							,mod_date=now()
							where ordno ='".$v['ordno']."'
							and mall_name='".$v['mall_name']."'
							and step!=4
							";
							$this->db->query($qry,$param);
						}
					}
				}
			
				if($chk_no['bundle_soldout']){ 

					foreach($chk_no['bundle_soldout'] as $v){
						$qry="update order_list set
						step2='".$step2_val."'
						,mod_date=now()
						where ordno ='".$v['ordno']."'
						and mall_name='".$v['mall_name']."'
						";
						$this->db->query($qry);
						
						$bundle_soldout_ordno[]=$v['ordno'];
					}

					if($bf_step=='4'){ 
						$param = $this->db->inqry_param($bundle_soldout_ordno);
						$qry="select o.no,o.order_num,o.deli_codeno,o.order_cost,g.goodsnm,g.no goodsno from order_list o 
						join goods g on o.goodsnm=g.goodsnm
						where o.ordno in (".implode(",",array_keys($param)).") 
						and step='4'
						";

						$res=$this->db->query($qry,$param);
						foreach($res->results as $v){

							$this->calc_stock_order($v['order_cost'],$v['no']);
							$okd=stock_io('order_cancel',$v['goodsno'],$v['goodsnm'],$v['order_num'],$v['no'],$_SERVER['REQUEST_URI'],$v['deli_codeno']);
						}
					}
				}
				

			}
		}
	}


	function set_bundle_cnt($ordno,$mall,$type='p'){ //$type p or m  (plus minus)
		
		if($type=='p'){
			$default_val=0;
			$calu="+";
		}else if($type=='m'){
			$default_val=2;
			$calu="-";
		}
		
		if($mall){
			$add_where=" and mall_no=:mall_no";
			$param[':mall_no']=$mall;
		}
		$qry="update order_list set bundle=if(bundle='".$default_val."',bundle".$calu."2,bundle".$calu."1) where bundle>0 and  ordno=:ordno".$add_where;
		$param[':ordno']=$ordno;
		$this->db->query($qry,$param);
		
	}
	
	function admin_memo($ordseq,$memo){ //$type p or m  (plus minus)

		foreach($ordseq as $v){
			//$qry="update order_list set memo=concat(ifnull(memo,''),'".$this->sess['name']."(".$this->sess['m_no']."):','".$memo." / ') where no=:no";
			if($this->sess['name']=='우요한'){

				$qry="update order_list set memo=concat(ifnull(memo,''),'".$memo." ') where no=:no";
				$res=$this->db->query($qry,array(":no"=>$v));
			}else{
			
				$qry="update order_list set memo=concat(ifnull(memo,''),'".$this->sess['name'].":','".$memo." / ') where no=:no";
				$res=$this->db->query($qry,array(":no"=>$v));
			}
		}
	}

	function order_search_where(){ //주문페이지 공통 검색기능.
		$add_where="";
	
		if($_POST['order_search_invo_chk']){
			$add_where[]="(ol.invoice='' || ol.invoice='0' )";
		}

		if($_POST['order_search_adminmemo_chk']){
			$add_where[]="ol.memo='' ";
		}
		
		if($_POST['order_search_cha_su']){
			$add_where[]="ol.cha_su=:cha_su";
			$param[":cha_su"]=$_POST['order_search_cha_su'];
		}

		if($_POST['order_search_brand']){
			$add_where[]="b.brandnm like '".trim($_POST['order_search_brand'])."%'";

		}
		
		if($_POST['order_search_mall']){
			$mallsql="select upload_form_type from mall_list where upload_form_type!='' group by upload_form_type";
			$mallres=$this->db->query($mallsql);
			foreach($mallres->results as $mallv){
				$upload_form_type_array[]=$mallv['upload_form_type'];
			}	
			if(in_array($_POST['order_search_mall'],$upload_form_type_array)){
				$add_where[]="ol.upload_form_type=:upload_form_type";
				$param[":upload_form_type"]=$_POST['order_search_mall'];
			}else{
				
				$add_where[]="ol.mall_no=:mall_no";
				$param[":mall_no"]=$_POST['order_search_mall'];
			}
		}
		if($_POST['order_search_goodsnm']){
			$add_where[]="ol.goodsnm=:goodsnm";
			$param[":goodsnm"]=$_POST['order_search_goodsnm'];
		}

		if($_GET['ts_ordno']){
			$add_where[]="ol.ordno=:ts_ordno";	
			$param[":ts_ordno"]=$_GET['ts_ordno'];
		}

		if($_POST['order_search_goodsnm_all']){
			$order_search_goodsnm_all=paste_to_arr($_POST['order_search_goodsnm_all']);
			if($order_search_goodsnm_all){

				if(count($order_search_goodsnm_all)==1){
					$add_where[]="ol.goodsnm like '".$order_search_goodsnm_all['0']."%' ";	
				}else{
					$order_search_goodsnm_all_imp=implode("','",$order_search_goodsnm_all);
					$add_where[]="ol.goodsnm in ('".$order_search_goodsnm_all_imp."')";	
				}



			}			
		}

		if($_POST['order_search_ordno']){
			$order_search_ordno=paste_to_arr($_POST['order_search_ordno']);
			if($order_search_ordno){

				if(count($order_search_ordno)==1){
					$add_where[]="ol.ordno like '".$order_search_ordno['0']."%' ";	
					//$order_search_ordno_imp=implode("','",$order_search_ordno);
					//$add_where[]="ol.ordno in ('".$order_search_ordno_imp."')";	
				}else{
					$order_search_ordno_imp=implode("','",$order_search_ordno);
					$add_where[]="ol.ordno in ('".$order_search_ordno_imp."')";	
				}



			}
			/*
			$s_paste=paste_to_arr($_POST['s_paste']);
			if($s_paste){

				$inarr = inarr_param($s_paste);

				tydebug($inarr);
				//$s_paste_imp=implode("','",$s_paste);
				//$where[]="g.goodsnm in ('".$s_paste_imp."')";	
			}				
			*/
			
			// $add_where[]="ol.ordno=:ordno";
			// $param[":ordno"]=$_POST['order_search_ordno'];
			
		}
		if($_POST['order_search_receiver']){
			
			$add_where[]=nameMasking($_POST['order_search_receiver']);
			/*
			$add_where[]="ol.receiver=:receiver";
			$param[":receiver"]=$_POST['order_search_receiver'];
			*/
		}

		if($_POST['order_search_sdate'] && $_POST['order_search_edate']){
			$add_where[]="ol.reg_date between :sdt and :edt";
			$param[":sdt"]=$_POST['order_search_sdate'];	
			$param[":edt"]=$_POST['order_search_edate'];	
		}

		if($_POST['order_search_comp_sdate'] && $_POST['order_search_comp_edate']){
			$add_where[]="left(ol.comp_date,10) between :sdt and :edt";
			$param[":sdt"]=$_POST['order_search_comp_sdate'];	
			$param[":edt"]=$_POST['order_search_comp_edate'];	
		}
		
		if($add_where)$add_where=" and ".implode(" and ",$add_where);
		
		
		if($add_where)$data['where']=$add_where;
		if($param)$data['param']=$param;

		return $data;
	}

	//품절 로그 등록 type=0 : 주문업로드시에 품절, type=1 : 주문발송완료후 품절
	function stock_soldout_log($goodsno, $type='0'){
		$now_ymd=date("Y-m-d", time());
		$qry="select no from stock_soldout_log where goodsno='".$goodsno."' and DATE_FORMAT(reg_date,'%Y-%m-%d')='".$now_ymd."' and type='".$type."'";
		
		$res=$this->db->query($qry);
		if(!$res->results){
			$sqry="select goodsnm from goods where no='".$goodsno."'";
			$sres=$this->db->query($sqry);
			$goodsnm=$sres->results[0]['goodsnm'];

			$iqry="insert into stock_soldout_log set 
			goodsno='".$goodsno."'
			,goodsnm='".$goodsnm."'
			,type='".$type."'
			,reg_date=now()
			";
			$this->db->query($iqry);
		}
	}
}

/*
주문참고사항

업로드시 0 1 2 로 분류되어 등록
0은 모델명 매칭안되는것들 ( 이곳에 외부발주 상품도 포함됨)
-모델명이 매칭되지 않은 이유를 확인하여 개발팀에 전달(후에 정확히 매칠될수있도록 개발수정), 정상 모델명 입력후 처리.
-외부발송 상품을 여기서 나눔. 해당 건들은 step 6으로 구분되고, 모든 주문단계 마무리 후 처리해야함( 취소시 외부건도 발송하지 말아야 하기때문에 관련 주문을 취소할 시 
해당 주문도 함께 자동취소처리되기때문에)


1은 발송가능 재고가 있는것
-단품과 묶음으로 분류됨. 
-묶음은( 같은몰 같은 주문번호. ) 하나라도 발송 못하면 발송확정목록으로 넘길 수 없음. 재고부족단계(2) 에서 묶음건이 있으면 이 사항을 참고하여 처리해야함.
-발송확정으로 넘길 시 출고위치에 재고량이 부족하면 넘어가지 않음. 성공시 재고 차감
-2개 발송인데 출고위치당 1개씩 주문이 있을 시 하단에서 주문을 복사하여 수량을 각각 보낼수있음
-묶음 배송 주문의 경우 주문마다 위치가 다를시 통합배송을 선택하면  순차적으로 재고가 있는 위치에서 발송처리됨.
-묶음주문 취소 처리시 묶음주문 중 재고가 있는 모델이 있으면 발송대기 (3) 으로 이동되어 cs에서 처리



2는 발송가능 재고가 부족한것 ( A모델 주문3건  재고 2건이면 A에관련된 3개 주문 모두가 2로 등록됨. 우선발송순위를 작업자가 선택하기 위함)
-필요건만 선택하여 최종확인 단계로 이동시킬수있음( 묶음 우선으로 보내는게 좋음)
-최종확인 단계로 이동 시 총재고를 확인하여 재고가 부족하면 넘어가지 않음. 
-묶음주문 취소 처리시 묶음주문 중 재고가 있는 모델이 있으면 발송대기 (3) 으로 이동되어 cs에서 처리


4는 발송확정단계
-완료하면 5로 변경됨
-취소시 동일하게 처리되고 재고 복원됨



6은 외부발송건
-외부 발송건은 해당건과 같은 주문을 품절/발송대기 처리시 함께 처리됨.( 그래서 모든 단계를 처리하고 처리해야함)
-완료시 5로 처리됨. (후에 5인것들로 매출계산)
-발송지가 외부발송으로 찍힘
-외부 발송건은 품절,주문취소 시 외에 주문등록 단계에서는 따로 처리



7 하자발송건 등록예정
*/
?>