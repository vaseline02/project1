<?php /* Template_ 2.2.8 2020/10/14 14:55:16 /www/html/ukk_test2/data/skin/admin/sms_set.htm 000009200 */ 
$TPL__cfg_sms_status_1=empty($GLOBALS["cfg_sms_status"])||!is_array($GLOBALS["cfg_sms_status"])?0:count($GLOBALS["cfg_sms_status"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span>(충전 잔량: <?php echo number_format($GLOBALS["sms_coin"])?>건)</span></h3></div>
<style>
    .table_left {width:90%; text-align: left; display: inline-block;}
    .table_left input {width:80%;}
    .table_rigth {width:8%; text-align: right;  display: inline-block;}
</style>
<form method="post" id="receiptForm" name="receiptForm">
    <input type="hidden" name="mode" value="receipt">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']?>">      
    <input type="hidden" name="etc_code" value="<?php echo $_GET['etc_code']?>">      
    <input type="hidden" name="etc_no" value="<?php echo $_GET['etc_no']?>">      
    <hr>
    <table id="" style="width:100%" class="listTable">
        <th colspan="3" class="bottom_btn_box">
            <div class="box_left">
                접수안내문자
            </div>
            <div class="box_right">
            </div>
        </tr>
        <tr>
            <td>1. <?php echo $TPL_VAR["data"][ 1][ 1]['title']?>

                <div><textarea style="width:100%;height:100px;" name="send_contents[1]"><?php echo $TPL_VAR["data"][ 1][ 1]['contents']?></textarea></div>
            </td>
            <td>2. <?php echo $TPL_VAR["data"][ 1][ 2]['title']?>

                <div><textarea style="width:100%;height:100px;" name="send_contents[2]"><?php echo $TPL_VAR["data"][ 1][ 2]['contents']?></textarea></div>
            </td>
            <td>3. <?php echo $TPL_VAR["data"][ 1][ 3]['title']?>

                <div><textarea style="width:100%;height:100px;" name="send_contents[3]"><?php echo $TPL_VAR["data"][ 1][ 3]['contents']?></textarea></div>
            </td>
        </tr>
        <tr>
            <td>4. <?php echo $TPL_VAR["data"][ 1][ 4]['title']?>

                <div><textarea style="width:100%;height:100px;" name="send_contents[4]"><?php echo $TPL_VAR["data"][ 1][ 4]['contents']?></textarea></div>
            </td>
            <td>5. <?php echo $TPL_VAR["data"][ 1][ 5]['title']?>

                <div><textarea style="width:100%;height:100px;" name="send_contents[5]"><?php echo $TPL_VAR["data"][ 1][ 5]['contents']?></textarea></div>
            </td>
            <td>6. <?php echo $TPL_VAR["data"][ 1][ 6]['title']?>

                <div><textarea style="width:100%;height:100px;" name="send_contents[6]"><?php echo $TPL_VAR["data"][ 1][ 6]['contents']?></textarea></div>
            </td>
        </tr>
    </table>
    <div class="bottom_btn_box" style="margin-top: 10px;">
        <div class="box_left">
            
        </div>
        <div class="box_right">
            <div class="btn btn-sm btn-warning checkForm" data-mode='receipt'>수정</div>
        </div>
    </div>   
</form>
<form method="post" id="etcForm" name="etcForm">
    <input type="hidden" name="mode" value="etc">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']?>">      
    <input type="hidden" name="etc_code" value="<?php echo $_GET['etc_code']?>">      
    <input type="hidden" name="etc_no" value="<?php echo $_GET['etc_no']?>">      
    <hr>
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
                    <div class="btn btn-sm btn-warning"  onclick="popup('sms_reg.php','sendPop','1100','900')">기타문자등록</div>
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
                                <input type="radio" class="" name="send_check" value="<?php echo $TPL_V2["type"]?>_<?php echo $TPL_V2["code"]?>">
                            </div>
                        </div>
                        <div>내용 <textarea style="width:100%;height:80px;" name="send_contents_<?php echo $TPL_V2["type"]?>[<?php echo $TPL_V2["code"]?>]"><?php echo $TPL_V2["contents"]?></textarea></div>
                    </td>
<?php }}?>
            </tr>
<?php }?>
<?php }}?>
    </table>
    <div class="bottom_btn_box" style="margin-top: 10px;">
        <div class="box_left">
            
        </div>
        <div class="box_right">
            <input type=text style="width:150px" name="send_mobile">
            <div class="btn btn-sm btn-warning checkForm" data-mode='etc'>발송</div>
        </div>
    </div>   
</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".check_class").click(function() {
  $(".check_class").attr("checked", false); //uncheck all checkboxes
  $(this).prop("checked", true);  //check the clicked one
});

$(".sms_type").change(function(){
    if($(this).val()==0){
        $(".sms_td").show();
    }else{
        $(".sms_td").hide();
        $(".sms_type_"+$(this).val()).show();
    }
});
$(".checkForm").click(function (){
    var mode=$(this).data('mode');
    if(mode=='receipt'){
        if(!confirm('수정하시겠습니까?')){
            return false;            
        }
    }else if(mode=='etc'){
        var checkNo=$("input:radio[name='send_check']:checked").val();
        if(!checkNo){
            alert("발송하실 내용을 선택해주세요.");
            return false;
        }
        var send_split=checkNo.split('_');
        var title=$("#"+$(this).data('mode')+"Form [name='send_title_"+send_split[0]+"["+send_split[1]+"]'").val();
        var contents=$("#"+$(this).data('mode')+"Form [name='send_contents_"+send_split[0]+"["+send_split[1]+"]'").val();
        var mobile=$("#"+$(this).data('mode')+"Form [name='send_mobile']").val();
        if(!title){
            alert("제목을 입력해주세요.");
            return false;
        }
        if(!contents){
            alert("내용을 입력해주세요.");
            return false;
        }
        if(!mobile){
            alert("발송될 번호를 입력해주세요.");
            $("#"+$(this).data('mode')+"Form [name='send_mobile']").focus();
            return false;
        }
        if(!confirm('발송하시겠습니까?')){
            return false;            
        }
    }else if(mode=='each'){
        var title=$("#"+$(this).data('mode')+"Form [name='send_title']").val();
        var contents=$("#"+$(this).data('mode')+"Form [name='send_contents']").val();
        var mobile=$("#"+$(this).data('mode')+"Form [name='send_mobile']").val();
        
        if(!mobile){
            alert("발송될 번호를 입력해주세요.");
            $("#"+$(this).data('mode')+"Form [name='send_mobile']").focus();
            return false;
        }
        if(!title){
            alert("제목을 입력해주세요.");
            $("#"+$(this).data('mode')+"Form [name='send_title']").focus();
            return false;
        }
        if(!contents){
            alert("내용을 입력해주세요.");
            $("#"+$(this).data('mode')+"Form [name='send_contents']").focus();
            return false;
        }
        
        if(!confirm('발송하시겠습니까?')){
            return false;            
        }
    }else{
        return false;
    }
    $("#"+$(this).data('mode')+"Form").submit();
});
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>