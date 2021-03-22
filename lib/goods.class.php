<?

class GOODS{

	function GOODS(){
		global $cfg, $db;
		$this->cfg = $cfg;
		$this->db = $db;
	}

	function get_brand_info(){
		$qry="select * from brand";
		$res=$this->db->query($qry);

		return $res->results; 
	}

	function get_cate_info(){
		$qry="select * from category";
		$res=$this->db->query($qry);

		return $res->results; 
	}

	function get_goods_info($goodsnm='',$where='',$columns){

		if(!is_array($goodsnm))$good_arr[]=$goodsnm;
		
		foreach($good_arr as $k=>$v){	
			$gname[]=":g".$k;
			$param[":g".$k]=$v;
		}

		if(is_array($wehre))$add_wehre =" and ".implode(" and ",$wehre);

		$qry="select g.*
		,b.brandnm,b.brand_img_folder
		,c.catenm
		,gcl.*
		from goods g
		join goods_cnt_loc gcl on g.no=gcl.goodsno
		join brand b on b.no=g.brandno
		left join category c on c.no=g.cateno
		where goodsnm in(".implode("','",$gname).")
		".$add_wehre."
		";

		$res=$this->db->query($qry,$param);
		return $res->results; 
	}

	function get_goodsno($goodsnm,$cateno=0,$brandno=0){
		
		if($goodsnm){
			if($cateno){
				$add_where=" and cateno=:cateno ";
				$param[':cateno']=$cateno;
			}
			if($brandno){
				$add_where.=" and brandno=:brandno ";
				$param[':brandno']=$brandno;
			}
			$param[':goodsnm']=$goodsnm;
			$qry="select no from goods where goodsnm=:goodsnm ".$add_where." and no!=''";
			$res=$this->db->query($qry,$param);
			
			if($res->results['1']['no']){
				return '0'; 
			}else{
				//return $res->results['0']['no']; 
				if($res->results['0']['no'])return $res->results['0']['no']; 
				else return '0'; 
			}
		}else{
			return '0';
		}		
	}

	//모델별 배송 가능한 재고. $place_no 를 선언해서 개별 재고를 구하는건 큰 의미없음. now_stock() 과 차이가없음. 모델명을 리턴 하느냐 하지않느냐 차이..
	function get_stock_deli_av($arr_goodsnm,$place_no=''){
		
		if($place_no){
			$add_col[]="gcl.codeno_".$place_no;
		}else{
			$codedata=get_codedata('place','1'); //주문발송이 가능한 재고위치 가져오기.
			foreach($codedata as $v){$add_col[]="gcl.codeno_".$v['no'];}
		}

		//모델별 재고합
		$qry="select g.goodsnm, (".implode("+",$add_col).") totstock from goods g 
		join goods_cnt_loc gcl on g.no=gcl.goodsno
		where g.goodsnm in('".implode("','",$arr_goodsnm)."')
		group by g.goodsnm
		";

		$res=$this->db->query($qry);

		return $res;
	}
	
	/*선입선출로 입고재고 차감 하여 남은재고 수량 계산*/
	function calc_stock($goodsno,$num){
		
		$qry="select no,now_cnt,cost from stock_list where goodsno=:goodsno and state='1' and now_cnt!=0 order by return_order desc, no";
		$res=$this->db->query($qry,array(":goodsno"=>$goodsno));
	
		unset($order_cost);
		foreach($res->results as $v){
			
			if($num>0){				

				if($v['now_cnt']>=$num){

					$now_cnt=$v['now_cnt']-$num;
					$order_cost[]=$v['no']."^".$v['cost']."^".$num;

					$qry="update stock_list set now_cnt='".$now_cnt."' where no='".$v['no']."' ";
					$this->db->query($qry);
					break;
					
				}else{

					$now_cnt=0;
					$num-=$v['now_cnt'];

					$order_cost[]=$v['no']."^".$v['cost']."^".$v['now_cnt'];

					$qry="update stock_list set now_cnt='".$now_cnt."' where no='".$v['no']."' ";
					$this->db->query($qry);
				}
			}else{
				break;
			}
		}
		
		$order_cost=implode("|",$order_cost);
		if($order_cost==''){
			
			$qry="select no,now_cnt,cost from stock_list where goodsno=:goodsno and state='1' order by reg_date desc limit 1";
			$res=$this->db->query($qry,array(":goodsno"=>$goodsno));

			$costdata=$res->results[0];
			
			if($costdata){
				$order_cost=$costdata['no']."^".$costdata['cost']."^".$num;		
			}else{
				$order_cost='입고내역없음';
			}
		}

		return $order_cost;

	}	
	
	function avg_price($goodsno,$list='',$col_name=''){
		

		if($col_name=='cost_ori'){
			//$add_where=" and f_group_id!='0' ";
		}else{
			$col_name='cost';
		}

		$qry="select cost_ori,cost,now_cnt,stock_num_reg,state from stock_list where goodsno=:goodsno 
		and (now_cnt>0 or state=0)
		and state!=2 
		".$add_where."
		#and return_order=0";
		$res = $this->db->query($qry,array(":goodsno"=>$goodsno));
		foreach($res->results as $sv){

			if($sv['state']==0)$calc_cnt=$sv['stock_num_reg'];
			else $calc_cnt=$sv['now_cnt'];
			
			$stock_sumPrice+=($sv[$col_name]*$calc_cnt);
			$stock_sumNum+=$calc_cnt;

		}
		
		$avg_price=round($stock_sumPrice/$stock_sumNum);

		if(!$avg_price && !$list){ //현재고가 없는경우 최근원가
			$qry="select cost avg_price from stock_list where goodsno=:goodsno and state=1 order by reg_date desc limit 1";
			$res = $this->db->query($qry,array(":goodsno"=>$goodsno));

			$avg_price=$res->results[0]['avg_price'];
		}
		return round($avg_price);
	}

	/*상품정보 노출형태*/
	function goods_prop_style($prop_k,$prop_v,$v,$info_en){
		
		if($prop_k && $prop_v){
			
			$exporp=explode("|",$prop_v);
	
			if($v[$exporp['0']])$size_arr[]=$v[$exporp['0']];
			if($v[$exporp['1']])$size_arr[]=$v[$exporp['1']];
			if($v[$exporp['2']])$size_arr[]=$v[$exporp['2']];
			$size_data=@implode('x',$size_arr);
						
			if($v['sabang_prop_code']=='019'){//귀금속/보석/시계류

				if($v['category']=='001001000000'){//시계

					if($prop_k=='1' || $prop_k=='16'){

						$tmp_prop="SIZE - ".$size_data;//치수
					}
					else if($prop_k=='2' || $prop_k=='9')$tmp_prop=$v[$exporp['0']]."(".$v[$exporp['1']]."/병행수입)";//제조사
					else if($prop_k=='7')$tmp_prop=($v[$exporp['0']]=='Y')?"Y 제공":"N 미제공";//품질보증서
					else if($prop_k=='8')$tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:"제조사에서 중량정보를 제공하지 않습니다.";//중량
					else if($prop_k=='10')$tmp_prop=$v[$exporp['0']]." / 케이스 - ".$v[$exporp['1']]." / 밴드 - ".$v[$exporp['2']];//주요소재
					else if($prop_k=='13')$tmp_prop="WATER RESISTANCE - ".$info_en[$v[$exporp['0']]]."(".$v[$exporp['0']].")";//기능,방수 등
					else $tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:trim($exporp['0']);

				}else if(substr($v['category'],0,3)=='003'){//쥬얼리
					
					if($prop_k=='1' || $prop_k=='16')$tmp_prop="SIZE - ".$size_data;//치수
					else if($prop_k=='2' || $prop_k=='9')$tmp_prop=$v[$exporp['0']]."(".$v[$exporp['1']]."/병행수입)";//제조사
					else if($prop_k=='7')$tmp_prop=($v[$exporp['0']]=='Y')?"Y 제공":"N 미제공";//품질보증서
					else if($prop_k=='8')$tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:"제조사에서 중량정보를 제공하지 않습니다.";//중량
					else if($prop_k=='10'){
						$tmp_prop=$v[$exporp['0']];//주요소재
						if($v[$exporp['1']])$tmp_prop.=" / 쥬얼리 - ".$v[$exporp['1']];
						if($v[$exporp['2']])$tmp_prop.=" / 팬던트 - ".$v[$exporp['2']];
					}
					else if($prop_k=='13')$tmp_prop="해당없음";//기능,방수 등
					else $tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:trim($exporp['0']);
				}


			}else if($v['sabang_prop_code']=='004'){//패션잡화(모자/벨트/지갑)
				
				if($prop_k=='3'|| $prop_k=='14')$tmp_prop="SIZE - ".$size_data;//치수
				else if($prop_k=='4')$tmp_prop=$v[$exporp['0']]."(".$v[$exporp['1']]."/병행수입)";//제조사
				else if($prop_k=='13'){
					
					$tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:"제조사에서 중량정보를 제공하지 않습니다.";//중량
				}
				else $tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:trim($exporp['0']);

			}else if($v['sabang_prop_code']=='002'){//구두/신발

				$gsize=end(explode("(",$v['goodsnm']));
				$gsize=reset(explode(")",$gsize));

				if($prop_k=='3'|| $prop_k=='11' || $prop_k=='13' || $prop_k=='16'){
					$tmp_prop="SIZE - ".$gsize."(".$v[$exporp['0']].")";//치수
				}
				else if($prop_k=='4' || $prop_k=='9')$tmp_prop=$v[$exporp['0']]."(".$v[$exporp['1']]."/병행수입)";//제조사
				else if($prop_k=='15')$tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:"제조사에서 중량정보를 제공하지 않습니다.";//중량
				else $tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:trim($exporp['0']);

			
			}else if($v['sabang_prop_code']=='003'){//가방

				if($prop_k=='3'|| $prop_k=='9')$tmp_prop=$v[$exporp['0']]."(".$v[$exporp['1']]."/병행수입)";//제조사
				else if($prop_k=='8' || $prop_k=='12')$tmp_prop="SIZE - ".$size_data;//치수
				else if($prop_k=='13')$tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:"제조사에서 중량정보를 제공하지 않습니다.";//중량
				else $tmp_prop=($v[$exporp['0']])?$v[$exporp['0']]:trim($exporp['0']);

			}
		}

		return $tmp_prop;
	}


	function goods_detail_select($info_arr=''){
		
		if(is_array($info_arr)){
			$add_where=" and cgi.info_name in ('".implode("','",$info_arr)."')";
		}else{
			$add_where=" and cgi.info_name in ('성별','본체재질','본체재질2','종류','방수','무브먼트')";
		}

		$qry="select cgi.colum_name,cgi.info_name,gif.filter_name from category_goods_info cgi
		join goods_info_filter gif on cgi.no=gif.category_goods_info_no
		where 1 ".$add_where." order by gif.filter_name";
		$res=$this->db->query($qry);
		
		foreach($res->results as $k=>$v){
			
			$data['view'][$v['colum_name']]=$v['info_name'];
			$data['data'][$v['colum_name']][]=$v['filter_name'];
		}

		return $data;
	}


	function cal_stock_price($v){

		//환율적용
		$tot_price=str_replace(",","",$v['4'])*str_replace(",","",$v['5']);
		
		if($tot_price>2000000){
			
			$t_std_price=$tot_price-2000000;
			
			$t_tax=$t_std_price*0.2;//특소세	
			$g_tax=$t_tax*0.3;//교육세

			$tot_price=$tot_price+$t_tax+$g_tax;
		}

		$tot_price=$tot_price*(1+$v['6']/100);//관세
		$tot_price=$tot_price*1.1;//부가세
		$tot_price=$tot_price*(1+$v['8']/100);//부대비용
		$tot_price=$tot_price*(1+$v['7']/100);//수수료

		return ceil($tot_price);
	}

	//상품상세이미지
	function get_detail_img($data){

		global $cfg;
		
		$brand_img_folder=$data['brand_img_folder'];
		$brand_img_nm=$data['brand_img_nm']?$data['brand_img_nm']:$brand_img_folder."_case";
		$goodsnm=($data['img_name'])?$data['img_name']:$data['goodsnm'];

		if($data['img_step']=='5' || $data['img_step']=='3'){

			$goods_detail='<div align="center"><br>
			<img src="'.$cfg['img_url'].'a/info/notice.jpg" /><br>

			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'.jpg"><br>

			<img src="'.$cfg['img_url'].'a/info/as.jpg" /><br> </div>';
		}else if($data['img_step']=='4'){

			$goods_detail='<div align="center"><br>
			<img src="'.$cfg['img_url'].'a/info/notice.jpg" /><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$brand_img_folder.'_story.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_01.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_spec.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_02.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_03.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_04.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_05.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_06.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_07.jpg"><br>

			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$brand_img_folder.'_ETC.jpg"><br>
			<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$brand_img_nm.'.jpg"><br>
			<img src="'.$cfg['img_url'].'a/info/as.jpg" /><br> </div>';
		}

		return $goods_detail;
	}

	//상품명
	function get_mall_goodsnm($v){

		if($v['brandnm'])$mall_goodsnm_brand[]=$v['brandnm'];
		if($v['brandnm_en'])$mall_goodsnm_brand[]=$v['brandnm_en'];


		$mall_goodsnm[]="[".implode(" ",$mall_goodsnm_brand)."]";


		if($v['goodsnm'])$mall_goodsnm[]=$v['goodsnm'];
		if($v['goodsnm_sub'])$mall_goodsnm[]=$v['goodsnm_sub'];
		if($v['collection'])$mall_goodsnm[]=$v['collection'];
		if($v['etc_info'])$mall_goodsnm[]=$v['etc_info'];
		if($v['gender'])$mall_goodsnm[]=$v['gender'];
		if($v['prod_type']=='시계')$mall_goodsnm[]=$v['movement'];
		if($v['prod_type'])$mall_goodsnm[]=$v['prod_type'];	

		$data=implode(" ",$mall_goodsnm);

		return $data;
	}

	function get_sabang_cate($v,$dep='2'){

		global $cfg_sabang_cate;

		if($cfg_sabang_cate[$dep][$v['depth_1']]){

			foreach($cfg_sabang_cate[$dep][$v['depth_1']] as $cv){
				$CLASS_CD2[]=$v[$cv];
			}
			$CLASS_CD2=implode(" ",$CLASS_CD2);
		}else{
			$CLASS_CD2=$v['prod_type'];
		}

		

		return $CLASS_CD2;
	}

}

?>
