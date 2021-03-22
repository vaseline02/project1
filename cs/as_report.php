<?
include "../_header.php";
$page_title='AS팀 결산자료';

$time = time(); 
$_GET['s_date']=$_GET['s_date']?$_GET['s_date']:date("Y-m",strtotime("now", $time)); 
$_GET['e_date']=$_GET['e_date']?$_GET['e_date']:date("Y-m",strtotime("now", $time)); 

if($_GET['s_date'] && $_GET['e_date']){
    
    //as접수,비용
    $qry="select month_date, sum(cnt1) as cnt1, sum(cnt2) as cnt2, sum(cnt3) as cnt3, sum(cnt4) as cnt4, sum(cnt5) as cnt5, sum(cnt6) as cnt6, sum(cnt7) as cnt7, sum(cnt8) as cnt8, sum(cnt9) as cnt9, sum(cnt10) as cnt10, sum(cnt11) as cnt11, sum(cnt12) as cnt12, sum(cnt13) as cnt13, sum(cnt14) as cnt14, sum(cnt15) as cnt15, sum(cnt5+cnt6) as t_cnt from (
        #고객접수
        select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as cnt1,'0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from as_info ai 
        left join as_detail ad on(ai.no=ad.info_no) 
        where  DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."'
        group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        union
        #고객출고
        select DATE_FORMAT(ad.out_regdate,'%Y-%m') as month_date, '0' as cnt1, count(ad.no) as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from as_info ai 
        left join as_detail ad on(ai.no=ad.info_no) 
        where DATE_FORMAT(ad.out_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."'         
        group by DATE_FORMAT(ad.out_regdate,'%Y-%m')
        union 
        #상품접수건
        select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, '0' as cnt1, '0' as cnt2, count(cb.no) as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from cs_bad cb 
        where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."'     
        group by DATE_FORMAT(cb.reg_date,'%Y-%m')    
        union 
        #상품출고건
        select DATE_FORMAT(cb.mod_date,'%Y-%m') as month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, count(cb.no) as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from cs_bad cb 
        where DATE_FORMAT(cb.mod_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and step in ('60','62')         
        group by DATE_FORMAT(cb.mod_date,'%Y-%m')
        union
        #자체접수건
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, sum(v1.self_cnt) as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from 
        (
            select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, count(cb.no) as self_cnt from cs_bad cb 
            where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and cb.repair_type in ('자체','시계수리연구소')
            group by DATE_FORMAT(cb.reg_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as self_cnt from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where  DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.progress_company in ('자체','시계수리연구소')    
            group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        ) v1 group by month_date
        union 
        #본사접수건
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, sum(v2.self_cnt) as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from 
        (
            select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, count(cb.no) as self_cnt from cs_bad cb 
            where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and cb.repair_type not in ('자체','시계수리연구소')
            group by DATE_FORMAT(cb.reg_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as self_cnt from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where  DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.progress_company not in ('자체','시계수리연구소')    
            group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        ) v2 group by month_date
        union
        #무한
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, sum(v3.self_cnt) as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from 
        (
            select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, count(cb.no) as self_cnt from cs_bad cb 
            where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and cb.repair_type='무한'
            group by DATE_FORMAT(cb.reg_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as self_cnt from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.progress_company='무한'    
            group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        ) v3 group by month_date
        union 
        #은하사
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, sum(v4.self_cnt) as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from 
        (
            select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, count(cb.no) as self_cnt from cs_bad cb 
            where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and cb.repair_type='은하사'
            group by DATE_FORMAT(cb.reg_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as self_cnt from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where  DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.progress_company='은하사'    
            group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        ) v4 group by month_date
        union
        #도우덱
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, sum(v5.self_cnt) as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from 
        (
            select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, count(cb.no) as self_cnt from cs_bad cb 
            where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and cb.repair_type='도우덱'
            group by DATE_FORMAT(cb.reg_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as self_cnt from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.progress_company='도우덱'    
            group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        ) v5 group by month_date
        union
        #크리스챤
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, sum(v6.self_cnt) as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from 
        (
            select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, count(cb.no) as self_cnt from cs_bad cb 
            where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and cb.repair_type='크리스챤'
            group by DATE_FORMAT(cb.reg_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as self_cnt from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where  DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.progress_company='크리스챤'    
            group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        ) v6 group by month_date
        union
        #그외본사
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, sum(v7.self_cnt) as cnt11, '0' as cnt12, '0' as cnt13, '0' as cnt14, '0' as cnt15 from 
        (
            select DATE_FORMAT(cb.reg_date,'%Y-%m') as month_date, count(cb.no) as self_cnt from cs_bad cb 
            where DATE_FORMAT(cb.reg_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and cb.repair_type not in ('자체','시계수리연구소','무한','은하사','도우덱','크리스챤')
            group by DATE_FORMAT(cb.reg_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.in_regdate,'%Y-%m') as month_date, count(ad.no) as self_cnt from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where DATE_FORMAT(ad.in_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.progress_company not in ('자체','시계수리연구소','무한','은하사','도우덱','크리스챤')    
            group by DATE_FORMAT(ad.in_regdate,'%Y-%m')
        ) v7 group by month_date
        union
        #자체공가,소가
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, sum(customer_cost) as cnt12, sum(real_cost) as cnt13, '0' as cnt14, '0' as cnt15 from (
            select DATE_FORMAT(cb.mod_date,'%Y-%m') as month_date, '0' as customer_cost, sum(cb.repair_cost) as real_cost from cs_bad cb 
            where DATE_FORMAT(cb.mod_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and step in ('60','62') and cb.repair_type in ('자체','시계수리연구소')
            group by DATE_FORMAT(cb.mod_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.out_regdate,'%Y-%m') as month_date, sum(ai.customer_cost) as customer_cost, sum(ai.real_cost) as real_cost from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where  DATE_FORMAT(ad.out_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.as_status='6' and ad.progress_company in ('자체','시계수리연구소')    
            group by DATE_FORMAT(ad.out_regdate,'%Y-%m') 
        ) v8 group by month_date
        union
        #본사공가,소가
        select month_date, '0' as cnt1, '0' as cnt2, '0' as cnt3, '0' as cnt4, '0' as cnt5, '0' as cnt6, '0' as cnt7, '0' as cnt8, '0' as cnt9, '0' as cnt10, '0' as cnt11, '0' as cnt12, '0' as cnt13, sum(customer_cost) as cnt14, sum(real_cost) as cnt15 from (
            select DATE_FORMAT(cb.mod_date,'%Y-%m') as month_date, '0' as customer_cost, sum(cb.repair_cost) as real_cost from cs_bad cb 
            where DATE_FORMAT(cb.mod_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and step in ('60','62') and cb.repair_type not in ('자체','시계수리연구소')
            group by DATE_FORMAT(cb.mod_date,'%Y-%m')
            union 
            select DATE_FORMAT(ad.out_regdate,'%Y-%m') as month_date, sum(ai.customer_cost) as customer_cost, sum(ai.real_cost) as real_cost  from as_info ai 
            left join as_detail ad on(ai.no=ad.info_no) 
            where  DATE_FORMAT(ad.out_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.as_status='6' and ad.progress_company not in ('자체','시계수리연구소')    
            group by DATE_FORMAT(ad.out_regdate,'%Y-%m') 
        ) v9 group by month_date
        
    ) v where month_date is not null group by month_date";
    // tydebug($qry);
	$res = $db->query($qry);
	foreach($res->results as $v){      		
		$loop[$v['month_date']]=$v;		
    }	


    //브랜드별 수리비
    $qry="     
    select * from (
        select 'bad' as type, cb.no, 'y' as report_yn, '' as detail_no, '' as cate, cb.repair_memo as repair_memo, b.brandnm, cb.goodsnm, cb.repair_type as company_name
        , '무상' as claim_type,'0' as customer_cost, cb.repair_cost as real_cost
        , cb.mod_date as list_date, DATE_FORMAT(cb.mod_date,'%Y-%m') as month_date from 
        cs_bad cb 
        left join goods g on (cb.goods_no=g.no)
        left join brand b on (g.brandno=b.no)
        where DATE_FORMAT(cb.mod_date,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and step in ('60','62') 
        union 
        select 'as' as type, ai.no, ai.report_yn, ad.no as detail_no, ad.as_cate as cate, '' as repair_memo, ad.brandnm, ad.goodsnm, ad.progress_company as company_name
        , if(ai.customer_cost>0,'유상','무상') as claim_type, ai.customer_cost as customer_cost, ai.real_cost as real_cost
        , ad.out_regdate as list_date, DATE_FORMAT(ad.out_regdate,'%Y-%m') as month_date from 
        as_info ai 
        left join as_detail ad on(ai.no=ad.info_no) 
        where  DATE_FORMAT(ad.out_regdate,'%Y-%m') between '".$_GET['s_date']."' and '".$_GET['e_date']."' and ad.as_status='6'
    )v order by list_date  desc
    ";
    // tydebug($qry);
	$res = $db->query($qry);
	foreach($res->results as $v){      		
        $sum+=$v['customer_cost'];
        $sum2+=$v['real_cost'];
        $repair_array="";
        if($v['type']=='as'){
            $sqry="select * from as_repair ar where detail_no='".$v['detail_no']."'";
            $sres = $db->query($sqry);
	        foreach($sres->results as $sv){  
                if($sv['as_code']=='98' || $sv['as_code']=='99'){
                    $repair_array[]=$sv['as_memo'];
                }else{
                    if($cfg_as_contents[$v['cate']][$sv['as_code']])$repair_array[]=$cfg_as_contents[$v['cate']][$sv['as_code']];
                }
            }
            //if(is_array($repair_array))$v['repair_memo']="[".implode("][",$repair_array)."]";
            if(is_array($repair_array))$v['repair_memo']=implode(",",$repair_array);
        }
		$bloop[]=$v;		
    }	
        
	$tpl->assign(array(	
	'data' => $data
	,'loop' => $loop
	,'bloop' => $bloop
	,'pg'=> $pg	
	));		
	
}

$tpl->print_('tpl');
?>


