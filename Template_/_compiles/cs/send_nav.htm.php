<?php /* Template_ 2.2.8 2021/02/23 15:50:19 /www/html/ukk_test2/data/skin/cs/send_nav.htm 000004720 */ ?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?
$qry="select 
cd.send_type,cd.return_confirm,ci.return_type,ci.return_type_sub,count(cd.no) as cnt
from cs_info ci 
left join cs_detail cd on (ci.no=cd.cs_info_no)
where cd.send_type between '1' and '90' 
and ((ci.return_type in ('60','70') and ci.return_type_sub!='3') or ci.return_type='40' or ci.return_type='90')
and ci.add_type='1'
group by cd.send_type,cd.return_confirm, ci.return_type,ci.return_type_sub";
$res =  $GLOBALS["db"]->query($qry);
foreach($res->results as $v){
    if($v['send_type']=='90')$v['send_type']='1';

	if(($v['return_type']=='40' || $v['return_type']=='70' || $v['return_type']=='90') && $v['send_type']=='2'){
		$data_nav2[$v['send_type']]['exchange']+=$v['cnt'];
    }else if($v['return_type']=='80'){
        $data_nav[$v['send_type']]+=$v['cnt'];
    }else if($v['send_type']=='3'){
		if($v['return_type_sub']=="4") $v['return_type_sub']="1";
		$data_nav2[$v['send_type']][$v['return_type_sub']]+=$v['cnt'];
	}else{
		$data_nav[$v['send_type']]+=$v['cnt'];
	}

    //반품(회수확인)
	/*
    if($v['return_type']=='60' && $v['send_type']=='2'){
        if($v['return_confirm']){
            $data_nav[$v['send_type']]['return']+=$v['cnt'];
        }else{
            $data_nav[$v['send_type']][$v['return_confirm']]+=$v['cnt'];
        } 
        if($v['return_confirm']=='0')$data_nav['1']+=$v['cnt'];
    //교환(회수확인)
    }else if($v['return_type']=='70' && $v['send_type']=='2'){		
        if($v['return_confirm']){
            $data_nav[$v['send_type']]['exchange']+=$v['cnt'];
        } else {
            $data_nav[$v['send_type']][$v['return_confirm']]+=$v['cnt'];
        }
        if($v['return_confirm']=='0')$data_nav['1']+=$v['cnt'];
		
    //교환,반품(회수확인제외)
    }else if($v['return_type']=='60' || $v['return_type']=='70'){
        $data_nav[$v['send_type']]+=$v['cnt'];
    //품절재주문
    }else if($v['return_type']=='80'){
        $data_nav[$v['send_type']]+=$v['cnt'];
    }
	*/
}
$qry="select count(ad.no) as as_cnt from as_info ai 
left join as_detail ad on (ai.no=ad.info_no)
where as_status='6'";

$res =  $GLOBALS["db"]->query($qry);
$as_count=$res->results[0]['as_cnt'];
?>

<div class="updateorder-contents">
	<div class="panel panel-default panel-stock margin20">	
		<div class="updateorder-process">
			<ol>
				<li>
					<a href="send_reception.php" id="nav_div1"><div class="updateorder-box "><p>1.접수</p>
					<span class="updateorder-cnt"><?=$data_nav['1']?$data_nav['1']:'0'?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
				</li>
				<li>
					<a href="send_out.php" id="nav_div2"><div class="updateorder-box "><p>2.발송처리</p>
					<span class="updateorder-cnt"><?=$data_nav2['2']['exchange']?$data_nav2['2']['exchange']:'0'?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
				</li>
				<li>
					<a href="send_in.php?subtype=1" id="nav_div3-1"><div class="updateorder-box smallsize"><p>3-1.양품입고</p>
					<span class="updateorder-cnt"><?=$data_nav2['3']['1']?$data_nav2['3']['1']:'0'?></span></div></a>
					<a href="send_in.php?subtype=2" id="nav_div3-2"><div class="updateorder-box smallsize"><p>3-2.하자입고</p>
					<span class="updateorder-cnt"><?=$data_nav2['3']['2']?$data_nav2['3']['2']:'0'?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
				</li>
				<li>
					<a href="send_close.php" id="nav_div4"><div class="updateorder-box "><p>4.처리완료</p>
					<span class="updateorder-cnt"><?=$data_nav['4']?$data_nav['4']:'0'?></span></div></a>
				</li>
			</ol>
		</div>
	</div>		
	<!--
	<div class="panel panel-default panel-stock margin20">	
		<div class="updateorder-process">
			<ol>
				<li>					
					<a href="etc_order.php" id="nav_div2_c"><div class="updateorder-box "><p>품절재주문</p>
					<span class="updateorder-cnt"><?=$data_nav['20']?$data_nav['20']:'0'?></span></div></a>
				</li>
			</ol>
		</div>
	</div>
	-->
	<!-- <div class="panel panel-default panel-stock margin20">	
		<div class="updateorder-process">
			<ol>
				<li>					
					<a href="send_as.php" id="nav_div3_c"><div class="updateorder-box"><p>AS발송</p>
					<span class="updateorder-cnt"><?=$as_count?></span></div></a>
				</li>
			</ol>
		</div>
	</div>		 -->
</div>

<?php }?>