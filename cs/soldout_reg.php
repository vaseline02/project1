<?
include "../_header.php";

$page_title='품절관리';

$popup_chk=1; //메뉴 컨트롤
$no=$_GET['no'];
$ordno=$_GET['ordno'];
$mall_no=$_GET['mall_no'];
$view_type=$_GET['view_type'];
$order_list_no=$_GET['order_list_no'];
//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

if(!$ordno || !$mall_no){
    msg('잘못된 접근입니다.','close');
}
if($_POST['mode']=="cancel"){
    try
    {
        $db->beginTransaction();
        
        //발송대기재고 원복
        hold_return($ordno);

        //원주문건 주문취소
        $sql="update order_list set step2='141', mod_date=now() where ordno='".$ordno."'";
        $db->query($sql);        
        
        //cs등록
        cs_ins($ordno, '80', '0', $_POST['contents']);

        $db->commit();
        //$db->rollBack();

        MsgViewCloseReload("취소 되었습니다.");	
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"soldout_reg.php?".$_POST['return_url']);
    }  
}else if($_POST['mode']=="neworder"){
    try
    {
        $db->beginTransaction();
        
        //발송대기재고 원복
        hold_return($ordno);

        //cs등록
        $csno=cs_ins($ordno, '80', '0', $_POST['contents'], $_POST['receiver'], $_POST['zipcode'], $_POST['address'], $_POST['mobile']);

        //원주문건 주문취소
        $sql="update order_list set step2='141', mod_date=now() where ordno='".$ordno."'";
        $db->query($sql);        

        //품절 detail
        if(count($_POST['order_list_no'])){
            $dqr="order_list_no=:order_list_no
            ,order_no=:order_no
            ,cs_info_no=:cs_info_no
            ,goods_no=:goods_no
            ,mall_no=:mall_no
            ,mall_goodsnm=:mall_goodsnm
            ,exchange_goods_no=:exchange_goods_no
            ,exchange_goods_nm=:exchange_goods_nm
            ,exchange_goods_num=:exchange_goods_num
            ,exchange_stock_yn=:exchange_stock_yn
            ,diff_price=:diff_price
            ";
            foreach($_POST['order_list_no'] as $k=>$v){
                $dparam=array(
                    ":order_list_no"=>$v
                    ,":order_no"=>$ordno
                    ,":cs_info_no"=>$csno
                    ,":goods_no"=>$_POST['goods_no'][$v]
                    ,":mall_no"=>$_POST['mall_no'][$v]
                    ,":mall_goodsnm"=>$_POST['mall_goodsnm'][$v]
                    ,":exchange_goods_no"=>$_POST["exchange_goods_no"][$v]
                    ,":exchange_goods_nm"=>$_POST["exchange_goods_nm"][$v]
                    ,":exchange_goods_num"=>$_POST["exchange_goods_num"][$v]
                    ,":exchange_stock_yn"=>$_POST["exchange_stock_yn"][$v]
                    ,":diff_price"=>$_POST['diff_price'][$v]
                );	
                    
                $qry="insert into cs_detail set
                ".$dqr."
                ,send_type=:send_type
                ,reg_date=now()
                ";	
                $dparam[':send_type']=$_POST['send_type']?$_POST['send_type']:"0";

                if($res=$db->query($qry,$dparam)){
                    $lastNo=$res->lastId;
                
                    $codedata=get_codedata('place','1'); 
                    $deli_codeno='0';
                    foreach($codedata as $cv){
                        $tmp = now_stock($_POST["exchange_goods_no"][$v],array($cv['no']));
                        
                        if($tmp['codeno_'.$cv['no']] && $tmp['codeno_'.$cv['no']] >=$_POST["exchange_goods_num"][$v]  ){
                            $deli_codeno=$cv['no']; 
                            break;
                        }
                    }
                    
                    if($deli_codeno || $_POST["exchange_stock_yn"][$v]=='n'){ //발송대기($cfg['hold_loc']) 로 재고를 이동                             
                        $okd=stock_io('cs_hold',$_POST["exchange_goods_no"][$v],$_POST["exchange_goods_nm"][$v],-$_POST["exchange_goods_num"][$v],$lastNo,$_SERVER['REQUEST_URI'],$deli_codeno,$cfg['hold_loc'],$_POST["exchange_stock_yn"][$v]);
                        $okd=stock_io('cs_hold',$_POST["exchange_goods_no"][$v],$_POST["exchange_goods_nm"][$v],$_POST["exchange_goods_num"][$v],$lastNo,$_SERVER['REQUEST_URI'],$cfg['hold_loc'],$deli_codeno,$_POST["exchange_stock_yn"][$v]);
                    }else{
                        throw new Exception('주문재고부족 : '.$v." ".$_POST["exchange_goods_no"][$v].":".$_POST["exchange_goods_nm"][$v], 1); 
                        //재고가 있는 발송위치 ( $deli_codeno ) 가 없을 수 없기때문에 이부분은 필요없을듯( step=1 인것을 쿼리한것이기때문에 이미 재고유무 체크가 된것)
                    }
                
                }else{
                    throw new Exception('정상처리되지 않았습니다.', 1);
                }    
            }

        }

        $db->commit();
        MsgViewCloseReload("재주문 되었습니다.");
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"soldout_reg.php?".$_POST['return_url']);
    }  
    
}else if($_POST['mode']=="memo"){
    try
    {
        $db->beginTransaction();
                
        //cs등록
        cs_ins($ordno, '6', '1', $_POST['contents']);

        $db->commit();
        //$db->rollBack();

        msg("접수내용이 등록되었습니다.","soldout_reg.php?".$_POST['return_url']);
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"soldout_reg.php?".$_POST['return_url']);
    }  
}

function hold_return($ordno){
    global $db;

    //재고 돌리기
    $sql="select * from 
    stock_io_log sil where sil.reference_no in (select concat(no) from order_hold_list ohl where ohl.ordno='".$ordno."' and ohl.close_yn='n' group by ohl.order_list_no ) 
    and sil.io_type='order_hold'
    ";
    
    $res=$db->query($sql);
    foreach($res->results as $v){
        stock_io('order_hold_cancel',$v["goodsno"],$v["goodsnm"],$v["cnt"],$v['reference_no'],$_SERVER['REQUEST_URI'],$v['loc_b'],$v['loc_f']);
        $uSql="update order_hold_list set close_yn='y' where no='".$v['reference_no']."' and ordno='".$ordno."'";
        $db->query($uSql);
    }
    
}

function cs_ins($order_no, $return_type, $return_type_sub, $contents, $receiver='', $zipcode='', $address='', $mobile=''){
    global $db;

    $param=array(
        ":order_no"=>$order_no
        ,":return_type"=>$return_type
        ,":return_type_sub"=>$return_type_sub
        ,":contents"=>$contents
        ,":receiver"=>$receiver      
        ,":zipcode"=>$zipcode        
        ,":address"=>$address        
        ,":mobile"=>$mobile        
        ,":admin_no"=>$_SESSION["sess"]["m_no"]
        ,":admin_name"=>$_SESSION["sess"]["name"]
    );	
    
    $qry="insert into cs_info set
        order_no=:order_no
        ,return_type=:return_type
        ,return_type_sub=:return_type_sub
        ,contents=:contents
        ,receiver=:receiver
        ,zipcode=:zipcode
        ,address=:address
        ,mobile=:mobile
        ,admin_no=:admin_no
        ,admin_name=:admin_name
        ,reg_date=now()
        ";

    $res=$db->query($qry,$param);

    $lastNo=$res->lastId;

    return $lastNo;

}

if($view_type){
    $oi_no=" and ol.no = '".$order_list_no."'";
    $cs_info_no=" and ci.no in (select cs_info_no from cs_detail where order_list_no='".$order_list_no."') ";
    $as_info_no=" and ai.no in (select info_no from as_detail where order_list_no='".$order_list_no."') ";
}

/*기본주문정보*/
$qry="select * from order_list ol
where ol.ordno='".$ordno."' and ol.mall_no='".$mall_no."' ".$oi_no." order by ol.no desc limit 1";
$res = $db->query($qry);
$data=$res->results[0];

$res = $db->query($qry);

/*주문상품리스트*/
$qry="select ol.*,g.goodsnm,g.stock_yn,b.brand_img_folder from order_list ol 
left join goods g on (ol.goodsno=g.no) 
left join brand b on g.brandno = b.no
where ol.step2!='141' and ol.ordno='".$ordno."' and ol.mall_no='".$mall_no."' ".$oi_no." ";
$res = $db->query($qry);
foreach($res->results as $v){
    $codedata=get_codedata('place','1');
     $cntArray="";
     foreach($codedata as $v2){
         $cntArray[]="gcl.codeno_".$v2['no'];        
     }
     if(count($cntArray)) $sumCnt="(".implode("+",$cntArray).") as totalCnt";

    $subQry="select ".$sumCnt." from goods_cnt_loc gcl where gcl.goodsno='".$v['goodsno']."'";
    
    $subRes=$db->query($subQry);
    $v['stock_num']=$subRes->results[0]['totalCnt'];

    if($v['step2']=='0' || $v['step2']=='41'){
        if($v['stock_num']>0){
            $v['soldout']="재고부족(".$v['stock_num'].")";
        }else{
            $v['soldout']="품절";
        }
    } 
    $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
    $goodsList[]=$v;
}


$tpl->assign($data);

/*cs,as 합침 */
$qry="select v.* from (
    select 'cs' as type, ci.no, ci.reg_date, ci.receipt
    from cs_info ci
    where ci.order_no='".$ordno."' ".$cs_info_no."
    union 
    select 'as' as type, ai.no, ai.reg_date, '0' as receipt
    from as_info ai 
    where ai.order_no='".$ordno."' ".$as_info_no."
    union
    select 'sms' as type, sl.no, sl.reg_date, '0' as receipt
    from sms_send_log sl
    where sl.order_no='".$ordno."'    
    ) v 
    order by receipt desc, reg_date desc
    ";
$res=$db->query($qry);

foreach($res->results as $uv){
    
    if($uv['type']=='cs'){
        /*접수내용 */
        $qry="select ci.*, cr.memo as receipt_memo, m.id from cs_info ci
        left join cs_receipt cr on (ci.receipt_no=cr.no)
        left join member m on (ci.admin_no=m.no)
        where ci.no='".$uv['no']."'
        ";
        $res = $db->query($qry);
        $data=$res->results[0];
        
        $dqry="select cd.*, g.goodsnm as g_goodsnm from cs_detail cd 
        left join goods g on (cd.goods_no=g.no)
        where cd.cs_info_no='".$data['no']."'";
        $dres=$db->query($dqry);
        $sendCount='0';
        foreach($dres->results as $dv){
            
            if($dv['send_type']!='1') $sendCount++;
            $data['cs_detail'][]=$dv;
        }

        if($data['ins_type']=='1'){
            $data['ins_color']="background-color:#eecccc;";
        }
        $data['send_count']=$sendCount;
        $data['cs_detail']=$dres->results;

    }else if($uv['type']=='as'){
         /**as접수내용 */
        $aqry="select ai.*
        , ad.*, ad.no as detail_no
        , m.id
        from 
        as_info ai 
        left join as_detail ad on(ai.no=ad.info_no)
        left join member m on (ai.admin_no=m.no)
        where ai.no='".$uv['no']."'";
        $ares=$db->query($aqry);
        $data=$ares->results[0];

        $rqry="select * from as_repair where detail_no='".$data['detail_no']."'";
        $rres=$db->query($rqry);
        foreach($rres->results as $rv){
            $data['as_repair'][]=$rv;
        }

        $data['ex_as']=explode("|",$data['as_contents']);
    }else if ($uv['type']=='sms'){
        /**sms로그 */
        $sqry="select sl.*
        , m.id
        from 
        sms_send_log sl
        left join member m on (sl.admin_no=m.no)
        where sl.no='".$uv['no']."'";

        $sres=$db->query($sqry);
        $data=$sres->results[0];
    }
    $data['type']=$uv['type'];
    $tloop[]=$data;    
}

$tpl->assign(array(
    'loop'=>$loop,
    'tloop'=>$tloop,
    'goodsList'=>$goodsList,
    'delivery_list'=>$delivery_list,
    'mall_list'=>$mall_list
));

$tpl->print_('tpl');
?>
