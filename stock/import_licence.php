<?
include "../_header.php";member_chk();

$page_title='수입면장관리';

$s_res=get_search_where();
$arr_title=array('import_licence'=>'수입면장','invoice'=>'인보이스');

if($_POST){ //수량에 맞는 면장디비 시퀀스 가져오기
	$model_arr = paste_to_arr($_POST['s_paste_mc']);
	$model_arr= array_values($model_arr);

	$arr_bgcolor=array("#fff","#ccc");

	foreach($model_arr as $k=>$v){
		
		$bgcolor=$arr_bgcolor[$k%2];

		$ex_v = explode("^",$v);

		$offer_num[$ex_v[0]]=$ex_v[1];

		//수입면장
		$qry="select il.*,b.brandnm,b.brand_img_folder,c.catenm,g.img_name g_img_name from import_licence il
		#join goods g on g.goodsnm =il.goodsnm
		join goods g on g.no =il.goodsno
		join brand b on g.brandno = b.no
		left join category c on g.cateno = c.no
		where 1
		and il.type='import_licence'
		and g.goodsnm=:goodsnm
		#and il.import_no in('11126-19-020049M','11126-19-030094M')
		order by g.no,il.reg_date desc,il.no desc
		";
	
		$res=$db->query($qry,array(":goodsnm"=>$ex_v['0']));
		
		$goods_cnt=0;
		//$chk_invoice_cnt=$ex_v['1']; //인보이스 마지막장을 수량에 맞게 가져오기 위해서.총 30개가 필요할경우 면장 10 15 40에서  마지막은 5개이상만 가져오면됨. 40개가져올필요없음
		foreach($res->results as $key=>$val){
			
			if($key==0)$val['offer_num']=$offer_num[$ex_v[0]];
			//인보이스 수량 컨트롤 -그냥 40개여도 가져오면되서 주석처리
			/*
			if($chk_invoice_cnt>$val['cnt']){
				$invoice_data[$val['goodsnm']][$val['import_no']]+=$val['cnt'];
				$chk_invoice_cnt-=$val['cnt'];
			}else $invoice_data[$val['goodsnm']][$val['import_no']]+=$chk_invoice_cnt;
			*/
			if($_POST['chk_invoice'])$invoice_data[$val['goodsnm']][$val['import_no']]+=$val['cnt'];

			//if(!$_POST['search_noimg'])$val['img_url']=img_url($glb_img_600_logo,$val['brand_img_folder'],$val['goodsnm']);
			if(!$_POST['search_noimg'])$val['img_url']=img_url($cfg['img_600_logo'],$val['brand_img_folder'],$val['g_img_name'],$val['goodsnm']);
			
			$val['bgcolor']=$bgcolor;
			$loop['import_licence'][$val['no']]=$val;

			$goods_cnt+=$val['cnt']; 
			if($goods_cnt>=$ex_v['1']){
				$model_color['import_licence'][$val['goodsnm']]='';
				break; //수량이 채워지면 다음모델
			}else{
				$model_color['import_licence'][$val['goodsnm']]='red';
			}
			
		}

		//인보이스
		$goods_cnt=0;
		foreach($invoice_data[$ex_v['0']] as $key=>$val){

			$qry="select il.*,b.brandnm,b.brand_img_folder,c.catenm,g.img_name g_img_name from import_licence il
			join goods g on g.no =il.goodsno
			join brand b on g.brandno = b.no
			left join category c on g.cateno = c.no
			where 1
			and il.type='invoice' and import_no=:import_no
			and g.goodsnm=:goodsnm
			order by g.no,il.reg_date desc,il.no desc
			";
			
			$res=$db->query($qry,array(":goodsnm"=>$ex_v['0'],":import_no"=>$key));	
			
			foreach($res->results as $val2){
				if(!$_POST['search_noimg'])$val2['img_url']=img_url($cfg['img_600_logo'],$val2['brand_img_folder'],$val2['g_img_name'],$val2['goodsnm']);

				$val2['bgcolor']=$bgcolor;
				$loop['invoice'][$val2['no']]=$val2;

				$goods_cnt+=$val2['cnt']; 
				if($goods_cnt>=$ex_v['1']){
					$model_color['invoice'][$val2['goodsnm']]='';
					break ; //수량이 채워지면 다음모델			
				}else $model_color['invoice'][$val2['goodsnm']]='red';
			}
			
		}
	}
	if($_POST['chk_invoice']){
		$loop['import_licence'][]=array(''); //중간에 공백 강제로 하나추가
		$checked['chk_invoice']="checked";
	}
}


$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
