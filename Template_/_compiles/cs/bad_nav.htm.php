<?php /* Template_ 2.2.8 2021/03/03 09:40:32 /www/html/ukk_test2/data/skin/cs/bad_nav.htm 000006173 */ ?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?
$_GET['s_date']= $GLOBALS["s_date_value"];
$_GET['e_date']= $GLOBALS["e_date_value"];
$_GET['s_date_search']= $GLOBALS["s_date_search"];

if($_GET['s_date'] && $_GET['e_date'] && $_GET['s_date_search']){
	$add_nav_where[]=$_GET['s_date_search']." between '".$_GET['s_date']."' and '".$_GET['e_date']." 20:59:59' ";
	$qry_str="&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&s_date_search=".$_GET['s_date_search'];
}
if($_GET['s_goodsnm']){
	$add_nav_where[]="goodsnm='".$_GET['s_goodsnm']."' ";
	$qry_str.="&s_goodsnm=".$_GET['s_goodsnm'];
}

if($_GET['s_mod_admin']){
	$add_nav_where[]="m.name='".$_GET['s_mod_admin']."'";
	$qry_str.="&s_mod_admin=".$_GET['s_mod_admin'];
}
if($_GET['s_mod_date'] && $_GET['e_mod_date']){
	$add_nav_where[]="cb.mod_date between '".$_GET['s_mod_date']." 00:00:00' and '".$_GET['e_mod_date']." 23:59:59'";
	$qry_str.="&s_mod_date=".$_GET['s_mod_date']."&e_mod_date=".$_GET['e_mod_date'];
}
if($_GET['s_no']){
	$add_nav_where[]="cb.no='".$_GET['s_no']."' ";
	$qry_str.="&s_no=".$_GET['s_no'];
}
if($_GET['s_order_no']){
	$add_nav_where[]="cb.order_no='".$_GET['s_order_no']."' ";
	$qry_str.="&s_order_no=".$_GET['s_order_no'];
}
if($_GET['s_memo']){
	$add_nav_where[]="cb.memo like '%".$_GET['s_memo']."%' ";
	$qry_str.="&s_memo=".$_GET['s_memo'];
}
if($_GET['s_repair_memo']){
	$add_nav_where[]="cb.repair_memo like '%".$_GET['s_repair_memo']."%' ";
	$qry_str.="&s_repair_memo=".$_GET['s_repair_memo'];
}
if($_GET['s_admin_memo']){
	$add_nav_where[]="cb.admin_memo like '%".$_GET['s_admin_memo']."%' ";
	$qry_str.="&s_admin_memo=".$_GET['s_admin_memo'];
}


$add_where=" and ".implode(" and ",$add_nav_where);

$qry="select 
cb.step,cb.order_no,count(cb.no) as cnt
from cs_bad cb 
left join member m on (cb.mod_admin_no=m.no)
where 1 
".$add_where."
group by cb.step,cb.order_no";

$res =  $GLOBALS["db"]->query($qry);
foreach($res->results as $v){
	if($v['step']=='1'){
		if($v['order_no']){
			$data_nav[$v['step']][0]+=$v['cnt'];
		}else{
			$data_nav[$v['step']][1]+=$v['cnt'];
		}
		
	}else{
		$data_nav[$v['step']]+=$v['cnt'];
	}
}
?>

<div class="updateorder-contents">
	<div class="panel panel-default panel-stock margin20">	
		<div class="updateorder-process">
			<ol>
				<li>
					<a href="bad_list.php" id="nav_div"><div class="updateorder-box "><p>전체</p>
					<!--<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 0]){?><?php echo $GLOBALS["data_nav"][ 0]?><?php }else{?>0<?php }?></span>--></div></a>
				</li>
				<li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>
				<li>
					<a href="bad_list.php?step=1&step_sub=0<?=$qry_str?>" id="nav_div1_0"><div class="updateorder-box smallsize"><p>3-2.하자입고</p>
					<span class="updateorder-cnt"><?=$data_nav['1']['0']?$data_nav['1']['0']:'0'?></span></div></a>
					<a href="bad_list.php?step=1&step_sub=1<?=$qry_str?>" id="nav_div1_1"><div class="updateorder-box smallsize"><p>3-2.하자입고(엑셀)</p>
					<span class="updateorder-cnt"><?=$data_nav['1']['1']?$data_nav['1']['1']:'0'?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:65px;" aria-hidden="true"></span>
				</li>
				<li>
					<a href="bad_list.php?step=20<?=$qry_str?>" id="nav_div20"><div class="updateorder-box "><p>4.접수</p>
					<span class="updateorder-cnt"><?=$data_nav['20']?$data_nav['20']:'0'?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:65px;" aria-hidden="true"></span>
				</li>
				<li>
					<a href="bad_list.php?step=40<?=$qry_str?>" id="nav_div40"><div class="updateorder-box smallsize"><p>5-1.자체수리</p>
					<span class="updateorder-cnt"><?=$data_nav['40']?$data_nav['40']:'0'?></span></div></a>
					<a href="bad_list.php?step=41<?=$qry_str?>" id="nav_div41"><div class="updateorder-box smallsize"><p>5-2.자체수리(해외자재요청)</p>
                    <span class="updateorder-cnt"><?=$data_nav['41']?$data_nav['41']:'0'?></span></div></a>
                    <a href="bad_list.php?step=42<?=$qry_str?>" id="nav_div42"><div class="updateorder-box smallsize"><p>5-3.국내본사수리요청</p>
                    <span class="updateorder-cnt"><?=$data_nav['42']?$data_nav['42']:'0'?></span></div></a>
                    <a href="bad_list.php?step=43<?=$qry_str?>" id="nav_div43"><div class="updateorder-box smallsize"><p>5-4.해외본사수리요청</p>
                    <span class="updateorder-cnt"><?=$data_nav['43']?$data_nav['43']:'0'?></span></div></a>
					<a href="bad_list.php?step=45<?=$qry_str?>" id="nav_div45"><div class="updateorder-box smallsize"><p>5-5.수리완료대기</p>
                    <span class="updateorder-cnt"><?=$data_nav['45']?$data_nav['45']:'0'?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:65px;" aria-hidden="true"></span>
                </li>
                <li>
					<a href="bad_list.php?step=60<?=$qry_str?>" id="nav_div60"><div class="updateorder-box smallsize"><p>6-1.수리완료</p>
					<span class="updateorder-cnt"><?=$data_nav['60']?$data_nav['60']:'0'?></span></div></a>
					<a href="bad_list.php?step=61<?=$qry_str?>" id="nav_div61"><div class="updateorder-box smallsize"><p>6-2.수리불가(폐기)</p>
                    <span class="updateorder-cnt"><?=$data_nav['61']?$data_nav['61']:'0'?></span></div></a>
                    <a href="bad_list.php?step=62<?=$qry_str?>" id="nav_div62"><div class="updateorder-box smallsize"><p>6-3.리퍼</p>
                    <span class="updateorder-cnt"><?=$data_nav['62']?$data_nav['62']:'0'?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:65px;" aria-hidden="true"></span>
				</li>
				<li>
					<a href="bad_list.php?step=80<?=$qry_str?>" id="nav_div80"><div class="updateorder-box "><p>7-2.폐기리스트</p>
					<span class="updateorder-cnt"><?=$data_nav['80']?$data_nav['80']:'0'?></span></div></a>
				</li>
			</ol>
		</div>
	</div>		
</div>

<?php }?>