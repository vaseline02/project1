<?
include "../_header.php";

$page_title='파일업로드sample';

$qry="select (select  count(no) from goods_barcode gb where gb.goodsno=g.no) as cnt, (select  cur_cnt from goods_cnt_loc gcl where gcl.goodsno=g.no) as cntt, goodsnm from goods g where g.goodsnm not like '%보호필름%' and g.goodsnm not like '%리퍼%'";
$res=$db->query($qry);
foreach($res->results as $v){
    if(!$v['cnt'] && $v['cntt'] && !strpos($v['goodsnm'],'보호필름') && !strpos($v['goodsnm'],'리퍼')) echo $v['goodsnm']."<br>";
}
//tydebug($error);
exit;
if($_FILES){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        
        try{
            
            $db->beginTransaction();
            foreach($excel_data as $k=>$v){
                
                if($v[1]){
                    $brand=$v[1];
                }else if(!$v[1]){
                    $v[1]=$brand;
                }
                if($v[2]){
                    $goodsnm=$v[2];
                    $qry="select no from goods where goodsnm='".$v['2']."' limit 1";
                    $res=$db->query($qry);
                    $goodsno=$res->results[0]['no'];

                    $v[6]=$goodsno;
                    
                }else if(!$v[2]){
                    $v[2]=$goodsnm;  
                    $v[6]=$goodsno;
                } 
                
                if($v[3]){
                    $goodsnm2=$v[3];
                }else if(!$v[3]){
                    $v[3]=$goodsnm2;
                } 
                
                
                $qry="insert into goods_barcode set 
                barcode=:barcode
                ,goodsno=:goodsno
                ,goodsnm=:goodsnm
                ,reg_date=now()
                ";
                $param[":barcode"]=$v[5];      
                $param[":goodsno"]=$v[6]?$v[6]:"0";      
                $param[":goodsnm"]=$v[2];      
                //tydebug($qry);

                $db->query($qry,$param);
            
                if(!$v[6]) $notgoods[$v[2]]=$v[6];
                
            }

            //$db->rollBack();
            $db->commit();
            
           // msg('처리되었습니다.',$returnUrl);
        }
        catch( Exception $e ){
            tydebug('err');
            $db->rollBack();
            tydebug($e->getMessage().":".$e->getFile());	
        }
		
    }
}

tydebug($notgoods);
$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg
,'mall_name'=>$mall_name
,'code_title'=>$code_title
,'code_value'=>$code_value
,'codeNo'=>$codeNo
));

$tpl->print_('tpl');
?>
