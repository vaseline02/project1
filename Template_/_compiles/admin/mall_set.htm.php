<?php /* Template_ 2.2.8 2020/07/20 10:09:24 /www/html/ukk_test/data/skin/admin/mall_set.htm 000002099 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<div>
    <button type="button" class="btn btn-sm btn-primary" onclick="popup('mall_reg.php','mall_reg','500','500')">몰등록</button>    

	<button type="button" class="btn btn-sm btn-success" onclick="popup('mall_order_seq.php','mall_reg','500','500')">주문 우선발송 등록</button>    
</div>

<form method="POST" name="mallListForm">
<input type="hidden" name="mode">
<input type="hidden" name="no">

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
            <th>몰코드</th>
			<th>몰명</th>
			<th>파일구분</th>
			<th>사용유무</th>
			<th>등록일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
            <td><?php echo $TPL_V1["mall_code"]?></td>
			<td><?php echo $TPL_V1["mall_name"]?></td>
			<td><?php echo $TPL_V1["upload_form_type"]?></td>
			<td><?php echo $TPL_V1["state"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td>
                <button type="button" class="btn btn-sm btn-warning" onclick="popup('mall_reg.php?no=<?php echo $TPL_V1["no"]?>&mode=mod','mall_reg','500','500')">정보수정</button>
                <button type="button" class="btn btn-sm btn-danger del" data-no=<?php echo $TPL_V1["no"]?>>삭제</button>
            </td>
		</tr>
<?php }}?>
	</tbody>
</table>
</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".del").click(function(){    
    if(confirm('삭제 하시겠습니까?')){
        $("input[name='mode']").val('del');
        $("input[name='no']").val($(this).data('no'));
        $("form[name='mallListForm']").submit();
    }
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>