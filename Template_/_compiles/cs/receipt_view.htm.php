<?php /* Template_ 2.2.8 2021/03/18 11:09:18 /www/html/ukk_test2/data/skin/cs/receipt_view.htm 000024012 */ 
$TPL__cfg_retrun_type_1=empty($GLOBALS["cfg_retrun_type"])||!is_array($GLOBALS["cfg_retrun_type"])?0:count($GLOBALS["cfg_retrun_type"]);
$TPL_tloop_1=empty($TPL_VAR["tloop"])||!is_array($TPL_VAR["tloop"])?0:count($TPL_VAR["tloop"]);?>
<div class="bottom_btn_box" style="margin-bottom: 5px;">
    <div class="box_left">
        <h1 class="page_title">접수내용(<?php echo $GLOBALS["ordno"]?>)</h1>
    </div>
    <div class="box_right">
        <select class="viewChange">
            <!-- <?php if($TPL__cfg_retrun_type_1){foreach($GLOBALS["cfg_retrun_type"] as $TPL_K1=>$TPL_V1){?>
            <option value=<?php echo $TPL_K1?>><?php echo $TPL_V1?></option>
<?php }}?> -->
            <option value="">전체</option>
            <option value="cs">CS접수</option>
            <option value="as">AS수리접수</option>
            <option value="sms">SMS발송건</option>
        </select>
    </div>
</div>

<table class="table table-bordered">
	<tbody>		
		<tr>
			<td>
                <div class="csDiv">
<?php if($TPL_tloop_1){foreach($TPL_VAR["tloop"] as $TPL_V1){?>
                    <div class="<?php echo $TPL_V1["type"]?>_div view_type">
<?php if($TPL_V1["type"]=='cs'){?>
                        <div class="csLoop">
                        <div class="info" style="height:100px;<?php echo $TPL_V1["ins_color"]?>">
                                <ul style="position: relative;">
                                    <div class="claimType">
                                        <?php echo $TPL_V1["reg_date"]?> - <?php echo $TPL_V1["admin_name"]?>(<?php echo $TPL_V1["id"]?>)
                                        <span style="right:0px; padding-right:10px; position: absolute; text-align: right;">
<?php if(!$GLOBALS["view_type"]&&$TPL_V1["return_type"]!='80'&&$GLOBALS["receipt_view_type"]=='mod'){?>
<?php if(!$TPL_V1["send_count"]&&($TPL_V1["return_type"]=='60'||$TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90')&&$TPL_V1["add_type"]=='1'){?>
                                            <button type="button" class="btn btn-sm btn-danger cancelOrder" data-no=<?php echo $TPL_V1["no"]?>>철회요청</button>
<?php }?>
<?php if(($TPL_V1["return_type"]=='60'||$TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90')&&($TPL_V1["add_type"]=='0'||$TPL_V1["add_type"]=='2')){?>
											<button type="button" class="btn btn-sm btn-warning claimModify <?php if($TPL_VAR["content_info"]['no']==$TPL_V1["no"]&&$GLOBALS["receipt_no"]){?>loadCopy<?php }?>" data-modtype='copy' data-no=<?php echo $TPL_V1["no"]?>>복사</button>
<?php }?>
                                            <button type="button" class="btn btn-sm btn-warning claimModify" data-modtype='mod' data-no=<?php echo $TPL_V1["no"]?>>수정</button>
<?php }?>
                                            <div style="padding-top:5px;">
<?php if(is_array($TPL_R2=($GLOBALS["cfg_call_type"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
                                                <label style="font-weight: normal;"><input type="checkbox" <?php if($TPL_V1["call_type"]==$TPL_K2){?>checked<?php }?> onclick="return false;"><?php echo $TPL_V2?></label>
<?php }}?>
                                            </div>
                                        </span>
                                    </div>                                   
                                    <div>
                                        접수구분 : <?php if($TPL_V1["route_type"]){?><?php echo $GLOBALS["cfg_route_type"][$TPL_V1["route_type"]]?>-<?php }?><?php echo $GLOBALS["cfg_retrun_type"][$TPL_V1["return_type"]]?><?php if($TPL_V1["return_type_sub"]){?>-<?php echo $GLOBALS["cfg_retrun_type_sub"][$TPL_V1["return_type"]][$TPL_V1["return_type_sub"]]?><?php }?>
<?php if($TPL_V1["refund_yn"]=='y'){?> / 환불완료 <?php }?>
<?php if($TPL_V1["receipt"]=='1'){?> / <font style="color: red; font-weight: bold;">선접수</font> <?php }?>
<?php if($TPL_V1["add_type"]=='0'){?> / <font style="color: red; font-weight: bold;">(접수)</font> <?php }elseif($TPL_V1["add_type"]=='2'){?> / <font style="color: red; font-weight: bold;">(처리중)</font> <?php }?>
										
<?php if(count($TPL_V1["cs_detail"])){?>
<?php if(is_array($TPL_R2=$TPL_V1["cs_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
												[<?php echo $TPL_V2["g_goodsnm"]?>]
<?php }}?>
<?php }?>
										
									</div>
<?php if(count($TPL_V1["cs_detail"])){?>
                                    <div style="padding-top:5px;"></div>
                                    <div class="csDetail btn btn-sm btn-primary" data-no=<?php echo $TPL_V1["no"]?> style="width:75px; ">상세보기</div>
<?php }?>
                                </ul>
                            </div>

<?php if(count($TPL_V1["cs_detail"])){?>
                            <div class="csLayer_<?php echo $TPL_V1["no"]?> csLayer notice-box" style="display: block; overflow:auto;padding-top:10px; display:none; font-size: 6px;">
                                <!-- <span id='close' onclick="this.parentNode.style.display = 'none';">&times;</span> -->
<?php if($TPL_V1["return_type"]=='80'){?>
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>수령자명</th>
                                            <td><?php echo $TPL_V1["receiver"]?></td>      
                                            <th>연락처</th>
                                            <td><?php echo $TPL_V1["mobile"]?></td>       
                                            
                                        </tr>
                                        <tr>
                                            <th>주소</th>
                                            <td colspan=3>우편번호 : <?php echo $TPL_V1["zipcode"]?><br><?php echo $TPL_V1["address"]?></td>                                                
                                        </tr>
                                    </tbody>
                                </table>              
<?php }elseif($TPL_V1["return_type"]=='60'){?>
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
<?php }elseif($TPL_V1["return_type"]=='40'||$TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90'){?>
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>수령자명</th>
                                            <td><?php echo $TPL_V1["receiver"]?></td>       
                                            <th>연락처</th>
                                            <td><?php echo $TPL_V1["mobile"]?></td>        
                                        </tr>
                                        <tr>
                                            <th>주소</th>
                                            <td>우편번호 : <?php echo $TPL_V1["zipcode"]?><br><?php echo $TPL_V1["address"]?></td>   
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
<?php if($TPL_V1["return_type"]=='40'||$TPL_V1["return_type"]=='60'||$TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90'){?>
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
										<tr>
                                            <th>상품이상유무</th>
                                            <td>
<?php if($TPL_V1["goods_bad_yn"]=='y'){?> 이상있음 <?php }else{?> 이상없음 <?php }?> 
<?php if($TPL_V1["goods_bad_memo"]){?>(<?php echo $TPL_V1["goods_bad_memo"]?>)<?php }?>
                                            </td>   
                                        </tr>
                                    </tbody>
                                </table>
<?php }?>
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
                                            <td><?php echo $TPL_V2["g_goodsnm"]?></td>
                                            <td><?php if($TPL_V2["exchange_goods_nm"]){?><?php echo $TPL_V2["exchange_goods_nm"]?><?php }else{?>-<?php }?></td>
                                            <td><?php echo $TPL_V2["exchange_goods_num"]?></td>
                                            <td><?php echo number_format($TPL_V2["diff_price"])?>원</td>
                                            <td><?php echo $GLOBALS["cfg_send_type"][$TPL_V2["send_type"]]?></td>
                                        </tr>
<?php }}?>
                                    </tbody>
                                </table>                    
<?php if($TPL_V1["receipt_memo"]){?>
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>택배접수내용</th>
                                            <td><?php echo nl2br($TPL_V1["receipt_memo"])?></td>   
                                        </tr>
                                    </tbody>
                                </table>
<?php }?>
                            </div>
<?php }?> 
<?php if($TPL_V1["return_type"]=='40'||$TPL_V1["return_type"]=='60'||$TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90'){?>
								<p class="csContents">
<?php if($TPL_V1["return_delivery_code"]){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?>(<?php echo $TPL_V1["return_invoice"]?>)<?php }?>
<?php if($TPL_V1["return_type_sub"]){?> / <?php echo $GLOBALS["cfg_retrun_type_sub"][$TPL_V1["return_type"]][$TPL_V1["return_type_sub"]]?><?php }?>
<?php if($TPL_V1["goods_bad_yn"]=='y'){?> / 이상있음 <?php }else{?> / 이상없음 <?php }?> <?php if($TPL_V1["goods_bad_memo"]){?>(<?php echo $TPL_V1["goods_bad_memo"]?>)<?php }?>
									/ <?php echo $TPL_V1["contents"]?>

<?php if($TPL_V1["delivery_type"]){?> / <?php echo $GLOBALS["cfg_return_delivery_type"][$TPL_V1["delivery_type"]]?>(<?php echo number_format($TPL_V1["delivery_price"])?>원)<?php }?> 
<?php if($TPL_V1["delivery_type2"]){?> / <?php echo $GLOBALS["cfg_return_delivery_type2"][$TPL_V1["delivery_type2"]]?>(<?php echo number_format($TPL_V1["delivery_price2"])?>원)<?php }?>
<?php if($TPL_V1["account_code"]&&$TPL_V1["account_number"]){?> / <?php echo $GLOBALS["cfg_account_code"][$TPL_V1["account_code"]]?>(<?php echo $TPL_V1["account_number"]?>)<?php }?> 
<?php if($TPL_V1["account_name"]){?> / 입금자명(<?php echo $TPL_V1["account_name"]?>) / 금액(<?php echo number_format($TPL_V1["account_price"])?>원)<?php }?>									
<?php }else{?>
	                            <p class="csContents"><?php echo nl2br($TPL_V1["contents"])?></p>
<?php }?>
                        </div>
<?php }elseif($TPL_V1["type"]=='as'){?>
                        <div class="csLoop">
                            <div class="info">
                                <ul style="position: relative;">
                                    <div class="claimType">
                                        <?php echo $TPL_V1["reg_date"]?> - <?php echo $TPL_V1["admin_name"]?>(<?php echo $TPL_V1["id"]?>)                                        
                                    </div>                                   
                                    <div>
                                        접수상품 : <?php echo $TPL_V1["goodsnm"]?>

                                        
                                    </div>

                                    <div style="padding-top:5px;"></div>
                                    <div class="asDetail btn btn-sm btn-primary" data-no=<?php echo $TPL_V1["no"]?> style="width:75px; ">상세보기</div>
                                </ul>
                            </div>

                            <div class="asLayer_<?php echo $TPL_V1["no"]?> asLayer notice-box" style="display: block; overflow:auto;padding-top:10px; display:none; font-size: 6px;">
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>접수자명</th>
                                            <td><?php echo $TPL_V1["receipt_name"]?></td>      
                                            <th>연락처</th>
                                            <td><?php echo $TPL_V1["mobile"]?></td>     
                                        </tr>
                                        <tr>
                                            <th>주소</th>
                                            <td>우편번호 : <?php echo $TPL_V1["zipcode"]?><br><?php echo $TPL_V1["address"]?></td>              
                                            <th>구매처</th>
                                            <td><?php echo $TPL_V1["order_buy"]?></td>                                    
                                        </tr>
                                        <tr>
                                            <th>고객비용</th>
                                            <td><?php echo $TPL_V1["customer_cost"]?></td>      
                                            <th>실비용</th>
                                            <td><?php echo $TPL_V1["real_cost"]?></td>      
                                        </tr>
                                        
                                        <tr>
                                            <th>제품특징</th>
                                            <td><?php echo $TPL_V1["product_point"]?></td>           
                                            <th>수리내용</th>
                                            <td>
<?php if(is_array($TPL_R2=$TPL_V1["ex_as"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                                    [<?php echo $GLOBALS["cfg_as_contents"][$TPL_V1["as_cate"]][$TPL_V2]?>]
<?php }}?>
                                            </td>                                 
                                        </tr>
                                        <tr>
                                            <th>반송장</th>
                                            <td>
                                                <div><?php echo $TPL_VAR["delivery_list"][$TPL_V1["delivery_code"]]['name']?></div>
                                                <div><?php echo $TPL_V1["invoice"]?></div>
                                            </td>           
                                            <th>출고송장</th>
                                            <td>
                                                <div><?php echo $TPL_VAR["delivery_list"][$TPL_V1["send_delivery_code"]]['name']?></div>
                                                <div><?php echo $TPL_V1["send_invoice"]?></div>
                                            </td>                                     
                                        </tr>
                                        <tr>
                                            <th>진행업체명</th>
                                            <td><?php echo $TPL_V1["progress_company"]?></td>           
                                            <th>기타</th>
                                            <td>재수리유무 : <?php echo $TPL_V1["re_receipt"]?>, 케이스유무 : <?php echo $TPL_V1["case_yn"]?>, 동작유무 : <?php echo $TPL_V1["action_yn"]?></td>                                 
                                        </tr>
                                        <tr>
                                            <th>입고일</th>
                                            <td><?php echo $TPL_V1["in_regdate"]?></td>           
                                            <th>출고일</th>
                                            <td><?php echo $TPL_V1["out_regdate"]?></td>                                 
                                        </tr>
                                        <tr>
                                            <th>진행단계</th>
                                            <td colspan="3"><?php echo $TPL_V1["as_status"]?></td>           
                                        </tr>
                                    </tbody>
                                </table>                    
                            </div>

                            <p class="csContents"><?php echo nl2br($TPL_V1["memo"])?></p>
                           
                        </div>
                        
<?php }elseif($TPL_V1["type"]=='sms'){?>
                        <div class="csLoop">
                            <div class="info">
                                <ul style="position: relative;">
                                    <div class="claimType">
                                        <?php echo $TPL_V1["reg_date"]?> - <?php echo $TPL_V1["admin_name"]?>(<?php echo $TPL_V1["id"]?>)                                        
                                    </div>                                   
                                    <div>
                                        [문자발송] - <?php echo $TPL_V1["title"]?>

                                    </div>

                                    <div style="padding-top:5px;"></div>
                                    <div class="smsDetail btn btn-sm btn-primary" data-no=<?php echo $TPL_V1["no"]?> style="width:75px; ">상세보기</div>
                                </ul>
                            </div>

                            <div class="smsLayer_<?php echo $TPL_V1["no"]?> smsLayer notice-box" style="display: block; overflow:auto;padding-top:10px; display:none; font-size: 6px;">
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <th>제목</th>
                                            <td><?php echo $TPL_V1["title"]?></td>      
                                        </tr>
                                        <tr>
                                            <th>연락처</th>
                                            <td><?php echo $TPL_V1["mobile"]?></td>      
                                        </tr>
                                        <tr>
                                            <th>내용</th>
                                            <td><?php echo nl2br($TPL_V1["contents"])?></td>     
                                        </tr>
                                    </tbody>
                                </table>                    
                            </div>
                        </div>
                        
<?php }?>
                    </div>
<?php }}?>
                    
                </div>
                
            </td>
		</tr>
	</tbody>
</table>

<script>    
    $(document).on("click",".csDetail",function(e){
        
        //var img_top = event.pageY-400;
        //var img_left = event.pageX; 
        var detailNo=$(this).data('no');
    
        //$(".csLayer").css("display","none");
        $(".csLayer_"+detailNo).toggle();
    
    });
    $(document).on("click",".asDetail",function(e){
        
        //var img_top = event.pageY-400;
        //var img_left = event.pageX; 
        var detailNo=$(this).data('no');
    
        //$(".csLayer").css("display","none");
        $(".asLayer_"+detailNo).toggle();
    
    });
    $(document).on("click",".smsDetail",function(e){
        
        //var img_top = event.pageY-400;
        //var img_left = event.pageX; 
        var detailNo=$(this).data('no');
    
        //$(".csLayer").css("display","none");
        $(".smsLayer_"+detailNo).toggle();
    
    });
    
    
    $(".viewChange").change(function (){
        $(".view_type").hide();
        if($(this).val()){
            $("."+$(this).val()+"_div").show();
        }else{
            $(".view_type").show();
        }
    });
</script>