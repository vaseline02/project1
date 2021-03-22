<?php /* Template_ 2.2.8 2021/02/25 11:21:30 /www/html/ukk_test2/data/skin/cs/send_sms.htm 000011547 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span>(충전 잔량: <?php echo number_format($GLOBALS["sms_coin"])?>건)</span></h3></div>
</div>
<style>
    .table_left {width:90%; text-align: left; display: inline-block;}
    .table_left input {width:80%;}
    .table_rigth {width:8%; text-align: right;  display: inline-block;}
</style>
<?php if($_GET['etc_code']=='as'){?>
<form method="post" id="receiptForm" name="receiptForm">
    <input type="hidden" name="mode" value="receipt">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']?>">      
    <input type="hidden" name="etc_code" value="<?php echo $_GET['etc_code']?>">      
    <input type="hidden" name="etc_no" value="<?php echo $_GET['etc_no']?>">      
    <hr>
    <table id="" style="width:100%" class="listTable">
        <tr>
            <th colspan="3">접수안내문자</th>
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
<?php }?>
<?php if($TPL_VAR["data"][$GLOBALS["typeno"]]){?>
<form method="post" id="etcForm" name="etcForm">
    <input type="hidden" name="mode" value="etc">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']?>">      
    <input type="hidden" name="etc_code" value="<?php echo $_GET['etc_code']?>">      
    <input type="hidden" name="etc_no" value="<?php echo $_GET['etc_no']?>">      
	<input type="hidden" name="order_no" value="<?php echo $_GET['order_no']?>">      
	<input type="hidden" name="order_list_no" value="<?php echo $_GET['order_list_no']?>">      
	<input type="hidden" name="sms_type" value="">   
    <hr>
    <table id="" style="width:100%" class="listTable">
        <tr>
            <th colspan="3">기타문자</th>
        </tr>
        <tr>

<?php if(is_array($TPL_R1=$TPL_VAR["data"][$GLOBALS["typeno"]])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
			<td>
                <div class="bottom_btn_box" style="margin-top: 0px;">
                    <div class="table_left" style="width:90%;">
                        제목 <input type=text name="send_title[<?php echo $TPL_K1?>]" value="<?php echo $TPL_V1["title"]?>">
                    </div>
                    <div class="table_rigth">
                        <input type="radio" class="" name="send_check" value="<?php echo $TPL_K1?>">
                    </div>
                </div>
                <div>내용 <textarea style="width:100%;height:80px;" name="send_contents[<?php echo $TPL_K1?>]"><?php echo $TPL_V1["contents"]?></textarea></div>
            </td>
<?php if(($TPL_I1+ 1)% 3== 0){?></tr><tr><?php }?>
<?php }}?>
		
        </tr>
    </table>
    <table id="" style="width:100%" class="listTable">
        
        <tr>
            <th>연락처<br>(엔터로 구분)</th>
            <td><!--<input type=text style="width:150px" name="send_mobile" value="<?php echo $GLOBALS["receiver_mobile"]?>">-->
				<textarea name="send_mobile" style="width:100%; height:150px;" <?php echo $GLOBALS["readonly_chk"]?>><?php echo $GLOBALS["receiver_mobile"]?></textarea>
			</td>
        </tr>
    </table>
    <div class="bottom_btn_box" style="margin-top: 10px;">
        <div class="box_left">
            
        </div>
        <div class="box_right">
           
            <div class="btn btn-sm btn-warning checkForm" data-mode='etc' data-smstype="1">발송(<?php echo number_format($GLOBALS["sms_coin"])?>건)</div>
			<div class="btn btn-sm btn-warning checkForm" data-mode='etc' data-smstype="2">발송(뿌리오)</div>
        </div>
    </div>   
</form>
<?php }?>
<form method="post" id="eachForm" name="eachForm">
    <input type="hidden" name="mode" value="each">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']?>">      
    <input type="hidden" name="etc_code" value="<?php echo $_GET['etc_code']?>">      
    <input type="hidden" name="etc_no" value="<?php echo $_GET['etc_no']?>">      
	<input type="hidden" name="order_no" value="<?php echo $_GET['order_no']?>">      
	<input type="hidden" name="order_list_no" value="<?php echo $_GET['order_list_no']?>">      
	<input type="hidden" name="sms_type" value="">   
    <hr>
    <table id="" style="width:100%" class="listTable">
        <tr>
            <th colspan="3">개별문자</th>
        </tr>
        <tr>
            <th>연락처<br>(엔터로 구분)</th>
            <td><!--<input type=text style="width:150px" name="send_mobile" value="<?php echo $GLOBALS["receiver_mobile"]?>">-->
				<textarea name="send_mobile" style="width:100%; height:150px;" <?php echo $GLOBALS["readonly_chk"]?>><?php echo $GLOBALS["receiver_mobile"]?></textarea>
			</td>
        </tr>
        <tr>
            <th>제목</th>
            <td><input type=text style="width:250px" name="send_title"></td>
        </tr>
        <tr>
            <th>내용</th>
            <td><textarea style="width:100%;height:100px" name="send_contents"></textarea></td>
        </tr>
    </table>
    <div class="bottom_btn_box" style="margin-top: 10px;">
        <div class="box_left">
            
        </div>
        <div class="box_right">
            <div class="btn btn-sm btn-warning checkForm" data-mode='each' data-smstype="1">발송(<?php echo number_format($GLOBALS["sms_coin"])?>건)</div>
			<div class="btn btn-sm btn-warning checkForm" data-mode='each' data-smstype="2">발송(뿌리오)</div>
        </div>
    </div>   
    <hr>
        
    <table class="table table-bordered" >
        <tbody>		
            <tr>
                <th colspan="3">문자발송리스트</th>
            </tr>
            <tr>
                <td>
                    <div class="csDiv" style="height:300px">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
                            <div class="csLoop">
                                <div class="info">
                                    <ul style="position: relative;">
                                        <div class="claimType">
                                            <?php echo $TPL_V1["reg_date"]?>

                                        </div>                                   
                                        <div>
                                            연락처 : <?php echo $TPL_V1["mobile"]?>

                                        </div>
                                        <div>
                                            제목 : <?php echo $TPL_V1["title"]?>

                                        </div>
                                       
                                    </ul>
                                </div>

                                <p class="csContents"><?php echo nl2br($TPL_V1["contents"])?></p>
                            </div>
                        
<?php }}?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".check_class").click(function() {
  $(".check_class").attr("checked", false); //uncheck all checkboxes
  $(this).prop("checked", true);  //check the clicked one
});

$(".checkForm").click(function (){
    var mode=$(this).data('mode');
	$("input[name='sms_type']").val($(this).data('smstype'));
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
        var title=$("#"+$(this).data('mode')+"Form [name='send_title["+checkNo+"]'").val();
        var contents=$("#"+$(this).data('mode')+"Form [name='send_contents["+checkNo+"]'").val();
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