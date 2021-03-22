<?php /* Template_ 2.2.8 2020/07/30 09:30:50 /www/html/ukk_test/data/skin/cs/soldout_reg.htm 000011066 */ 
$TPL_goodsList_1=empty($TPL_VAR["goodsList"])||!is_array($TPL_VAR["goodsList"])?0:count($TPL_VAR["goodsList"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<form method="post" id="csForm" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="">
<input type="hidden" name="order_no" value="<?php echo $TPL_VAR["ordno"]?>">
<input type="hidden" name="send_type" value="20">
<input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING']?>"> 


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


<h1 class="page_title">상품정보</h1>

<table id="" style="width:100%" class="listTable">
	<thead>
		<tr>			
<?php if(!$GLOBALS["view_type"]){?>
            <th width='50'><input type="checkbox" class="allCheck"></th>
<?php }?>
			<th width='100'>상품명</th>
			<th width='100'>모델명</th>
			<th width='100'>이미지</th>
			<th width='100'>수량</th>
			<th width='100'>가격</th>
			<th width='100'>메모</th>			
			<th width='100'>품절여부</th>			
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_goodsList_1){foreach($TPL_VAR["goodsList"] as $TPL_V1){?>
        <input type="hidden" name="goods_no[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["goodsno"]?>">        
        <input type="hidden" name="mall_no[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["mall_no"]?>">        
        <input type="hidden" name="ori_order_no[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["ori_ordno"]?>">        
		<tr class="<?php echo $TPL_V1["line_color"]?> trNo_<?php echo $TPL_V1["no"]?>">			
<?php if(!$GLOBALS["view_type"]){?>
            <td class="centerClass"><input type="checkbox" name="order_list_no[]" id="order_list_no_<?php echo $TPL_V1["no"]?>" class="goodsTableAdd" data-no=<?php echo $TPL_V1["no"]?> data-mall_goodsnm='<?php echo $TPL_V1["mall_goodsnm"]?>' data-order_num='<?php echo $TPL_V1["order_num"]?>' data-goodsnm='<?php echo $TPL_V1["goodsnm"]?>' data-goodsno='<?php echo $TPL_V1["goodsno"]?>' data-step2='<?php echo $TPL_V1["step2"]?>' data-stock_yn='<?php echo $TPL_V1["stock_yn"]?>' value=<?php echo $TPL_V1["no"]?>></td>
<?php }?>
			<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td class="centerClass"><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo number_format($TPL_V1["order_price"].$TPL_VAR["deli_price"])?>원</td>
            <td><?php echo $TPL_V1["memo"]?></td>		
            <td><?php echo $TPL_V1["soldout"]?></td>	
		</tr>
<?php }}?>
	</tbody>
</table>

<hr>
<?php if(!$GLOBALS["view_type"]){?>
<h1 class="page_title">접수</h1>

<table class="table table-bordered" >
	<tbody>		
		<tr>
            <th style="text-align: left;">
                <div>
                    수령자명    : <input type="text" value="<?php echo $TPL_VAR["receiver"]?>" name="receiver" style="width: 70px;"> 
                    연락처      : <input type="text" value="<?php echo $TPL_VAR["mobile"]?>" name="mobile" style="width: 130px;">
                </div>
                <div style="padding-top: 10px;">                    
                    주소        : <input type="text" value="<?php echo $TPL_VAR["zipcode"]?>" name="zipcode" style="width: 70px;" class="zipcode"> <input type="text" value="<?php echo $TPL_VAR["address"]?>" name="address" style="width: 500px;" class="address"> 
                    <button type="button" class="btn btn-sm btn-primary searchAddress">우편번호찾기</button>
                </div>               
            </th>
        </tr>
        <tr>
            <td>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('강성')">강성</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('반품접수')">반품접수</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('하자')">하자</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('품절')">품절</button>
                </div>
                <div>
                    <textarea style="overflow:auto; width:100%; height:120px;" name="contents" class="textPick"></textarea>
                </div>
            </td>
        </tr>
    </tbody>
 </table>
 <center>
    <div class="btn btn btn-primary buttonNewOrder">재주문</div>
    <div class="btn btn btn-primary buttonCancel">전체취소</div>
    <div class="btn btn btn-success buttonMemo">내용등록</div>
</center>
<hr>
<?php }?>

<?php echo $this->define('tpl_include_file_1',"cs/receipt_view.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>


</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

var textareaContents;
var textSum;
//클릭text
function textPick(text){
    textareaContents=$(".textPick").val();        
    if(textareaContents) textSum=textareaContents+' '+text;
    else textSum=text;
    
    $(".textPick").val(textSum);
}
function checkForm(){
    insMode=$("input[name='mode']").val();
    
    if(insMode=='cancel' || insMode=='neworder'){
        textareaContents=$(".textPick").val();
        if(!textareaContents){
            alert('내용을 입력해주세요.');
            return false;
        }
        if(insMode=='mod'){
            if(!confirm("수정하시겠습니까?")) return false;
        }
    }
}

//재주문
$(".buttonNewOrder").click(function (){
    if(!$(".goodsTableAdd").is(":checked")){
        alert("재주문할 상품이 선택되지 않았습니다.");return false;
    }
    var exchangeCheck=0;
    $(".goodsTableAdd").each(function(index, item){
        if($(item).is(":checked")){        
            if(!$("input[name='exchange_goods_num["+$(item).val()+"]']").val()) exchangeCheck++;
        }
    });
    if(exchangeCheck>0){
        alert("재주문할 상품의 수량이 입력되지 않았습니다.");
        return false;
    }
    if(confirm('선택된 상품만 재주문 요청됩니다. \n진행하시겠습니까?')){
        $("input[name='mode']").val('neworder');
        $("form[id='csForm']").submit();
    }
});

//취소
$(".buttonCancel").click(function (){
    if(confirm('전체취소됩니다. 진행하시겠습니까? \n (특정상품만 주문할경우 상품 선택후 재주문접수 버튼을 클릭해주세요.)')){
        $("input[name='mode']").val('cancel');
        $("form[id='csForm']").submit();
    }    
});

//내용등록
$(".buttonMemo").click(function (){
    if(confirm('접수내용만 등록됩니다. 진행하시겠습니까?')){
        $("input[name='mode']").val('memo');
        $("form[id='csForm']").submit();
    }    
});

//상품 체크시 교환관련 항목 노출
$(".goodsTableAdd").click(function(){
    var no=$(this).data('no');
    var mallGoodsnm=$(this).data('mall_goodsnm');
    var goodsnm=$(this).data('goodsnm');
    var orderNum=$(this).data('order_num');
    var goodsNo=$(this).data('goodsno');
    var step2=$(this).data('step2');
    var stockYn=$(this).data('stock_yn');
    var checkYn=($(this).is(":checked"));
    var thLength=$(".listTable th").length;
    var addHtml="";
    if(step2=='0' || step2=='41')orderNum='';    

    if(checkYn){
        addHtml="<tr class='trNo_"+no+"'>";
        addHtml+="  <input type='hidden' name='exchange_goods_no["+no+"]' value='"+goodsNo+"'>";
        addHtml+="  <input type='hidden' name='exchange_stock_yn["+no+"]' value='"+stockYn+"'>";
        addHtml+="  <th style='text-align: left;' colspan="+thLength+">";
        addHtml+="      <div style='padding-top: 10px; display:none'>";
        addHtml+="          구매상품 : <input type='text' value='"+mallGoodsnm+"' name='mall_goodsnm["+no+"]' style='width: 800px;''> ";
        addHtml+="      </div>";
        addHtml+="      <div style='padding-top: 10px;'>";
        addHtml+="          모델명 : <input type='text' value='"+goodsnm+"' name='exchange_goods_nm["+no+"]' style='width: 400px;' readonly> ";
        addHtml+="          수량 : <input type='text' value='"+orderNum+"' name='exchange_goods_num["+no+"]' style='width: 50px;' onkeypress='inNumber()'> ";
        addHtml+="          비용 : <input type='text' value='0' name='diff_price["+no+"]' style='width: 130px;' onkeypress='inNumber()'> ";
        addHtml+="          <button type='button' class='btn btn-sm btn-warning' onclick='popup(\"goods_search.php?goodsno="+no+"\",\"goods_search\",\"1000\",\"900\")'>교환상품선택</button>";
        addHtml+="      </div>";
        addHtml+="  </th>";
        addHtml+="</tr>";

        $('.listTable > tbody > .trNo_'+no+':last').after(addHtml);
    }else{
        $('.trNo_'+no+':last').remove();
    }
});

//전체체크        
$(".allCheck").click(function(){    
    var subject = $('.goodsTableAdd');
    $(subject).each(function(index, item){
        $(item).click(); 
    });
});

//전체체크        
$(".allCheck").click(function(){    
    var subject = $('.goodsTableAdd');
    
    $(subject).each(function(index, item){
        if($(".allCheck").is(":checked")){
            if(!$(item).is(":checked")){
                $(item).click(); 
            }
        }else{
            if($(item).is(":checked")){
                $(item).click(); 
            }
        }
    });
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

<?php $this->print_("footer",$TPL_SCP,1);?>