<?
include "../_header.php";

$page_title='AS상세';
$popup_chk=1; //메뉴 컨트롤

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

$now_date=date("Y-m-d");
/**GET */
$as_no=$_GET['as_no'];

$qry="select ai.*
,ad.*, ad.no as detail_no
,ol.mall_no as order_mall_no, ol.mall_name as order_mall_name, ol.step, ol.step2, ol.mall_goodsnm as order_mall_goodsnm, ol.receiver as order_receiver
,ol.mobile as order_mobile, ol.zipcode as order_zipcode, ol.address as order_address, ol.courier_code as order_courier_code, ol.invoice as order_invoice, ol.reg_date as ol_reg
,g.no as goods_no, g.goodsnm as g_goodsnm,g.stock_yn
,b.brand_img_folder, b.brandnm as b_brandnm
from as_info ai
left join as_detail ad on (ai.no=ad.info_no) 
left join order_list ol on (ad.order_list_no=ol.no)
left join goods g on (ad.goods_no=g.no) 
left join brand b on (g.brandno = b.no)
where ai.no='".$as_no."'
";

$res=$db->query($qry);
foreach($res->results as $v){
    $checked['re_receipt'][$v['re_receipt']]='checked';
    $checked['case_yn'][$v['case_yn']]='checked';
    $checked['action_yn'][$v['action_yn']]='checked';
    $v['ex_as']=explode("|",$v['as_contents']);

    $sqry="select * from as_repair where detail_no='".$v['detail_no']."'";
    $sres=$db->query($sqry);
    foreach($sres->results as $sv){
        $v['repair'][$sv['as_code']]=$sv;
        $v['repair'][$sv['as_code']]['sum_price']+=$sv['as_price']*$sv['as_quantity'];
        $v['vat_price']+=$sv['as_price']*$sv['as_quantity'];
    }

    $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['g_goodsnm']);
    $asData[]=$v;
}   

$tpl->assign(array(
    'asData'=>$asData,
    'delivery_list'=>$delivery_list,
    'mall_list'=>$mall_list
));

    
$tpl->print_('tpl');

?>