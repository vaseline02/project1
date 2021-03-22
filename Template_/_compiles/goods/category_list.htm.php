<?php /* Template_ 2.2.8 2020/10/05 13:58:46 /www/html/ukk_test2/data/skin/goods/category_list.htm 000004904 */ 
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
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" onclick="popup('goods_info_reg.php','goods_info_reg','1100','900')">상품속성정보</button>
								<span style="padding-left:10px;"> </span>
								<button class="btn btn-primary" type="button" onclick="popup('category_reg.php','gift_reg','1100','900')">카테고리등록</button>
							</span>
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="20%"/>
					<col/>
					<col width="20%"/>
					<col width="10%" />
					<col width="10%" />
					<col width="5%" />
					<col width="3%" />
					
				</colgroup>
				<thead>
					<tr>
						<th>카테고리코드</th>
						<th>카테고리명</th>
						<th>분류코드</th>
						<th>노출여부</th>
						<th>등록일</th>
						<th>상품수</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr>
						<td><?php echo $TPL_V1["catecode"]?></td>
						<td class="text-left">
<?php if($TPL_V1["cate_1"]){?><?php echo $TPL_V1["cate_1"]?><?php }?>
<?php if($TPL_V1["cate_2"]){?> >> <?php echo $TPL_V1["cate_2"]?><?php }?>
<?php if($TPL_V1["cate_3"]){?> >> <?php echo $TPL_V1["cate_3"]?><?php }?>
<?php if($TPL_V1["cate_4"]){?> >> <?php echo $TPL_V1["cate_4"]?><?php }?>                        
                        </td>
						<td><?php echo $GLOBALS["cfg_prop_code"][$TPL_V1["sabang_prop_code"]]?> <?php echo $TPL_V1["sabang_prop_code"]?></td>
						<td><?php echo $TPL_V1["view_yn"]?></td>
						<td><?php echo $TPL_V1["reg_date"]?></td>
						<td><?php echo $TPL_V1["g_cnt"]?></td>
			
						<td>                           
<?php if($TPL_V1["g_cnt"]||$TPL_V1["c_cnt"]){?>
                                <div class="input-group fileload-list-small-button">
                                    <span class="input-group-btn"><button class="btn btn-danger" style="opacity: 0.6; cursor: not-allowed;" onclick="alert('등록되있는 상품이나 하위카테고리가 있어서 삭제가 불가능합니다.')" type="button">삭제</button></span>
                                </div>
<?php }else{?>
                                <div class="input-group fileload-list-small-button">
                                    <span class="input-group-btn"><button class="btn btn-danger del" data-no=<?php echo $TPL_V1["no"]?> data-mode="del" type="button">삭제</button></span>
                                </div>
<?php }?>
<?php if(!$TPL_V1["cate_2"]){?>
								<div class="input-group fileload-list-small-button" style="padding-top:5px;">
									<span class="input-group-btn"><button class="btn btn-warning" type="button" onclick="popup('../goods/goods_info_reg.php?cate=<?php echo $TPL_V1["depth_1"]?>','goods_info_reg','1100','900')">속성등록</button></span>
								</div>
<?php }else{?>
								<div class="input-group fileload-list-small-button" style="padding-top:5px;">
									<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="popup('../goods/goods_prop_reg.php?no=<?php echo $TPL_V1["no"]?>&cate_code=<?php echo $TPL_V1["depth_1"]?>','goods_prop_reg','1100','900')">정보고시설정</button></span>
								</div>
<?php }?>
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