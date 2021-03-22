<?php /* Template_ 2.2.8 2020/11/09 16:42:58 /www/html/ukk_test2/data/skin/goods/stock_move_excel.htm 000000875 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
    <tr>
        <td>모델명</td>
        <td>수량</td>
        <td>차감위치</td>
        <td>증가위치</td>
		<td>메모</td>
		<td>관리자</td>
		<td>변경일</td>
    </tr>
    
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
    <tr>
        <td><?php echo $TPL_V1["g_goodsnm"]?></td>
        <td><?php echo $TPL_V1["quantity"]?></td>
        <td><?php echo $TPL_V1["s_name"]?></td>
        <td><?php echo $TPL_V1["e_name"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
		<td><?php echo $TPL_V1["admin_name"]?></td>
		<td><?php echo $TPL_V1["reg_date"]?></td>
    </tr>
<?php }}?>
</table>