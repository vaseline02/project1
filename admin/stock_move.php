<?
include "../_header.php";

$page_title='재고이동관리';

//재고이동 가능 code
$mall_name=get_codedata('place','',$loc_f);

if(is_array($_REQUEST['codeNo'])){
    $codeNo=$_REQUEST['codeNo'];
}else{
    $codeNo=unserialize(urldecode($_REQUEST['codeNo']));
}
$no=$_REQUEST['no'];
$mode=$_REQUEST['mode'];
$returnUrl=$_REQUEST['returnUrl']?$_REQUEST['returnUrl']:$_SERVER['REQUEST_URI'];
if($_FILES){
	$excel_data=excel_read('unlink','7');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			
			if(!$v['0'])$err_msg[]=$k."번열 상품고유코드가 존재하지않습니다.";
            if(!$v['2'])$err_msg[]=$k."번열 모델명이 존재하지않습니다.";
            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
                    
                    if(!$v[3] || !$v[4] || !$v[5]) continue;

                    $sqry="select no from codedata where type='PLACE' and cd='".$v[3]."'";
                    $sres=$db->query($sqry);
                    $scode=$sres->results[0]['no'];

                    $eqry="select no from codedata where type='PLACE' and cd='".$v[4]."'";
                    $eres=$db->query($eqry);
                    $ecode=$eres->results[0]['no'];
                   
                    if($scode && $ecode){
                        stock_io('move',$v[0],$v[2],-$v[5],0,$_SERVER['REQUEST_URI'],$scode,$ecode);
                        stock_io('move',$v[0],$v[2],$v[5],0,$_SERVER['REQUEST_URI'],$ecode,$scode);
                    }
				}


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
if($mode=='move'){
    if($no){
        try
        {
            $db->beginTransaction();

            stock_io('move',$no,$_POST['goodsnm'][$no],-$_POST['moveCnt'][$no],0,$_SERVER['REQUEST_URI'],$_POST['s_cnt'][$no],$_POST['e_cnt'][$no]);
            stock_io('move',$no,$_POST['goodsnm'][$no],$_POST['moveCnt'][$no],0,$_SERVER['REQUEST_URI'],$_POST['e_cnt'][$no],$_POST['s_cnt'][$no]);
            
            $db->commit();
            msg('처리되었습니다.',$returnUrl);

            
        }
        catch(Exception $e)
        {
            $db->rollBack();

            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            msg($s,$returnUrl);
        }  
    }else{
        msg("문제가발생했습니다. 개발자에게 문의주세요.",$returnUrl);	
    }

}


$_GET[page_num]=100;
$field="g.*,b.brandnm,b.brand_img_folder,c.catenm";
$db_table="goods g
left join brand b on g.brandno = b.no
left join category c on g.cateno = c.no
";


if($_REQUEST['s_paste']){
    $s_paste=paste_to_arr($_REQUEST['s_paste']);
    if($s_paste){
        $s_paste_imp=implode("','",$s_paste);
        $where[]="g.goodsnm in ('".$s_paste_imp."')";	
    }
}
if($_REQUEST['s_brand'])$where[]="b.brandnm like '%".$_REQUEST['s_brand']."%'";

if($_REQUEST['s_paste'])$no_limit=1;

$pg = new page($_GET[page],$_GET[page_num],$no_limit);

$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);
$pg->exec();

$res = $db->query($pg->query);
foreach($res->results as $v){
    $gcl=now_stock($v['no']);
    
	if(!$v['img_name'])$v['img_name']=$v['goodsnm'];

	if(!$_REQUEST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
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
foreach($codeNo as $v){
    $qry="select * from codedata where no='".$v."'";
    $res=$db->query($qry);
    
    $code_title[]=$res->results[0];
    $checked['codeNo'][$v]="checked";
}

foreach($loop as $k=>$v){
    foreach($codeNo as $cv){
        $qry="select *, (select codeno_".$cv." from goods_cnt_loc where goodsno='".$v['no']."') as cnt from codedata where no='".$cv."'";
        $res=$db->query($qry);
        
        $code_value[$v['no']][]=$res->results[0];
    }
}
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
