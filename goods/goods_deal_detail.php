<?
include "../_header.php";

$page_title='딜상품등록';


$codedata=get_codedata('place');
asort($codedata);

$viewmode=$_GET['viewmode'];

if($viewmode!='cal')$popup_chk=1; //메뉴 컨트롤
else $popup_chk2=1;

$GOODS=NEW goods();
$QUERY_STRING = $_SERVER['QUERY_STRING'];

function deal_log($no, $goodsno, $a_price){
	global $db;

	$qry="select price from goods_deal_detail where no='".$no."'";
	$res=$db->query($qry);
	$b_price=$res->results[0]['price'];
	if(($b_price!=$a_price) && $a_price){
		$iqry="insert into goods_deal_log set
		detail_no='".$no."'
		,b_price='".$b_price."'
		,a_price='".$a_price."'
		,admin_no='".$_SESSION['sess']['m_no']."'
		,reg_date=now()
		,goods_no='".$goodsno."'
		,info_no='".$_GET['no']."'
		";
		$db->query($iqry);
	}
}

if($_FILES){
	if($_POST['mode']=='excel_ins'){
		$excel_data=excel_read('unlink','2');

		//데이터 검증
		if(count($excel_data)>0){
			foreach($excel_data as $k=>$v){			
				$gqry="select no from goods g where goodsnm='".$v[0]."'";
				$gres=$db->query($gqry);
				$gno=$gres->results[0]['no'];

				if(!$gno){
					$err_msg[]=$k."번열 모델이 존재하지않습니다.";	
				}else{
					$goodschk[$gno]++;

					if($goodschk[$gno]>1) $err_msg[]="(".$v[0].") 상품이 중복입력 되어있습니다.";		
				}
				if(!$v['1'])$err_msg[]=$k."번열 수량이 존재하지않습니다.";			
			}

			if (!sizeof($err_msg)) {
				try{
					
					$db->beginTransaction();

					//삭제후 재등록
					$dqry="delete from goods_deal_detail where info_no='".$_GET['no']."'";
					$db->query($dqry);
					
					foreach($excel_data as $k=>$v){			
						$gqry="select no from goods g where goodsnm='".$v[0]."'";
						$gres=$db->query($gqry);
						$gno=$gres->results[0]['no'];

						$cost=$GOODS->avg_price($gno);

						$iqry="insert into goods_deal_detail set
						info_no='".$_GET['no']."'
						,goodsno='".$gno."'
						,goodsnm='".$v[0]."'
						,quantity='".$v[1]."'
						,cost='".$cost."'
						,price='".$v[2]."'
						,comm='".$v[3]."'
						,coupon_rate='".$v[4]."'
						,memo='".$v[5]."'
						,stock_memo='".$v[6]."'
						,admin_no='".$_SESSION['sess']['m_no']."'
						,reg_date=now()
						";
						$db->query($iqry);
					}
					
					//컨펌 초기화
					$uqry="update goods_deal_info set 
					confirm_admin_no='0'
					,confirm_date=''
					where no='".$_GET['no']."'
					";
					$db->query($uqry);

					//$db->rollBack();
					$db->commit();
				   
					MsgReload('처리되었습니다.','goods_deal_detail.php?'.$QUERY_STRING);
				}
				catch( Exception $e ){
					tydebug('err');
					$db->rollBack();
					tydebug($e->getMessage().":".$e->getFile());	
				}
			}
		}
	}else if($_POST['mode']=='excel_mod'){
		$excel_data=excel_read('unlink','2');

		//데이터 검증
		if(count($excel_data)>0){
			foreach($excel_data as $k=>$v){			
				$gqry="select no, goodsno from goods_deal_detail gdi where info_no='".$_GET['no']."' and goodsnm='".$v[1]."'";
				$gres=$db->query($gqry);
				$gno[$k]=$gres->results[0]['no'];
				$goodsno[$k]=$gres->results[0]['goodsno'];
				if(!$gno[$k]){
					$err_msg[]=$k."번열 모델이 존재하지않습니다.";	
				}
			}

			if (!sizeof($err_msg)) {
				try{
					
					$db->beginTransaction();

					foreach($excel_data as $k=>$v){		

						//로그
						//if($v['26']) deal_log($gno[$k], $goodsno[$k], $v['24']);

						$uqry="update goods_deal_detail set 
						leader_memo='".$v['25']."'
						,leader_admin_no='".$_SESSION['sess']['m_no']."'
						,change_price='".$v['26']."'		
						,price='".$v['26']."'
						where info_no='".$_GET['no']."' and goodsnm='".$v[1]."'";

						$db->query($uqry);
						
					}
					

					//$db->rollBack();
					$db->commit();
				   
					MsgReload('처리되었습니다.','goods_deal_detail.php?'.$QUERY_STRING);
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



if($_POST['mode']=="mod"){
	try{				
		$db->beginTransaction();

		foreach($_POST['deal_no'] as $v){
			//로그
			if($_POST['change_price'][$v]) deal_log($v, $_POST['goods_no'][$v], $_POST['change_price'][$v]);
			$uqry="update goods_deal_detail set 
			leader_memo='".$_POST['leader_memo'][$v]."'
			,change_price='".$_POST['change_price'][$v]."'
			,price='".$_POST['change_price'][$v]."'
			,leader_admin_no='".$_SESSION['sess']['m_no']."'
			where no='".$v."'
			";
			$db->query($uqry);
		}
		//$db->rollBack();
		$db->commit();
	   
		msg('수정 처리되었습니다.','goods_deal_detail.php?'.$QUERY_STRING);
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage().":".$e->getFile());	
	}	

}else if($_POST['mode']=="confirm"){
	$uqry="update goods_deal_info set 
	confirm_admin_no='".$_SESSION['sess']['m_no']."'
	,confirm_date=now()
	where no='".$_GET['no']."'
	";
	$db->query($uqry);

	MsgReload('확인 처리되었습니다.','goods_deal_detail.php?'.$QUERY_STRING);

}else if($_POST['mode']=="info_mod"){

	$deal_color=($_POST['deal_type']==1)?"important":"success";

	$qry="update goods_deal_info set
	location='".$_POST['location']."'
	,deal_type='".$_POST['deal_type']."'
	,deal_color='".$deal_color."'
	,sales_target='".$_POST['sales_target']."'
	,s_date='".$_POST['s_date']."'
	,e_date='".$_POST['e_date']."'
	,delivery_type='".$_POST['delivery_type']."'
	,delivery_chk_price='".$_POST['delivery_chk_price']."'
	,delivery_price='".$_POST['delivery_price']."'
	,event_url='".$_POST['event_url']."'
	,etc='".$_POST['etc']."'
	,deal_name='".$_POST['deal_name']."'
	,admin_no='".$_SESSION['sess']['m_no']."'
	where no='".$_POST['no_mod']."'
	";

	$db->query($qry);
	msg('처리되었습니다.');
}

//info
$qry="select gdi.*,ml.mall_name, ml.upload_form_type from goods_deal_info gdi
join mall_list ml on gdi.mall_no=ml.no
where gdi.no='".$_GET['no']."' ";
$res=$db->query($qry);
$info=$res->results['0'];

$selected['delivery_type'][$info['delivery_type']]='selected';
$selected['deal_type'][$info['deal_type']]='selected';

$qry="select gdi.*,gdd.*, gdd.no as detail_no, g.no as goods_no, g.goodsnm as g_goodsnm, g.img_name, g.order_7day, g.order_15day, g.order_1month, g.order_2month, g.order_3month, gsp.ec_price 
,b.brand_img_folder, b.brandnm
,gcl.*
from goods_deal_info gdi
join goods_deal_detail gdd on (gdi.no=gdd.info_no)
join goods g on (gdd.goodsno=g.no)
join goods_cnt_loc gcl on g.no=gcl.goodsno
left join brand b on g.brandno = b.no
left join goods_sale_period gsp on (gsp.goodsno=g.no)
where gdi.no='".$_GET['no']."'
order by gdd.no asc
";

$res=$db->query($qry);
foreach($res->results as $v){
	$priceChgLog="";

	if($print_xls){
		if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['g_goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['g_goodsnm']);
	}
	
	foreach($psb_stock_loc as $psb_v){
		$v['psb_stock']+=$v[$psb_v];
	}

	$lqry="select * from goods_deal_log where detail_no='".$v['detail_no']."' order by reg_date desc";
	$lres=$db->query($lqry);

	foreach($lres->results as $lv){
		$priceChgLog[]=$lv;
	}
	$v['priceLog']=$priceChgLog;

	$v['now_cost']=$GOODS->avg_price($v['goodsno']);

	$per=round(100-(($v['now_cost']/$v['cost'])*100));
	//등록시 원가와 현재원가가 10프로이상이면
	if($per>'10'){
		$v['per_cost']="<font color='red'>".number_format($v['cost'])."</font>";
	//등록시 원가와 현재원가가 10프로이하이면
	}else if($per<'-10'){
		$v['per_cost']="<font color='blue'>".number_format($v['cost'])."</font>";
	}else{
		$v['per_cost']=number_format($v['cost']);
	}
	$delivery_price="0";

	//조건부배송비
	if($v['delivery_type']=="2"){
		if($v['price']>$v['delivery_chk_price']){
			$delivery_price=$v['delivery_price'];
		}
	//무료배송
	}else if($v['delivery_type']=="1"){
		$delivery_price=3000;
	}

	//수익율 (가격-(가격*수수료)-원가-배송비)/가격
	$v['revenue_per']=($v['price']-($v['price']*$v['comm'])-$v['cost']-$delivery_price)/$v['price'];


	//수익원 (가격-(가격*수수료)-원가-배송비)
	$v['revenue_price']=number_format($v['price']-($v['price']*$v['comm'])-$v['cost']-$delivery_price);
	
	//퍼센트 표시
	$v['comm']=$v['comm']*100;
	$v['revenue_per']=$v['revenue_per']*100;
	$v['coupon_rate']=$v['coupon_rate']*100;

	//제휴몰
	$v['sangsi_price']=$v['ec_price']*1.07; 
	//결과가 30이상이면 -1000원 만원단위까지 반올림. 천원단위까지 반올림. 미만이면 -100
	if($v['sangsi_price']>=300000){
		$round_p=10000;
		$ctl_p=1000;
	}else{
		$round_p=1000;
		$ctl_p=100;
	}
	$v['sangsi_price']=round($v['sangsi_price']/$round_p)*$round_p-$ctl_p; 


	//상품별 가장 최근 승인됐던 딜 정보 
	$qry = "select gdi.no, gdi.confirm_date, (select price from goods_deal_detail where 
	info_no = gdi.no and goodsno=".$v['goodsno'].") as price, ml.upload_form_type, ml.mall_name 
	from goods_deal_info gdi left join mall_list ml on ml.no = gdi.mall_no
	where gdi.no in (select info_no from goods_deal_detail where goodsno = ".$v['goodsno'].")
	and gdi.confirm_date is not null 
	and gdi.confirm_admin_no is not null  
	and gdi.confirm_date != '0000-00-00 00:00:00' 
	and gdi.confirm_admin_no  != 0 
	order by gdi.confirm_date desc limit 1";
	$res=$db->query($qry);
	$past_deal=$res->results['0'];
	if(sizeof($past_deal)){
		$v['past_deal'] = substr($past_deal['confirm_date'], 0, 10)."<br>".$past_deal['upload_form_type']."(".$past_deal['mall_name'].")";
		$v['past_price'] = number_format($past_deal['price']);
	}
	

	$loop[]=$v;

}

$tpl->assign(array(	
'loop' => $loop
,'info' => $info
));

$tpl->print_('tpl');
?>