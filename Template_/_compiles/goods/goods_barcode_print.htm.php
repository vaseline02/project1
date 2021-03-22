<?php /* Template_ 2.2.8 2020/10/12 15:26:03 /www/html/ukk_test2/data/skin/goods/goods_barcode_print.htm 000008788 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<h1><?php echo $GLOBALS["page_title"]?></h1>

<form enctype="multipart/form-data" method="POST" name="insForm" id="insForm">
<input type="hidden" name="mode" value="ins">
<table class="table table-bordered" >
    <tr>
        <th>등록</th>
        <td>
            <table class="table table-bordered" >
                <tr>
                    <th>모델명</th>
                    <th>출력사유</th>
                    <th>수량</th>
                    <th style="width:10px;"></th>
                </tr>
                <tr>
                    <td><input type="text" name="goodsnm" style="width:100%"></td>
                    <td><input type="text" name="memo" style="width:100%"></td>
                    <td><input type="text" name="quantity" style="width:100%"></td>
                    <td style="text-align: center;"><button class="btn btn-primary dataIns" data-mode='ins' data-title='개별업로드'>등록</button></td>
                </tr>
            </table>
        </td>
        <th>엑셀등록</th>
        <td>
            <input type="file" name="excelFile[]" id="excelFile" required/><button class="btn btn-primary dataIns" data-mode='excelupload' data-title='엑셀업로드'>업로드</button>
            <button type="button" class="btn btn-success" onclick="location.href='../xls_file/barcode_print_upload.xls'">양식 다운로드</button>
        </td>
    </tr>
</table>
</form>

<form method="get" id="glb_search_form">
<input type="hidden"name="print_xls" value="">

<table class="table table-bordered " >
	<tbody>
		<tr>
			<th>등록일</th>
			<td>
                <div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
                    <button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
                    <button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>7일</button>
                    <button type="button" class="btn btn-default dayChange" data-int='15' data-type='day'>15일</button>
                    <button type="button" class="btn btn-default dayChange" data-int='1' data-type='month'>1개월</button>
                    <button type="button" class="btn btn-default dayChange" data-int='3' data-type='month'>3개월</button>
                    <button type="button" class="btn btn-default dayChange" data-int='1' data-type='year'>1년</button>
                    <!-- <button type="button" class="btn btn-primary">전체</button> -->
                </div>
                <div class="col-md-2 date-wrap">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $GLOBALS["s_date_value"]?>" readonly />
                        <span class="input-group-btn">
                            <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                        </span>
                    </div>
                </div>
                
                <p class="date-tilde">~</p>
                <div class="col-md-2 date-wrap">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $GLOBALS["e_date_value"]?>" readonly />
                        <span class="input-group-btn">
                            <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                        </span>
                    </div>										
                </div>						
            </td>
        </tr>
        
</table>

<center style="margin-bottom:20px; padding-top: 10px;">
    <button class="btn btn-primary">검 색</button> 
    <button type="button" class="btn btn-success" id="print_xls">선택엑셀 다운로드</button>
</center>
</form>
<?php }?>

<form method="POST" id="barcodeForm" name="barcodeForm">
    <input type="hidden" name="mode" value="print">
    <table id="" class="display display_dt barcodeTable" border="<?php echo $GLOBALS["xls_border"]?>">
        <thead>
            <tr>
                <th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
                <th width="150"></th>
                <th>작성자</th>
                <th>브랜드명</th>
                <th>출력 원하는 모델명</th>
                <th>바코드</th>
                <th>출력사유</th>
                <th>수량</th>
                <th>담당자 출력확인</th>
                <!-- <th></th> -->
            </tr>
        </thead>
        <tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
            <tr>
                <td><?php if($TPL_V1["print_date"]){?>출력완료<?php }else{?><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"><?php }?></td>
                <td><?php echo $TPL_V1["reg_date"]?></td>
                <td><?php echo $TPL_V1["name"]?></td>
                <td><?php echo $TPL_V1["brandnm"]?></td>
                <td><?php echo $TPL_V1["goodsnm"]?></td>
                <td><?php echo $TPL_V1["barcode"]?></td>
                <td><?php echo $TPL_V1["memo"]?></td>
                <td><?php echo $TPL_V1["quantity"]?></td>
                <td><?php if($TPL_V1["mod_name"]){?>[<?php echo $TPL_V1["mod_name"]?>]<?php }?><?php echo $TPL_V1["print_date"]?></td>
                <!-- <td></td> -->
            </tr>
<?php }}?>
        </tbody>
    </table>
<?php if($GLOBALS["print_xls"]!= 1){?>
    <div class="bottom_btn_box">
        <div class="box_left">
            <button type="button" class="btn btn-primary checkForm" data-mode="print">출력확인</button>
        </div>
        <div  class="box_right">		
            
        </div>
    </div>
<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
    $(".checkForm").click(function(){
        $("input[name='mode']").val($(this).data("mode"));
        
        if(!$(".chk_no").is(":checked")){
            alert("선택된 접수건이 없습니다.");
            return false;        
        }
        if(confirm('[출력확인] 처리하시겠습니까?')) $("#barcodeForm").submit();
    });	
        
    $(".dataIns").click(function(){
        var mode=$(this).data('mode');
        var title=$(this).data('title');
        if(mode=="excelupload"){
            if(!$("#excelFile").val()){
                alert("파일을 등록해주세요.");
                return false;
            }
        }else{
            if(!$("input[name='goodsnm']").val()){
                alert("모델명을 입력해주세요.");
                return false;
            }else if(!$("input[name='memo']").val()){
                alert("출력사유를 입력해주세요.");
                return false;
            }else if(!$("input[name='quantity']").val()){
                alert("수량을 입력해주세요.");
                return false;
            }

        }
        if(confirm('['+title+'] 등록하시겠습니까?')){
            $("input[name='mode']").val(mode);
            $("#insForm").submit();
        }
    
    });

    $("#print_xls").click(function(){
        if(!$(".chk_no").is(":checked")){
            alert("선택된 접수건이 없습니다.");
            return false;        
        }
        var html='<div id="div_excel_search_val">';
        html+='<input type="hidden" name="print_xls" value="1" >';
        // html+='<input type="hidden" name="print_xls" value="0" >';
        // html+='<input type="hidden" name="cs_search_invo_chk" value="'+invo_chk+'">';
        html+='</div>';	
        $("#barcodeForm").append(html);
        
        $("#barcodeForm").attr("action","goods_barcode_print_excel.php");
        $("#barcodeForm").submit();
        $("#barcodeForm").attr("action","");
        $("#div_excel_search_val").remove();
	});
    
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>