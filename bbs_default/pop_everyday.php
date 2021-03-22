<?
require_once("../outline/header.php");

$border = 0;
$tday = date('Y-m-d');
$close_date = date('Y-m-d',strtotime($tday.'-92 days'));

$qry = "select sl.social_name,sl.mall_name , sl.social_key,sl.social_Sdate ,sl.social_link, sl.social_id
,sum(if(sml.model_type='sale',1,0)) model_type_cnt from wd_social_list sl
join wd_social_model_list sml on sl.no = sml.sl_sn
join wd_mall_list ml on sl.mall_name = ml.wd_mall_name
where sl.social_name in('다운폰','그루폰')
and sl.social_Sdate > '2015-12-31'
and sl.social_Sdate <= '".$close_date."'
and sl.social_id!=''
group by sl.social_name,sl.mall_name , sl.social_key
having model_type_cnt > 0
";

$res = dbquery($qry);

?>


<script type="text/javascript">
	document.title = '';
</script>
<style>
div.jeahn_btn_layer{left:150px;}
</style>
<div class="main_wrap">

<h1>오픈 3개월 지난 딜</h1>
<table width=100% cellpadding="0" cellspacing="1" border="<?=$border?>" class="display_sort">
	<thead>
		<tr>
			<th>몰명</th>
			<th>회차</th>
			<th>오픈일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?
	while($row = mysql_fetch_assoc($res)){
	?>
		<tr class="text_center">
			<td class="jeahn_list"  param1="<?=$row['social_name']?>" param2="<?=$row['social_key']?>" param3="<?=$row['social_link']?>" param4=<?=trim($row['social_id'])?> param5="<?=$row['admin_link']?>">
				<?=$row['mall_name']?> <?=$row['social_name']?>
				<div class='jeahn_btn_layer'></div>
			</td>
			<td><?=$row['social_key']?></td>
			<td><?=$row['social_Sdate']?></td>
			<td><?=$row['social_id']?></td>
		</tr>
	<?}?>
	</tbody>
</table>

<center><button type="button" class="close_day">오늘 더이상 보지 않기</button></center>

<script>
$(function(){

	$(".close_day").click(function(){
		if(confirm('오늘 더이상 보지 않으시겠습니까?')){
			var date = new Date();
			var day_no = date.getDate();
			var sn  = 'pop_everyday';
			var ntime = 24 - date.getHours();
			date.setTime(date.getTime() + (ntime * 60 * 60 * 1000));
			$.cookie("alarm_pop"+day_no+sn, "1", { expires: date, path: '/' });
			self.close();
		}
	});
});
</script>

</div>
<?
require_once("../js/jeahn.php");
require_once("../outline/footer.php");
?>
