<?php /* Template_ 2.2.8 2020/10/23 11:50:05 /www/html/ukk_test2/data/skin/cs/test_file_upload.htm 000000554 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<form method="POST" enctype="multipart/form-data">
<div class="row">
	<div class="bottom_btn_box" style="padding-bottom:20px;">
		<div class="box_left" style="padding-left:15px;">
			<input type="file" name="excelFile[]" id="excelFile" required/><button class="btn btn-sm btn-primary">업로드</button>
		</div>		
	</div>	
</div>
</form>
<?php $this->print_("footer",$TPL_SCP,1);?>