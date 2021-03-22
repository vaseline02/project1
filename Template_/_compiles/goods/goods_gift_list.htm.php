<?php /* Template_ 2.2.8 2020/08/06 18:34:03 /www/html/ukk_test2/data/skin/goods/goods_gift_list.htm 000003325 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" name="giftForm">
<input type="hidden" name="mode">
<input type="hidden" name="no">
<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색"> -->
							<span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="popup('goods_gift_reg.php','gift_reg','1100','900')">메뉴등록</button></span>
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="15%" />
					<col width="15%" />
					<col/>
					<col width="15%" />
					<!-- <col width="5%" /> -->
					<col width="10%" />
					<col width="3%" />
					
				</colgroup>
				<thead>
					<tr>
						<th>사은품명</th>
						<th>적용브랜드</th>
						<th>적용카테고리</th>
						<th>적용상품명</th>
						<!-- <th>노출여부</th> -->
						<th>등록일</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr>
						<td><?php echo $TPL_V1["giftgoodsnm"]?></td>
						<td><?php echo $TPL_V1["brandnm"]?></td>
						<td>
<?php if($TPL_V1["cate_1"]){?><?php echo $TPL_V1["cate_1"]?><?php }?>
<?php if($TPL_V1["cate_2"]){?> >> <?php echo $TPL_V1["cate_2"]?><?php }?>
<?php if($TPL_V1["cate_3"]){?> >> <?php echo $TPL_V1["cate_3"]?><?php }?>
<?php if($TPL_V1["cate_4"]){?> >> <?php echo $TPL_V1["cate_4"]?><?php }?>                        
                        </td>
						<td><?php echo $TPL_V1["goodsnm"]?></td>
						<!-- <td><?php echo $TPL_V1["view_yn"]?></td> -->
						<td><?php echo $TPL_V1["reg_date"]?></td>
			
						<td>
                            <div class="input-group fileload-list-small-button">
                                <span class="input-group-btn"><button class="btn btn-danger del" data-no=<?php echo $TPL_V1["no"]?> data-mode="del" type="button">삭제</button></span>
                            </div>
						</td>
					</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</form>
<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<?php }?>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".del").click(function(){

    var no=$(this).data("no");
    var mode=$(this).data("mode");

    $("input[name=mode]").val(mode);
    $("input[name=no]").val(no);

    if(confirm("삭제하시겠습니까?")){
        $("form[name=giftForm]").submit();
    }
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>