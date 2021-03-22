<?
include "../_header.php";member_chk();

$page_title='행사가격 관리';

$GOODS=new goods();

if($_FILES){
	$excel_data=excel_read('unlink','5');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			
			if(!$v['3'])$err_msg[]=$k."번열 모델명 필수입력사항.";            
            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{

				$db->beginTransaction();
				foreach($excel_data as $k=>$v){
					
					$price_chk=0;
					unset($param);
					if($_POST['upload_sel']=='1'){
						$add_set="gsp.tm_price=:tm_price";
						$param[':tm_price']=trim(str_replace(",","",$v[4]));
						$price_chk=$param[':tm_price'];
					}else{
						$add_set="gsp.ec_price=:ec_price";
						$param[':ec_price']=trim(str_replace(",","",$v[6]));
						$price_chk=$param[':ec_price'];
					}
					
					if($price_chk==0)continue;
					$sqry="update goods_sale_period gsp 
					join goods g on g.no=gsp.goodsno
					set 
					".$add_set."
					,gsp.mod_date=now()
					where g.goodsnm=:goodsnm
					";
					
					$param[':goodsnm']=trim($v[3]);
					
					if($db->query($sqry,$param)){

						unset($param2);
						$ins_qry="insert into goods_sale_period_log set
						goodsno=:goodsno
						,price=:price
						,admin_no=:admin_no
						,price_type=:price_type
						,reg_date=now()
						";
						
						$param2[':goodsno']=$GOODS->get_goodsno($param[':goodsnm']);
						$param2[':price']=$price_chk;
						$param2[':admin_no']=$sess['m_no'];
						$param2[':price_type']=$_POST['upload_sel'];

						$db->query($ins_qry,$param2);
					}
				}
				$db->commit();
				msg('처리되었습니다.');
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		
        }        
    }
}


//phpinfo();
$_GET[page_num]=100;
$field="g.*,b.brandnm,b.brand_img_folder,gcl.*,gsp.*,gi.prod_type,gi.consumer_price";
$db_table="goods g
left join goods_info gi on gi.goodsno=g.no
left join brand b on g.brandno = b.no
left join goods_sale_period gsp on g.no=gsp.goodsno
join goods_cnt_loc gcl on g.no=gcl.goodsno
";



if($_POST['s_paste'])$no_limit=1;
$s_res=get_search_where();
if($s_res['where'])$where=$s_res['where'];
if($_POST['s_paste'])$no_limit=1;

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);

$pg->exec();
$qry=$pg->query;

$res = $db->query($qry);

foreach($res->results as $v){
	$sqry="select * from stock_list where goodsno='".$v['no']."' and now_cnt > 0 and state in('0','1') order by reg_date";
	$sres=$db->query($sqry);
	$v['stock_list']=$sres->results;

	$stock_sumPrice=0;
	$stock_sumNum=0;
	foreach($v['stock_list'] as $sv){
		$stock_sumPrice+=($sv['cost']*$sv['now_cnt']);
		$stock_sumNum+=$sv['now_cnt'];
	}
	$v['stock_average']=round($stock_sumPrice/$stock_sumNum);

	$v['c_price']=($v['consumer_price'])?$v['consumer_price']:$v['c_price'];

	$tm_cha=($v['tm_price']>=100000)?3000:0;
	$v['tm_per']=round(($v['tm_price']-$v['stock_average']-$tm_cha)/$v['tm_price']*100,2);

	$v['ec_per']=round(($v['ec_price']-$v['stock_average']-3000)/$v['ec_price']*100,2);
	$v['sangsi_price']=round(($v['ec_price']*1.07)/1000)*1000;
	if($v['sangsi_price']>=300000)$v['sangsi_price']-=1000;
	else $v['sangsi_price']-=100;
	$v['sangsi_per']=round(($v['sangsi_price']-$v['stock_average']-3000)/$v['sangsi_price']*100,2);

	$v['tm_per6m']=round($v['tm3m']/($v['tm3m']+$v['ec3m']+$v['b2b3m'] )*100,2);
	$v['ec_per6m']=round($v['ec3m']/($v['tm3m']+$v['ec3m']+$v['b2b3m'] )*100,2);
	$v['b2b_per6m']=round($v['b2b3m']/($v['tm3m']+$v['ec3m']+$v['b2b3m'] )*100,2);

	if($print_xls){
		if($_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
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



$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
