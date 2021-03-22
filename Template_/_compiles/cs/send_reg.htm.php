<?php /* Template_ 2.2.8 2020/03/26 11:32:30 /www/html/ukk_test/data/skin/cs/send_reg.htm 000003524 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<form method="post" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="order_no" value="<?php echo $TPL_VAR["ordno"]?>">
<input type="hidden" name="claim_no" value="">

<h1 class="page_title">정보</h1>
<style>
    .search_td_width{width:400px;}
</style>
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>주문번호</th>
            <td class="search_td_width"><?php echo $TPL_VAR["order_no"]?></td>            
            <th>수령자</th>
            <td><?php echo $TPL_VAR["receiver"]?></td>   
        </tr>
        <tr>
			<th>주소</th>
            <td><?php echo $TPL_VAR["zipcode"]?> <?php echo $TPL_VAR["address"]?></td>   
            <th>연락처</th>
            <td><?php echo $TPL_VAR["mobile"]?></td>   
        </tr>
        <tr>
			<th>송장번호</th>
            <td><?php echo $TPL_VAR["invoice"]?></td>   
            <th>차액</th>
            <td><?php echo number_format($TPL_VAR["diff_price"])?>원</td>   
        </tr>
        <tr>
			<th>교환반품</th>
            <td><?php echo $TPL_VAR["return_type_nm"]?></td>   
            <th>진행상태</th>
            <td></td>   
        </tr>
	</tbody>
</table>

<hr>


<h1 class="page_title">상품정보</h1>

<table id="" style="width:100%" class="listTable">
    <tr>
        <td>
            <table id="" style="width:100%" class="listTable">
                <thead>
                    <tr>			
                        <th width='100'>모델명</th>
                        <th width='100'>이미지</th>
                        <th width='100'>수량</th>
                    </tr>
                </thead>	
                <tbody>
                    
                    <tr>			
                        <td><?php echo $TPL_VAR["goodsnm"]?></td>
                        <td class="td_img"><?php echo $TPL_VAR["img_url"]?></td>
                        <td class="centerClass"><?php echo $TPL_VAR["order_num"]?></td>
                    </tr>
                    
                </tbody>
            </table>
        </td>
        <td style="text-align: center;">=></td>
        <td>
                
            <table id="" style="width:100%" class="listTable">
                <thead>
                    <tr>			
                        <th width='100'>모델명</th>
                        <th width='100'>이미지</th>
                        <th width='100'>수량</th>
                    </tr>
                </thead>	
                <tbody>
                
                    <tr>			
                        <td><?php echo $TPL_VAR["exchange_goodsnm"]?></td>
                        <td class="td_img"><?php echo $TPL_VAR["exchange_img_url"]?></td>
                        <td class="centerClass"><?php echo $TPL_VAR["exchange_goods_num"]?></td>
                    </tr>
                    
                </tbody>
            </table>
        </td>
    </tr>
</table>
<hr>
 <center>
    <button class="btn btn btn-primary buttonChange">등록</button>
</center>


</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>