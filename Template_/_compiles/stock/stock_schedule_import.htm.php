<?php /* Template_ 2.2.8 2021/03/02 14:06:21 /www/html/ukk_test2/data/skin/stock/stock_schedule_import.htm 000007353 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
			<button type="button" class="btn btn-success" onclick="location.href='../xls_file/stock_exceln.xlsx'">양식 다운로드</button>
		</td>
		<th>국내입고 <br/>업체선택</th>
		<td style="position:relative">
			<input type="text" name="mallnm" id="" class="mallnm_check" value="">
			<div class="mallnm_info" style="color: red;position:absolute;background-color:#fff;z-index:2;padding:0px 10px;"></div>
			(국내입고시에만 설정)
		</td>
    </tr>
</table>
</form>
<?php }?>



<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<input type="hidden" name="d_code" id="d_code">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
			<th>브랜드</th>
			<th>분류</th>
			<th>이미지</th>
			<th>모델명1</th>
			<th>모델명2</th>
			<th>원산지</th>
			<th>거래처</th>
			<th>수량</th>
			<th>외화</th>
			<th>환율</th>
			<th>관세율</th>
			<th>부대비용</th>
			<th>수수료</th>
			<th>메모</th>
			<th>비고</th>
			<th>등록일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	
		<tr>
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["catenm"]?></td>
			
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><input type="text" class="goodsChk" name="m_goodsnm[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["goodsnm"]?>" data-no="<?php echo $TPL_V1["no"]?>"><span class="goodsyn_<?php echo $TPL_V1["no"]?>"></span></td>
			<td><?php echo $TPL_V1["goodsnm_sub"]?></td>
			<td><?php echo $TPL_V1["origin"]?></td>
			<td><?php echo $TPL_V1["codename"]?></td>
			<td><?php echo number_format($TPL_V1["stock_num_reg"])?></td>
			<td><?php echo number_format($TPL_V1["cost_std"])?></td>
			<td><?php echo number_format($TPL_V1["rate"], 1)?></td>
			<td><?php echo $TPL_V1["duty_per"]?>%</td>
			<td><?php echo $TPL_V1["extra_expense"]?>%</td>
			<td><?php echo $TPL_V1["charge"]?>%</td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td><?php if($TPL_V1["new_chk"]=='y'){?><font color=red>신규모델</font><?php }?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td>
				<button type="button" class="btn btn-warning" onclick="popup('stock_mod.php?no=<?php echo $TPL_V1["no"]?>&page_type=1','stock_mod','600','600')">수정</button>
			</td>
			

		</tr>
<?php }}?>
	</tbody>
</table>


<?php if($GLOBALS["print_xls"]!= 1){?>

<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?>, 입고수량 : <?php echo number_format($GLOBALS["stock_sum"])?></div>
<div class="bottom_btn_box">
	<div class="box_left">
	<button type="button" class="btn btn-danger del">선택모델삭제</button>
	</div>
	<div  class="box_right">
	<button type="button" class="btn btn-primary mod">모델명 변경</button>
	<br/><br/>

	<select class="ex-select" name="cal_type">
		<option value="success" data-color="#449d44">green</option>
		<option value="info" data-color="#5bc0de">lightblue</option>
		<option value="yellow" data-color="#dddddd">gray</option>
		
		<option value="warning" data-color="#f0ad4e">yellow</option>
		<option value="important" data-color="#d9534f">red</option>
		
	</select>
	<input type="text" name="cal_date" id="cal_date" class="datepicker_common" autocomplete="off">
	<input type="text" name="cal_text" id="cal_text" style="width:250px;" required>
	<button type="button" class="btn btn-primary" id="stock_comp">입고예정완료</button>

	</div>
</div>

<?php }?>

</form>


<style>
.ex-select {border-radius:0.5em; border:3px solid;vertical-align:middle}
</style>

 
<script>
$(function() {
	$('.ex-select').change(function(e) {
		var $this = $(this);
		var c = $this.find('option:selected').data('color');
		$this.css({'color':c, 'border-color': c});
	});
	$('.ex-select').each(function() {
		var $this = $(this);
		$this.trigger('change');
		$this.find('option').each(function() {
			$(this).css('color',$(this).data('color'));
		});
	});
});
</script>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

function mallnmin(code,name){
	
	$(".mallnm_check").val(name);
	$("#d_code").val(code);
	
	$('.mallnm_info').empty();
}

$(function(){

	$(".mallnm_check").keyup(function(){
		var mallnm=$(this).val();
		var noticeValue='';
		var exdata='';
		$.post("../ajax/chk_mallnm.php",{mallnm:mallnm},function(data){
			$('.mallnm_info').empty();
			
			$.each(data,function(index, item){		
				
				exdata=item.split("^");
					
				noticeValue+="<div><a href=\"javascript:mallnmin('"+exdata[0]+"','"+exdata[1]+"')\" style='color: red;'>"+exdata[1]+"</a></div>";
			});

			$('.mallnm_info').append(noticeValue);
			
		},'json');
	});

	$(".goodsChk").keyup(function(){
		var goodsnm=$(this).val();
		var no=$(this).data("no");
		
		$.ajax({
            url: "../order/chk_model.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "model_name="+goodsnm,
            success: function(data){
               $('.goodsyn_'+no+':last').empty();
				if(data=='N'){				
					$('.goodsyn_'+no+':last').append('<br>* 해당 모델은 존재하지않습니다.');
				}
            },
            error: function (request, status, error){        
                console.log(error);
            }
        });
	});

	$(".del").click(function(){
		if( $(".chk_no:checked").length <=0 ){
			alert('삭제할 목록을 선택해주세요.');
			return;
		}

		if(confirm('삭제 하시겠습니까?')){
			
			$("#mode").val("del");
			$("#main_form").submit();
		}
	});

	
	$(".mod").click(function(){
		if( $(".chk_no:checked").length <=0 ){
			alert('변경할 목록을 선택해주세요.');
			return;
		}

		if(confirm('변경 하시겠습니까?')){
			
			$("#mode").val("mod");
			$("#main_form").submit();
		}
	});

	$("#stock_comp").click(function(){
		
		var sloc=$(".stock_comp_loc option:selected").html();

		if( $("#cal_date").val()=='' ){
			alert('일정을 입력해주세요.');
			$("#cal_date").focus();
			return;
		}

		if( $(".chk_no:checked").length <=0 ){
			alert('입고예정등록할 상품을 선택해주세요.');
			return;
		}

		if( $("#cal_text").val()=='' ){
			alert('일정명을 입력해주세요.');
			$("#cal_text").focus();
			return;
		}

		if(confirm('입고예정등록 하시겠습니까?')){
			
			$("#mode").val("stock_comp");
			$("#main_form").submit();
		}
	});
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>