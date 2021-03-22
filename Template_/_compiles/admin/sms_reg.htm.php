<?php /* Template_ 2.2.8 2020/07/17 08:19:17 /www/html/ukk_test2/data/skin/admin/sms_reg.htm 000005661 */ 
$TPL__cfg_sms_status_1=empty($GLOBALS["cfg_sms_status"])||!is_array($GLOBALS["cfg_sms_status"])?0:count($GLOBALS["cfg_sms_status"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<form method="post" name="addForm">
<input type="hidden" name="mode" value="ins">

<table class="table table-bordered" >
	<tbody>		
        <tr>
			<th>문자분류</th>
			<td>
                <select name="send_type" class="send_type">
                    <option value="0">== 선택 ==</option>
<?php if($TPL__cfg_sms_status_1){foreach($GLOBALS["cfg_sms_status"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='1'){?>
                        <option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }?>
                    
<?php }}?>
                </select>
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
				<input type=text name="send_title" class="send_title">
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td>
				<textarea style="width:100%;height:80px;" name="send_contents" class="send_contents"></textarea>
			</td>
		</tr>
	</tbody>
</table>
<center>
	<div class="btn btn btn-primary checkForm" data-form="addForm">등록</div>
</center>
</form>
<hr>
<form method="post" name="modForm">
<input type="hidden" name="mode" value="mod">
<table id="" style="width:100%" class="listTable">
    <tr>
        <th colspan="3" class="bottom_btn_box">
            <div class="box_left">
                기타문자
                <select name="sms_type" class="sms_type">
                    <option value="0">== 선택 ==</option>
<?php if($TPL__cfg_sms_status_1){foreach($GLOBALS["cfg_sms_status"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='1'){?>
                        <option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }?>
                    
<?php }}?>
                </select>
            </div>
            <div class="box_right">
            </div>
            
        </th>
    </tr>
<?php if($TPL__cfg_sms_status_1){foreach($GLOBALS["cfg_sms_status"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='1'){?>
        <tr class="sms_td sms_type_<?php echo $TPL_K1?>">
            <th colspan="3" class="bottom_btn_box"><?php echo $TPL_V1?></th>
<?php if(is_array($TPL_R2=($TPL_VAR["data"][$TPL_K1]))&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2% 3== 0){?>
                </tr><tr class="sms_td sms_type_<?php echo $TPL_K1?>">
<?php }?>
                <td class="sms_td sms_type_<?php echo $TPL_V2["type"]?>">
                    <div class="bottom_btn_box" style="margin-top: 0px;">
                        <div class="table_left" style="width:90%;">
                            제목 <input type=text name="send_title_<?php echo $TPL_V2["type"]?>[<?php echo $TPL_V2["code"]?>]" value="<?php echo $TPL_V2["title"]?>">
                        </div>
                        <div class="table_rigth">
                            <input type="checkbox" class="check_class" name="send_check[]" value="<?php echo $TPL_V2["type"]?>_<?php echo $TPL_V2["code"]?>">
                        </div>
                    </div>
                    <div>내용 <textarea style="width:100%;height:80px;" name="send_contents_<?php echo $TPL_V2["type"]?>[<?php echo $TPL_V2["code"]?>]"><?php echo $TPL_V2["contents"]?></textarea></div>
                </td>
<?php }}?>
        </tr>
<?php }?>
<?php }}?>
   
</table>
<center>
	<div class="btn btn btn-warning checkForm" data-form='modForm' data-mode='mod'>수정</div>
	<div class="btn btn btn-danger  checkForm" data-form='modForm' data-mode='del'>삭제</div>
</center>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".sms_type").change(function(){
    if($(this).val()==0){
        $(".sms_td").show();
    }else{
        $(".sms_td").hide();
        $(".sms_type_"+$(this).val()).show();
    }
});

$(".checkForm").click(function(){
    var formName=$(this).data("form");

    if(formName=="addForm"){
        if($(".send_type").val()==0){
            alert("문자분류를 선택해주세요.");
            return false;
        }else if(!$(".send_title").val()){
            alert("제목을 입력해주세요.");
            return false;
        }else if(!$(".send_contents").val()){
            alert("내용을 입력해주세요.");
            return false;
        }
        if(confirm("등록하시겠습니까?")){
            $("form[name='"+formName+"']").submit();
        }
    }else if(formName=="modForm"){
        $("form[name='"+formName+"']").find("input[name='mode']").val($(this).data("mode"));
        
        if($(this).data("mode")=="mod"){
            if(!$(".check_class").is(":checked")){
                alert("수정하실 문자내용을 선택해주세요.");
                return false;
            }
            
            if(confirm("수정하시겠습니까?")){
                $("form[name='"+formName+"']").submit();
            }
        }else if($(this).data("mode")=="del"){
            if(!$(".check_class").is(":checked")){
                alert("삭제하실 문자내용을 선택해주세요.");
                return false;
            }

            if(confirm("삭제하시겠습니까?")){
                $("form[name='"+formName+"']").submit();
            }
        }
    }
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>