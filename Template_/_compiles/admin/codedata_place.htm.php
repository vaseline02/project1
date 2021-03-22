<?php /* Template_ 2.2.8 2021/03/11 12:02:01 /www/html/ukk_test2/data/skin/admin/codedata_place.htm 000001958 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<hr>

<div><button type="button" class="btn btn-primary" onclick="popup('codedata_place_reg.php','codedata_place_reg','1100','900')">등록</button></div>

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th>이름</th>
			<th>대분류</th>
			<th>재고배치순번</th>
			<th>더존장소코드</th>
			<!--<th>가용재고 포함유무</th>-->
			<th>재고위치 사용유무</th>
			<th>발주가능여부</th>
			<th>등록일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["cd"]?></td>
			<td><?php echo $GLOBALS["cfg_place_type"][$TPL_V1["place_type"]]?></td>
			<td><?php echo $TPL_V1["v"]?></td>
			<td><?php echo $TPL_V1["place_code"]?></td>
			<!--<td><?php echo $TPL_V1["stock_include_yn"]?></td>-->
			<td><?php echo $TPL_V1["view_yn"]?></td>
			<td><?php echo $TPL_V1["v2nm"]?></td>
			<td><?php echo $TPL_V1["save_time"]?></td>
			<td><button type="button" class="btn btn-sm btn-warning" onclick="popup('codedata_place_reg.php?codeno=<?php echo $TPL_V1["no"]?>','codedata_place_reg','1100','900')">정보수정</button></td>
		</tr>
<?php }}?>
	</tbody>
</table>


<script>
document.title="<?php echo $GLOBALS["page_title"]?>";


function popup1(src,name,width,height)
{
	window.open(src,name,'width=300,height=300,scrollbars=1,resizable=1');
}

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>