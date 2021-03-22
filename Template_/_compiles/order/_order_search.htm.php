<?php /* Template_ 2.2.8 2020/01/03 17:19:02 /www/html/ukk/data/skin/order/_order_search.htm 000000716 */ ?>
<form method="post" >


<table class="table table-bordered " >
	<tbody>
		<tr>
			<th>몰명</th>
			<td style="width:200px"><input name="s_mall" type="text" value="<?php echo $_POST['s_mall']?>"></td>
			<th>모델명</th>
			<td style="width:200px"><input name="s_model" type="text" value="<?php echo $_POST['s_model']?>"></td>
			<th>구매자/수령자</th>
			<td><input name="order_name" type="text" value="<?php echo $_POST['order_name']?>"></td>	
		</tr>
	</tbody>
</table>

<center style="margin-bottom:20px;">
<button class="btn btn-primary">검 색</button> 
</center>
</form>