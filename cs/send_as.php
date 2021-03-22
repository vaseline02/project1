<?
include "../_header.php";

$page_title='기타발송관리(AS발송)';

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 


//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();


$mode=$_POST["mode"];
$no=$_POST["no"];
$returnUrl=$_POST["returnUrl"]?$_POST["returnUrl"]:"as_list.php";

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();


if($_GET['s_receiver']) $add_where[]="ai.receiver like '%".$_GET['s_receiver']."%'";
if(count($_GET['s_mall_no']))$add_where[]="ad.mall_no in ('".implode("','",$_GET['s_mall_no'])."')";
if($_GET['s_mobile'])$add_where[]="concat(ai.mobile) like '%".$_GET['s_mobile']."%' ";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ad.in_regdate between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
if($_GET['s_goodsnm'])$add_where[]="ad.goodsnm like '%".$_GET['s_goodsnm']."%' ";
if($_GET['s_invoice'])$add_where[]="concat(ad.invoice,ad.send_invoice) like '%".$_GET['s_invoice']."%' ";
if($_GET['s_ordno'])$add_where[]="ad.order_no like '%".$_GET['s_ordno']."%' ";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
$add_where[]="ad.as_status='6'";

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
if(count($add_where)){
	/*리스트*/

    $qry="select ai.*
    , ad.order_list_no, ad.delivery_code, ad.invoice, ad.in_regdate, ad.out_regdate, ad.as_status, ad.brandnm, ad.goodsnm, ad.progress_company
    , g.goodsnm as g_goodsnm
    , b.brand_img_folder
    , m.id, m.name
    , (select id from member mm where mm.no=ai.mod_admin_no) as mod_id
    , (select name from member mm where mm.no=ai.mod_admin_no) as mod_name
    from as_info ai 
    left join as_detail ad on (ai.no=ad.info_no)
    left join order_list ol on (ad.order_list_no=ol.no)
    left join goods g on (ad.goods_no=g.no) 
	left join brand b on (g.brandno = b.no)
	left join member m on (m.no=ai.admin_no)
    where 1=1 ".$add_where." ";
	$res = $db->query($qry);
	
	foreach($res->results as $v){
        if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['g_goodsnm']);
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
        
        //주문번호 매칭 접수건
        if($v['order_list_no']){
            $receipt_type="order";
        //수기 접수건
        }else{
            $receipt_type="hand";
        }
        
		$loop[$receipt_type][]=$v;
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
