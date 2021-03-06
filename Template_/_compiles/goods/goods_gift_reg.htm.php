<?php /* Template_ 2.2.8 2020/08/06 18:34:20 /www/html/ukk_test2/data/skin/goods/goods_gift_reg.htm 000006537 */ 
$TPL_brandlist_1=empty($TPL_VAR["brandlist"])||!is_array($TPL_VAR["brandlist"])?0:count($TPL_VAR["brandlist"]);?>
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
							<th scope="row"><b class="red">*</b>사은품 선택</th>
							<td class="receive-title no-gutters">
                                <div class="input-group fileload-list-small-button">
                                    <span class="input-group-btn"><button class="btn btn-primary" onclick='popup("goods_search_pop.php","goods_search","1000","900")' type="button">선택</button></span>
                                </div>
                            </td>
                            <th scope="row">사은품</th>
							<td class="receive-title no-gutters" colspan=3>
                                <span class="gift_goodsnm" style="vertical-align: middle;"></span>
                                <input type="hidden" name="gift_goodsno">
							</td>
                        </tr>
						<tr>
							<th scope="row"><b class="red">*</b> 브랜드선택</th>
							<td class="receive-title no-gutters" colspan=3>
								<div class="form-check form-check-inline">
									<select name="brandno" id="brandno">
											<option value="">== 브랜드 선택 ==</option>
<?php if($TPL_brandlist_1){foreach($TPL_VAR["brandlist"] as $TPL_V1){?>
											<option value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["selected"]['brandno'][$TPL_V1["no"]]?>><?php echo $TPL_V1["brandnm"]?></option>
<?php }}?>
									</select>
								</div>
							</td>
                        </tr>
                        <tr>
							<th scope="row">카테고리</th>
							<td class="receive-title no-gutters" colspan=3>
								<div class="form-check form-check-inline">
                                    <?php echo $this->define('tpl_include_file_1',"goods/category_form.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

								</div>
							</td>
                        </tr>
                        <tr>
							<th scope="row">상품</th>
							<td class="receive-title no-gutters">
                                <textarea name="goodsnm" style="width: 250px; height:150px" class="goods_chk"></textarea>
                            </td>
                            <th scope="row">상품비매칭</th>
                            <td>
                                <div style="float: left; overflow-x:hidden; width: 100%; height:150px; color:red;" class="not_goods">
                                </div>       
                            </td>
						</tr>
						
                        <!-- <tr>
							<th scope="row">포함제외</th>
							<td class="receive-title no-gutters" colspan=3>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='status' id="status_0" value='0' <?php echo $GLOBALS["checked"]['status']['0']?>>
									<label class="form-check-label" for="status_0">포함</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='status' id="status_1" value='1' <?php echo $GLOBALS["checked"]['status']['1']?>>
									<label class="form-check-label" for="status_1">제외</label>
								</div>
							</td>
						</tr> -->
						<!-- <tr>
							<th scope="row">사용유무</th>
							<td class="receive-title no-gutters" colspan=3>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='view_yn' id="view_yn_y" value='Y' <?php echo $GLOBALS["checked"]['view_yn']['Y']?>>
									<label class="form-check-label" for="view_yn_y">사용</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='view_yn' id="view_yn_n" value='N' <?php echo $GLOBALS["checked"]['view_yn']['N']?>>
									<label class="form-check-label" for="view_yn_n">사용안함</label>
								</div>
							</td>
						</tr> -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

	function checkForm(){
        var gift_goodsno=$("input[name='gift_goodsno']").val();
        var brandno=$("select[name='brandno']").val();
        
		if(!gift_goodsno){
            alert('사은품을 선택해주세요.');
            return false;
		}else if(!brandno){
            alert('브랜드를 선택해주세요.');
            return false;
        }else{        
            
            if(!confirm("사은품을 등록하시겠습니까?")){
                return false;
            }
        }
	}

    $(".goods_chk").keyup(function (){
        var val=$(this).val();
        $(".not_goods").html("");
        $.ajax({
            url: "./gift_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "mode=goods&val="+val,
            success: function(data){           
                $(".not_goods").html("");                 
                $.each(data,function(index, item){
                    $(".not_goods").append(item);
                    $(".not_goods").append("<br>");
                });
            }
        });
    });
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>