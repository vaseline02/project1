<?php /* Template_ 2.2.8 2020/10/12 14:25:44 /www/html/ukk_test2/data/skin/goods/goods_barcode.htm 000005378 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td><input type="file" name="excelFile[]" required/><button class="btn btn-primary">업로드</button></td>
    </tr>
</table>
</form>
<?php }?>


<?php if($GLOBALS["print_xls"]!= 1){?>
<style>
    .mallLabel{ display:inline-block; width:180px; line-height:30px;}
</style>
<form method="get" id="glb_search_form">
<input type="hidden"name="print_xls" value="">

<table class="table table-bordered " >
	<tbody>
		<tr>
			<th>브랜드</th>
			<td><input name="s_brand" type="text" value="<?php echo $_REQUEST['s_brand']?>"></td>
			<th>모델명 다중검색</th>
			<td><textarea name="s_paste" id="" style="height:100px;" cols="30"><?php echo $_REQUEST['s_paste']?></textarea></td>
        </tr>
        <tr>
            <th>기타</th>
            <td colspan='3'>
                <label style="font-weight: normal;"><input type="checkbox" name="noBarcode" value="1" <?php echo $GLOBALS["checked"]['noBarcode']['1']?>>바코드없는 상품만 검색</label>
            </td>
        </tr>
	</tbody>
</table>

<center style="margin-bottom:20px;">
<button class="btn btn-primary">검 색</button> 
<!--<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>-->
</center>
</form>

<?php }?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<table id="" class="display display_dt barcodeTable" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th width="150">브랜드</th>
			<th>모델명</th>
			<th>이미지</th>
			<th>가격</th>
            <th>바코드</th>
            <th>총재고</th>
            <th>사무실</th>
            <th>3자물류</th>
            <th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo number_format($TPL_V1["c_price"])?></td>
			<td>
<?php if(count($TPL_V1["barcode"])){?>
<?php if(is_array($TPL_R2=$TPL_V1["barcode"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <div><?php echo $TPL_V2["barcode"]?></div>
<?php }}?>
<?php }?>
			</td>
			<td><?php echo number_format($TPL_V1["cur_cnt"])?></td>
			<td><?php echo number_format($TPL_V1["codeno_1"])?></td>
			<td><?php echo number_format($TPL_V1["codeno_51"])?></td>
            <td><div class="btn btn-sm btn-warning" onclick="popup('goods_barcode_reg.php?no=<?php echo $TPL_V1["no"]?>','','1100','900')">등록/수정</div></td>
		</tr>
<?php }}?>
	</tbody>
</table>
<?php }else{?>
<div style="color: red; font-weight: bold;">* 엑셀에 입력된 상품의 바코드로 새로등록됩니다.</div>
<div style="color: red; font-weight: bold;">* 빨간표시된 타이틀의 내용은 수정하지마세요.</div>
<table id="" class="display display_dt barcodeTable" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th><div style="color: red;">상품코드</div></th>
			<th><div style="color: red;">브랜드</div></th>
			<th><div style="color: red;">모델명</div></th>			
			<th>바코드<div style="color: red;">* |구분자로 등록해주세요.</div></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["no"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td style="mso-number-format:'\@'">
<?php if(count($TPL_V1["barcode"])){?>
<?php if(is_array($TPL_R2=$TPL_V1["barcode"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?><?php if($TPL_K2!= 0){?>|<?php }?><?php echo $TPL_V2["barcode"]?><?php }}?>
<?php }?>
            </td>            
		</tr>
<?php }}?>
	</tbody>
</table>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
    $(".checkForm").click(function(){
        var scnt=$("select[name='s_cnt["+$(this).data('no')+"]']").val();
        var ecnt=$("select[name='e_cnt["+$(this).data('no')+"]']").val();
        var movecnt=$("input[name='moveCnt["+$(this).data('no')+"]']").val();
        
        if(!scnt){
            alert('차감위치를 선택해주세요.');
            return false;
        }else if(!ecnt){
            alert('증가위치를 선택해주세요.');
            return false;
        }else if(!movecnt){
            alert('수량을 등록해주세요.');
            return false;
        }else{
            $("input[name=no]").val($(this).data('no'));
            $("form[id='main_form']").submit();
        }
    });
	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#glb_search_form").submit();
		$("input[name='print_xls']").val("0");
	});
    
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>