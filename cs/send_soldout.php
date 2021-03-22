<?
include "../_header.php";

$page_title='품절관리';
$formType='cs';

$time = time(); 
$s_date_value=$_POST['s_date']?$_POST['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_POST['e_date']?$_POST['e_date']:date("Y-m-d",strtotime("now", $time)); 


//몰명리스트 함수
$mall_list=get_mall_info();

/**
 * s_mall_no : 몰번호
 * s_receiver : 고객명
 * s_invoice : 송장번호
 * s_date : 주문일자 (시작)
 * e_date : 주문일자 (종료)
 * s_mall_goodsnm : 모델명
 * s_ordno : 주문번호
 */
if($_POST['s_receiver']) $add_where[]=nameMasking($_POST['s_receiver']);
if($_POST['s_mall_no'])$add_where[]="ol.mall_no like '%".$_POST['s_mall_no']."%' ";
if($_POST['s_date'] && $_POST['e_date'])$add_where[]="ol.reg_date between '".$_POST['s_date']."' and '".$_POST['e_date']."'";
if($_POST['s_mall_goodsnm'])$add_where[]="ol.mall_goodsnm like '%".$_POST['s_mall_goodsnm']."%' ";
if($_POST['s_invoice'])$add_where[]="ol.invoice like '%".$_POST['s_invoice']."%' ";
if($_POST['s_ordno'])$add_where[]="ol.ordno like '%".$_POST['s_ordno']."%' ";
if($_POST['s_admin'])$add_where[]="(m.id like '%".$_POST['s_admin']."%' or m.name like '%".$_POST['s_admin']."%') ";
if($_POST['s_ing_type']!='')$add_where[]="cc.ing_type = '".$_POST['s_ing_type']."' ";

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
if($_POST && $add_where){
    
	/*리스트*/
    $qry="select ol.*,g.goodsnm,b.brand_img_folder, cc.ing_type, cc.admin_no, m.id, m.name from order_list ol 
    left join goods g on (ol.goodsno=g.no) 
	left join brand b on g.brandno = b.no	
	left join cs_claim cc on (cc.no=(select no from cs_claim where order_list_no=ol.no and order_no=ol.ordno and goods_no=ol.goodsno order by no desc limit 1))
	left join member m on (m.no=cc.admin_no)
    where ol.step2='0' ".$add_where." ";
    $res = $db->query($qry);
	$bf_ordno='';
	$color_key=0;
	foreach($res->results as $v){

		if($bf_ordno!=$v['ordno']){
			$bf_ordno=$v['ordno'];
			$color_key++;
		}
        $v['line_color']="table_tr".$color_key%2;

        if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        
		if($v['bundle']>0)$v['bundle_color']="red";
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
		if(isset($v['ing_type'])) $v['ing_type']=$cfg_ing_step[$v['ing_type']];
		$loop[]=$v;
	}

	$tpl->assign(array(	
    'loop' => $loop
	));
}

$selected['mall_no'][$_POST['s_mall_no']]="selected";
$selected['ing_type'][$_POST['s_ing_type']]="selected";

$tpl->assign(array(	
    'mall_list' => $mall_list
));
    
$tpl->print_('tpl');
?>
