<?php /* Template_ 2.2.8 2020/09/11 08:53:25 /www/html/ukk_test2/data/skin/admin/mall_list_set.htm 000003419 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<?php if($GLOBALS["h_control"]['calcu']){?>
<div>
    <button type="button" class="btn btn-sm btn-primary" onclick="popup('mall_list_reg.php','mall_reg','1100','800')">몰등록</button>    

	<button type="button" class="btn btn-sm btn-success" onclick="popup('mall_order_seq.php','mall_reg','500','500')">주문 우선발송 등록</button>    
</div>

<?php }?>
<form method="POST" name="mallListForm">
<input type="hidden" name="mode">
<input type="hidden" name="no">

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
            <th>고객코드</th>
            <th width="120">고객명</th>
            <!--<th>구분</th>-->
            <th>납품처코드</th>
            <th width="120">납품처명</th>
            <th>납품처코드(WMS)</th>
            <th>납품처명(WMS)</th>
            <th>실적코드</th>
            <th>실적팀명</th>
            <th>업로드구분</th>
			<th>발주서몰명</th>
            <th>사용유무</th>
            <th>본사오더 담당</th>
            <th width="120">브랜드</th>
            
            <th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
            <td><?php echo $TPL_V1["d_code"]?></td>
            <td><?php echo $TPL_V1["d_name"]?></td>
            <!--<td><?php echo $TPL_V1["d_type"]?></td>-->
            <td><?php echo $TPL_V1["d2_code"]?></td>
            <td><?php echo $TPL_V1["d2_name"]?></td>
            <td><?php echo $TPL_V1["mall_code"]?></td>
            <td><?php echo $TPL_V1["wms_mallnm"]?></td>
            <td><?php echo $TPL_V1["sales_code"]?></td>
            <td><?php echo $TPL_V1["sales_team"]?></td>
            <td><?php echo $TPL_V1["upload_form_type"]?></td>
            <td><?php echo $TPL_V1["mall_name"]?></td>
            <td><?php echo $TPL_V1["state"]?></td>
            <td><?php echo $TPL_V1["c_mem_name"]?></td>
            <td>
<?php if(is_array($TPL_R2=$TPL_V1["brand_arr"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <?php echo $TPL_V2["brandnm"]?><br>
<?php }}?>
                <!-- <?php echo $TPL_V1["brand"]?> -->
            </td>
			<td>
                <button type="button" class="btn btn-sm btn-warning" onclick="popup('mall_list_reg.php?no=<?php echo $TPL_V1["no"]?>&mode=mod','mall_reg','1100','800')">정보수정</button>
<?php if($GLOBALS["h_control"]['calcu']){?><button type="button" class="btn btn-sm btn-danger del" data-no=<?php echo $TPL_V1["no"]?>>삭제</button><?php }?>
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

<!--60이하 버튼제한-->
<?php $this->print_("footer",$TPL_SCP,1);?>