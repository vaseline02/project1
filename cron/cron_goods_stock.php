<?
$glb_root_cron="/www/html/ukk_test";
require_once($glb_root_cron."/lib/db.class.php");
require_once($glb_root_cron."/lib/lib.func.php");

$db =  new DB($glb_root_cron."/conf/db.conf.php");
ini_set('memory_limit', -1);

$tday=date('Y-m-d');

$qry="select 
g.no
,ifnull((select sum(order_num) as day_7 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 7 DAY) and step='5' ),0) as day_7
,ifnull((select sum(order_num) as day_15 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 15 DAY) and step='5' ),0) as day_15
,ifnull((select sum(order_num) as month_1 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 1 MONTH) and step='5' ),0) as month_1
,ifnull((select sum(order_num) as month_2 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 2 MONTH) and step='5' ),0) as month_2
,ifnull((select sum(order_num) as month_3 from order_list where goodsno=g.no and reg_date >= (CURDATE()-INTERVAL 3 MONTH) and step='5' ),0) as month_3
,g.bad_stock_date
,(select max(reg_date) from order_list where goodsno=g.no and step='5' ) last_sale_date
,(select max(reg_date) from stock_list where goodsno=g.no) last_stock_date
,gcl.cur_cnt,gcl.codeno_3
from goods g
left join goods_cnt_loc gcl on g.no=gcl.goodsno
#where g.no='1211'
#limit 10
";
$res=$db->query($qry);
foreach($res->results as $v){

	$sdt = new DateTime($v["last_stock_date"]); // 20120101 같은 포맷도 잘됨
	$edt = new DateTime($tday);
	$cha = date_diff($sdt, $edt);

    if(!$v["month_3"] && ($v["cur_cnt"]-$v["codeno_3"])>0 && $cha->days>90){
        $bad_stock_date=($v["last_sale_date"])?$v["last_sale_date"]:"판매데이터없음";
    }else{
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
	$db->query($uqry,array(),'cron');
    // tydebug($uqry);
}



die;

$qry="select g.no, g.goodsnm, gcl.cur_cnt, gcl.codeno_1, gcl.codeno_51 from goods g 
left join goods_cnt_loc gcl on (g.no=gcl.goodsno)";

$res=$db->query($qry);
foreach($res->results as $v){
	
    #일별 재고 등록
	/*
    if($v['cur_cnt']>0){
        $sqry="select count(*) as tcnt from stock_cron sc where sc.goodsno='".$v['no']."' and sc.reg_date='".date('Y-m-d', time())."'";
        $sres=$db->query($sqry);
        $cdata=$sres->results[0]['tcnt'];

        if(!$cdata){
            $iqry="insert into stock_cron set 
            goodsno=:goodsno
            ,goodsnm=:goodsnm
            ,cnt=:cnt
            ,1_cnt=:1_cnt
            ,51_cnt=:51_cnt
            ,reg_date=now()
            ";
            $param[":goodsno"]=$v['no'];
            $param[":goodsnm"]=$v['goodsnm'];
            $param[":cnt"]=$v['cur_cnt'];
            $param[":1_cnt"]=$v['codeno_1'];
            $param[":51_cnt"]=$v['codeno_51'];
            $db->query($iqry,$param,'cron');
        }
       
    }
	*/
    #판매재고
    #7일
    $sqry="select sum(if(ol.upload_form_type in ('타임메카','스토어팜'),ol.order_num,0)) as tm 
	,sum(if(ol.upload_form_type in ('B2B'),ol.order_num,0)) as b2b 
	,sum(if(ol.upload_form_type not in ('타임메카','스토어팜','B2B'),ol.order_num,0)) as ec 
	from 
    order_list ol 
    where ol.goodsno='".$v['no']."' and ol.step=5 and ol.reg_date between '".date('Y-m-d', strtotime("-7 day", time()))."' and '".date('Y-m-d', time())."'";
    $sres=$db->query($sqry);

	$arr_7['tm']=$sres->results['0']['tm'];
	$arr_7['ec']=$sres->results['0']['ec'];
	$arr_7['b2b']=$sres->results['0']['b2b'];
    #15일
    $sqry="select sum(if(ol.upload_form_type in ('타임메카','스토어팜'),ol.order_num,0)) as tm 
	,sum(if(ol.upload_form_type in ('B2B'),ol.order_num,0)) as b2b 
	,sum(if(ol.upload_form_type not in ('타임메카','스토어팜','B2B'),ol.order_num,0)) as ec 
	from 
    order_list ol 
    where ol.goodsno='".$v['no']."' and ol.step=5 and ol.reg_date between '".date('Y-m-d', strtotime("-15 day", time()))."' and '".date('Y-m-d', time())."'";
    $sres=$db->query($sqry);

	$arr_15['tm']=$sres->results['0']['tm'];
	$arr_15['ec']=$sres->results['0']['ec'];
	$arr_15['b2b']=$sres->results['0']['b2b'];
    #30일
    $sqry="select sum(if(ol.upload_form_type in ('타임메카','스토어팜'),ol.order_num,0)) as tm 
	,sum(if(ol.upload_form_type in ('B2B'),ol.order_num,0)) as b2b 
	,sum(if(ol.upload_form_type not in ('타임메카','스토어팜','B2B'),ol.order_num,0)) as ec 
	from 
    order_list ol 
    where ol.goodsno='".$v['no']."' and ol.step=5 and ol.reg_date between '".date('Y-m-d', strtotime("-1 month", time()))."' and '".date('Y-m-d', time())."'";
    $sres=$db->query($sqry);

	$arr_30['tm']=$sres->results['0']['tm'];
	$arr_30['ec']=$sres->results['0']['ec'];
	$arr_30['b2b']=$sres->results['0']['b2b'];
    #60일
    $sqry="select sum(if(ol.upload_form_type in ('타임메카','스토어팜'),ol.order_num,0)) as tm 
	,sum(if(ol.upload_form_type in ('B2B'),ol.order_num,0)) as b2b 
	,sum(if(ol.upload_form_type not in ('타임메카','스토어팜','B2B'),ol.order_num,0)) as ec 
	from 
    order_list ol 
    where ol.goodsno='".$v['no']."' and ol.step=5 and ol.reg_date between '".date('Y-m-d', strtotime("-3 month", time()))."' and '".date('Y-m-d', time())."'";
    $sres=$db->query($sqry);
	$arr_60['tm']=$sres->results['0']['tm'];
	$arr_60['ec']=$sres->results['0']['ec'];
	$arr_60['b2b']=$sres->results['0']['b2b'];

    #90일
    $sqry="select sum(if(ol.upload_form_type in ('타임메카','스토어팜'),ol.order_num,0)) as tm 
	,sum(if(ol.upload_form_type in ('B2B'),ol.order_num,0)) as b2b 
	,sum(if(ol.upload_form_type not in ('타임메카','스토어팜','B2B'),ol.order_num,0)) as ec 
	from 
    order_list ol 
    where ol.goodsno='".$v['no']."' and ol.step=5 and ol.reg_date between '".date('Y-m-d', strtotime("-6 month", time()))."' and '".date('Y-m-d', time())."'";
    $sres=$db->query($sqry);
	$arr_90['tm']=$sres->results['0']['tm'];
	$arr_90['ec']=$sres->results['0']['ec'];
	$arr_90['b2b']=$sres->results['0']['b2b'];


	$uqry2="insert into goods_sale_period (
	goodsno
	,tm7,tm15,tm1m,tm2m,tm3m
	,ec7,ec15,ec1m,ec2m,ec3m
	,b2b7,b2b15,b2b1m,b2b2m,b2b3m
	)values('".$v['no']."',
	'".$arr_7['tm']."','".$arr_15['tm']."','".$arr_30['tm']."','".$arr_60['tm']."','".$arr_90['tm']."',
	'".$arr_7['ec']."','".$arr_15['ec']."','".$arr_30['ec']."','".$arr_60['ec']."','".$arr_90['ec']."',
	'".$arr_7['b2b']."','".$arr_15['b2b']."','".$arr_30['b2b']."','".$arr_60['b2b']."','".$arr_90['b2b']."'

	)
	ON DUPLICATE KEY UPDATE
	tm7='".$arr_7['tm']."'
	,tm15='".$arr_15['tm']."'
	,tm1m='".$arr_30['tm']."'
	,tm2m='".$arr_60['tm']."'
	,tm3m='".$arr_90['tm']."'
	,ec7='".$arr_7['ec']."'
	,ec15='".$arr_15['ec']."'
	,ec1m='".$arr_30['ec']."'
	,ec2m='".$arr_60['ec']."'
	,ec3m='".$arr_90['ec']."'
	,b2b7='".$arr_7['b2b']."'
	,b2b15='".$arr_15['b2b']."'
	,b2b1m='".$arr_30['b2b']."'
	,b2b2m='".$arr_60['b2b']."'
	,b2b3m='".$arr_90['b2b']."'
	";
	
	$db->query($uqry2,array(),'cron');
   // $loop[]=$v;
}

?>