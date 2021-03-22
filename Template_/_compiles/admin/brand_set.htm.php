<?php /* Template_ 2.2.8 2021/03/03 08:50:25 /www/html/ukk_test2/data/skin/admin/brand_set.htm 000004897 */ 
$TPL_mall_list_1=empty($TPL_VAR["mall_list"])||!is_array($TPL_VAR["mall_list"])?0:count($TPL_VAR["mall_list"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<div class="row">
	<div class="col-lg-12">		
		<form method="get">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="15%" />
					<col width="85%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row" class="align-left">브랜드구분</th>
						<td class="receive-title no-gutters">
							
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type" value="" name="type" <?php echo $GLOBALS["checked"]['type']['']?>>
								<label class="form-check-label" for="type">전체</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type_A" value="A" name="type" <?php echo $GLOBALS["checked"]['type']['A']?>>
								<label class="form-check-label" for="type_A">공통</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type_I" value="I" name="type" <?php echo $GLOBALS["checked"]['type']['I']?>>
								<label class="form-check-label" for="type_I">내부</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type_O" value="O" name="type" <?php echo $GLOBALS["checked"]['type']['O']?>>
								<label class="form-check-label" for="type_O">외부</label>
							</div>
						</td>
					</tr>
					<!-- <tr>
						<th rowspan="5">몰명</th>
						<td rowspan="5">
							<div style="overflow: auto; height:210px; font-size: 11px;">
<?php if($TPL_mall_list_1){foreach($TPL_VAR["mall_list"] as $TPL_V1){?>
							
								<label class="mallLabel"><input type="checkbox" name="s_mall_no[]" value=<?php echo $TPL_V1["no"]?> <?php echo $GLOBALS["checked"]['mall_no'][$TPL_V1["no"]]?>><?php if($TPL_V1["upload_form_type"]!='사방넷'){?>(<?php echo $TPL_V1["upload_form_type"]?>)<?php }?><?php echo $TPL_V1["mall_name"]?></label>
							
<?php }}?>
								
						</td>
					</tr> -->
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>
			<!-- <button class="btn btn-default" onclick="location.href ='cs_total_list.php'; return false;">초기화</button> -->
		</div>
		</form>
	</div>			
</div>




<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="popup('brand_reg.php','brand_reg','1100','900')">브랜드등록</button></span>
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="15%" />
					<col width="15%" />
					<col width="15%" />
					<col width="15%" />
					<col/>
					<col width="10%" />
					<col width="3%" />
					
				</colgroup>
				<thead>
					<tr>
						<th>브랜드명</th>
						<th>브랜드영문명</th>
						<th>이미지폴더명</th>
						<th>케이스이미지명</th>
						<th>메모</th>
						<th>등록일</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr>
						<td><?php echo $TPL_V1["brandnm"]?></td>
						<td><?php echo $TPL_V1["brandnm_en"]?></td>
						<td><?php echo $TPL_V1["brand_img_folder"]?></td>
						<td><?php echo $TPL_V1["brand_img_nm"]?></td>
						<td><?php echo $TPL_V1["memo"]?></td>
						<td><?php echo $TPL_V1["save_time"]?></td>
						<td>
							<button type="button" class="btn btn-sm btn-warning" onclick="popup('brand_reg.php?no=<?php echo $TPL_V1["no"]?>&mode=mod','brand_reg','1100','900')">정보수정</button>
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
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>