<?php /* Template_ 2.2.8 2020/10/22 12:19:20 /www/html/ukk_test2/data/skin/admin/test.htm 000000841 */ 
$TPL__data_1=empty($GLOBALS["data"])||!is_array($GLOBALS["data"])?0:count($GLOBALS["data"]);?>
<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">

	<tbody>
<?php if($TPL__data_1){foreach($GLOBALS["data"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["no"]?></td>
			<td><?php echo $TPL_V1["m_no"]?></td>
			<td><?php echo $TPL_V1["name"]?></td>
			<td><?php echo $TPL_V1["cost"]?></td>
			<td><?php echo $TPL_V1["io"]?></td>
			<td><?php echo $TPL_V1["customer"]?></td>
			<td><?php echo $TPL_V1["invoice"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td><?php echo $TPL_V1["cost1"]?></td>
		</tr>
<?php }}?>

</table>