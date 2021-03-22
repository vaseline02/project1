<?php /* Template_ 2.2.8 2021/03/11 11:54:05 /www/html/ukk_test2/data/skin/outline/search_box.htm 000012204 */ ?>
<?php if($GLOBALS["print_xls"]!= 1){?>

<?
$GOODS=new goods();
$data=$GOODS->goods_detail_select();

$sres= $GLOBALS["s_res"];
?>

<form method="post" id="glb_search_form">
<input type="hidden"name="print_xls" value="">
<input type="hidden"name="s_search_mode" value="1">
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
	
		
		<div class="option-searchbox-hide searchbox-default">

		<table class="table fileload-list-small">
			<colgroup>
				<col width="8%" />
				<col width="10%" />
				<col width="8%" />
				<col width="10%" />
				<col width="8%" />
				<col width="10%" />
				<col width="8%" />
				<col width="20%" />
			</colgroup>
			<tbody>

				<tr>
					<th scope="row" class="align-left">브랜드</th>
					<td class="receive-title no-gutters">
						<div class="col-xs-12"><input type="text" class="form-control" name="s_brand" value="<?php echo $_POST['s_brand']?>"/></div>
					</td>
					<th scope="row" class="align-left">가용수량</th>
					<td class="receive-title no-gutters">
						<div class="col-xs-12">
						<input type="text" class="" style="width:70px;" name="s_psb_stock" value="<?php echo $_POST['s_psb_stock']?>"/> ~ 
						<input type="text" class="" style="width:70px;" name="e_psb_stock" value="<?php echo $_POST['e_psb_stock']?>"/>
						</div>
					</td>
					<th scope="row" rowspan='3'>모델명 다중검색</th>
					<td class="receive-title no-gutters" rowspan='3'>
						<div class="col-xs-12">
							<textarea class="form-control" name="s_paste" id="s_paste" cols="10" rows="5"><?php echo $_POST['s_paste']?></textarea>
						</div>
					</td>
					<th scope="row" rowspan='3'>브랜드 다중검색</th>
					<td class="receive-title no-gutters" rowspan='3'>
						<div class="col-xs-12">
							<table class="table fileload-list-small">
								<tr>
									<td style="vertical-align: top;"><textarea class="form-control" name="s_b_paste" id="" style="width:100%" rows="5"><?php echo $_POST['s_b_paste']?></textarea></td>
									<td style="vertical-align: top;">
										<input type="text" class="form-control brand_check" style="width:120px;" placeholder="브랜드찾기" >
										<div class="brand_notice" style="color: red; text-align:left;"></div>
									</td>
								</tr>
							</table>											
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">모델명</th>
					<td class="receive-title no-gutters">
						<div class="col-xs-12"><input type="text" class="form-control" name="s_model" value="<?php echo $_POST['s_model']?>"/></div>
					</td>
					<th scope="row">촬영</th>
					<td class="receive-title no-gutters">
						<div class="col-xs-12">
							<input type="radio" id="img_chk" name="s_img" value="" <?php echo $GLOBALS["s_res"]['checked']['s_img']['']?>>
							<label for="img_chk">전체</label>&nbsp;&nbsp;
							<input type="radio" id="img_chk_1" name="s_img" value="1" <?php echo $GLOBALS["s_res"]['checked']['s_img']['1']?>>
							<label for="img_chk_1">촬영</label>&nbsp;&nbsp;
							<input type="radio" id="img_chk_2" name="s_img" value="2" <?php echo $GLOBALS["s_res"]['checked']['s_img']['2']?>>
							<label for="img_chk_2">미촬영</label>
						</div>
					</td>
				</tr>
				<tr>
					
					<th scope="row">기타</th>
					<td class="receive-title no-gutters" colspan='3'>
					<div class="option-searchbox-hide inline_block s_no_limit_div" >
						<input type="checkbox" name="s_no_limit" id="s_no_limit" value="1"><label for="s_no_limit">페이징해제</label> |
						<input type="checkbox" name="s_view_hidden" id="s_view_hidden" value="1" <?php echo $GLOBALS["s_res"]['checked']['s_view_hidden']['1']?>><label for="s_view_hidden">숨김모델표시</label>
					</div>
					
					<div class="option-searchbox-hide inline_block s_no_cate" >
						<input type="checkbox" name="s_no_cate" id="s_no_cate" value="1" <?php echo $GLOBALS["s_res"]['checked']['s_no_cate']['1']?>><label for="s_no_cate">카테고리 미등록</label> 
					</div>
					<!--
					<div>
						현재고 
						<select name="s_stock_giho" style="width:40px;">
							<option >=</option>
							<option >></option>
							<option ><</option>
						</select> 
						<input type="text" name="s_stock_cnt" size=4>
					</div>
					-->
					<!--
						<div class="col-xs-12">
							<dl class="multitext-search">
								<dd><textarea class="form-control" name="s_paste" id="" cols="30" rows="3"></textarea></dd>
							</dl>
						</div>
					-->
					</td>
				</tr>
				<?/*?>
				<tr>
					<th scope="row">주문일자</th>
					<td colspan="3" class="receive-title no-gutters">
						
						<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
							<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
							<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>3일</button>
							<button type="button" class="btn btn-default dayChange" data-int='15' data-type='day'>7일</button>
							<button type="button" class="btn btn-default dayChange" data-int='1' data-type='month'>1개월</button>
							<button type="button" class="btn btn-default dayChange" data-int='3' data-type='month'>3개월</button>
							<button type="button" class="btn btn-default dayChange" data-int='1' data-type='year'>1년</button>
							<!-- <button type="button" class="btn btn-primary">전체</button> -->
						</div>
						<div class="col-md-2 date-wrap">
							<div class="input-group">
								<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $GLOBALS["s_date_value"]?>"  />
								<span class="input-group-btn">
									<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
								</span>
							</div>
						</div>
						
						<p class="date-tilde">~</p>
						<div class="col-md-2 date-wrap">
							<div class="input-group">
								<input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $GLOBALS["e_date_value"]?>"  />
								<span class="input-group-btn">
									<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
								</span>
							</div>										
						</div>
						<script>
							
						</script>
					</td>
				</tr>
				<?*/?>
			</tbody>
		</table>
		</div>

		<div class="option-searchbox-hide searchbox-goods-detail">
		<table class="table">
			<colgroup>
				<col width="10%" />
			</colgroup>
			<tbody>
				<tr>
					<th>카테고리</th>
					<td><?php echo $this->define('tpl_include_file_1',"goods/category_form.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?></td>
				</tr>
				<tr>
					<th>조건검색</th>
					<td colspan="3">
						<?	foreach($data['view'] as $k=>$v){ ?>
						<div class="detail_div">

							<span><?=$v?></span>
							<select name="select_detail[<?=$k?>]" id="">
								<option value="">선택</option>
								<?	foreach($data['data'][$k] as $k2=>$v2){ ?>
								<option value="<?=$v2?>" <?=$sres['selected']['detail'][$k][$v2]?> ><?=$v2?>  </option>
								<?}	?>		
							</select>
						</div>
						<?}	?>
						
					</td>
				</tr>
			</tbody>
		</table>
		</div>

		<div class="option-searchbox-hide searchbox-img-step">
		<table class="table table-bordered" >

				<tr>
					<th>촬영단계</th>
					<td>

						<input type="checkbox" id="chk_1" name="s_img_step[]" value="1" <?php echo $GLOBALS["s_res"]['checked']['s_img_step']['1']?>>
						<label class="label label-default" for="chk_1"> 1 </label>
						&nbsp;&nbsp;
						
						<input type="checkbox" id="chk_2" name="s_img_step[]" value="2" <?php echo $GLOBALS["s_res"]['checked']['s_img_step']['2']?>>
						<label class=" label label-info" for="chk_2"> 2 </label>
						&nbsp;&nbsp;
						
						<input type="checkbox" id="chk_3" name="s_img_step[]" value="3" <?php echo $GLOBALS["s_res"]['checked']['s_img_step']['3']?>>
						<label class=" label label-success" for="chk_3"> 3 </label>
						&nbsp;&nbsp;
						
						<input type="checkbox" id="chk_4" name="s_img_step[]" value="4" <?php echo $GLOBALS["s_res"]['checked']['s_img_step']['4']?>>
						<label class=" label label-warning" for="chk_4"> 4 </label>
						&nbsp;&nbsp;
						
						<input type="checkbox" id="chk_5" name="s_img_step[]" value="5" <?php echo $GLOBALS["s_res"]['checked']['s_img_step']['5']?>>
						<label class=" label label-important" for="chk_5"> 5 </label>
						&nbsp;&nbsp;

					</td>
				</tr>
		</table>
		</div>

		<div class="option-searchbox-hide searchbox-modelNcnt">
		<table class="table table-bordered " >
			<tbody>
				<tr>
					<th>모델명,수량 <br>다중검색</th>
					<td>
						<textarea name="s_paste_mc" id="" cols="30" rows="3"><?php echo $_POST['s_paste_mc']?></textarea>(모델명^수량 형식으로 '^'로 연결하여 입력)
					</td>
					<th>옵션</th>
					<td>
					<input type="checkbox" name="chk_invoice" value="1" id="chk_invoice" <?php echo $GLOBALS["s_res"]['checked']['chk_invoice']['1']?>>
					<label class=" label label-success" for="chk_invoice" >인보이스 포함</label>
					</td>
				</tr>
			</tbody>
		</table>
		</div>



	
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검 색</button> 
			<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
			[<input type="checkbox"  value="1" name='search_noimg' id='search_noimg' <?php echo $GLOBALS["s_res"]['checked']['search_noimg']['1']?>>
			<label class=" label label-success" for="search_noimg">이미지 <?php if($GLOBALS["my_page"]=='goods_list.php'||$GLOBALS["my_page"]=='event_price.php'){?>포함<?php }else{?>제외<?php }?></label>]
		</div>	
	</div>
</div>
</form>
<script>
$(function(){

	$("#print_xls").click(function(){
		
		var old_val='';

		if($(".chk_no:checked").length!='0'){
			
			old_val=$("#s_paste").val();
			$("#s_paste").val("");
			var chk_model='';
			$(".chk_no:checked").each(function(){
				chk_model+=$(this).closest("tr").find(".goods_detail_pop").html()+"\n";//상품명 찾기
			});

			$("#s_paste").val( chk_model);
			
		}
		$("input[name='print_xls']").val("1");
		$("#glb_search_form").submit();
		$("input[name='print_xls']").val("0");
		if($(".chk_no:checked").length!='0'){
			$("#s_paste").val(old_val);
		}
	});

	
	$(".brand_check").keyup(function (){
		var brandName=$(this).val();
		var noticeValue="";

		//$('.brand_notice_'+no).remove();
		$.ajax({
			url: "../order/chk_brand.php",
			type: "POST",
			cache: false,
			dataType: "json",
			data: "mode=allbrand&brand_name="+brandName,
			success: function(data){
				$('.brand_notice').empty();
				$(data).each(function(index, item){
					noticeValue+="<div><a href=\"javascript:brandNmin('"+item+"')\" style='color: red;'>"+item+"</a></div>";

				});
				$('.brand_notice').append(noticeValue);
	//				$(".brand_notice_"+no).text(noticeValue);

				/*
				if(data=='N'){
					$(".brand_notice_"+no).text('브랜드가 존재하지않습니다.');
				}else{
					$(".brand_notice_"+no).text('');
				}
				*/
			},
			error: function (request, status, error){        
				console.log(error);
			}
		});
	});

})
function brandNmin(brandnm){
	var s_b_paste=$("textarea[name='s_b_paste']").val();
	if(s_b_paste){
		$("textarea[name='s_b_paste']").val(s_b_paste+"\n"+brandnm);
	}else{
		$("textarea[name='s_b_paste']").val(brandnm);
	}

}

</script>
<?php }?>