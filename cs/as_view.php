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
$mode=$_POST['mode'];

if($mode=="ins"){
    try
    {
        $db->beginTransaction();

                
        $qry="select ai.*
        ,ad.*    
        ,ol.mall_no as order_mall_no, ol.mall_name as order_mall_name, ol.step, ol.step2, ol.mall_goodsnm as order_mall_goodsnm, ol.receiver as order_receiver, ol.ori_ordno
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
        $data=$res->results[0];

      
        // $qr="
        // asno=:asno
        // ,ordno=:ordno
        // ,ori_ordno=:ori_ordno
        // ,mall_name=:mall_name
        // ,mall_no=:mall_no
        // ,bundle='0'
        // ,step=:step
        // ,step2='0'
        // ,ord_date=now()
        // ,reg_date=now()
        // ,mall_goodsnm=:mall_goodsnm
        // ,goodsnm=:goodsnm
        // ,goodsno=:goodsno
        // ,order_num=:order_num
        // ,order_price=:order_price
        // ,settle_price=:settle_price
        // ,order_cost=:order_cost
        // ,buyer=:buyer
        // ,receiver=:receiver
        // ,buyer_mobile=:buyer_mobile
        // ,mobile=:mobile
        // ,zipcode=:zipcode
        // ,address=:address
        // ";
        
        // if($odata['ori_ordno']){
        //     $ordno=$data['ori_ordno'];
        // }else{
        //     $ordno=$data['order_no'];
        // }
        
        // $mall_goodsnm="AS-".$data['order_mall_goodsnm'];
        // $ordno.='mecca-'.$data['order_no'];
        
        // $param[":step"]='4';
        // $param[":asno"]=$as_no;
        // $param[":ordno"]=$ordno;
        // $param[":ori_ordno"]=$data['ori_ordno']; 
        // $param[":mall_name"]=$data['order_mall_name'];
        // $param[":mall_no"]=$data['order_mall_no'];
        // $param[":mall_goodsnm"]=$mall_goodsnm; 
        // $param[":goodsnm"]=$data['goodsnm'];
        // $param[":goodsno"]=$data['goods_no'];
        // $param[":order_num"]='1';
        // $param[":order_price"]=''; 
        // $param[":settle_price"]='';
        // $param[":order_cost"]='';
        // $param[":buyer"]=$data['receiver'];
        // $param[":receiver"]=$data['receiver'];
        // $param[":buyer_mobile"]=$data['mobile']; 
        // $param[":mobile"]=$data['mobile'];      
        // $param[":zipcode"]=$data['zipcode'];      
        // $param[":address"]=$data['address'];      
        
        // $qry="insert into order_list set 
        // ".$qr."
        // ";

        $db->commit();        
        //MsgViewCloseReload("처리되었습니다");	
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"as_reg.php?".$_POST['return_url']);
    }  
}

$qry="select ai.*
,ad.*    
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
    foreach($v['ex_as'] as $ck=>$cv){
        $checked['as_contents'][$cv]='checked';            
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