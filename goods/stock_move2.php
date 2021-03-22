<?
include "../_header.php";member_chk();

$page_title='재고이동';

$codedata=get_codedata('place');
asort($codedata);

$QUERY_STRING = $_SERVER['QUERY_STRING'];

$selected['codedata_sort'][$_REQUEST['codedata_sort']]="selected";
$checked['sort_type'][$_REQUEST['sort_type']]="checked";
$checked['stock_check'][$_REQUEST['stock_check']]="checked";
//phpinfo();


if($_FILES){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){			
			$gqry="select no from goods g where goodsnm='".$v[0]."'";
			$gres=$db->query($gqry);
			$gno=$gres->results[0]['no'];
			if(!$gno)$err_msg[]=$k."번열 모델이 존재하지않습니다.";
			if(!$v['1'])$err_msg[]=$k."번열 수량이 존재하지않습니다.";
			
			$sqry="select no from codedata where type='PLACE' and cd='".$v[2]."'";
			$sres=$db->query($sqry);
			$scode=$sres->results[0]['no'];
			if(!$scode)$err_msg[]=$k."번열 차감위치가 존재하지않습니다.";

			if($gno && $scode){
				$sqry="select * from goods_cnt_loc gcl where goodsno='".$gno."'";
				$sres=$db->query($sqry);
				$s_stock=$sres->results[0]['codeno_'.$scode];
				
				if($s_stock < $v[1]) $err_msg[]=$k."번열 차감할 재고(".$s_stock.")가 부족합니다.";         
			}

			$eqry="select no from codedata where type='PLACE' and cd='".$v[3]."'";
			$eres=$db->query($eqry);
			$ecode=$eres->results[0]['no'];
			if(!$ecode)$err_msg[]=$k."번열 증가위치가 존재하지않습니다.";            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
                    
                    if(!$v[1] || !$v[2] || !$v[3]) continue;

					$gqry="select no from goods g where goodsnm='".$v[0]."'";
					$gres=$db->query($gqry);
					$gno=$gres->results[0]['no'];

                    $sqry="select no from codedata where type='PLACE' and cd='".$v[2]."'";
                    $sres=$db->query($sqry);
                    $scode=$sres->results[0]['no'];

                    $eqry="select no from codedata where type='PLACE' and cd='".$v[3]."'";
                    $eres=$db->query($eqry);
                    $ecode=$eres->results[0]['no'];
                   
                    if($scode && $ecode){
                        stock_io('move',$gno,$v[0],-$v[1],0,$_SERVER['REQUEST_URI'],$scode,$ecode);
                        stock_io('move',$gno,$v[0],$v[1],0,$_SERVER['REQUEST_URI'],$ecode,$scode);

						$iqry="insert into stock_move_log set
						goodsno='".$gno."'
						,goodsnm='".$v[0]."'
						,quantity='".$v[1]."'
						,memo='".$v[4]."'
						,s_move='".$scode."'
						,e_move='".$ecode."'
						,admin_no='".$_SESSION['sess']['m_no']."'
						,admin_name='".$_SESSION['sess']['name']."'
						,reg_date=now()
						";

						$db->query($iqry);
                    }
				}


				//$db->rollBack();
                $db->commit();
               
				msg('처리되었습니다.','stock_move.php?'.$QUERY_STRING);
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		
        }        
    }
}


$_GET[page_num]=100;
$field="g.*,b.brandnm,b.brand_img_folder,gcl.*
";
$db_table="goods g
left join brand b on g.brandno = b.no
join goods_cnt_loc gcl on g.no=gcl.goodsno
";

if($_POST['s_paste'])$no_limit=1;
$s_res=get_search_where();
if($s_res['where'])$where=$s_res['where'];
if($_POST['s_paste'])$no_limit=1;


if($_REQUEST['codedata_sort']){
    $_GET[sort]="gcl.codeno_".$_REQUEST['codedata_sort']." ".$_REQUEST['sort_type'];
    if($_REQUEST['stock_check']) $where[]="gcl.codeno_".$_REQUEST['codedata_sort'].">0";
}

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);

$pg->exec();
$qry=$pg->query;
// tydebug($qry);
$res = $db->query($qry);

foreach($res->results as $v){
	
	if($print_xls){
		if($_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}
    
    foreach($codedata as $cv){
        $v["codedata"][]=$v['codeno_'.$cv['no']];
    }
	$loop[$v['goodsnm']]=$v;
}

//붙여넣기가 있으면 붙여넣기 순서로 재정렬
if($_POST['s_paste']){
	
	$paste_arr = paste_to_arr($_POST['s_paste']);
	foreach($paste_arr as $v){

		if($loop[$v]){
			$tmp_arr[]=$loop[$v];
			unset($loop[$v]);
		}
	}
	$loop=$tmp_arr;
}


// //합계
foreach($codedata as $cv){
    $sumCode[]="sum(codeno_".$cv['no'].") as sumcode_".$cv['no'];
}
$sumStock="";
$sumqry="select sum(cur_cnt) as sum_cur_cnt, ".implode(",",$sumCode)." from ".$db_table." where 1=1";
if($where) $sumqry.=" and ".implode(" and ",$where);
$sumres=$db->query($sumqry);
$sumData=$sumres->results[0];
$sumStock[]=$sumData['sum_cur_cnt'];
foreach($codedata as $cv){
    $sumStock[]=$sumData['sumcode_'.$cv['no']];
}

$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	
,'sumStock'=> $sumStock	
));

$tpl->print_('tpl');
?>