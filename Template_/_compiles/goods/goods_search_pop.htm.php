<?php /* Template_ 2.2.8 2020/08/06 15:49:38 /www/html/ukk_test2/data/skin/goods/goods_search_pop.htm 000004003 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>



<form method="get">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b></b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><button class="btn btn-primary">검색</button>	</span>
							</div>
							
						</div>
					</caption>
					<colgroup>
						<col width="15%" />
						<col width="85%" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">모델명</th>
							<td class="receive-title no-gutters">
								<textarea name="s_goodsnm" style="width:100%; height:100px"><?php echo $_POST['s_goodsnm']?></textarea>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>


<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색"> -->
							<!-- <span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="popup('menu_reg.php','member_reg','1100','900')">메뉴등록</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					<col/>
					<col width="10%" />
					<col width="15%" />
					<col width="15%" />
					<col width="10%" />
					<col width="3%" />
					
				</colgroup>
				<thead>
					<tr>
						<th>모델명</th>
                        <th>이미지</th>
                        <th>판매가</th>
                        <th>소비자가</th>
                        <th>수량</th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr>
						<td><?php echo $TPL_V1["goodsnm"]?></td>
                        <td class="td_img_sm"><?php echo $TPL_V1["img_url"]?></td>
                        <td><?php echo number_format($TPL_V1["s_price"])?>원</td>
                        <td><?php echo number_format($TPL_V1["c_price"])?>원</td>
                        <td><?php echo $TPL_V1["totalCnt"]?></td> 
                        <td>
                            <div class="input-group fileload-list-small-button">
                                <span class="input-group-btn"><button class="btn btn-warning goodsClick" data-no=<?php echo $TPL_V1["no"]?> data-goodsnm='<?php echo $TPL_V1["goodsnm"]?>' data-stock_yn='<?php echo $TPL_V1["stock_yn"]?>' type="button">선택</button></span>
                            </div>
                        </td>
					</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<?php }?>
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".goodsClick").click(function(){
	var goodsno=$(this).data('no');
	var goodsnm=$(this).data('goodsnm');
	$("input[name='gift_goodsno']",opener.document).val(goodsno);
	$(".gift_goodsnm",opener.document).html(goodsnm);
	self.close();

});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>