<?
include "../_header.php";member_chk();

$page_title='매출관리(브랜드)';
$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("now", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 
$type=$_GET['type']?$_GET['type']:"";
$order_type=$_GET['order_type']?$_GET['order_type']:"";
$checked['type'][$type]="checked";
$checked['order_type'][$order_type]="checked";

if($_GET['s_date'] && $_GET['e_date']){
    if($type)$where=" and b.type='".$type."'";
    if($order_type=='I'){
        $owhere=" and ol.deli_codeno!='outside'";
    }else if($order_type=='O'){
        $owhere=" and ol.deli_codeno='outside'";
    }
	
	$order_where=" and ol.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
    $cance_where=" and ol.mod_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";

    // $qry="select g.brandno, if(sum(ol.settle_price),sum(ol.settle_price),0) as order_price, if(sum(ol.order_num),sum(ol.order_num),0) as order_quantity, '0' as cancel_price, '0' cancel_quantity
    // from order_list ol 
    // left join goods g on(ol.goodsno=g.no) 
    // where 1=1 ".$order_where." ".$owhere." and ol.goodsno!=0
    // group by g.brandno
    // union 
    // select g.brandno,'0' as order_price, '0' as order_quantity, if(sum(ol.settle_price),sum(ol.settle_price),0) as cancel_price, if(sum(ol.order_num),sum(ol.order_num),0) as cancel_quantity
    // from order_list ol 
    // left join goods g on(ol.goodsno=g.no) 
    // where 1=1 ".$cance_where." ".$owhere." and ol.step2 >= 40 and ol.goodsno !=0
    // group by g.brandno
    // ";    

/*
    $qry="
    select 
        v.brandno
        , if(sum(v.order_price),sum(v.order_price),0) as order_price
        , if(sum(v.order_quantity),sum(v.order_quantity),0) as order_quantity
        , if(sum(v.cancel_price),sum(v.cancel_price),0) as cancel_price
        , if(sum(v.cancel_quantity),sum(v.cancel_quantity),0) as cancel_quantity
    from (
        select 
            if(g.brandno,g.brandno,ol.outside_brand) as brandno, ol.settle_price as order_price, ol.order_num as order_quantity
            , '0' as cancel_price, '0' cancel_quantity
        from order_list ol 
        left join goods g on(ol.goodsno=g.no) 
        where 1=1 ".$order_where." ".$owhere."       
        union 
        select 
            if(g.brandno,g.brandno,ol.outside_brand) as brandno,'0' as order_price, '0' as order_quantity
            , ol.settle_price as cancel_price, ol.order_num as cancel_quantity
        from order_list ol 
        left join goods g on(ol.goodsno=g.no) 
        where 1=1 ".$cance_where." ".$owhere." and ol.step2 >= 40
    ) v  group by brandno
    ";    
    */
    $qry="
    select 
        v.chk_brandno as brandno
        , if(sum(v.order_price),sum(v.order_price),0) as order_price
        , if(sum(v.order_quantity),sum(v.order_quantity),0) as order_quantity
        , if(sum(v.cancel_price),sum(v.cancel_price),0) as cancel_price
        , if(sum(v.cancel_quantity),sum(v.cancel_quantity),0) as cancel_quantity
    from (
        select 
            if(g.brandno,g.brandno,ol.outside_brand) as chk_brandno, sum(ol.settle_price) as order_price, sum(ol.order_num) as order_quantity
            , '0' as cancel_price, '0' cancel_quantity
        from order_list ol 
        left join goods g on(ol.goodsno=g.no) 
        where 1=1 ".$order_where." ".$owhere."       
        group by chk_brandno
        union 
        select 
            if(g.brandno,g.brandno,ol.outside_brand) as chk_brandno,'0' as order_price, '0' as order_quantity
            , sum(ol.settle_price) as cancel_price, sum(ol.order_num) as cancel_quantity
        from order_list ol 
        left join goods g on(ol.goodsno=g.no) 
        where 1=1 ".$cance_where." ".$owhere." and ol.step2 >= 40
        group by chk_brandno
    ) v  group by brandno
    ";    
      //tydebug1($qry);
    $res=$db->query($qry);

    foreach($res->results as $v){
        
        $oloop[$v['brandno']]['order_price']+=$v['order_price'];
        $oloop[$v['brandno']]['order_quantity']+=$v['order_quantity'];
        $oloop[$v['brandno']]['cancel_price']+=$v['cancel_price'];
        $oloop[$v['brandno']]['cancel_quantity']+=$v['cancel_quantity'];
    }
    //tydebug1($qry);
  //  tydebug($sumOrderPrice);
    
/*
    $bqry="select 
	b.brandnm
	#,(select if(sum(ol.settle_price),sum(ol.settle_price),0) from order_list ol left join goods g on(ol.goodsno=g.no) where 1=1 ".$order_where.") as order_price #주문금액
	#,(select if(sum(ol.order_num),sum(ol.order_num),0) from order_list ol left join goods g on(ol.goodsno=g.no) where 1=1 ".$order_where.") as order_quantity #주문수량
	#,(select if(sum(ol.settle_price),sum(ol.settle_price),0) from order_list ol left join goods g on(ol.goodsno=g.no) where 1=1 ".$cance_where." and step2 >= 40 ) as cancel_price #취소금액
	#,(select if(sum(ol.order_num),sum(ol.order_num),0) from order_list ol left join goods g on(ol.goodsno=g.no) where 1=1 ".$cance_where." and step2 >= 40 ) as cancel_quantity #취소수량
    from brand b 
    where 1=1
    ".$where."
    order by b.brandnm limit 100";	
*/
    $bqry="select *	from brand b 
    where 1=1
    ".$where."
    order by b.brandnm";	
	$bres=$db->query($bqry);
    $sumOrderPrice=0;
	$sumOrderQuantity=0;
	$sumCancelPrice=0;
	$sumCancelQuantity=0;
	foreach($bres->results as $k=>$v){		
        $v['order_price']+=$oloop[$v['no']]['order_price'];
        $v['order_quantity']+=$oloop[$v['no']]['order_quantity'];
        $v['cancel_price']+=$oloop[$v['no']]['cancel_price'];
        $v['cancel_quantity']+=$oloop[$v['no']]['cancel_quantity'];

         //합계금액
		$sumOrderPrice+=$oloop[$v['no']]['order_price'];
		$sumOrderQuantity+=$oloop[$v['no']]['order_quantity'];
		$sumCancelPrice+=$oloop[$v['no']]['cancel_price'];
        $sumCancelQuantity+=$oloop[$v['no']]['cancel_quantity'];

        $loop[]=$v;				
	}
}

$tpl->assign(array(	
'loop' => $loop
,'oloop' => $oloop
));

$tpl->print_('tpl');
?>