<?//미사용
// $glb_root_cron="/www/html/ukk";
// require_once($glb_root_cron."/lib/db.class.php");
// require_once($glb_root_cron."/lib/lib.func.php");

// $db =  new DB($glb_root_cron."/conf/db.conf.php");

include "../_header.php";
ini_set('memory_limit', -1);


$qry="select g.no, g.goodsnm, gcl.cur_cnt, gcl.codeno_1, gcl.codeno_51 from goods g 
left join goods_cnt_loc gcl on (g.no=gcl.goodsno) limit 10";

$res=$db->query($qry);
foreach($res->results as $v){
    #일별 재고 등록
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
            $db->query($iqry,$param);
        }
       
    }

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
    where ol.goodsno='".$v['no']."' and ol.step=5 and ol.reg_date between '".date('Y-m-d', strtotime("-2 month", time()))."' and '".date('Y-m-d', time())."'";
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
    where ol.goodsno='".$v['no']."' and ol.step=5 and ol.reg_date between '".date('Y-m-d', strtotime("-3 month", time()))."' and '".date('Y-m-d', time())."'";
    $sres=$db->query($sqry);
	$arr_90['tm']=$sres->results['0']['tm'];
	$arr_90['ec']=$sres->results['0']['ec'];
	$arr_90['b2b']=$sres->results['0']['b2b'];


	$uqry2="insert into goods_sale_period (
	goodsno
	,tm7,tm15,tm1m,tm2m,tm3m
	,ec7,ec15,ec1m,ec2m,ec3m
	,b2b7,b2b15,b2b1m,b2b2m,b2b3m
	)values(
	'".$arr_7['tm']."','".$arr_15['tm']."','".$arr_30['tm']."','".$arr_60['tm']."','".$arr_90['tm']."',
	'".$arr_7['ec']."','".$arr_15['ec']."','".$arr_30['ec']."','".$arr_60['ec']."','".$arr_90['ec']."',
	'".$arr_7['b2b']."','".$arr_15['b2b']."','".$arr_30['b2b']."','".$arr_60['b2b']."','".$arr_90['b2b']."'

	)

	";

//tydebug($uqry);
   // $loop[]=$v;
}
 tydebug($loop);


?>