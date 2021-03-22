<?php /* Template_ 2.2.8 2020/10/12 09:24:50 /www/html/ukk_test2/data/skin/cs/cs_receipt_reg.htm 000017177 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_uloop_1=empty($TPL_VAR["uloop"])||!is_array($TPL_VAR["uloop"])?0:count($TPL_VAR["uloop"]);
$TPL__cfg_receipt_type_1=empty($GLOBALS["cfg_receipt_type"])||!is_array($GLOBALS["cfg_receipt_type"])?0:count($GLOBALS["cfg_receipt_type"]);
$TPL__cfg_account_code_1=empty($GLOBALS["cfg_account_code"])||!is_array($GLOBALS["cfg_account_code"])?0:count($GLOBALS["cfg_account_code"]);
$TPL_delivery_list_1=empty($TPL_VAR["delivery_list"])||!is_array($TPL_VAR["delivery_list"])?0:count($TPL_VAR["delivery_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<style>
.search_td_width{width:800px;}
#nav_div1_1 a:after{width:90%}
</style>
<?php if(!$TPL_VAR["receipt_no"]||$TPL_VAR["uloop"][ 0]['receipt_type']=='1'){?>
<form id="searchForm" method="POST" >

<table id="" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
    <tr>
        <td style="width:25%; vertical-align: top;">
            <table class="table table-bordered" >
                <tr>
                    <th>원송장/반송장번호</th>
                    <td><input type="text" name="s_invoice" class="s_invoice" id="enter_input" style="width:300px;" ></td>           
                    <th>주문번호</th>
                    <td><input type="text" name="s_order_no" ></td>           
                </tr>
                <tr>
                    <th>이름</th>
                    <td><input type="text" name="s_receiver" ></td>                    
                    <th>전화번호</th>
                    <td><input type="text" name="s_mobile" ></td>                    
                </tr>
            </table>
        </td>
    </tr>	
</table>
<center style="padding-top:10px;">
    <button class="btn btn-primary" id="subm">검 색</button>
</center>
</form>
<hr>
<?php }?>
<form id="sendForm" method="POST">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING']?>">      
<?php if(!$TPL_VAR["receipt_no"]){?>
        <input type="hidden" name="mode" value="ins">

        <div style="padding-bottom: 10px;">
            <label style="font-weight: normal;"><input type="checkbox" name="receipt_type" class="receiptCheck" value="1"> 수기등록</label>
            <!-- <div type="button" class="btn btn-sm btn-warning" id="">수기등록</div> -->
        </div>
        <div class="receiptDiv" style="display: none;">
        <table id="" class="table table-bordered">
            <tr>
                <th>모델명</th>
                <td><input type="text" name="goodsnm" style="width:250px;"></td>
                
            </tr>
            <tr>            
                <th>전화번호</th>
                <td><input type="text" name="mobile" style="width:250px;" class="number_only"></td>
            </tr>
            <tr>            
                <th>이름</th>
                <td><input type="text" name="customer_name" style="width:250px;"></td>
            </tr>       
        </table>
        </div>
        <div class="receiptDiv2">
        <table id="" class="table table-bordered">
            <tr>			
                <th style="width:20px;"></th>
                <th>몰명</th>
                <th>주문번호</th>
                <th style="width:100px;">이미지</th>
                <th>옵션명</th>
                <th style="width:70px;">구매자<br>수령자</th>
                <th>연락처<br>모바일</th>
                <th style="width:120px;">주문일자</th>
            </tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
            <tr class="radioCheck" data-no=<?php echo $TPL_V1["no"]?> data-return_courier_code='<?php echo $TPL_V1["return_courier_code"]?>' data-return_invoice='<?php echo $TPL_V1["return_invoice"]?>'>			
                <td><input type="radio" class="radioNo_<?php echo $TPL_V1["no"]?>" name="no" value='<?php echo $TPL_V1["no"]?>'></td>
                <td><?php echo $TPL_V1["mall_name"]?></td>
                <td><?php echo $TPL_V1["ordno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
                <td><?php echo $TPL_V1["img_url"]?></td>
                <td><?php echo $TPL_V1["goodsnm"]?></td>
                <td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
                <td><?php echo $TPL_V1["buyer_mobile"]?><br/><?php echo $TPL_V1["mobile"]?></td>
                <td><?php echo $TPL_V1["reg_date"]?></td>
            </tr>
<?php }}?>
        </table>
        </div>
<?php }else{?>
        <input type="hidden" name="mode" value="mod">
        
<?php if($TPL_VAR["uloop"][ 0]['receipt_type']=='1'&&$GLOBALS["open_route"]!='as_reg'){?>
        <div style="padding-bottom: 10px;">
            <label style="font-weight: normal;"><input type="checkbox" name="receipt_type" class="receiptCheck" value="1" <?php if(!count($TPL_VAR["loop"])){?>checked<?php }?>> 수기등록</label>
            <!-- <div type="button" class="btn btn-sm btn-warning" id="">수기등록</div> -->
        </div>
<?php }elseif($GLOBALS["open_route"]=='as_reg'){?>
        <input type="hidden" name="receipt_type" value="0">
<?php }else{?>
        <input type="hidden" name="receipt_type" value="<?php echo $TPL_VAR["uloop"][ 0]['receipt_type']?>">
<?php }?>
        <input type="hidden" name="loopCount" value="<?php echo count($TPL_VAR["loop"])?>">
        <div class="receiptDiv" <?php if(($TPL_VAR["uloop"][ 0]['receipt_type']!='1'||count($TPL_VAR["loop"]))||$GLOBALS["open_route"]=='as_reg'){?>style="display: none;"<?php }?>>
            <table id="" class="table table-bordered">
                <tr>
                    <th>모델명</th>
                    <td><input type="text" name="goodsnm" value="<?php echo $TPL_VAR["uloop"][ 0]['receipt_goodsnm']?>"></td>
                </tr>
                <tr>            
                    <th>전화번호</th>
                    <td><input type="text" name="mobile" value="<?php echo $TPL_VAR["uloop"][ 0]['receipt_mobile']?>" style="width:250px;" class="number_only"></td>
                </tr>
                <tr>            
                    <th>이름</th>
                    <td><input type="text" name="customer_name" value="<?php echo $TPL_VAR["uloop"][ 0]['customer_name']?>" style="width:250px;"></td>
                </tr>       
            </table>
        </div>
        <div class="receiptDiv2" <?php if(($TPL_VAR["uloop"][ 0]['receipt_type']=='1'&&!count($TPL_VAR["loop"]))&&$GLOBALS["open_route"]!='as_reg'){?>style="display: none;"<?php }?>>
            <table id="" class="table table-bordered">
                <tr>			
<?php if(count($TPL_VAR["loop"])){?>
                    <th style="width:20px;"></th>
<?php }?>
                    <th>몰명</th>
                    <th>주문번호</th>
                    <th style="width:100px;">이미지</th>
                    <th>옵션명</th>
                    <th style="width:70px;">구매자<br>수령자</th>
                    <th>연락처<br>모바일</th>
                    <th style="width:120px;">주문일자</th>
                </tr>
<?php if(count($TPL_VAR["loop"])){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
                    <tr class="radioCheck" data-no=<?php echo $TPL_V1["no"]?> data-return_courier_code='<?php echo $TPL_V1["return_courier_code"]?>' data-return_invoice='<?php echo $TPL_V1["return_invoice"]?>'>			
                        <td><input type="radio" class="radioNo_<?php echo $TPL_V1["no"]?>" name="no" value='<?php echo $TPL_V1["no"]?>'></td>
                        <td><?php echo $TPL_V1["mall_name"]?></td>
                        <td><?php echo $TPL_V1["ordno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
                        <td><?php echo $TPL_V1["img_url"]?></td>
                        <td><?php echo $TPL_V1["goodsnm"]?></td>
                        <td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
                        <td><?php echo $TPL_V1["buyer_mobile"]?><br/><?php echo $TPL_V1["mobile"]?></td>
                        <td><?php echo $TPL_V1["reg_date"]?></td>
                    </tr>
<?php }}?>
<?php }else{?>
<?php if($TPL_uloop_1){foreach($TPL_VAR["uloop"] as $TPL_V1){?>
                    <tr>			
                        <td><?php echo $TPL_V1["mall_name"]?></td>
                        <td><?php echo $TPL_V1["ordno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
                        <td><?php echo $TPL_V1["img_url"]?></td>
                        <td><?php echo $TPL_V1["goodsnm"]?></td>
                        <td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
                        <td><?php echo $TPL_V1["buyer_mobile"]?><br/><?php echo $TPL_V1["mobile"]?></td>
                        <td><?php echo $TPL_V1["reg_date"]?></td>
                    </tr>
<?php }}?>
<?php }?>
            </table>
        </div>
<?php }?>
    <hr>
    <table id="" class="table table-bordered" <?php if($GLOBALS["open_route"]=='as_reg'){?>style="display: none;"<?php }?>>
        <tr>
            <th>접수유형</th>
            <td style="width:50px;">
                
<?php if(!$TPL_VAR["receipt_no"]||$TPL_VAR["uloop"][ 0]['receipt_return_type']=='3'){?>
                <select name="return_type" class="return_type receiptType">
                    <!--<option value="">=== 접수유형선택 ===</option>-->
<?php if($TPL__cfg_receipt_type_1){foreach($GLOBALS["cfg_receipt_type"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1=='3'){?>
						<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['return_type'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
                </select>
<?php }else{?>
                    <input type="hidden" name="return_type" class="return_type" value=<?php echo $TPL_VAR["uloop"][ 0]['receipt_return_type']?>>
                    <input type="hidden" name="return_type_sub" value=<?php echo $TPL_VAR["uloop"][ 0]['receipt_return_type_sub']?>>
                    <?php echo $GLOBALS["cfg_receipt_type"][$TPL_VAR["uloop"][ 0]['receipt_return_type']]?>

<?php if($TPL_VAR["uloop"][ 0]['receipt_return_type_sub']){?>(<?php echo $GLOBALS["cfg_receipt_type_sub"][$TPL_VAR["uloop"][ 0]['receipt_return_type']][$TPL_VAR["uloop"][ 0]['receipt_return_type_sub']]?>)<?php }?>
<?php }?>
                <span id="return_sub_span"></span>
            </td>
            <th rowspan="4">내용</th>
            <td rowspan="4"><textarea style="width:100%; height: 150px;" name="memo"><?php echo $TPL_VAR["uloop"][ 0]['receipt_memo']?></textarea></td>
            
        </tr>
        <tr>
            
            <th>계좌번호</th>
            <td>
                <div>
                <select name="account_code">
                    <option value="">=== 은행선택 ===</option>
<?php if($TPL__cfg_account_code_1){foreach($GLOBALS["cfg_account_code"] as $TPL_K1=>$TPL_V1){?>
                    <option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['account_code'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }}?>
                </select>
                </div>
                <div style="padding-top:5px;"><input type="text" name="account_number" value="<?php echo $TPL_VAR["uloop"][ 0]['receipt_account_number']?>" style="width:250px;"></div>
            </td>
        </tr>
        <tr>
            <th>반송장번호</th>
            <td>
                <div>
                    <select name="delivery_code">
                        <option value="">=== 택배사선택 ===</option>
<?php if($TPL_delivery_list_1){foreach($TPL_VAR["delivery_list"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["code"]?>" <?php echo $GLOBALS["selected"]['delivery_code'][$TPL_V1["code"]]?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
                    </select>
                </div>
                <div style="padding-top:5px;"><input type="text" name="invoice"  value="<?php if(!$TPL_VAR["receipt_no"]){?><?php echo $TPL_VAR["loop"][ 0]['return_invoice']?><?php }else{?><?php echo $TPL_VAR["uloop"][ 0]['receipt_invoice']?><?php }?>" style="width:250px;"></div>
            </td>
        </tr>
        
    </table>

    <div class="bottom_btn_box">
        <div  class="box_left"></div>
        <div  class="box_right">           
<?php if(!$TPL_VAR["receipt_no"]){?>
            <div type="button" class="btn btn-sm btn-primary checkForm" id="" data-mode='ins'>등록</div>
<?php }else{?>
            <div type="button" class="btn btn-sm btn-warning checkForm" id="" data-mode='mod'>수정</div>
<?php }?>
           
        </div>
    </div>

</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";






$(document).ready(function() {

	$("#enter_input").keydown(function(key) {
		if (key.keyCode == 13) {
			$("#subm").trigger("click");
		}
	});

    $(".radioCheck").click(function(){
        // alert($(this).data('return_courier_code'));
        // alert($(this).data('return_invoice'));
        $(".radioNo_"+$(this).data('no')).prop('checked', true);
        $("input[name='invoice']").val($(this).data('return_invoice'));
        if($(this).data('return_courier_code'))$("select[name='delivery_code']").val($(this).data('return_courier_code')).prop("selected",true);
        
    });
    $(".s_invoice").keypress(function (e) {
        if (e.which == 13){
            $("form[name='searchForm']").submit();
        }       
    });
    $('.s_invoice').focus();

    $(".receiptCheck").click(function (){
        if($("input[name='receipt_type']").is(":checked")){
            $(".receiptDiv").show();
            $(".receiptDiv2").hide();
            
        }else{
            $(".receiptDiv").hide();
            $(".receiptDiv2").show();
        }
    });

    $(".checkForm").click(function(){
        var mode=$(this).data('mode');
        if(mode=='ins'){
            if($("input[name='receipt_type']").is(":checked")){
                if(!$("input[name='goodsnm']").val()){
                    alert("모델명을 입력해주세요.");
                    return false;
                //}else if(!$("textarea[name='memo']").val()){
                    //alert("내용을 입력해주세요.");
                    //return false;
                }else if(!$(".return_type").val()){
                    alert("접수유형을 선택해주세요.");
                    return false;
                }else{
                    $("#sendForm").submit();
                }
            }else{
                if(!$("input[name='no']:checked").val()){
                    alert("등록할 주문건을 선택해주세요.");
                    return false;
                }else if(!$(".return_type").val()){
                    alert("접수유형을 선택해주세요.");
                    return false;
                }else{
                    $("#sendForm").submit();
                }
            }
        }else if(mode=='mod'){
            var loopCount=$("input[name='loopCount']").val();
            if(loopCount>0){
                if(!$("input[name='no']:checked").val()){
                    alert("수정할 주문건을 선택해주세요.");
                    return false;
                }
            }else if(!$(".return_type").val()){
                alert("접수유형을 선택해주세요.");
                return false;
            }
            $("#sendForm").submit();
        }
    });

    //발송선택후 일반문의로 변경시 체크해제
    $(".receiptType").change(function(){    
        returnSubappend($(this).val());
    });
        
    function returnSubappend(returnNo,subNo,type){
        
        $.ajax({
            url: "./cs_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "no="+returnNo+"&mode=receiptType",
            success: function(data){
                $('#return_sub_span *').remove();
                if(data){
                addHtml="<select name='return_type_sub'>";
            
                    $.each(data,function(index, item){
                        var selected='';
                        if(index==subNo) selected='selected';                
                        addHtml+="<option value='"+index+"' "+selected+">"+item+"</option>";
                    });
                
                    addHtml+="</select>";
                    $('#return_sub_span').append(addHtml);
                }

            }
        });
    }
    
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>