<?
include "../_header.php";

$s_mall=$_GET['s_mall'];

/*리스트*/

tydebug($_GET);
tydebug($_POST);

$delivery_info=get_delivery_info();


//tydebug1($_GET);

if($_GET['chasu']>0){
	$add_where="and o.cha_su=:cha_su"; 
	$param[':cha_su']=$_GET['chasu'];
}

if($s_mall){
	$add_where.=" and  o.upload_form_type=:upload_form_type"; 
	$param[':upload_form_type']=$s_mall;
}

if($_GET['deli_comp']=='1'){
	$add_where="and o.step=:deli_comp"; 
	$param[':deli_comp']='5';
}


if($_GET['xls_type']>0)$add_where.=" and o.step in ('2','3','8')";

$qry="select o.*,ml.mall_code,b.brandnm,gcl.*,g.goodsnm_sub 
,(codeno_1+codeno_51+codeno_87+codeno_91+codeno_125) deli_stock
from order_list o
left join mall_list ml on o.mall_no=ml.no
left join goods g on g.no = o.goodsno
left join brand b on b.no = g.brandno
left join goods_cnt_loc gcl on gcl.goodsno=o.goodsno

where 1
and o.reg_date between :s_date and :e_date
".$add_where."
order by o.mall_name,o.ordno
";

$param[':s_date']=$_GET['s_date'];
$param[':e_date']=$_GET['e_date'];


$res = $db->query($qry,$param);
tydebug($qry);
foreach($res->results as $v){

	$v = infoMasking($v, 'order_list'); //마스킹

	if($v['bundle']>0)$v['color']='#729bda';
	$v['ent_name']=$v['mall_name'];
	if($v['mall_name']!=$v['upload_form_type'])$v['ent_name'].=" ".$v['upload_form_type'];

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
		if($v['step2']==0){
			if(($v['deli_stock']<$v['order_num'])){
				$v['position']='품절';	
			}else{
				$v['position']='품절과 묶음';	
			}
		}else if($v['step2']==1){
			//입고예정에만 재고가있을경우 입고예정
			if(($v['deli_stock']<$v['order_num'])){
				$v['position']='입고예정';	
			}else{
				$v['position']='입고예정과 묶음';	
			}					
		}	
		/*
		if(($v['codeno_1']+$v['codeno_3']+$v['codeno_51']+$v['codeno_91']+$v['codeno_125']==0)){
			$v['position']='품절';	
		}else{
			if($v['step2']==0){
				if(($v['codeno_1']+$v['codeno_51']+$v['codeno_91']+$v['codeno_125']==0)){
					$v['position']='품절';	
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
		*/
	}else if( $v['step']=='3'){
		$v['position']='발송대기';
	}else{
		$v['position']='';
	}

	$loop[]=$v;
}

tydebug(count($loop));

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>