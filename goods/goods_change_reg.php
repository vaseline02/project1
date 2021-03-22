<?
include "../_header.php";

$page_title='모델명수정';

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];
$no=$_GET['no'];
$cate_code=$_GET['cate_code']; //제품 카테고리

//권한체크
if($_SESSION['sess']['m_id']=='jkm9424' || $_SESSION['sess']['m_id']=='naskka' || $_SESSION['sess']['m_id']=='koreaadidas1' || $_SESSION['sess']['m_id']=='sowuzu' || $_SESSION['sess']['m_id']=='trendmecca'){
	$member_level="1";
}

if(!$no){
    msg('잘못된 접근입니다.','close');
}


/*제품속성*/
$qry="select no,goods_info from category where depth_1=:depth_1 and depth_2='000'";
$res = $db->query($qry,array(":depth_1"=>$cate_code));

foreach($res->results as $v){
	$sfilter=$v['goods_info'];
}

if($sfilter){
	$ex_sfilter=explode(":",$sfilter);
	
	$sfilter_data=explode("|",$ex_sfilter[0]);
	$sfilter_sort=explode("|",$ex_sfilter[1]);

	$orderby=" order by case";

	foreach($sfilter_data as $k=>$v){
		
		$orderby.=" when no='".$v."' then  ".$sfilter_sort[$k]." ";
	}
	$orderby.=" else 1000 end";
}
	

$qry="select * from category_goods_info where no in ('".str_replace("|","','",$ex_sfilter[0])."')
".$orderby."
";
$res = $db->query($qry);

foreach($res->results as $v){
	$gi[$v['colum_name']]=$v['info_name'];
}


$qry="select g.*, gi.* 
from goods g 
left join goods_info gi on g.no=gi.goodsno
where g.no = '".$no."'";

$res = $db->query($qry);
   
foreach($res->results as $v){
	foreach($gi as $key=>$val){
			$v['spec_data'][$key]=$v[$key];
		}

		$spec[$v['goodsnm']]=$v;
}
////

if($mode){
    
    try
    {
        $db->beginTransaction();
       
        if($mode=='mod'){
            $goodsnm=$_POST['goodsnm'];
            $goodsnm_sub=$_POST['goodsnm_sub'];

		
            $qry="select count(no) as cnt, goodsnm, goodsnm_sub from goods where no='".$no."'";
            $res=$db->query($qry);
            $ori_goods=$res->results[0];
            if(!$ori_goods['cnt']) msg("등록된 모델이 없습니다.","goods_change_reg.php?no=".$no);	
			
			$qry="select count(no) as cnt from goods where goodsnm='".$goodsnm."'";
            $res=$db->query($qry);
            $goods_cnt=$res->results[0];
            if($goods_cnt['cnt']) msg("같은 상품명이 있습니다.","goods_change_reg.php?no=".$no);	

			if(!$goodsnm && !$goodsnm_sub) msg("모델명이 없습니다.","goods_change_reg.php?no=".$no);	

			if($member_level && $goodsnm){
				//key : 테이블명 value : 컬럼명
				$table_array=array(
					"as_detail"=>"goodsnm"
					,"cs_bad"=>"goodsnm"
					,"cs_receipt"=>"goodsnm"
					,"cs_detail"=>"exchange_goods_nm"
					,"goods"=>"goodsnm"
					,"goods_barcode"=>"goodsnm"
					,"goods_barcode_print"=>"goodsnm"
					,"goods_deal_detail"=>"goodsnm"
					,"import_licence"=>"goodsnm"
					,"stock_quick"=>"goodsnm"
					,"stock_move_log"=>"goodsnm"
					,"stock_list"=>"goodsnm"
					,"stock_io_log"=>"goodsnm"
					,"stock_hold"=>"goodsnm"
					,"stock_cron"=>"goodsnm"
					,"stock_change_log"=>"goodsnm"
					,"stock_soldout_log"=>"goodsnm"
					,"outside_return_log"=>"goodsnm"
					,"outside_goods"=>"goodsnm"
					,"order_list"=>"goodsnm"
					,"wholesale_cart"=>"goodsnm"
					,"wholesale_cart_excel_goods"=>"goodsnm"
					,"wholesale_order"=>"goodsnm"
				);

				foreach($table_array as $tk=>$tv){
					$qry="update ".$tk." set ".$tv."='".$goodsnm."' where ".$tv."='".$ori_goods['goodsnm']."'";
					//tydebug($qry);
					$db->query($qry);
				}
				$log_qry="insert into goodsnm_chg_log set `before`='".$ori_goods['goodsnm']."', after='".$goodsnm."', admin_no='".$_SESSION['sess']['m_no']."', chg_type='0', reg_date=now()";
				$db->query($log_qry);
				
			}

			if($goodsnm_sub){
				$qry="update goods set 
				goodsnm_sub='".$goodsnm_sub."'
				where no='".$no."'
				";
				//tydebug($qry);
				$db->query($qry);

				$log_qry="insert into goodsnm_chg_log set `before`='".$ori_goods['goodsnm_sub']."', after='".$goodsnm_sub."', admin_no='".$_SESSION['sess']['m_no']."', chg_type='1', reg_date=now()";
				//tydebug($log_qry);
				$db->query($log_qry);
				
			}
				
        }else if($mode=='link'){

			 $qry = "update goods set 
			 youtube_link = '".$_POST['link']."'
			 where no = '".$no."'
			 ";
			 $db->query($qry);

		}else if($mode=='spec'){

			foreach($gi as $key=>$val){				
				if($key == 'warranty' || $key == 'import' || $key == 'bezel'){
					$_POST[$key] = strtoupper($_POST[$key]);
				}

				$str .= $key." = '".$_POST[$key]."',";			
			}
			$str = rtrim($str, ',');

			$qry = "update goods_info 
			set ".$str." 
			where goodsno ='".$no."' 
			";

			$db->query($qry);

		}
        
        $db->commit();
        echo "<script>opener.location.reload();</script>";
        msg("처리되었습니다","goods_change_reg.php?no=".$no."&cate_code=".$cate_code);	
        
    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"goods_change_reg.php?no=".$no."&cate_code=".$cate_code);
    }  
   
}
/*기본상품정보*/
$qry="select * from goods g
where g.no='".$no."'";
$res = $db->query($qry);
$data=$res->results[0];



$tpl->assign($data);
$tpl->assign(array(
    'loop'=>$loop
	,'spec'=>$spec
	,'gi'=>$gi

));

    
$tpl->print_('tpl');
?>