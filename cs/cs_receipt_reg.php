<?
include "../_header.php";

$page_title='택배상품접수';
$popup_chk=1; //메뉴 컨트롤

$mode=$_POST["mode"];
$receipt_type=$_POST['receipt_type']?$_POST['receipt_type']:"0";
$receipt_no=$_GET['receipt_no'];
$open_route=$_GET['open_route'];

$return_type=$_POST["return_type"];
$return_type_sub=$_POST["return_type_sub"]?$_POST["return_type_sub"]:"0";
$delivery_code=$_POST["delivery_code"]?$_POST["delivery_code"]:"";
$invoice=$_POST["invoice"]?$_POST["invoice"]:"";
$account_code=$_POST["account_code"]?$_POST["account_code"]:"";
$account_number=$_POST["account_number"]?$_POST["account_number"]:"";
$goodsnm=$_POST["goodsnm"];
$mobile=$_POST["mobile"];
$memo=$_POST["memo"];
$customer_name=$_POST["customer_name"];



//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

if($mode=="ins"){
    try
    {
        //throw new Exception('정상처리되지 않았습니다.', 1);
        $db->beginTransaction();
        
        if($receipt_type){
            
            $sql="insert into cs_receipt set 
            goodsnm=:goodsnm
            ,customer_name=:customer_name
            ,mobile=:mobile
            ,delivery_code=:delivery_code
            ,invoice=:invoice
            ,account_code=:account_code
            ,account_number=:account_number
            ,memo=:memo
            ,return_type=:return_type
            ,return_type_sub=:return_type_sub
            ,status=:status
            ,admin_no=:admin_no
            ,admin_name=:admin_name
            ,receipt_type=:receipt_type
            ,reg_date=now()
            ";
            $iparam[':goodsnm']=$goodsnm;
            $iparam[':customer_name']=$customer_name;
            $iparam[':mobile']=$mobile;
            $iparam[':delivery_code']=$delivery_code;
            $iparam[':invoice']=$invoice;
            $iparam[':account_code']=$account_code;
            $iparam[':account_number']=$account_number;
            $iparam[':memo']=$memo;
            $iparam[':return_type']=$return_type;
            $iparam[':return_type_sub']=$return_type_sub?$return_type_sub:"0";
            $iparam[':status']='0';
            $iparam[':admin_no']=$_SESSION["sess"]["m_no"];
            $iparam[':admin_name']=$_SESSION["sess"]["name"];
            $iparam[':receipt_type']=$receipt_type;

            $res=$db->query($sql, $iparam);
            $lastReceiptNo=$res->lastId;

        }else{
            $no=$_POST["no"];

            $sql="select ol.*, b.brandnm from order_list ol
            left join goods g on (ol.goodsno=g.no) 
            left join brand b on (g.brandno = b.no)
            where ol.no=:no";
            $param[':no']=$no;

            $res=$db->query($sql, $param);
            $orderData=$res->results[0];

            $sql="insert into cs_receipt set 
            order_list_no=:order_list_no
            ,order_no=:order_no
            ,customer_name=:customer_name
            ,goodsnm=:goodsnm
            ,mobile=:mobile
            ,delivery_code=:delivery_code
            ,invoice=:invoice
            ,account_code=:account_code
            ,account_number=:account_number
            ,memo=:memo
            ,return_type=:return_type
            ,return_type_sub=:return_type_sub
            ,status=:status
            ,admin_no=:admin_no
            ,admin_name=:admin_name
            ,receipt_type=:receipt_type
            ,reg_date=now()
            ";
            $iparam[':order_list_no']=$no;
            $iparam[':order_no']=$orderData['ordno'];
            $iparam[':customer_name']=$orderData['receiver'];
            $iparam[':goodsnm']=$orderData['goodsnm'];
            $iparam[':mobile']=$orderData['mobile'];
            $iparam[':delivery_code']=$delivery_code;
            $iparam[':invoice']=$invoice;
            $iparam[':account_code']=$account_code;
            $iparam[':account_number']=$account_number;
            $iparam[':memo']=$memo;
            $iparam[':return_type']=$return_type;
            $iparam[':return_type_sub']=$return_type_sub;
            $iparam[':status']='0';
            $iparam[':admin_no']=$_SESSION["sess"]["m_no"];
            $iparam[':admin_name']=$_SESSION["sess"]["name"];
            $iparam[':receipt_type']=$receipt_type;

            $res=$db->query($sql, $iparam);
            $lastReceiptNo=$res->lastId;
        
            //order_list에 반송장번호 업데이트
            $sql="update order_list set
            return_courier_code=:return_courier_code
            ,return_invoice=:return_invoice
            where no=:no";
            $uparam[':return_courier_code']=$delivery_code;
            $uparam[':return_invoice']=$invoice;
            $uparam[':no']=$no;

            $res=$db->query($sql, $uparam);

        }
        #as접수건일경우 as_info, as_detail 에 등록
        if($return_type=='3') asIns($_POST, $lastReceiptNo, $orderData);

        $db->commit();        
        MsgReload("처리되었습니다","cs_receipt_reg.php");	
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"cs_receipt_reg.php");
    }  
    
}else if($mode=="mod"){
    try
    {
        //throw new Exception('정상처리되지 않았습니다.', 1);
        $db->beginTransaction();
        
        #기존 접수유형
        $bqry="select return_type from cs_receipt where no='".$receipt_no."'";
        $bres=$db->query($bqry);
        $before_return_type=$bres->results[0]['return_type'];

        if($receipt_type){
            $sql="update cs_receipt set 
            goodsnm=:goodsnm
            ,customer_name=:customer_name
            ,mobile=:mobile
            ,delivery_code=:delivery_code
            ,invoice=:invoice
            ,account_code=:account_code
            ,account_number=:account_number
            ,memo=:memo
            ,return_type=:return_type
            ,return_type_sub=:return_type_sub
            where no=:no
            ";
            $iparam[':no']=$receipt_no;
            $iparam[':goodsnm']=$goodsnm;
            $iparam[':customer_name']=$customer_name;
            $iparam[':mobile']=$mobile;
            $iparam[':delivery_code']=$delivery_code;
            $iparam[':invoice']=$invoice;
            $iparam[':account_code']=$account_code;
            $iparam[':account_number']=$account_number;
            $iparam[':memo']=$memo;
            $iparam[':return_type']=$return_type?$return_type:"0";
            $iparam[':return_type_sub']=$return_type_sub?$return_type_sub:"0";
            
            $res=$db->query($sql, $iparam);
        }else{
            $no=$_POST["no"];
            if($no){

                //자동등록 주문에서 매칭해서 등록
                $sql="select ol.*, b.brandnm from order_list ol
                left join goods g on (ol.goodsno=g.no) 
                left join brand b on g.brandno = b.no
                where ol.no=:no";
                $param[':no']=$no;

                $res=$db->query($sql, $param);
                $orderData=$res->results[0];

                $qr=",order_list_no=:order_list_no
                ,order_no=:order_no
                ,customer_name=:customer_name
                ,goodsnm=:goodsnm
                ,mobile=:mobile";

                $iparam[':order_list_no']=$no;
                $iparam[':order_no']=$orderData['ordno'];
                $iparam[':customer_name']=$orderData['receiver'];
                $iparam[':goodsnm']=$orderData['goodsnm'];
                $iparam[':mobile']=$orderData['mobile'];

                //등록되있는 수기 as건 상품정보 업데이트
                $uqry="update as_info set
                order_no=:order_no
                ,order_buy=:order_buy
                where receipt_no=:receipt_no
                ";

                $uparam[":receipt_no"]=$receipt_no;
                $uparam[":order_buy"]=$orderData['mall_name'];
                $uparam[":order_no"]=$orderData['ordno'];

                $db->query($uqry, $uparam);

                unset($uparam);
                $uqry="update as_detail ad set
                order_list_no=:order_list_no
                ,order_no=:order_no
                ,mall_no=:mall_no
                ,mall_name=:mall_name
                ,goods_no=:goods_no
                ,goodsnm=:goodsnm
                ,brandnm=:brandnm
                where info_no=(select no from as_info where receipt_no=:receipt_no order by reg_date desc limit 1)
                ";
                $uparam[":receipt_no"]=$receipt_no;
                $uparam[':order_list_no']=$no;
                $uparam[":order_no"]=$orderData['ordno'];
                $uparam[':mall_no']=$orderData['mall_no'];
                $uparam[':mall_name']=$orderData['mall_name'];
                $uparam[':goods_no']=$orderData['goodsno'];
                $uparam[':goodsnm']=$orderData['goodsnm'];
                $uparam[':brandnm']=$orderData['brandnm'];

                $db->query($uqry, $uparam);
            
                // unset($uparam);
                // //order_list에 반송장번호 업데이트
                // $uqry="update order_list set
                // return_courier_code=:return_courier_code
                // ,return_invoice=:return_invoice
                // where no=:no";
                // $uparam[':return_courier_code']=$delivery_code;
                // $uparam[':return_invoice']=$invoice;
                // $uparam[':no']=$no;

                // $res=$db->query($uqry, $uparam);
            }

            $sql="update cs_receipt set 
            delivery_code=:delivery_code
            ,invoice=:invoice
            ,account_code=:account_code
            ,account_number=:account_number
            ,memo=:memo
            ,return_type=:return_type
            ,return_type_sub=:return_type_sub
            ,receipt_type=:receipt_type
            ".$qr."
            where no=:no
            ";

            $iparam[':no']=$receipt_no;
            $iparam[':delivery_code']=$delivery_code;
            $iparam[':invoice']=$invoice;
            $iparam[':account_code']=$account_code;
            $iparam[':account_number']=$account_number;
            $iparam[':memo']=$memo;
            $iparam[':return_type']=$return_type?$return_type:"0";
            $iparam[':return_type_sub']=$return_type_sub?$return_type_sub:"0";
            $iparam[':receipt_type']=$receipt_type;
            
            $res=$db->query($sql, $iparam);
            
        }
        #as접수건일경우 as_info, as_detail 에 등록
        if($return_type=='3' && $before_return_type!='3') asIns($_POST, $receipt_no, $orderData);

        $db->commit();        
        if($open_route=='as_reg'){
            MsgViewCloseReload("처리되었습니다.");
        }else{
            MsgReload("처리되었습니다","cs_receipt_reg.php?".$_POST['return_url']);	
        }


    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"cs_receipt_reg.php?".$_POST['return_url']);
    }  
}

function asIns($data, $receiptNo, $orderData=''){
    global $db;

    //as info            
    $qr="receipt_name=:receipt_name
    ,receiver=:receiver
    ,mobile=:mobile
    ,memo=:memo
    ,receipt_no=:receipt_no
    ,admin_no=:admin_no
    ,admin_name=:admin_name
    ";
    
    $param=array(
        ":memo"=>$data['memo']
        ,":admin_no"=>$_SESSION["sess"]["m_no"]
        ,":admin_name"=>$_SESSION["sess"]["name"]
        ,":receipt_no"=>$receiptNo
        );	

        
    if($orderData){
        $qr.=",order_no=:order_no
        ,zipcode=:zipcode
        ,address=:address
        ,order_buy=:order_buy
        ,order_reg=:order_reg";

        $param[":order_no"]=$orderData['ordno'];
        $param[":receipt_name"]=$orderData['receiver'];
        $param[":receiver"]=$orderData['receiver'];
        $param[":mobile"]=$orderData['mobile'];
        $param[":zipcode"]=$orderData['zipcode'];
        $param[":address"]=$orderData['address'];
        $param[":order_buy"]=$orderData['mall_name'];
        $param[":order_reg"]=$orderData['reg_date'];
    }else{
        $param[":receipt_name"]=$data['customer_name'];
        $param[":receiver"]=$data['customer_name'];
        $param[":mobile"]=$data['mobile'];
    }

    $qry="insert into as_info set
    ".$qr."
    ,reg_date=now()
    ";	        

    $res=$db->query($qry,$param);
    $lastInfoNo=$res->lastId;

    //as detail     
    $dqr="
    goodsnm=:goodsnm
    ,delivery_code=:delivery_code
    ,invoice=:invoice
    ,in_regdate=:in_regdate
    ,as_status=:as_status
    ,info_no=:info_no
    ";
        
    $dparam=array(
    ":delivery_code"=>$data['delivery_code']
    ,":invoice"=>$data['invoice']
    ,":in_regdate"=>date("Y-m-d", time())    
    ,":as_status"=>'0'
    ,":info_no"=>$lastInfoNo
    );	

    if($orderData){
        $dqr.=",order_no=:order_no
        ,brandnm=:brandnm
        ,mall_no=:mall_no
        ,goods_no=:goods_no
        ,mall_name=:mall_name
        ,order_list_no=:order_list_no";

        $dparam['order_no']=$orderData['ordno'];
        $dparam['brandnm']=$orderData['brandnm'];
        $dparam['goodsnm']=$orderData['goodsnm'];

        $dparam[":goods_no"]=$orderData['goodsno'];
        $dparam[":mall_no"]=$orderData['mall_no'];
        $dparam[":mall_name"]=$orderData['mall_name'];
        $dparam[":order_list_no"]=$orderData['no'];
        
    }else{
        $dparam['goodsnm']=$data['goodsnm'];
    }

    $dqry="insert into as_detail set
    ".$dqr."
    ,reg_date=now()
    ";	
    $dres=$db->query($dqry,$dparam);
    
}

if($_POST['s_receiver']) $add_where[]=nameMasking($_POST['s_receiver']);
if($_POST['s_mobile'])$add_where[]="concat(ol.buyer_mobile,' ',ol.mobile) like '%".$_POST['s_mobile']."%' ";
if($_POST['s_invoice'])$add_where[]="(return_invoice = '".$_POST['s_invoice']."' or invoice = '".$_POST['s_invoice']."')";
if($_POST['s_order_no'])$add_where[]="ol.ordno = '".$_POST['s_order_no']."'";

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}

if($_POST && $add_where){
    $sql="select ol.*,g.goodsnm,b.brand_img_folder from order_list ol 
    left join goods g on (ol.goodsno=g.no) 
    left join brand b on g.brandno = b.no	
    where 1=1 ".$add_where;

    $res=$db->query($sql);
    foreach($res->results as $v){
        
        if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];

        $loop[]=$v;
    }
    $selected['delivery_code'][$loop[0]['return_courier_code']]="selected";
}

if($receipt_no){
    $sql="select cr.goodsnm as receipt_goodsnm, cr.mobile as receipt_mobile, cr.delivery_code as receipt_delivery_code, cr.invoice as receipt_invoice, cr.account_code as receipt_account_code, cr.account_number as receipt_account_number
    , cr.memo as receipt_memo, cr.return_type as receipt_return_type, cr.return_type_sub as receipt_return_type_sub, cr.status as receipt_status, cr.receipt_type, cr.customer_name
    , ol.*,g.goodsnm,b.brand_img_folder from 
    cs_receipt cr 
    left join order_list ol on (ol.no=cr.order_list_no)
    left join goods g on (ol.goodsno=g.no) 
    left join brand b on g.brandno = b.no	
    where cr.no='".$receipt_no."' ";
    $res=$db->query($sql);
    foreach($res->results as $v){
        
        if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
        
        $uloop[]=$v;
    }

    $selected['return_type'][$uloop[0]['receipt_return_type']]="selected";
    $selected['return_type_sub'][$uloop[0]['receipt_return_type_sub']]="selected";
    $selected['account_code'][$uloop[0]['receipt_account_code']]="selected";
    $selected['delivery_code'][$uloop[0]['receipt_delivery_code']]="selected";
}
$tpl->assign(array(	
    'loop' => $loop
    ,'uloop' => $uloop
    ,'mall_list' => $mall_list
    ,'delivery_list'=>$delivery_list
    ,'receipt_no'=>$receipt_no
    ));

$tpl->print_('tpl');
?>
