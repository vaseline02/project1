<?
include "../_header.php";

$page_title='CS관리';
$formType='cs';

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 


//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();


/**
 * s_mall_no : 몰번호
 * s_receiver : 고객명
 * s_invoice : 송장번호
 * s_date : 주문일자 (시작)
 * e_date : 주문일자 (종료)
 * s_mall_goodsnm : 모델명
 * s_ordno : 주문번호
 */

if($_GET['s_receiver']) $add_where[]=nameMasking($_GET['s_receiver']);
if(count($_GET['s_mall_no']))$add_where[]="ol.mall_no in ('".implode("','",$_GET['s_mall_no'])."')";
if($_GET['s_mobile'])$add_where[]="concat(ol.buyer_mobile,' ',ol.mobile) like '%".$_GET['s_mobile']."%' ";
//if($_GET['s_mobile'])$add_where[]="(ol.buyer_mobile like '%".$_GET['s_mobile']."%' or ol.mobile like '%".$_GET['s_mobile']."%')";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ol.reg_date between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
if($_GET['s_mall_goodsnm'])$add_where[]="ol.mall_goodsnm like '%".$_GET['s_mall_goodsnm']."%' ";
if($_GET['s_invoice'])$add_where[]="concat(ol.invoice,ci.return_invoice) like '%".$_GET['s_invoice']."%' ";
if($_GET['s_ordno'])$add_where[]="ol.ordno like '%".$_GET['s_ordno']."%' ";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
if($_GET['s_ing_type']!='')$add_where[]="ci.ing_type = '".$_GET['s_ing_type']."' ";
/*
if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
*/
if($_GET && count($add_where)){
	/*리스트*/
	$_GET[page_num]=100;
	$_GET[sort]="ol.no desc";
	$field="ol.*,g.goodsnm,b.brand_img_folder, ci.no as cno, ci.return_type, ci.return_type_sub, ci.ing_type, ci.admin_no, ci.return_invoice, m.id, m.name";
	$db_table="order_list ol 
    left join goods g on (ol.goodsno=g.no) 
	left join brand b on g.brandno = b.no	
	left join cs_info ci on (ci.no=(select cs_info_no from cs_detail where order_list_no=ol.no and order_no=ol.ordno and goods_no=ol.goodsno order by no desc limit 1))
	left join member m on (m.no=ci.admin_no)";
	$pg = new page($_GET[page],$_GET[page_num],$no_limit);
	$pg->field = $field;
	$pg->setQuery($db_table,$add_where,$_GET[sort]);

	$pg->exec();
	$qry=$pg->query;

	$res = $db->query($qry);
/*
    $qry="select ol.*,g.goodsnm,b.brand_img_folder, ci.no as cno, ci.return_type, ci.ing_type, ci.admin_no, ci.return_invoice, m.id, m.name from order_list ol 
    left join goods g on (ol.goodsno=g.no) 
	left join brand b on g.brandno = b.no	
	left join cs_info ci on (ci.no=(select cs_info_no from cs_detail where order_list_no=ol.no and order_no=ol.ordno and goods_no=ol.goodsno order by no desc limit 1))
	left join member m on (m.no=ci.admin_no)
    where 1=1 ".$add_where." ";
	$res = $db->query($qry);
	*/
	$bf_ordno='';
	$color_key=0;
	foreach($res->results as $v){

		if($bf_ordno!=$v['ordno']){
			$bf_ordno=$v['ordno'];
			$color_key++;
		}
		$v['line_color']="table_tr".$color_key%2;

		$v['delivery_name']=mb_substr($delivery_list[$v['courier_code']]['name'],0,2,'utf-8');
		//cs접수별 쿼리
		$dloop="";
		if($v['cno']){
			$dqry="select * from cs_detail cd 
			left join cs_info ci on (cd.cs_info_no=ci.no)
			left join member m on (m.no=ci.admin_no)
			where cd.order_list_no='".$v['no']."' order by ci.reg_date desc limit 1";
			$dres=$db->query($dqry);
			foreach($dres->results as $dv){
				$dloop[]=$dv;
			}			
			$v['cs_detail']=$dloop;
		}
		
		// tydebug($dloop);

        if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        
		if($v['bundle']>0)$v['bundle_color']="red";
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
		if(isset($v['ing_type'])) $v['ing_type']=$cfg_ing_type[$v['ing_type']];
		$loop[]=$v;
	}

	$tpl->assign(array(	
	'loop' => $loop
	,'pg'=> $pg	
	));
}
foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}

$selected['ing_type'][$_GET['s_ing_type']]="selected";

$tpl->assign(array(	
	'mall_list' => $mall_list
	,'delivery_list'=>$delivery_list
));
    
$tpl->print_('tpl');
?>
