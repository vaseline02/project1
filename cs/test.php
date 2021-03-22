<?
include "../_header.php";

exit;
$CANCEL=NEW cancel();
$aaa=$CANCEL->bad_calc_stock("10","1");
tydebug($aaa);
exit;

$qry="select * from cs_bad where goods_no='0'";

tydebug($qry);
$res=$db->query($qry);

foreach($res->results as $k=>$v){
	$uqry="update cs_bad set goods_no=(select no from goods where goodsnm='".$v['goodsnm']."') where no='".$v['no']."'";

$db->query($uqry);


}
exit;
try{
	$db->beginTransaction();

	$CANCEL=NEW cancel();

	//$aaa=$CANCEL->bad_calc_stock("10","1");

	//$bbb=$CANCEL->bad_calc_stock_order("44965");

	tydebug($bbb);
	$db->commit();
	//msg('처리되었습니다.',"bad_list.php?".$QUERY_STRING);
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage().":".$e->getFile());	
}

exit;
/*
//접수
$qry="select * from cs_info ci left join cs_detail cd on (ci.no=cd.cs_info_no) where ci.return_type in (60,70,90) and ci.add_type in ('0') 
and ci.reg_date>='2020-10-19 00:00:00' and ci.reg_date<='2020-10-27 23:59:59' group by cd.order_list_no order by cd.no asc";
//완료

$qry="select * from cs_info ci left join cs_detail cd on (ci.no=cd.cs_info_no) where ci.return_type in (60,70,90) and ci.add_type in ('1') 
and ci.reg_date>='2020-10-19 00:00:00' and ci.reg_date<='2020-10-27 23:59:59' order by cd.no asc";

tydebug($qry);
$res=$db->query($qry);

foreach($res->results as $k=>$v){
    $iqry="insert into cs_report_log set
    ins_date='".reset(explode(' ',$v['reg_date']))."'
    ,admin_no='".$v['admin_no']."'
    ,add_type='0'
    ,order_list_no='".$v['order_list_no']."'
    ,mall_no='".$v['mall_no']."'
    ,order_no='".$v['order_no']."'
    ,goods_no='".$v['goods_no']."'
    ,reg_date='".$v['reg_date']."'
    ";
	//$db->query($iqry);
    tydebug($iqry);
    tydebug($k);
    tydebug($v);
}
*/

//cs리스트 접수건 삭제
$qry="select * from cs_info c where return_type in (60,70,90) and add_type in ('1')";
$res=$db->query($qry);

foreach($res->results as $k=>$v){
    //접수 cd.send_type in ('1','90')
    //발송처리 cd.send_type in ('2')
    //처리완료 cd.send_type in ('4')
    $sqry="select * from cs_detail cd where cs_info_no='".$v['no']."' and cd.order_list_no > '0' and cd.send_type in ('1','90')";
    $sres=$db->query($sqry);
    foreach($sres->results as $sk=>$sv){
        $info[]=$sv['cs_info_no'];
        $detail[]=$sv['no'];
        $data[]=$sv;
    }
}
$dqry="delete from cs_info where no in ('".implode("','",$info)."')";
//$db->query($dqry);
tydebug($dqry);
$dqry="delete from cs_detail where no in ('".implode("','",$detail)."')";
//$db->query($dqry);
tydebug($dqry);
tydebug($data);
exit;

// select ci.return_type,ci.return_type_sub,ci.return_invoice, ci.return_delivery_code, ci.receipt, ci.account_code, ci.account_number
//         , cd.*
//         , ol.courier_code, ol.invoice, ol.order_num, ol.goodsnm, ol.order_num, ol.mall_no, ol.mall_name, ol.step, ol.step2, ol.step2, ol.deli_codeno, ol.order_cost
//         , b.brand_img_folder
//         , exg.exchange_brand_img_folder, exg.exchange_goodsnm 
//         , m.id, m.name
// 		, ol2.ordno as ex_ordno, ol2.invoice as ex_invoice, ol2.courier_code as ex_courier_code
        
//         from 
//         cs_info ci
//         left join cs_detail cd on (ci.no=cd.cs_info_no)
//         left join order_list ol on (cd.order_list_no=ol.no)
//         left join goods g on (cd.goods_no=g.no) 
//         left join brand b on (g.brandno = b.no)	
//         left join member m on (ci.admin_no=m.no)
//         left join (
//             select  g.no, b.brand_img_folder as exchange_brand_img_folder, g.goodsnm as exchange_goodsnm from goods g 
//             left join brand b on (g.brandno = b.no)
//             ) exg on (cd.exchange_goods_no=exg.no)
// 		left join order_list ol2 on (ol2.csno=cd.no)

//         where 1=1  and ci.return_type in ('60','70','90') and cd.order_list_no > '0' and cd.send_type in ('1','90') order by ci.reg_date desc
tydebug($detail);
exit;
$qry="select * from category c where depth_1!='000' and depth_2='000' order by depth_1,no desc";
$res=$db->query($qry);
$category=$res->results;

foreach($category as $cv){
	if($cv['goods_info']){

		$ex_goodsInfoData=explode(":",$cv['goods_info']);
		$ex_goodsInfoNo=explode("|",$ex_goodsInfoData[0]);
		$ex_goodsInfoSort=explode("|",$ex_goodsInfoData[1]);

	//tydebug($ex_goodsInfoSort);
	$infoSort="";
		foreach($ex_goodsInfoSort as $sk=>$sv){		
			$infoSort[]=$sv."_".$ex_goodsInfoNo[$sk];
		}	
		natsort($infoSort);
	}
	$i=1;
	//tydebug($infoSort);
	foreach($infoSort as $k=>$v){
		$infoNo=explode("_",$v);

		$qry="select * from category_goods_info where no='".$infoNo[1]."'";
		$res=$db->query($qry);
		$data=$res->results[0];

		$qry1="select * from category_goods_info_detail where cate_code='".$cv['depth_1']."' and colum_name='".$data['colum_name']."'";
		$res1=$db->query($qry1);
		$data1=$res1->results[0];

		if($data1){
			$uqry="update category_goods_info_detail set sort='".$infoNo[0]."' where cate_code='".$cv['depth_1']."' and colum_name='".$data['colum_name']."'";
			$db->query($uqry);
			tydebug($uqry);

		}else{
			$iqry="insert into category_goods_info_detail set cate_code='".$cv['depth_1']."', colum_name='".$data['colum_name']."', sort='".$infoNo[0]."', detail_view_yn='N', reg_date=now()";
			$db->query($iqry);
			tydebug($iqry);
		}

		tydebug($data);

	//	tydebug($infoNo);
		$i++;
	}
}

exit;
$aaa=reserve_indb("1","1","1","발송대기 자동등록","51");
tydebug($aaa);

exit;
$qry="select * from mall_list where brand!=''
";
$res=$db->query($qry);
foreach($res->results as $v){
    $ex_brandnm=explode("|",$v['brand']);
    foreach($ex_brandnm as $ev){
        $sqry="select * from brand where brandnm='".$ev."'";
        $sres=$db->query($sqry);
        $brand=$sres->results[0];		
        
        $iqry="insert into mall_brand set
        mall_no='".$v['no']."'
        ,brand_no='".$brand['no']."'
        ,mall_name='".$v["mall_name"]."'
        ,brand_name='".$ev."'
        ,reg_date=now()	
        ";			
        //tydebug($iqry);
        //$db->query($iqry);
    
     /*$sqry="select count(*) as cnt  from brand where brandnm ='".$ev."'";
     $sres=$db->query($sqry);
     $cnt=$sres->results[0]['cnt'];
     if(!$cnt){
         //$uqry="update brand set type='A' where brandnm='".$ev."'";
         $iqry="insert into brand set
         brandnm='".$ev."'
         ,save_time=now()
         ,memo='외부브랜드'
         ";
         tydebug($iqry);
        // $db->query($iqry);
        tydebug($ev);
     }*/

    }

}

exit;
$qry="select 
g.no
,ifnull((select sum(order_num) as day_7 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 7 DAY) and step='5' ),0) as day_7
,ifnull((select sum(order_num) as day_15 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 15 DAY) and step='5' ),0) as day_15
,ifnull((select sum(order_num) as month_1 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 1 MONTH) and step='5' ),0) as month_1
,ifnull((select sum(order_num) as month_2 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 2 MONTH) and step='5' ),0) as month_2
,ifnull((select sum(order_num) as month_3 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 3 MONTH) and step='5' ),0) as month_3
,g.bad_stock_date
from goods g
#where g.no='21547'
#limit 10
";
exit;
$res=$db->query($qry);
foreach($res->results as $v){
    if($v["bad_stock_date"]=="0000-00-00" && !$v["month_3"]){
        $bad_stock_date=date("Y-m-d");
    }else if($v["bad_stock_date"]!="0000-00-00" && $v["month_3"]){
        $bad_stock_date="";
    }     
   
    $uqry="update goods set 
    order_7day='".$v['day_7']."'
    ,order_15day='".$v['day_15']."'
    ,order_1month='".$v['month_1']."'
    ,order_2month='".$v['month_2']."'
    ,order_3month='".$v['month_3']."'
    ,bad_stock_date='".$bad_stock_date."'
    where no='".$v["no"]."'
    ";  
    $db->query($uqry);    
}


?>