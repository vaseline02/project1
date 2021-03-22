<?
include "../_header.php";
ini_set('memory_limit', '256M');
$page_title='바코드관리';
$codedata=get_codedata('place');
asort($codedata);

$returnUrl=$_REQUEST['returnUrl']?$_REQUEST['returnUrl']:$_SERVER['REQUEST_URI'];

if($_FILES){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			
			if(!$v['0'])$err_msg[]=$k."번열 상품고유코드가 존재하지않습니다.";            
            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
                    //$dqry="delete from goods_barcode where goodsno='".$v[0]."'";
                    //$db->query($dqry);

                    $sqry="select count(no) as cnt from goods_barcode where goodsnm='".$v[2]."' and barcode='".$v[5]."'";
                    $sres=$db->query($sqry);
                    $scheck=$sres->results[0]['cnt'];
                   
                    // $exBarcode=explode("|",$v[3]);

                    if(!$scheck){
                        unset($param);
						if($v[4]=='1'){ //1번이 새로 들어오면 나머지는 다 2번으로 
							$qry="update goods_barcode set sort='2' where goodsnm=:goodsnm";
							$db->query($qry,array(":goodsnm"=>$v[2]));

							$add_qry=",sort=:sort";
							$param[':sort']=$v[4];
						}else{
							$add_qry="";
						}


                        $sqry="insert into goods_barcode set 
                        barcode=:barcode
						".$add_qry."
                        ,goodsno=:goodsno
                        ,goodsnm=:goodsnm
                        ,reg_date=now()
                        ";

                        $param[':barcode']=trim($v[5]);
                        $param[':goodsno']='0';
                        $param[':goodsnm']=$v[2];
						
                        $db->query($sqry,$param);
                    }else{
						$sqry="update goods_barcode set sort=:sort where goodsnm='".$v[2]."' and barcode='".$v[5]."'";
						$db->query($sqry,array(":sort"=>$v[4]));
					}
				}
                $uqry="update goods_barcode gb set goodsno=(select no from goods g where g.goodsnm=gb.goodsnm) where gb.goodsno='0'";
                $db->query($uqry);

				//$db->rollBack();
                $db->commit();
               
				msg('처리되었습니다.',$returnUrl);
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		
        }        
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

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
if($add_where || $_REQUEST['noBarcode']){
    
    foreach($codedata as $cv){
        $sumCode[]="gcl.codeno_".$cv['no'];
    }
	/*리스트*/
    $qry="select g.*, b.brand_img_folder, b.brandnm, (select count(no) from goods_barcode gb where gb.goodsno=g.no ) as barcodecnt, gcl.cur_cnt, ".implode(",",$sumCode)." from goods g 
    left join brand b on g.brandno = b.no	
    join goods_cnt_loc gcl on g.no=gcl.goodsno
    where 1=1 ".$add_where;
    if($_REQUEST['noBarcode']) $qry.=" having barcodecnt=0";
    $res = $db->query($qry);
    
	foreach($res->results as $v){
        $bqry="select barcode from goods_barcode where goodsno='".$v['no']."'";
        $bres=$db->query($bqry);
        $v['barcode']=$bres->results;
        $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
		$loop[$v['goodsnm']]=$v;
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
