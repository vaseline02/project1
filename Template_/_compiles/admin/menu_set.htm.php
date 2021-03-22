<?php /* Template_ 2.2.8 2020/08/04 14:28:12 /www/html/ukk_test2/data/skin/admin/menu_set.htm 000002488 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색"> -->
							<span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="popup('menu_reg.php','member_reg','1100','900')">메뉴등록</button></span>
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="15%" />
					<col width="15%" />
					<col/>
					<col width="5%" />
					<col width="5%" />
					<col width="10%" />
					<col width="3%" />
					
				</colgroup>
				<thead>
					<tr>
						<th>1차카테고리</th>
						<th>2차카테고리</th>
						<th>링크</th>
						<th>1차사용유무</th>
						<th>2차사용유무</th>
						<th>등록일</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr>
						<td><?php echo $TPL_V1["menunm"]?></td>
						<td><?php echo $TPL_V1["menu_snm"]?></td>
						<td><?php echo $TPL_V1["link"]?></td>
						<td><?php echo $TPL_V1["state"]?></td>
						<td><?php echo $TPL_V1["subState"]?></td>
						<td><?php echo $TPL_V1["subRegdate"]?></td>
			
						<td>
<?php if($TPL_V1["subSn"]){?>
						<button type="button" class="btn btn-sm btn-warning" onclick="popup('menu_reg.php?sn=<?php echo $TPL_V1["subSn"]?>&mode=mod','menu_reg','1100','900')">정보수정</button>
<?php }?>
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