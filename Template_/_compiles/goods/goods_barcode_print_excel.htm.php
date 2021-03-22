<?php /* Template_ 2.2.8 2020/10/13 17:37:39 /www/html/ukk_test/data/skin/goods/goods_barcode_print_excel.htm 000001267 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table id="" class="display display_dt barcodeTable" border="<?php echo $GLOBALS["xls_border"]?>">
    <thead>
        <tr>
            <th></th>			
            <th>모델명</th>
            <th>바코드</th>
            <th></th>
            <th>모델명</th>
            <th>모델명</th>
            <th>브랜드</th>
            <th>출력수량</th>
        </tr>
    </thead>
    <tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
        <tr>
            <td></td>
            <td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
            <td style='mso-number-format:"\@";'><?php echo $TPL_V1["barcode"]?></td>
            <td></td>
            <td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
            <td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
            <td><?php echo $TPL_V1["brand_img_folder"]?></td>
            <td><?php echo $TPL_V1["quantity"]?></td>
        </tr>
<?php }}?>
    </tbody>
</table>