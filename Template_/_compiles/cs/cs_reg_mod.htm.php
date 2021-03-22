<?php /* Template_ 2.2.8 2020/05/22 08:12:33 /www/html/ukk_test/data/skin/cs/cs_reg_mod.htm 000010033 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<h1 class="page_title">기본주문정보</h1>
<style>
    .search_td_width{width:400px;}
    
    .notice-box { padding:0px 10px 10px 10px; background-color:rgb(249, 250, 252); text-align:left;  } 
    .notice-box p { -webkit-margin-before: .3em; -webkit-margin-after: .5em; } 
    #close { float:right; display:inline-block; padding:2px 5px; font-weight: 700; text-shadow: 0 1px 0 #fff; font-size: 2.0rem; } 
    #close:hover { border: 0; cursor:pointer; opacity: .75; }
</style>
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>주문번호</th>
            <td class="search_td_width"><?php echo $TPL_VAR["mall_name"]?>(<?php echo $TPL_VAR["ordno"]?>)</td>            
            <th>구매자</th>
            <td><?php echo $TPL_VAR["buyer"]?></td>   
        </tr>
        <tr>
			<th>주소</th>
            <td><?php echo $TPL_VAR["zipcode"]?> <?php echo $TPL_VAR["address"]?></td>   
            <th>연락처</th>
            <td><?php echo $TPL_VAR["mobile"]?></td>   
        </tr>
	</tbody>
</table>

<hr>

<h1 class="page_title">접수내용</h1>
<input type="hidden" name="csCount" value="<?php echo $GLOBALS["csCount"]?>">    
<table class="table table-bordered" >
	<tbody>		
		<tr>
			<td>
                <div class="csDiv">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
                        <div class="csLoop">
                            <div class="info">
                                <ul style="position: relative;">
                                    <div class="claimType">
                                        <?php echo $TPL_V1["reg_date"]?> - <?php echo $TPL_V1["admin_name"]?>(<?php echo $TPL_V1["id"]?>)
                                        
                                    </div>                                   
                                    <div>
                                        <!-- 진행상태 : <span class="<?php echo $TPL_V1["ingColorType"]?>"><?php echo $GLOBALS["cfg_ing_type"][$TPL_V1["ing_type"]]?></span>  -->
                                        접수구분 : <?php echo $GLOBALS["cfg_retrun_type"][$TPL_V1["return_type"]]?>

<?php if($TPL_V1["refund_yn"]=='y'){?> / 환불완료 <?php }?>
                                    </div>
<!--                                     
<?php if($TPL_V1["return_type"]>='40'&&$TPL_V1["return_type"]<'50'){?>
                                        <div>수령자명 : <?php echo $TPL_V1["receiver"]?> / 주소 : <?php echo $TPL_V1["zipcode"]?> <?php echo $TPL_V1["address"]?> / 연락처 : <?php echo $TPL_V1["mobile"]?></div>                                                
<?php }?>                                 -->
<?php if(count($TPL_V1["cs_detail"])){?>
                                    <div style="padding-top:5px;"></div>
                                    <div class="csDetail btn btn-sm btn-primary" data-no=<?php echo $TPL_V1["no"]?> style="width:75px; ">상세보기</div>
<?php }?>
                                </ul>
                            </div>

<?php if(count($TPL_V1["cs_detail"])){?>
                            <div class="csLayer_<?php echo $TPL_V1["no"]?> csLayer notice-box" style="display: block; overflow:auto;padding-top:10px; display:none; font-size: 6px;">
                                <!-- <span id='close' onclick="this.parentNode.style.display = 'none';">&times;</span> -->
<?php if($TPL_V1["return_type"]=='1'||($TPL_V1["return_type"]>='40'&&$TPL_V1["return_type"]<'50')){?>
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>수령자명</th>
                                            <td><?php echo $TPL_V1["receiver"]?></td>            
                                            <th>주소</th>
                                            <td>우편번호 : <?php echo $TPL_V1["zipcode"]?><br><?php echo $TPL_V1["address"]?></td>   
                                        </tr>
                                        <tr>
                                            <th>연락처</th>
                                            <td><?php echo $TPL_V1["mobile"]?></td>   
                                            <th>배송정보</th>
                                            <td>
<?php if($TPL_V1["delivery_type"]){?><?php echo $GLOBALS["cfg_return_delivery_type"][$TPL_V1["delivery_type"]]?>(<?php echo number_format($TPL_V1["delivery_price"])?>원)<?php }?> 
<?php if($TPL_V1["delivery_type2"]){?>/ <?php echo $GLOBALS["cfg_return_delivery_type2"][$TPL_V1["delivery_type2"]]?>(<?php echo number_format($TPL_V1["delivery_price2"])?>원)<?php }?>
<?php if($TPL_V1["return_delivery_code"]){?><div><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?>-<?php echo $TPL_V1["return_invoice"]?></div><?php }?>
                                            </td>   
                                        </tr>
                                    </tbody>
                                </table>
<?php }else{?>
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>배송정보</th>
                                            <td>
<?php if($TPL_V1["delivery_type"]){?><?php echo $GLOBALS["cfg_return_delivery_type"][$TPL_V1["delivery_type"]]?>(<?php echo number_format($TPL_V1["delivery_price"])?>원)<?php }?> 
<?php if($TPL_V1["delivery_type2"]){?>/ <?php echo $GLOBALS["cfg_return_delivery_type2"][$TPL_V1["delivery_type2"]]?>(<?php echo number_format($TPL_V1["delivery_price2"])?>원)<?php }?>
<?php if($TPL_V1["return_delivery_code"]){?><div><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?>-<?php echo $TPL_V1["return_invoice"]?></div><?php }?>
                                            </td>   
                                        </tr>
                                    </tbody>
                                </table>
<?php }?>
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>환불정보</th>
                                            <td>
<?php if($TPL_V1["account_code"]&&$TPL_V1["account_number"]){?><?php echo $GLOBALS["cfg_account_code"][$TPL_V1["account_code"]]?> / <?php echo $TPL_V1["account_number"]?><?php }?> 
<?php if($TPL_V1["account_name"]){?><div>입금자명 : <?php echo $TPL_V1["account_name"]?> / 금액 : <?php echo number_format($TPL_V1["account_price"])?>원</div><?php }?>
<?php if($TPL_V1["account_etc"]){?><div>비고 : <?php echo $TPL_V1["account_etc"]?></div><?php }?>
                                            </td>   
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>	
                                            <th>상품명</th>
                                            <th>교환모델명</th>
                                            <th>수량</th>
                                            <th>발생비용</th>
                                            <th>상태</th>
                                        </tr>
<?php if(is_array($TPL_R2=$TPL_V1["cs_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                        <tr>
                                            <td><?php echo $TPL_V2["mall_goodsnm"]?></td>
                                            <td><?php if($TPL_V2["exchange_goods_nm"]){?><?php echo $TPL_V2["exchange_goods_nm"]?><?php }else{?>-<?php }?></td>
                                            <td><?php echo $TPL_V2["exchange_goods_num"]?></td>
                                            <td><?php echo number_format($TPL_V2["diff_price"])?>원</td>
                                            <td><?php echo $GLOBALS["cfg_send_type"][$TPL_V2["send_type"]]?></td>
                                        </tr>
<?php }}?>
                                    </tbody>
                                </table>                    
                            </div>
<?php }?>

                            <p class="csContents"><?php echo nl2br($TPL_V1["contents"])?></p>
                        </div>
<?php }}?>
                </div>
            </td>
		</tr>
	</tbody>
</table>
<hr>
<center>
    <div class="btn btn btn-primary buttonChange">확인</div>    
</center>


<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(document).on("click",".csDetail",function(e){
    
    //var img_top = event.pageY-400;
    //var img_left = event.pageX; 
    var detailNo=$(this).data('no');

    //$(".csLayer").css("display","none");
    $(".csLayer_"+detailNo).toggle();

});

$(".buttonChange").click(function (){
    if(confirm("추가 등록하시겠습니까? 확인후 전페이지에서 등록버튼을 다시 눌러주세요.")){
        
        $(opener.document).find("input[name='csCount']").val($("input[name='csCount']").val());
        self.close();
    }

});

</script>

<?php $this->print_("footer",$TPL_SCP,1);?>