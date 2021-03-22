<?
include "../_header.php";

$page_title='재고보류';

$popup_chk=1; //메뉴 컨트롤

#GET
$goodsno=$_GET['goodsno'];
$order_no=$_GET['order_no'];
$order_list_no=$_GET['order_list_no'];

#POST
$mode=$_POST['mode'];
$goodsnm=$_POST['goodsnm'];
$cnt=$_POST['cnt'];
$memo=$_POST['memo'];
$no=$_POST['no'];


#상품정보
$qry="select * from goods g where g.no='".$goodsno."'";
$res=$db->query($qry);
$gdata=$res->results[0];

if($mode=="ins"){
    try
    {
        $db->beginTransaction();
            
        $codedata=get_codedata('place','1'); 
        $deli_codeno='0';
        foreach($codedata as $cv){
            $tmp = now_stock($goodsno,array($cv['no']));
            
            if($tmp['codeno_'.$cv['no']] && $tmp['codeno_'.$cv['no']] >=$cnt  ){
                $deli_codeno=$cv['no']; 
                break;
            }
        }

        $qry="insert into stock_hold set 
        order_no=:order_no
        ,order_list_no=:order_list_no
        ,goodsno=:goodsno
        ,goodsnm=:goodsnm
        ,cnt=:cnt
        ,memo=:memo
        ,reg_date=now()";

        $param[":order_no"]=$order_no;
        $param[":order_list_no"]=$order_list_no;
        $param[":goodsno"]=$goodsno;
        $param[":goodsnm"]=$goodsnm;
        $param[":cnt"]=$cnt;
        $param[":memo"]=$memo;

        if($res=$db->query($qry,$param)){
            $lastNo=$res->lastId;

            stock_io('stock_hold',$gdata['no'],$gdata['goodsnm'],-$cnt,$lastNo,$_SERVER['REQUEST_URI'],$deli_codeno,'127');
            stock_io('stock_hold',$gdata['no'],$gdata['goodsnm'],$cnt,$lastNo,$_SERVER['REQUEST_URI'],'127',$deli_codeno);
        }else{
            throw new Exception('정상처리되지 않았습니다.', 1);
        }    
        $db->commit();
       
        msg("등록되었습니다","stock_hold.php?".$_POST['return_url']);	

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"stock_hold.php?".$_POST['return_url']);
    }  
}else if($mode=='mod'){
    try
    {
        $db->beginTransaction();
            
        $qry="update stock_hold set 
        status='1'
        where no=:no";
        
        $param[":no"]=$no;
        $db->query($qry,$param);

        $lqry="select * from stock_io_log sil where io_type='stock_hold' and reference_no=:no";

        if($res=$db->query($lqry,$param)){
            foreach($res->results as $v){
                stock_io('stock_hold_cancel',$v["goodsno"],$v["goodsnm"],$v["cnt"],$v["reference_no"],$_SERVER['REQUEST_URI'],$v['loc_b'],$v['loc_f']);
            }
        }else{
            throw new Exception('정상처리되지 않았습니다.', 1);
        }    
        $db->commit();
       
        msg("해제되었습니다","stock_hold.php?".$_POST['return_url']);	

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"stock_hold.php?".$_POST['return_url']);
    }  
}

#재고홀딩정보
$qry="select sh.*, b.brandnm, b.brand_img_folder from stock_hold sh
left join goods g on (sh.goodsno=g.no)
left join brand b on (g.brandno=b.no)
where 1 and sh.goodsno='".$goodsno."' and sh.status='0'
order by sh.reg_date desc";
$res = $db->query($qry);
foreach($res->results as $v){
    $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
    $loop[]=$v;    
}   

$tpl->assign($gdata);
$tpl->assign(array(
    'loop'=>$loop
));

$tpl->print_('tpl');

?>