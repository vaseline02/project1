<?php /* Template_ 2.2.8 2020/09/03 14:43:21 /www/html/ukk_test2/data/skin/goods/category_reg.htm 000002577 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="ins">
	<div class="row">
		<div class="col-lg-12">
			
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b></b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><button class="btn btn-primary">등록/수정</button></span>
							</div>
							
						</div>
					</caption>
					<colgroup>
						<col width="15%" />
                        <col width="35%" />
                        <col width="15%" />
						<col width="35%" />
					</colgroup>
					<tbody>
                        <tr>
							<th scope="row">카테고리</th>
							<td class="receive-title no-gutters" colspan=3>
								<div class="form-check form-check-inline">
                                    <?php echo $this->define('tpl_include_file_1',"goods/category_form.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

								</div>
							</td>
                        </tr>
                        <tr>
							<th scope="row">카테고리명</th>
							<td class="receive-title no-gutters">
                                <input type='text' class="form-control" name='catenm'>
                            </td>
						</tr>						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

	function checkForm(){
        var catenm=$("input[name='catenm']").val();
        var category_4=$("select[name='category_4']").val();
        
        
		if(!catenm){
            alert('카테고리명을 입력해주세요.');
            return false;
		}else if(category_4){
            alert('4차카테고리까지만 등록가능합니다.');
            return false;
        }else{                    
            if(!confirm("카테고리를 등록하시겠습니까?")){
                return false;
            }
        }
	}

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>