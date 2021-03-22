<?
include "../_header.php";

$page_title='주문확인';

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("0 day", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

//몰정보
$mall_info=get_mall_info('y');

foreach($mall_info as $v){
	$arr_mall[$v['upload_form_type']][]=$v['mall_name'];
}

if($_GET['chasu'])$add_where[]="ol.cha_su ='".$_GET['chasu']."'";
if($_GET['s_mall'])$add_where[]="ol.upload_form_type like '%".$_GET['s_mall']."%' ";
if($_GET['s_ordno'])$add_where[]="ol.ordno like '%".$_GET['s_ordno']."%' ";
if($_GET['s_date'] && $_GET['e_date']){
    $add_where[]="ol.reg_date between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
}else{
	$add_where[]="ol.reg_date between '".$s_date_value."' and '".$e_date_value."'";
}

if($_GET){
    /*리스트*/
    $_GET[page_num]=100;
	$_GET[sort]='invoice,ordno';
	$field="ol.*".$cfg_select_gcl;
	$db_table="order_list ol join mall_list ml on ol.mall_no=ml.no left join goods_cnt_loc gcl on (ol.goodsno=gcl.goodsno)";

	$pg = new page($_GET[page],$_GET[page_num],$no_limit);
    $pg->field = $field;
	$pg->setQuery($db_table,$add_where,$_GET[sort]);
    $pg->exec();
	$qry=$pg->query;
	$res = $db->query($qry);

	foreach($res->results as $v){
		
        if($v['courier_code']){
            $delivery_qry="select name from delivery_info di where di.code='".$v['courier_code']."'";
            $delivery_res=$db->query($delivery_qry);
            $v['delivery_name']=$delivery_res->results[0]['name'];
        }
		$v['place_name']=$place_name[$v['deli_codeno']];

		$v['ent_name']=$v['mall_name'];
		if($v['mall_name']!=$v['upload_form_type'])$v['ent_name'].=" ".$v['upload_form_type'];

		//if($v['code1']!=$v['goodsnm'])$v['color']="style='color:red'";


		//주문단계,링크로드
		$order_step_view=order_step_view($v);

		$v['step_lv']=$order_step_view['step_lv'];
		$v['step_lv_link']=$order_step_view['step_lv_link'];



		if($v['step2']>40){
			$v['position']='취소';
		}else if(in_array($v['step'],array('4','5','6')) ){
			if($v['invoice']){
				$v['position']=$v['invoice'];
			}else{
				if($v['step']=='6'){
					$v['position']='외부발송';
				}else if($v['deli_codeno']=='1'){
					$v['position']='발송확정목록(사무실)';
				}else if($v['deli_codeno']=='125'){
					$v['position']='발송확정목록(원마케팅)';	
				}else{
					$v['position']='발송확정목록(3자물류)';	
				}
			}
		}else if(in_array($v['step'],array('8'))){
			$v['position']='보류';	
			$v['admin_memo']=$v['memo'];
		}else if( $v['step']=='2'){
			
			if(($v['codeno_1']+$v['codeno_3']+$v['codeno_51']+$v['codeno_91']+$v['codeno_125']==0)){
				$v['position']='품절';	
			}else{
				if($v['step2']==0){
                    if(($v['codeno_1']+$v['codeno_51']+$v['codeno_91']+$v['codeno_125']==0)){
                        $v['position']='입고예정';	
                    }else{
                        $v['position']='품절과 묶음';	
                    }
				}else if($v['step2']==1){
                    //입고예정에만 재고가있을경우 입고예정
                    if(($v['codeno_1']+$v['codeno_51']+$v['codeno_91']+$v['codeno_125']==0)){
                        $v['position']='입고예정';	
                    }else{
                        $v['position']='입고예정과 묶음';	
                    }					
				}
			}
		}else if( $v['step']=='3'){
			$v['position']='발송대기';
		}else{
			$v['position']='';
		}


		$loop[]=$v;
	}

	$tpl->assign(array(	
	'loop' => $loop
	,'pg' => $pg
	));
}
$selected['s_mall'][$_GET['s_mall']]="selected";

$tpl->print_('tpl');
?>
