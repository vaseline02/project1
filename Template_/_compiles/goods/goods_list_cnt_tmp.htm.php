<?php /* Template_ 2.2.8 2020/10/05 10:35:11 /www/html/ukk_test/data/skin/goods/goods_list_cnt_tmp.htm 000007417 */ 
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_sumStock_1=empty($TPL_VAR["sumStock"])||!is_array($TPL_VAR["sumStock"])?0:count($TPL_VAR["sumStock"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<form method="post" id="glb_search_form">
    <input type="hidden"name="print_xls" value="">
    <div class="col-lg-12">
        <div class="panel panel-default panel-stock margin20">
            <div class="searchbox-default">
                <table class="table fileload-list-small">
                    <colgroup>
                        <col width="12%" />
                        <col width="35%" />
                        <col width="12%" />
                        <col width="35%" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row" class="align-left">브랜드</th>
                            <td class="receive-title no-gutters">
                                <div class="col-xs-12"><input type="text" class="form-control" name="s_brand" value="<?php echo $_POST['s_brand']?>"/></div>
                            </td>
                            <th scope="row">모델명</th>
                            <td class="receive-title no-gutters">
                                <div class="col-xs-12"><input type="text" class="form-control" name="s_model" value="<?php echo $_POST['s_model']?>"/></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">모델명 다중검색</th>
                            <td class="receive-title no-gutters">
                                <div class="col-xs-12">
                                    <dl class="multitext-search">
                                        <dd><textarea class="form-control" name="s_paste" id="" cols="30" rows="3"><?php echo $_POST['s_paste']?></textarea></dd>
                                    </dl>
                                </div>
                            </td>
                            <th scope="row">정렬</th>
                            <td class="receive-title no-gutters">
                                <select name="codedata_sort">
                                    <option value="">==선택==</option>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
                                    <option value='<?php echo $TPL_V1["no"]?>' <?php echo $GLOBALS["selected"]['codedata_sort'][$TPL_V1["no"]]?>><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
                                </select>
                                &nbsp;
                                <label style="font-weight: normal;"><input type="radio" name="sort_type" value="asc" <?php echo $GLOBALS["checked"]['sort_type']['asc']?>>오름차순</label>
                                &nbsp;
                                <label style="font-weight: normal;"><input type="radio" name="sort_type" value="desc" <?php echo $GLOBALS["checked"]['sort_type']['desc']?>>내림차순</label>
                                &nbsp;
                                <label style="font-weight: normal;"><input type="checkbox" name="stock_check" value="Y" <?php echo $GLOBALS["checked"]['stock_check']['Y']?>>재고있음</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">    
                <div class="text-center table-btn-group">
                    <button class="btn btn-primary">검 색</button> 
                    <button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
                <!-- <button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
                    [<input type="checkbox"  value="1" name='search_noimg' id='search_noimg' <?php echo $GLOBALS["s_res"]['checked']['search_noimg']['1']?>>
                    <label class=" label label-success" for="search_noimg">이미지 <?php if($GLOBALS["my_page"]=='goods_list.php'||$GLOBALS["my_page"]=='event_price.php'){?>포함<?php }else{?>제외<?php }?></label>]-->
                </div>	
            </div>
        
        </div>
    </div>
</form>
<?php }?>

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
	<caption>
		<div class="input-group col-lg-12 common-table-search2">
			<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
			<div class="input-group common-table-search">
			</div>
		</div>
	</caption>                
	<colgroup>
		<col width="5%" />
		<col width="4%" />
		<col width="3%"/>
		<col width="7%" />
		<col width="7%" />
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
		<col width="140px"/>
<?php }}?>
	</colgroup>
<?php }?>
	<thead>
		<tr>
			<th>브랜드</th>
			<th>분류</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th>이미지</th><?php }?>
			<th>모델명1</th>
			<th>모델명2</th>
			<th>현재고</th>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
				<th><?php echo $TPL_V1["cd"]?></th>
<?php }}?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["brandnm"]?></td>
				<td><?php echo $TPL_V1["prod_type"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img" ><?php echo $TPL_V1["img_url"]?></td><?php }?>
				<td class="text_type"><?php echo $TPL_V1["goodsnm"]?></td>
				<td class="text_type"><?php echo $TPL_V1["goodsnm_sub"]?></td>
				<td><?php echo $TPL_V1["cur_cnt"]?></td>
<?php if(is_array($TPL_R2=$TPL_V1["codedata"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<td><?php echo $TPL_V2?></td>
<?php }}?>
			</tr>
<?php }}?>
	</tbody>
	<tfoot>
		<tr style="border-top:1px solid black;">
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td colspan='5' style="border-top:1px solid black; text-align: center;">합계</td>
<?php }else{?>
			<td colspan='4' style="border-top:1px solid black; text-align: center;">합계</td>
<?php }?>
<?php if($TPL_sumStock_1){foreach($TPL_VAR["sumStock"] as $TPL_V1){?>
			<td style="border-top:1px solid black;"><?php echo number_format($TPL_V1)?></td>
<?php }}?>
		</tr>
	</tfoot>
	
		
</table>



<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<?php }?>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(function(){

$("#print_xls").click(function(){
    $("input[name='print_xls']").val("1");
    $("#glb_search_form").submit();
    $("input[name='print_xls']").val("0");
});
})
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>