<?
include "../_header.php";

$page_title='CS관리';

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';
$no=$_GET['no'];
$ordno=$_GET['ordno'];

if(!$no){
    msg('잘못된 접근입니다.','close');
}

if($_POST['mode']){
    
    // try
    // {
    //     $db->beginTransaction();
    //     if(count($_POST['order_list_no'])){
    //         $qr="order_list_no=:order_list_no
    //         ,goods_no=:goods_no
    //         ,return_type=:return_type
    //         ,contents=:contents
    //         ,receiver=:receiver
    //         ,zipcode=:zipcode
    //         ,address=:address
    //         ,mall_goodsnm=:mall_goodsnm
    //         ,mobile=:mobile
    //         ,ing_type=:ing_type
    //         ,admin_no=:admin_no
    //         ,admin_name=:admin_name
    //         ,order_no=:order_no
    //         ,exchange_goods_no=:exchange_goods_no
    //         ,exchange_goods_nm=:exchange_goods_nm
    //         ,exchange_goods_num=:exchange_goods_num
    //         ,diff_price=:diff_price
    //         ,send_type=:send_type
    //         ";
    //         foreach($_POST['order_list_no'] as $k=>$v){
    //             $param=array(
    //                 ":order_list_no"=>$v
    //                 ,":goods_no"=>$_POST['goods_no'][$v]
    //                 ,":return_type"=>$_POST["return_type"]
    //                 ,":contents"=>$_POST["contents"]
    //                 ,":receiver"=>$_POST["receiver"]
    //                 ,":zipcode"=>$_POST["zipcode"]
    //                 ,":address"=>$_POST["address"]
    //                 ,":mall_goodsnm"=>$_POST['mall_goodsnm'][$v]
    //                 ,":mobile"=>$_POST["mobile"]
    //                 ,":ing_type"=>$_POST["ing_type"]
    //                 ,":admin_no"=>$_SESSION["sess"]["m_no"]
    //                 ,":admin_name"=>$_SESSION["sess"]["name"]
    //                 ,":order_no"=>$ordno
    //                 ,":exchange_goods_no"=>$_POST["exchange_goods_no"][$v]
    //                 ,":exchange_goods_nm"=>$_POST["exchange_goods_nm"][$v]
    //                 ,":exchange_goods_num"=>$_POST["exchange_goods_num"][$v]
    //                 ,":diff_price"=>$_POST['diff_price'][$v]
    //                 ,":send_type"=>$_POST['send_type']?$_POST['send_type']:"0"
    //             );	
                
    //             if($_POST['mode']=='ins'){
    //                 $qry="insert into cs_claim set
    //                 ".$qr."
    //                 ,reg_date=now()
    //                 ";	
    //             }else if ($_POST['mode']=='mod'){
    //                 $qry="update cs_claim set
    //                 ".$qr."
    //                 where no=:no
    //                 ";	
    //                 $param[':no']=$_POST['claim_no'];
    //             }

    //             if(!$db->query($qry,$param)){
    //                 throw new Exception('정상처리되지 않았습니다.', 1);
    //             }    
    //         }        
    //     }else{
    //         $qr="return_type=:return_type
    //         ,contents=:contents
    //         ,receiver=:receiver
    //         ,zipcode=:zipcode
    //         ,address=:address
    //         ,mobile=:mobile
    //         ,ing_type=:ing_type
    //         ,admin_no=:admin_no
    //         ,admin_name=:admin_name
    //         ,order_no=:order_no
    //         ,send_type=:send_type
    //         ";
    //         $param=array(
    //             ":return_type"=>$_POST["return_type"]
    //             ,":contents"=>$_POST["contents"]
    //             ,":receiver"=>$_POST["receiver"]
    //             ,":zipcode"=>$_POST["zipcode"]
    //             ,":address"=>$_POST["address"]
    //             ,":mobile"=>$_POST["mobile"]
    //             ,":ing_type"=>$_POST["ing_type"]
    //             ,":admin_no"=>$_SESSION["sess"]["m_no"]
    //             ,":admin_name"=>$_SESSION["sess"]["name"]
    //             ,":order_no"=>$ordno
    //             ,":send_type"=>$_POST['send_type']?$_POST['send_type']:"0"
    //         );	
            
    //         if($_POST['mode']=='ins'){
    //             $qry="insert into cs_claim set
    //             ".$qr."
    //             ,reg_date=now()
    //             ";	
    //         }else if ($_POST['mode']=='mod'){
    //             $qry="update cs_claim set
    //             ".$qr."
    //             where no=:no
    //             ";	
    //             $param[':no']=$_POST['claim_no'];
    //         }
    //         if(!$db->query($qry,$param)){
                
    //             throw new Exception('정상처리되지 않았습니다.', 1);
    //         }            
    //     }
        
    //     $db->commit();
    //     msg("처리되었습니다","cs_reg.php?ordno=".$ordno);	
    // }
    // catch(Exception $e)
    // {
    //     $db->rollBack();

    //     $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
    //     msg($s,"cs_reg.php?ordno=".$ordno);
    // }  
   
}

/*원상품*/
$qry="select cc.*,ol.order_num, ol.invoice, g.goodsnm,b.brand_img_folder, exg.* from cs_claim cc
left join order_list ol on (cc.order_list_no=ol.no)
left join goods g on (ol.goodsno=g.no) 
left join brand b on g.brandno = b.no
left join (
    select  g.no, b.brand_img_folder as exchange_brand_img_folder, g.goodsnm as exchange_goodsnm from goods g 
    left join brand b on (g.brandno = b.no)
    ) exg on (cc.exchange_goods_no=exg.no)
where cc.no='".$no."' ";
$res = $db->query($qry);
$data=$res->results[0];
$data['img_url']=img_url($cfg['img_600_logo'],$data['brand_img_folder'],$data['goodsnm']);
$data['exchange_img_url']=img_url($cfg['img_600_logo'],$data['exchange_brand_img_folder'],$data['exchange_goodsnm']);
$data['return_type_nm']=$cfg_retrun_type[$data['return_type']];

$tpl->assign($data);
$tpl->assign(array(
    'goodsList'=>$goodsList
));

$tpl->print_('tpl');
?>
