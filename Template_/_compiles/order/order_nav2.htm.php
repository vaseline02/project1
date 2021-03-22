<?php /* Template_ 2.2.8 2020/11/24 15:19:52 /www/html/ukk_test2/data/skin/order/order_nav2.htm 000005667 */ ?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?

$today=date('Y-m-d');

$mallsql="select upload_form_type from mall_list where upload_form_type!='' group by upload_form_type";
$mallres= $GLOBALS["db"]->query($mallsql);
foreach($mallres->results as $mallv){
	$upload_form_type_array[]=$mallv['upload_form_type'];
}	

$qry="select step,step2,count(*) cnt,bundle,reg_date,LEFT(mod_date,10) mod_date, deli_codeno from order_list where step in('0','1','2','3','4','6','7','8') ";
#and step2 in ('0','1','41') 

if($_POST['order_search_mall']){
	if(in_array($_POST['order_search_mall'],$upload_form_type_array)){
		$qry.="and upload_form_type='".$_POST['order_search_mall']."'";
	}else{
		$qry.="and mall_no='".$_POST['order_search_mall']."'";
	}
}

if($_POST['order_search_sdate'] && $_POST['order_search_edate']){

	$qry.="and reg_date between '".$_POST['order_search_sdate']."' and '".$_POST['order_search_edate']."' ";
}

$search_qrystr="order_search_mall=".$_POST['order_search_mall'];
$search_qrystr.="&order_search_sdate=".$_POST['order_search_sdate'];
$search_qrystr.="&order_search_edate=".$_POST['order_search_edate'];


$qry.="group by step,step2,bundle,reg_date,deli_codeno";
$res =  $GLOBALS["db"]->query($qry);
foreach($res->results as $v){
	
	if($v['bundle']>0)$gubun_b=2;
	else $gubun_b=1;
	if($v['reg_date']==$today && $v['step']=='2' && $v['step2']==0 ){

		$data_nav['2-'.$gubun_b.'-1']+=$v['cnt'];

	}else if($v['reg_date']!=$today && $v['step']=='2' && $v['step2']==0 ){

		$data_nav['2-'.$gubun_b.'-2']+=$v['cnt'];

	}else if( $v['step']=='2' && $v['step2']==1){

		$data_nav['2-'.$gubun_b.'-3']+=$v['cnt'];
	
	}else if( $v['step']=='4' && $v['step2']<=40){
		if($v['step2']==2){
		
			$data_nav[$v['step']]['change']+=$v['cnt'];			
		}else{
			$data_nav[$v['step']][$v['deli_codeno']]+=$v['cnt'];
		}
			
	}else if($v['step2']<40){

		$data_nav[$v['step']]+=$v['cnt'];

		if($v['bundle']>0)$bundle=1;
		else $bundle=0;

		$data_nav_b[$v['step']][$bundle]+=$v['cnt'];

	}else if( ($v['reg_date']==$today || $v['mod_date']==$today) && ($v['step2']>='39' && $v['step2']<'100')){ //취소건
		$data_nav_cancel+=$v['cnt'];
	}
}

if(strpos($_SERVER['PHP_SELF'],'order/order_upload'))$order_search_view=0;
else $order_search_view=1;
?>

<style>

</style>

<div class="col-lg-12 updateorder-contents">
	<div style="position:absolute;top:-50px;right:10px;margin:10px"><button type="button" class="btn-sm btn-primary" onclick="popup('order_tot_search.php','order_tot_search','1300')">주문 통합검색</button></div>
	<div class="panel panel-default panel-stock margin20">	
		<div class="panel-heading hidden">주문 업로드</div>
		<div class="updateorder-process">
			<ol>
                <li>
					<a href="order_stock_shortage.php?gubunb=3&tday=2&<?=$search_qrystr?>"  id="nav_div2-2-2"><div class="updateorder-box  " ><p>품절(단품/묶음)</p><span class="updateorder-cnt"><?=number_format($data_nav['2-1-1']+$data_nav['2-2-1']+$data_nav['2-1-2']+$data_nav['2-2-2'])?></span></div></a>
                </li>

					

                <li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>

                
                <li>
					<a href="order_stock_shortage_stand.php?gubunb=3&<?=$search_qrystr?>"  id="nav_div2-2-3"><div class="updateorder-box  active"><p>입고예정(단품/묶음)</p><span class="updateorder-cnt"><?=number_format($data_nav['2-1-3']+$data_nav['2-2-3'])?></span></div></a>
				</li>


				<li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>
				<li>
					<a href="order_d_hold.php?<?=$search_qrystr?>"  id="nav_div5-1"><div class="updateorder-box"><p>마진취소주문<br/>특이주문</p><span class="updateorder-cnt"><?=number_format($data_nav['8'])?></span></div></a>
				</li>
				<li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>
				<li>
					<a href="order_hold.php?<?=$search_qrystr?>"  id="nav_div5-2"><div class="updateorder-box"><p>재고보류주문(묶음)</p><span class="updateorder-cnt"><?=number_format($data_nav['3'])?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				</li>
				<li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>
				<li>
					<a href="order_settle.php?gubun=2&<?=$search_qrystr?>"  id="nav_div5-3"><div class="updateorder-box"><p>모델변경주문(CS)</p><span class="updateorder-cnt"><?=number_format($data_nav['4']['change'])?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				</li>
				<li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>
				<li>
					<a href="order_outside.php?<?=$search_qrystr?>"  id="nav_div6"><div class="updateorder-box"><p>위탁오더주문</p><span class="updateorder-cnt"><?=number_format($data_nav['6'])?></span></div></a>			
				</li>
				<li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>
				<li>
					<a href="order_settle.php?gubun=3&<?=$search_qrystr?>"  id="nav_div7-3"><div class="updateorder-box"><p>재고확보요청</p><span class="updateorder-cnt"><?=number_format($data_nav['4']['125'])?></span></div></a>
				</li>
			</ol>
		</div>
	</div>				
</div>

<?if($order_search_view){?><?php echo $this->define('tpl_include_file_1',"order/order_search.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?><?}?>

<?php }?>