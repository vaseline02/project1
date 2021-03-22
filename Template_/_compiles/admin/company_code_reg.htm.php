<?php /* Template_ 2.2.8 2020/07/29 09:00:37 /www/html/ukk_test/data/skin/admin/company_code_reg.htm 000006301 */ 
$TPL__mall_list_1=empty($GLOBALS["mall_list"])||!is_array($GLOBALS["mall_list"])?0:count($GLOBALS["mall_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<!-- Main Contents -->
<form method="post">
    <input type="hidden" name="mode" value="ins">
<div class="post">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="15%" />
                    <col width="35%" />
                    <col width="15%" />
					<col width="35%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">거래처명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="account_name" id="account_name" value="<?php echo $_POST['account_name']?>"/></div>
                        </td>
                        <th scope="row">제휴업체명</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo $_POST['company_name']?>"/></div>
						</td>
                    </tr>
					<tr>
						<th scope="row" class="align-left">업체코드</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12">
								<select name="company_code" id="company_code">
<?php if($TPL__mall_list_1){foreach($GLOBALS["mall_list"] as $TPL_V1){?>
								<option value=<?php echo $TPL_V1["mall_code"]?>><?php echo $TPL_V1["mall_code"]?>(<?php echo $TPL_V1["mall_name"]?>)</option>
<?php }}?>
								</select>
								<!-- <input type="text" class="form-control" name="company_code" id="company_code" value="<?php echo $_POST['company_code']?>"/> -->
							</div>
                        </td>
                        <th scope="row">제휴업체명2</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="company_name2" id="company_name2" value="<?php echo $_POST['company_name2']?>"/></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">remark</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="remark" id="remark" value="<?php echo $_POST['remark']?>"/></div>
                        </td>
                        <th scope="row">고객코드</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="member_code" id="member_code" value="<?php echo $_POST['member_code']?>"/></div>
						</td>
                    </tr>
                    <tr>
						<th scope="row" class="align-left">고객명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="member_name" id="member_name" value="<?php echo $_POST['member_name']?>"/></div>
                        </td>
                        <th scope="row">구분</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="status" id="status" value="<?php echo $_POST['status']?>"/></div>
						</td>
                    </tr>
                    <tr>
						<th scope="row" class="align-left">납품처코드</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="delivery_code" id="delivery_code" value="<?php echo $_POST['delivery_code']?>"/></div>
                        </td>
                        <th scope="row">납품처명</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="delivery_name" id="delivery_name" value="<?php echo $_POST['delivery_name']?>"/></div>
						</td>
                    </tr>
                    <tr>
						<th scope="row" class="align-left">고객코드2</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="member_code2" id="member_code2" value="<?php echo $_POST['total_search']?>"/></div>
                        </td>
                        <th scope="row">고객명2</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="member_name2" id="member_name2" value="<?php echo $_POST['member_name2']?>"/></div>
						</td>
                    </tr>
                    <tr>
						<th scope="row" class="align-left">구분2</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="status2" id="status2" value="<?php echo $_POST['status2']?>"/></div>
                        </td>
                        <th scope="row">납품처명</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="delivery_name2" id="delivery_name2" value="<?php echo $_POST['delivery_name2']?>"/></div>
						</td>
                    </tr>
                    <tr>
						<th scope="row" class="align-left">매출처</th>
						<td colspan=3 class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="sales" id="sales" value="<?php echo $_POST['sales']?>"/></div>
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">등록</button>
			<!-- <button class="btn btn-default" onclick="location.href ='cs_total_list.php'; return false;">초기화</button> -->
		</div>
	</div>			
</div>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>