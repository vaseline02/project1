<?php /* Template_ 2.2.8 2021/03/18 10:26:05 /www/html/ukk_test2/data/skin/order/order_mod_pop.htm 000004830 */ 
$TPL_delivery_list_1=empty($TPL_VAR["delivery_list"])||!is_array($TPL_VAR["delivery_list"])?0:count($TPL_VAR["delivery_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<style>
table.table-bordered td{width:300px;}
table.table-bordered input,textarea{width:100%;}
</style>

<form method="post" id="main_form" onsubmit="return chkform();">
<input type="hidden" name="mode" value="mod">
<input type="hidden" name="no" value="<?php echo $GLOBALS["no"]?>">
<input type="hidden" name="model_chk" value="<?php echo $GLOBALS["model_chk"]?>">
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>몰명</th>
			<td><?php echo $TPL_VAR["mall_name"]?></td>
			<th>주문번호</th>
			<td><?php echo $TPL_VAR["ordno"]?></td>
		</tr>

		<tr>
			<th>상품명</th>
			<td><textarea name="mall_goodsnm" required <?php echo $GLOBALS["mod_able"]?>><?php echo $TPL_VAR["mall_goodsnm"]?></textarea></td>
			<th>옵션명</th>
			<td>
				<input type="text" name="goodsnm" class="chk_goodsnm" value="<?php echo $TPL_VAR["goodsnm"]?>" <?php echo $GLOBALS["mod_able"]?>>
				<input type="hidden" class="submit_ok_chk" id="hid_chk_goods" name="hid_chk_goods" value="1" alt="옵션명 체크">
				<span id="chk_goods_msg">사용가능</span>
			</td>
		</tr>

		<tr>
			<th>수량</th>
			<td><input type="text" name="order_num" value="<?php echo $TPL_VAR["order_num"]?>" required <?php echo $GLOBALS["mod_able"]?>></td>
			<th>가격</th>
			<td>
				구매가:<input type="text" name="order_price" value="<?php echo $TPL_VAR["order_price"]?>" required <?php echo $GLOBALS["mod_able"]?>><br/>
				결제가:<input type="text" name="settle_price" value="<?php echo $TPL_VAR["settle_price"]?>" required <?php echo $GLOBALS["mod_able"]?>><br/>
				배송비(형식:<?php echo $TPL_VAR["deli_type"]?>):<input type="text" name="deli_price" value="<?php echo $TPL_VAR["deli_price"]?>" required <?php echo $GLOBALS["mod_able"]?>><br/>
			</td>
		</tr>

		<tr>
			<th>구매자</th>
			<td><input type="text" name="buyer" value="<?php echo $TPL_VAR["buyer"]?>" required></td>
			<th>수령자</th>
			<td><input type="text" name="receiver" value="<?php echo $TPL_VAR["receiver"]?>" required></td>
		</tr>

		<tr>
			<th>구매자연락처</th>
			<td><input type="text" name="buyer_mobile" value="<?php echo $TPL_VAR["buyer_mobile"]?>"></td>
			<th>수령자연락처</th>
			<td><input type="text" name="mobile" value="<?php echo $TPL_VAR["mobile"]?>" required></td>
		</tr>

		<tr>
			<th>우편번호</th>
			<td><input type="text" name="zipcode" value="<?php echo $TPL_VAR["zipcode"]?>" ></td>
			<th>주소</th>
			<td><textarea name="address" required><?php echo $TPL_VAR["address"]?></textarea></td>
		</tr>

		<tr>
			<th>송장번호</th>
			<td>
				<select name="courier_code">      
					<option value="">== 택배사선택 ==</option>
<?php if($TPL_delivery_list_1){foreach($TPL_VAR["delivery_list"] as $TPL_V1){?>
						<option value=<?php echo $TPL_V1["code"]?> <?php if($TPL_VAR["courier_code"]){?><?php if($TPL_V1["code"]==$TPL_VAR["courier_code"]){?>selected<?php }?><?php }else{?><?php if($TPL_V1["code"]=='CJGLS'){?>selected<?php }?><?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
				<input type="text" name="invoice" value="<?php echo $TPL_VAR["invoice"]?>">
			</td>
			<th>차수</th>
			<td>
				<input type="text" name="cha_su" value="<?php echo $TPL_VAR["cha_su"]?>">
			</td>
		</tr>
		<tr>
			<th>WMS주문번호</th>
			<td>
				<input type="text" name="wms_ordno" value="<?php echo $TPL_VAR["wms_ordno"]?>">
			</td>
			<th>주문메모</th>
			<td><textarea name="order_memo" ><?php echo $TPL_VAR["order_memo"]?></textarea></td>
		</tr>
		<tr>
			<th>관리자 메모</th>
			<td><textarea name="memo" ><?php echo $TPL_VAR["memo"]?></textarea></td>
			<th></th>
			<td></td>
		</tr>

	</tbody>
</table>


<center>
	<button class="btn btn btn-primary">주문정보 수정</button>
</center>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){

	$(".chk_goodsnm").keyup(function(){
		
		var this_val=$(this).val();
		if( this_val.length >3 ){

			$.post("../ajax/chk_goodsnm.php",{goodsnm:this_val},function(data){
				
				if(data=='1'){
					$("#chk_goods_msg").html('사용가능').css("color","black");
					$("#hid_chk_goods").val("1");
				}else{
					$("#chk_goods_msg").html('사용불가').css("color","red");
					$("#hid_chk_goods").val("0");		
				}
			});
		}
	});

});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>