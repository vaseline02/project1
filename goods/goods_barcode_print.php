<?
include "../_header.php";

$page_title='바코드출력';
$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("now", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

$QUERY_STRING = $_SERVER['QUERY_STRING'];
$mode=$_POST["mode"];
if($mode=="excelupload" && $_FILES){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
            if(!$v['1']){
                $err_msg[]=$k."번열 상품명이 존재하지않습니다.";            
            }else{
                $sqry="select * from goods g where goodsnm='".$v[1]."' ";
                $sres=$db->query($sqry);
                $goodsData=$sres->results[0];
                if(!$goodsData['no'])$err_msg[]=$k."번열 [".$v[1]."] 상품이 존재하지않습니다.";            
            }
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){                    
                    $sqry="select * from goods g where goodsnm='".$v[1]."' ";
                    $sres=$db->query($sqry);
                    $goodsData=$sres->results[0];                   

                    if($goodsData){
                        
                        $sqry="insert into goods_barcode_print set 
                        brandno=:brandno
                        ,goodsno=:goodsno
                        ,goodsnm=:goodsnm
                        ,quantity=:quantity
                        ,memo=:memo
                        ,admin_no=:admin_no
                        ,reg_date=now()
                        ";

                        $param[':brandno']=$goodsData['brandno'];
                        $param[':goodsno']=$goodsData['no'];
                        $param[':goodsnm']=$v[1];
                        $param[':quantity']=$v[3];
                        $param[':memo']=$v[2];
                        $param[':admin_no']=$_SESSION['sess']['m_no'];

                        $db->query($sqry,$param);
                    }
                }
                
				//$db->rollBack();
                $db->commit();
               
				msg('처리되었습니다.',"goods_barcode_print.php?".$QUERY_STRING);
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		
        }        
    }
}else if($mode=="ins"){
    try{
				
        $db->beginTransaction();        

        $sqry="select * from goods g where goodsnm='".$_POST['goodsnm']."' ";
        $sres=$db->query($sqry);
        $goodsData=$sres->results[0];            

        if(!$goodsData) throw new Exception('해당모델이 존재하지않습니다.(GOODSNM)', 1);

        $iqry="insert into goods_barcode_print set 
        brandno=:brandno
        ,goodsno=:goodsno
        ,goodsnm=:goodsnm
        ,quantity=:quantity
        ,memo=:memo
        ,admin_no=:admin_no
        ,reg_date=now()
        ";
        $param[':brandno']=$goodsData['brandno'];
        $param[':goodsno']=$goodsData['no'];
        $param[':goodsnm']=$_POST['goodsnm'];
        $param[':quantity']=$_POST['quantity'];
        $param[':memo']=$_POST['memo'];
        $param[':admin_no']=$_SESSION['sess']['m_no'];

        $db->query($iqry,$param);
        
        //$db->rollBack();
        $db->commit();
       
        msg('[등록]처리되었습니다.',"goods_barcode_print.php?".$QUERY_STRING);
    }
    catch( Exception $e ){
        tydebug('err');
        $db->rollBack();
        tydebug($e->getMessage().":".$e->getFile());	
    }    

}else if($mode=="print"){
    try{
				
        $db->beginTransaction();
        foreach($_POST["chk_no"] as $v){    

           $uqry="update goods_barcode_print set 
           print_date=now()
           ,mod_admin_no='".$_SESSION['sess']['m_no']."'
           where no='".$v."'
           ";
           $db->query($uqry);
    
        }    
        
        //$db->rollBack();
        $db->commit();
       
        msg('[출력완료]처리되었습니다.',"goods_barcode_print.php?".$QUERY_STRING);
    }
    catch( Exception $e ){
        tydebug('err');
        $db->rollBack();
        tydebug($e->getMessage().":".$e->getFile());	
    }    
}

if($_REQUEST['s_paste']){
    $s_paste=paste_to_arr($_REQUEST['s_paste']);
    if($s_paste){
        $s_paste_imp=implode("','",$s_paste);
        $add_where[]="g.goodsnm in ('".$s_paste_imp."')";	
    }
}
if($_REQUEST['s_brand'])$add_where[]="b.brandnm like '%".$_REQUEST['s_brand']."%'";
if($s_date_value && $e_date_value)$add_where[]="bp.reg_date between '".$s_date_value." 00:00:00' and '".$e_date_value." 23:59:59'";
if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
if($add_where){
    
	/*리스트*/
    $qry="select bp.*, b.brandnm, m.name, (select m2.name from member m2 where m2.no=bp.mod_admin_no ) as mod_name
    ,(select barcode from goods_barcode gb where gb.goodsno=bp.goodsno and gb.sort='1' order by no limit 1) as barcode
    from goods_barcode_print bp
    left join goods g on (bp.goodsno=g.no)
    left join brand b on (g.brandno=b.no)	
    left join member m on (bp.admin_no=m.no)
    where 1=1 ".$add_where."
    order by no desc";
    $res = $db->query($qry);
    
	foreach($res->results as $v){
        $v['reg_date']=reset(explode(" ",$v['reg_date']));
        if($v['print_date']!='0000-00-00') $v['print_date']="출력완료(".$v['print_date'].")";
        else $v['print_date']="";       
       
		$loop[]=$v;
    }
    //붙여넣기가 있으면 붙여넣기 순서로 재정렬
    if($_REQUEST['s_paste']){
        
        $paste_arr = paste_to_arr($_REQUEST['s_paste']);
        foreach($paste_arr as $v){

            if($loop[$v]){
                $tmp_arr[]=$loop[$v];
                unset($loop[$v]);
            }
        }
        $loop=$tmp_arr;
    }
    $checked['noBarcode'][$_GET['noBarcode']]='checked';

	$tpl->assign(array(	
    'loop' => $loop
	));
}

$tpl->print_('tpl');
?>
