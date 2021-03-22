<?php
include "../_header.php";

if($_FILES){
	
	
	$gift_set=goods_freegift();
	

	if(strpos($_FILES['excelFile']['name']['0'],$_POST['upload_form_type'])!==false) {
		$file_chk='1';
	}else{
		$file_chk='0';
	}
	
	if(!$file_chk && $_POST['upload_form_type']!='nonexcel_b2b')msg('선택한 몰과 업로드 파일이 다릅니다.','order_upload.php');

	$excel_data=excel_read();

	//데이터 검증 
	if(count($excel_data)>0 || $_POST['upload_form_type']=='nonexcel_b2b'){ //nonexcel_b2b는 도매디비에서 로딩
		$GOODS=new goods();
		$ORDER=new order();

		//업로드쿼리 컬럼배열
		//code1 부터는 불확실한 데이터를 임의로 담아둠. erp적용전에 필요여부를 체크할 시간이 없어서 임의로 입력. 후에 유지여부를 따져봐야함.
		$arr_make_qry=array('ordno','wno','ori_ordno','dupl_key','mall_name','mall_no','ord_date','reg_date','step','mall_goodsnm','goods_code','goodsnm','ori_goodsnm','order_num','order_price','settle_price','deli_type','deli_price','buyer','receiver','buyer_mobile','mobile','zipcode','address','order_memo','upload_form_type','mall_key','mall_key2','pay_type','use_reserve','use_naver_point','coupon_dc','coupon_name','code1','email','memo'); 
		

		$today=date('Y-m-d');

		$mall_info=get_mall_info('y');
		foreach($mall_info as $mallv){
			$arr_mall_name[$mallv['upload_form_type']][]=$mallv['mall_name'];

			$arr_mall_no[$mallv['upload_form_type']][$mallv['mall_name']]=$mallv['no'];
			
			$mall_name_seq[$mallv['no']]=$mallv['mall_name'];
		}
		

		if(count($excel_data)>0){
			foreach($excel_data as $k=>$v){
				switch($_POST['upload_form_type']){
					/* 각 업로드 양식은 모든 케이스가 파악된것이 아니기 때문에 변수가 존재함.*/
					case '타임메카':
						$tmp=explode("-",$v['0']);
						$ord_date=reset($tmp);
						$order_price=$v['15'];
						$mall_goodsnm=$v['8'];
						$goodsnm=($v['10'])?$v['10']:$v['9'];
						
						unset($ex_goods);
						//$ex_goods=explode(",",$goodsnm); 콤마로 옵션 분류 우선 하지않기로.
						$ex_goods[]=$goodsnm; //콤마로 옵션 분류 우선 하지않기로.
						
						foreach($ex_goods as $gk=>$gv){
							
							//if($gk!=0)$order_price=0; //콤마로 주문 분리시 가격 분리 어떻게 할껀지 발주팀과 상의
							
							if(!strstr($gv,',')){ //콤마가 있는 상품(옵션이 여러개 넘어온상품)은 모델명 필터 않하고 그대로 넘겨서 모델명 매칭으로 넘김.
								
								//if(preg_match("/선택[0-9]{1,3}\.\s*/",$gv)) $gname=preg_split("/선택[0-9]{1,3}\.\s*/",$gv);
								//else $gname=explode("=",$gv);
								//$gname=($gname['1'])?$gname['1']:$gname['0'];
								
								$gname=filter_goodsnm($gv);
							}else{
								$gname=$gv;
							}
							
							if($gname!='선택안함'){
								
								if(strpos($gname,"//")){ //자사몰 팀과 얘기해서 옵션명 뒤에 실제 모델명을   // 후에 등록하게 괄호는 싸이즈가 붙을수있어서 않됨.
									$ex_gname=explode("//",$gname);
									$mall_goodsnm.="||".$ex_gname['0'];

									$gname=trim($ex_gname['1']);
								}
							
								$key=$k."_".$gk; //1개의 주문에 옵션이 담겨 넘어오기때문에 분리해줌
								$data[$key]['ordno']=$v['0'];
								$data[$key]['ori_ordno']=$v['0'];
								$data[$key]['mall_name']=$mall_name_seq['1'];
								$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name_seq['1']];
								$data[$key]['ord_date']=$ord_date;
								$data[$key]['reg_date']=$today;
								$data[$key]['step']='0';
								$data[$key]['mall_goodsnm']= $mall_goodsnm;
								$data[$key]['goods_code']=$v['29'];
								$data[$key]['goodsnm']=$gname;
								$data[$key]['ori_goodsnm']=$gname;
								$data[$key]['goods_opt']=$v['11'];
								$data[$key]['order_num']=$v['12'];
								$data[$key]['order_price']=$order_price;
								$data[$key]['settle_price']=$v['16'];
								$data[$key]['deli_price']=$v['17'];
								$data[$key]['buyer']=$v['18'];
								$data[$key]['receiver']=$v['3'];
								$data[$key]['buyer_mobile']=$v['6'];
								$data[$key]['mobile']=$v['7'];
								$data[$key]['zipcode']=$v['4'];
								$data[$key]['address']=$v['5'];
								$data[$key]['order_memo']=$v['13'];		
								$data[$key]['mall_key']=$v['20'];	
								$data[$key]['mall_key2']=$v['19'];	
								
								$data[$key]['pay_type']=$v['26'];	
								$data[$key]['use_reserve']=$v['22'];	
								$data[$key]['use_naver_point']=$v['23'];	
								$data[$key]['coupon_dc']=$v['24'];	
								$data[$key]['coupon_name']=$v['25'];	

								$data[$key]['upload_form_type']=$_POST['upload_form_type'];			
								$data[$key]['dupl_key']='';

								/*사은품 추가*/
								$add_gift=get_goods_gift($data[$key],$key,$gift_set);
								
								foreach($add_gift as $giftk=>$giftv){
									$gift_cnt++;
									$data[$giftk]=$giftv;
								}
								/*사은품 추가 end*/
							}else{
								$order_dupli[]=$k."열 모델명 오류";
							}			
						}

						break;

					case '사방넷':
						
						if($v['17']=='trendmecca_hiver')$v['1']='하이버';

						if(in_array($v['1'],$arr_mall_name[$_POST['upload_form_type']])){
							$mall_name=$v['1'];
						}else{
							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." ".$v['1'];
						}
				
						//$mobile=($v['6'])?$v['6']:$v['7'];
						/*
						$gname=explode('/',$v['9']);
						$gname=end($gname);
						$gname=explode(':',$gname);
						$gname=end($gname);
						*/
						//$gname=$v['9'];
						
						$gname=filter_goodsnm($v['4']);

						if(!$v['10'])$v['10']=$v['11'];
						if(!$v['11'])$v['11']=$v['10'];

						$key=$k;					
						$data[$key]['ordno']=$v['0'];
						$data[$key]['ori_ordno']=$v['0'];
						$data[$key]['mall_name']=$v['1'];
						$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$v['1']];
						$data[$key]['ord_date']=$v['2'];
						$data[$key]['reg_date']=$today;
						$data[$key]['step']='0';
						$data[$key]['mall_goodsnm']=$v['3'];
						$data[$key]['goodsnm']=$gname;
						$data[$key]['ori_goodsnm']=$gname;
						$data[$key]['order_num']=$v['5'];
						$data[$key]['order_price']=$v['7'];
						$data[$key]['settle_price']=$v['7'];
						$data[$key]['deli_price']='';
						$data[$key]['buyer']=$v['8'];
						$data[$key]['receiver']=$v['9'];
						$data[$key]['buyer_mobile']=$v['10'];
						$data[$key]['mobile']=$v['11'];
						$data[$key]['zipcode']=$v['12'];
						$data[$key]['address']=$v['13'];
						$data[$key]['order_memo']=$v['14'];			
						$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
						$data[$key]['code1']=$v['15'];	//사방넷 주문번호?
						$data[$key]['dupl_key']='';


						/*사은품 추가*/
						$add_gift=get_goods_gift($data[$key],$key,$gift_set);
						
						foreach($add_gift as $giftk=>$giftv){
							$gift_cnt++;
							$data[$giftk]=$giftv;
						}
						/*사은품 추가 end*/
						break;
					case '셀피아':
						
						$mall_name=$v['1'];
						
						if(in_array($mall_name,$arr_mall_name[$_POST['upload_form_type']])){
						
						}else{
							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." ".$v['1'];
						}
				
						$gname=end(explode(":",$v['13']));

						$gname=filter_goodsnm($gname);
						
						if(!$v['6'])$v['6']=$v['7'];
						if(!$v['7'])$v['7']=$v['6'];

						$key=$k;					
						$data[$key]['ordno']=$v['0'];
						$data[$key]['ori_ordno']=$v['0'];
						$data[$key]['mall_name']=$mall_name;
						$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name];
						$data[$key]['ord_date']=$today;
						$data[$key]['reg_date']=$today;
						$data[$key]['step']='0';
						$data[$key]['mall_goodsnm']=$v['12'];
						$data[$key]['goodsnm']=$gname;
						$data[$key]['ori_goodsnm']=$gname;
						$data[$key]['order_num']=$v['10'];
						$data[$key]['order_price']=$v['14'];
						$data[$key]['settle_price']=$v['14'];
						$data[$key]['deli_price']='0';
						$data[$key]['buyer']=$v['3'];
						$data[$key]['receiver']=$v['3'];
						$data[$key]['buyer_mobile']=$v['6'];
						$data[$key]['mobile']=$v['7'];
						$data[$key]['zipcode']=$v['4'];
						$data[$key]['address']=$v['5'];
						$data[$key]['order_memo']=$v['11'];			
						$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
						$data[$key]['deli_type']=$v['8']; //추가 선불착불
						$data[$key]['mall_key']=$v['16'];	//추가 마켓키값(품목번호)
						#$data[$key]['code1']=$v['9'];	//추가 자사코드
						#$data[$key]['cha_su']=$v['17'];	//추가 
						$data[$key]['dupl_key']='';
							
						/*사은품 추가*/
						$add_gift=get_goods_gift($data[$key],$key,$gift_set);
						
						foreach($add_gift as $giftk=>$giftv){
							$gift_cnt++;
							$data[$giftk]=$giftv;
						}
						/*사은품 추가 end*/

						break;

					case 'B2B':

						$mall_name=$v['1'];
						
						if(in_array($mall_name,$arr_mall_name[$_POST['upload_form_type']])){
						
						}else{
							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." ".$v['1'];
						}
					
						if(!$v['12'])$v['12']=$v['13'];
						if(!$v['13'])$v['13']=$v['12'];
						
						$gname=filter_goodsnm($v['4']);

						$key=$k;					
						$data[$key]['ordno']=$v['0'];
						$data[$key]['ori_ordno']=$v['0'];
						$data[$key]['mall_name']=$mall_name;
						$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name];
						$data[$key]['ord_date']=$today;
						$data[$key]['reg_date']=$today;
						$data[$key]['step']='0';
						$data[$key]['mall_goodsnm']=$v['4']." ".$v['5'];
						$data[$key]['goodsnm']=$gname;
						$data[$key]['ori_goodsnm']=$gname;
						$data[$key]['order_num']=$v['8'];
						$data[$key]['order_price']=$v['8']*$v['6'];
						$data[$key]['settle_price']=$v['7'];
						$data[$key]['deli_price']=$v['7']-($v['8']*$v['6']);
						$data[$key]['buyer']=$mall_name;
						$data[$key]['receiver']=$v['11'];
						$data[$key]['buyer_mobile']=$v['12'];
						$data[$key]['mobile']=$v['13'];
						$data[$key]['zipcode']='';
						$data[$key]['address']=$v['15']." ".$v['16'];
						$data[$key]['email']=$v['14'];
						$data[$key]['order_memo']=$v['17'];			
						$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
						$data[$key]['deli_type']=$v['7']-($v['6']*$v['8']); //추가 선불착불
						$data[$key]['dupl_key']='';


						
						/*사은품 추가*/
						$add_gift=get_goods_gift($data[$key],$key,$gift_set);
						
						foreach($add_gift as $giftk=>$giftv){
							$gift_cnt++;
							$data[$giftk]=$giftv;
						}
						/*사은품 추가 end*/

						break;


					case '오피셜':
					
						$gname=filter_goodsnm($v['0']);
						//$gres=$GOODS->get_goods_info($gname);
						$brandnm=$v['23'];
						
						if(!in_array($brandnm,$arr_mall_name[$_POST['upload_form_type']]))$err_msg[]="몰명 오류 ".$brandnm." ".$gname;
						

						

						if(!$v['10'] || !$v['10']=='--')$v['10']=$v['11'];
						if(!$v['11'] || !$v['11']=='--')$v['11']=$v['10'];

						$key=$k;					
						$data[$key]['ordno']=trim($v['6']);
						$data[$key]['ori_ordno']=trim($v['6']);
						$data[$key]['mall_name']=$brandnm;
						$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$brandnm];
						$data[$key]['ord_date']=$today;
						$data[$key]['reg_date']=$today;
						$data[$key]['step']='0';
						$data[$key]['mall_goodsnm']= $gname;
						$data[$key]['goodsnm']=$gname;
						$data[$key]['ori_goodsnm']=$gname;
						$data[$key]['order_num']=$v['4'];
						$data[$key]['order_price']=$v['12'];
						$data[$key]['settle_price']=$v['13'];
						$data[$key]['deli_price']='';
						$data[$key]['buyer']=$v['8'];
						$data[$key]['receiver']=$v['9'];
						$data[$key]['buyer_mobile']=$v['10'];
						$data[$key]['mobile']=$v['11'];
						$data[$key]['zipcode']=$v['19'];
						$data[$key]['address']=$v['7'];
						$data[$key]['order_memo']=$v['20'];			
						$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
						$data[$key]['mall_key']=$v['22'];
						$data[$key]['mall_key2']=$v['21'];
						$data[$key]['dupl_key']='';		

						
						/*사은품 추가*/
						$add_gift=get_goods_gift($data[$key],$key,$gift_set);
						
						foreach($add_gift as $giftk=>$giftv){
							$gift_cnt++;
							$data[$giftk]=$giftv;
						}
						/*사은품 추가 end*/

						break;
					
					case "스토어팜":
							/*
							if($v['17']=='조합형옵션상품'){

								$gname=explode(" ",$v['18']);
								$gname=end($gname);
							}else{
								$gname=$v['37'];
							}
							*/

							$gname=filter_goodsnm($v['37']);

						if($k>1){//3번열부터
							


							$gres=$GOODS->get_goods_info($gname);

							$brandnm=$gres['0']['brandnm'];
							$key=$k;					
							$data[$key]['ordno']=$v['1'];
							$data[$key]['ori_ordno']=$v['1'];
							$data[$key]['mall_name']=$mall_name_seq['4'];
							$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name_seq['4']];
							$data[$key]['ord_date']=$v['14'];
							$data[$key]['reg_date']=$today;
							$data[$key]['step']='0';
							$data[$key]['mall_goodsnm']= $v['16'];
							$data[$key]['goodsnm']=$gname;
							$data[$key]['ori_goodsnm']=$gname;
							$data[$key]['order_num']=$v['20'];
							$data[$key]['order_price']=($v['21']+$v['22']-$v['24'])/$v['20'];
							$data[$key]['settle_price']=$v['25'];
							$data[$key]['deli_price']=$v['34'];
							$data[$key]['buyer']=$v['8'];
							$data[$key]['receiver']=$v['10'];
							$data[$key]['buyer_mobile']=$v['41'];
							$data[$key]['mobile']=$v['40'];
							$data[$key]['zipcode']=$v['44'];
							$data[$key]['address']=$v['42'];
							$data[$key]['order_memo']=$v['45'];			
							$data[$key]['dupl_key']=$v['0'];		
							$data[$key]['mall_key']=$v['0'];
							$data[$key]['upload_form_type']=$_POST['upload_form_type'];	

							/*사은품 추가*/
							$add_gift=get_goods_gift($data[$key],$key,$gift_set);
							
							foreach($add_gift as $giftk=>$giftv){
								$gift_cnt++;
								$data[$giftk]=$giftv;
							}
							/*사은품 추가 end*/
							
						}
						break;

					case '롯데묘미':
						
						$mall_name=$mall_name_seq['1289'];
						
						if(in_array($mall_name,$arr_mall_name[$_POST['upload_form_type']])){
						
						}else{

							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." ".$v['1'];
						}
				
						$gname=filter_goodsnm($v['9']);
						
						$key=$k;					
						$data[$key]['ordno']=$v['4'];
						$data[$key]['ori_ordno']=$v['4'];
						$data[$key]['mall_name']=$mall_name;
						$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name];
						$data[$key]['ord_date']=$v['2'];
						$data[$key]['reg_date']=$today;
						$data[$key]['step']='0';
						$data[$key]['mall_goodsnm']=$v['8'];
						$data[$key]['goodsnm']=$gname;
						$data[$key]['ori_goodsnm']=$gname;
						$data[$key]['order_num']=$v['10'];
						$data[$key]['order_price']=$v['26'];
						$data[$key]['settle_price']=($v['26']*1.1)/$v['10'];
						$data[$key]['deli_price']=$v['27'];
						$data[$key]['buyer']=$v['12'];
						$data[$key]['receiver']=$v['14'];
						$data[$key]['buyer_mobile']=$v['13'];
						$data[$key]['mobile']=$v['15'];
						$data[$key]['zipcode']='';
						$data[$key]['email']='';
						$data[$key]['address']=$v['16'];
						$data[$key]['order_memo']=$v['17'];			
						$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
						$data[$key]['dupl_key']='';
							
						/*사은품 추가*/
						$add_gift=get_goods_gift($data[$key],$key,$gift_set);
						
						foreach($add_gift as $giftk=>$giftv){
							$gift_cnt++;
							$data[$giftk]=$giftv;
						}
						/*사은품 추가 end*/

						break;

					case '롯데홈쇼핑 방송':
						
						$mall_name=$mall_name_seq['37'];
						
						if(in_array($mall_name,$arr_mall_name[$_POST['upload_form_type']])){
						
						}else{

							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." ".$v['1'];
						}
						

						$gname=end(explode(" ",$v['36']));
						$gname=filter_goodsnm($gname);
						
						if($k>1){//3번열부터

							$key=$k;					
							$data[$key]['ordno']=$v['4'];
							$data[$key]['ori_ordno']=$v['4'];
							$data[$key]['mall_name']=$mall_name;
							$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name];
							$data[$key]['ord_date']=$v['1'];
							$data[$key]['reg_date']=$today;
							$data[$key]['step']='0';
							$data[$key]['mall_goodsnm']=$v['36'];
							$data[$key]['goodsnm']=$gname;
							$data[$key]['ori_goodsnm']=$gname;
							$data[$key]['order_num']=$v['39'];
							$data[$key]['order_price']=$v['46'];
							$data[$key]['settle_price']=$v['46'];
							$data[$key]['deli_price']=0;
							$data[$key]['buyer']=$v['22'];
							$data[$key]['receiver']=$v['24'];
							$data[$key]['buyer_mobile']=$v['24'];
							$data[$key]['mobile']=$v['27'];
							$data[$key]['zipcode']=$v['42'];
							$data[$key]['email']='';
							$data[$key]['address']=$v['43'];
							$data[$key]['order_memo']='';			
							$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
							$data[$key]['dupl_key']='';
								
							/*사은품 추가*/
							$add_gift=get_goods_gift($data[$key],$key,$gift_set);
							
							foreach($add_gift as $giftk=>$giftv){
								$gift_cnt++;
								$data[$giftk]=$giftv;
							}
							/*사은품 추가 end*/
						}
						break;

					case 'CJ홈쇼핑(씨제이홈쇼핑)홈방용':
						
						$mall_name=$mall_name_seq['1580'];
						
						if(in_array($mall_name,$arr_mall_name[$_POST['upload_form_type']])){
						
						}else{

							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." ".$v['1'];
						}
						
						$gname=filter_goodsnm($v['27']);
						
						if($k>3){//4번열부터

							$key=$k;					
							$data[$key]['ordno']=$v['10'];
							$data[$key]['ori_ordno']=$v['10'];
							$data[$key]['mall_name']=$mall_name;
							$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name];
							$data[$key]['ord_date']=$v['3'];
							$data[$key]['reg_date']=$today;
							$data[$key]['step']='0';
							$data[$key]['mall_goodsnm']=$v['26'];
							$data[$key]['goodsnm']=$gname;
							$data[$key]['ori_goodsnm']=$gname;
							$data[$key]['order_num']=$v['21'];
							$data[$key]['order_price']=$v['23'];
							$data[$key]['settle_price']=$v['23'];
							$data[$key]['deli_price']=0;
							$data[$key]['buyer']=$v['11'];
							$data[$key]['receiver']=$v['13'];
							$data[$key]['buyer_mobile']=$v['12'];
							$data[$key]['mobile']=$v['15'];
							$data[$key]['zipcode']=$v['16'];
							$data[$key]['email']='';
							$data[$key]['address']=($v['18'])?$v['18']:$v['17'];
							$data[$key]['order_memo']=$v['19'];	
							$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
							$data[$key]['dupl_key']=$v['20'];
								
							/*사은품 추가*/
							$add_gift=get_goods_gift($data[$key],$key,$gift_set);
							
							foreach($add_gift as $giftk=>$giftv){
								$gift_cnt++;
								$data[$giftk]=$giftv;
							}
							/*사은품 추가 end*/
						}
						break;

					case '기타':
						
						$mall_name=$mall_name_seq['1582'];
						
						if(in_array($mall_name,$arr_mall_name[$_POST['upload_form_type']])){
						
						}else{

							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." ".$v['1'];
						}
						
						$gname=filter_goodsnm($v['9']);
						
						if($k>1){//4번열부터

							$key=$k;					
							$data[$key]['ordno']=$v['0'];
							$data[$key]['ori_ordno']=$v['0'];
							$data[$key]['mall_name']=$mall_name;
							$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name];
							$data[$key]['ord_date']=$today;
							$data[$key]['reg_date']=$today;
							$data[$key]['step']='0';
							$data[$key]['mall_goodsnm']=$v['9'];
							$data[$key]['goodsnm']=$gname;
							$data[$key]['ori_goodsnm']=$gname;
							$data[$key]['order_num']=$v['10'];
							$data[$key]['order_price']='0';
							$data[$key]['settle_price']='0';
							$data[$key]['deli_price']=0;
							$data[$key]['buyer']=$v['3'];
							$data[$key]['receiver']=$v['3'];
							$data[$key]['buyer_mobile']=$v['6'];
							$data[$key]['mobile']=$v['7'];
							$data[$key]['zipcode']=$v['4'];
							$data[$key]['email']='';
							$data[$key]['address']=$v['5'];
							$data[$key]['order_memo']=$v['11'];	
							$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
							$data[$key]['dupl_key']='';
								
							/*사은품 추가*/
							$add_gift=get_goods_gift($data[$key],$key,$gift_set);
							
							foreach($add_gift as $giftk=>$giftv){
								$gift_cnt++;
								$data[$giftk]=$giftv;
							}
							/*사은품 추가 end*/
						}
						break;

					case '라플란드코리아':
						
						$mall_name=$v['1'];
						if(in_array($mall_name,$arr_mall_name[$_POST['upload_form_type']])){
						
						}else{
							$err_msg[]="몰명 오류 ".$_POST['upload_form_type']." / ".$v['1'];
						}
				
						$gname=filter_goodsnm($v['9']);
						
						$key=$k;					
						$data[$key]['ordno']=trim($v['0']);
						$data[$key]['ori_ordno']=trim($v['0']);
						$data[$key]['mall_name']=$mall_name;
						$data[$key]['mall_no']=$arr_mall_no[$_POST['upload_form_type']][$mall_name];
						$data[$key]['ord_date']=$today;
						$data[$key]['reg_date']=$today;
						$data[$key]['step']='0';
						$data[$key]['mall_goodsnm']=$gname;
						$data[$key]['goodsnm']=$gname;
						$data[$key]['ori_goodsnm']=$gname;
						$data[$key]['order_num']=$v['10'];
						$data[$key]['order_price']=$v['11'];
						$data[$key]['settle_price']=$v['11'];
						$data[$key]['deli_price']='';
						$data[$key]['buyer']=$v['3'];
						$data[$key]['receiver']=$v['3'];
						$data[$key]['buyer_mobile']=$v['6'];
						$data[$key]['mobile']=$v['7'];
						$data[$key]['zipcode']=$v['4'];
						$data[$key]['email']='';
						$data[$key]['address']=$v['5'];
						$data[$key]['order_memo']=$v['12'];			
						$data[$key]['upload_form_type']=$_POST['upload_form_type'];	
						$data[$key]['dupl_key']='';
						
						/*사은품 추가*/
						$add_gift=get_goods_gift($data[$key],$key,$gift_set);
						
						foreach($add_gift as $giftk=>$giftv){
							$gift_cnt++;
							$data[$giftk]=$giftv;
						}
						/*사은품 추가 end*/

						break;

				}	
			}
		}else if($_POST['upload_form_type']=='nonexcel_b2b'){
			
			try{
				
				$db->beginTransaction();	
				$gift_set_ws=goods_freegift_wholesale();
				
				$qry="select wo.*,wm.company_name,ml.no mall_no from wholesale_order wo
				join wholesale_member wm on wm.no=wo.m_no
				left join mall_list ml on ml.mall_name=wm.company_name
				where wo.step='1' and wo.refund='n' ";

				$res=$db->query($qry,$chk_no);

				$today=date('Y-m-d');
				foreach($res->results as $k=>$v){
					
					$mall_name=$v['company_name'];
					
					if(!$v['mobile'])$v['mobile']=$v['mobile2'];
					if(!$v['mobile2'])$v['mobile2']=$v['mobile'];
					
					$gname=filter_goodsnm($v['goodsnm']);

					$key=$k;					
					$data[$key]['ordno']=$v['ordno'];
					$data[$key]['ori_ordno']=$v['ordno'];
					$data[$key]['wno']=$v['no'];
					$data[$key]['mall_name']=$mall_name;
					$data[$key]['mall_no']=$v['mall_no'];
					$data[$key]['ord_date']=$today;
					$data[$key]['reg_date']=$today;
					$data[$key]['step']='0';
					$data[$key]['mall_goodsnm']=$gname;
					$data[$key]['goodsnm']=$gname;
					$data[$key]['ori_goodsnm']=$gname;
					$data[$key]['order_num']=$v['order_num'];
					$data[$key]['order_price']=$v['order_price']*$v['order_num'];
					$data[$key]['settle_price']=($v['order_price']*$v['order_num'])+$v['deli_price'];
					$data[$key]['deli_price']=$v['deli_price'];
					$data[$key]['buyer']=$mall_name;
					$data[$key]['receiver']=$v['receiver'];
					$data[$key]['buyer_mobile']=$v['mobile2'];
					$data[$key]['mobile']=$v['mobile'];
					$data[$key]['zipcode']=$v['zipcode'];
					$data[$key]['address']=$v['address'];
					$data[$key]['email']='';
					$data[$key]['order_memo']=$v['memo'];			
					$data[$key]['upload_form_type']='B2B';
					$data[$key]['deli_type']=$v['deli_type'];
					$data[$key]['dupl_key']='';

					if($v['deli_type']=="착불퀵")	{
						$data[$key]['memo']='<font style=\'color:red\'>착불퀵</font>';
					}
					

					
					//사은품 추가
					
					$add_gift=get_goods_gift($data[$key],$key,$gift_set_ws);
					
					foreach($add_gift as $giftk=>$giftv){
						$gift_cnt++;
						$data[$giftk]=$giftv;
					}
					//사은품 추가 end

					//도매주문 등록표시
					if($v['mall_no']){
						$qry="update wholesale_order set step='2' where step='1' and refund='n' and no='".$v['no']."' ";
						$db->query($qry);
					}
				}



				$db->commit();
				
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage());		
			}
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
			
		}else{

			try{
				
				$db->beginTransaction();

				/*주문에 중복이 있을수도 있다는 가정을하면 동일 주문서의 내용을 필터해줘야함.*/
				$loop_cnt=0;

				foreach($data as $k=>$v){
					unset($chk_param);
					unset($qry_str);
					unset($var_str);

					if(!$v['goodsnm']){
						$v['ori_goodsnm']=$v['goodsnm']='옵션명 없음'.$k;
					}

					$chk_qry="select no from order_list
					where ordno=:ordno
					and mall_name=:mall_name
					and ori_goodsnm=:ori_goodsnm
					and receiver=:receiver
					and dupl_key=:dupl_key
					";
					$chk_param[':ordno']=$v['ordno'];
					$chk_param[':mall_name']=$v['mall_name'];
					$chk_param[':ori_goodsnm']=$v['ori_goodsnm'];
					$chk_param[':receiver']=$v['receiver'];
					$chk_param[':dupl_key']=$v['dupl_key'];
					$chk_res=$db->query($chk_qry,$chk_param);
					
					if($chk_res->count!=0){
						$order_dupli[]=$v['ordno']."  중복주문으로 미처리됨";
					}else{
						$v['buyer'] = addslashes($v['buyer']);
						$v['receiver'] = addslashes($v['receiver']);
						$v['address'] = addslashes($v['address']);
						$v['order_memo'] = addslashes($v['order_memo']);

						foreach($arr_make_qry as $mv)$qry_str[]=":".$mv.$k;
						foreach($arr_make_qry as $mv)$var_str[":".$mv.$k]=$v[$mv];	
						
						$qry="insert into order_list (".implode(",",$arr_make_qry).")values(".implode(",",$qry_str).")";
						$db->query($qry,$var_str);

						$loop_cnt++;
					}
				}

				/*업로드 후 처리 */
				/*주문수량만큼 재고가 있는지 확인.*/
				$qry="select goodsnm,sum(order_num) sumN from order_list 
				where reg_date=curdate()
				and step in('".implode("','",$order_before_stock_step)."')
				and step2<40
				#and step_fixed=0
				group by goodsnm";
				$res=$db->query($qry);
				foreach($res->results as $v){
					$arr_goodsnm[]=$v['goodsnm'];
					$goods_order_num[$v['goodsnm']]=$v['sumN'];
				}
				
				//발송가능 재고수량
				$res=$GOODS->get_stock_deli_av($arr_goodsnm);

				//주문재고 체크
				foreach($res->results as $v){

					$chk_goods=$GOODS->get_goodsno($v['goodsnm']);
					if(!$chk_goods){
						$order_step='0'; //여긴 조건이 없음
					}else{
						if($goods_order_num[$v['goodsnm']] && $goods_order_num[$v['goodsnm']] <= $v['totstock'])$order_step='1';
						else $order_step='2';
					}
				
					if($order_step=='2'){
						$add_set_step2=",step2=1"; //기본적으로 품절의 스텝2를 1로(입예가 있는것으로 분류) 후에 입예가 없는것을 스텝2를 0으로 돌린다.

						//품절처리된 상품의 로그를 등록한다.
						$ORDER->stock_soldout_log($chk_goods,'0');
					}else{
						$add_set_step2='';
					}

					$upd_qry="update order_list set 
					step='".$order_step."' 
					".$add_set_step2."
					,goodsno='".$chk_goods."'
					where goodsnm='".$v['goodsnm']."' 
					and reg_date=curdate()
					and step_fixed='0'
					and step in('".implode("','",$order_before_stock_step)."')
					";
					$db->query($upd_qry);
				}

				/*묶음 발송상품 분류 */
				$qry="select ordno,mall_no,address,receiver,count(*) cnt from order_list 
				where reg_date=curdate()
				and step in('".implode("','",$order_before_stock_step)."')
				group by ordno,mall_no,address,receiver
				having cnt>1
				";
				$res=$db->query($qry);
				
				foreach($res->results as $v){
					$upd_qry="update order_list set bundle='".$v['cnt']."' 
					where ordno='".$v['ordno']."' 
					and mall_no='".$v['mall_no']."' 
					and address='".$v['address']."' 
					and receiver='".$v['receiver']."' 
					and reg_date=curdate()
					and step in('".implode("','",$order_before_stock_step)."')
					";
					$db->query($upd_qry);
				}
				
				$ORDER->sortOrderSoldout();//품절주문 재정렬

				//$db->rollBack();	
				$db->commit();
				
				if($order_dupli){
					msg($loop_cnt.'건 처리되었습니다. (사은품:'.$gift_cnt.'건)');
					tydebug($order_dupli);
					echo "<button type='button' onclick='location.href=\"order_upload.php\"'>확인완료</button>";
				}else{
					msg($loop_cnt.'건 처리되었습니다. (사은품:'.$gift_cnt.'건)','order_upload.php');
				}
				
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}				
		}
	}



}
?>
