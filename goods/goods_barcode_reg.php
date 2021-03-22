<?
include "../_header.php";

$page_title='CS관리';

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];
$no=$_GET['no'];

if(!$no){
    msg('잘못된 접근입니다.','close');
}

if($mode){
    
    try
    {
        $db->beginTransaction();
       
        if($mode=='ins'){
            $barcode=$_POST['barcode'];
            $goodsnm=$_POST['goodsnm'];

            $qry="select count(no) as cnt from goods_barcode where barcode='".$barcode."'";
            $res=$db->query($qry);
            $bcnt=$res->results[0]['cnt'];

            if($bcnt>0) msg("등록된 바코드가있습니다.","goods_barcode_reg.php?no=".$no);	
            
            $qry="insert into goods_barcode set 
            barcode=:barcode
            ,goodsno=:goodsno
            ,goodsnm=:goodsnm
            ,reg_date=now()
            ";

            $param[':barcode']=$barcode;
            $param[':goodsno']=$no;
            $param[':goodsnm']=$goodsnm;

            $db->query($qry,$param);

        }else if($mode=='del'){
            $dno=$_POST['dno'];

            if(!$dno)  throw new Exception('정상처리되지 않았습니다.', 1);

            $qry="delete from goods_barcode where no=:no";
            $param[':no']=$dno;
            
            $db->query($qry,$param);
        }
        
        
        $db->commit();
        echo "<script>opener.location.reload();</script>";
        msg("처리되었습니다","goods_barcode_reg.php?no=".$no);	
        
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"goods_barcode_reg.php?no=".$no);
    }  
   
}
/*기본상품정보*/
$qry="select * from goods g
where g.no='".$no."'";
$res = $db->query($qry);
$data=$res->results[0];
/*기본바코드정보*/
$qry="select * from goods_barcode gb
where gb.goodsno='".$no."'";
$res = $db->query($qry);
foreach($res->results as $v){
    $loop[]=$v;    
}
$tpl->assign($data);
$tpl->assign(array(
    'loop'=>$loop,
    'data'=>$data
));

    
$tpl->print_('tpl');
?>
