<?php /* Template_ 2.2.8 2020/11/02 16:48:36 /www/html/ukk_test2/data/skin/goods/goods_cate.htm 000006471 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>
<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="get" id="glb_search_form">
<input type="hidden"name="print_xls" value="">
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">		
            <div class="option-searchbox-hide searchbox-default">
                <table class="table fileload-list-small">
                    <colgroup>
                        <col width="12%" />
                        <col width="35%" />
                        <col width="12%" />
                        <col width="35%" />
                    </colgroup>
                    <tbody>
						<tr>
							<th scope="row">카테고리</th>
							<td class="receive-title no-gutters"><?php echo $this->define('tpl_include_file_1',"goods/category_search_form.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?></td>

							<th scope="row" class="align-left">브랜드</th>
                            <td class="receive-title no-gutters">
                                <div class="col-xs-12"><input type="text" class="form-control" name="s_brand" value="<?php echo $_GET['s_brand']?>"/></div>
                            </td>							
						</tr>
                        <tr>
                            
                            <th scope="row">모델명</th>
                            <td class="receive-title no-gutters">
                                <div class="col-xs-12"><input type="text" class="form-control" name="s_model" value="<?php echo $_GET['s_model']?>"/></div>
                            </td>

							<th scope="row">모델명 다중검색</th>
                            <td class="receive-title no-gutters">
                                <div class="col-xs-12">
                                    <dl class="multitext-search">
                                        <dd><textarea class="form-control" name="s_paste" id="" cols="30" rows="3"><?php echo $_GET['s_paste']?></textarea></dd>
                                    </dl>
                                </div>
                            </td>
                        </tr>                             
                    </tbody>
                </table>
            </div>
		</div>
        <div class="text-center table-btn-group">
            <button class="btn btn-primary">검 색</button> 
        </div>	        
	</div>
</div>
</form>
<?php }?>
<form method="post" id="cate_form">
<input type="hidden" name="mode" id="mode" value="ins">
<input type="hidden" name="no" id="no" value="">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
	<colgroup>
		<col/><!-- 선택 -->
		<col width="150px"/><!-- 브랜드 -->		
		<col width="150px"/><!-- 이미지-->
		<col/><!-- 모델명1-->
		<col/><!-- 모델명2-->
		<col width="60px"/><!--수량-->
        <col/><!-- 분류 -->
	</colgroup>
<?php }?>
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<th>브랜드</th>
			<th>이미지</th>
			<th>모델명1</th>
			<th>모델명2</th>
			<th>수량</th>
			<th>분류</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td><?php }?>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td class="td_img" ><?php echo $TPL_V1["img_url"]?></td>
			<td class="text_type"><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="text_type"><?php echo $TPL_V1["goodsnm_sub"]?></td>
			<td><?php echo number_format($TPL_V1["cur_cnt"])?></td>
            <td>
<?php if(is_array($TPL_R2=$TPL_V1["cate"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["cate_1"]){?><?php echo $TPL_V2["cate_1"]?><?php }?>
<?php if($TPL_V2["cate_2"]){?> >> <?php echo $TPL_V2["cate_2"]?><?php }?>
<?php if($TPL_V2["cate_3"]){?> >> <?php echo $TPL_V2["cate_3"]?><?php }?>
<?php if($TPL_V2["cate_4"]){?> >> <?php echo $TPL_V2["cate_4"]?><?php }?>                   
                    <button class="btn btn-danger btn_sumbit" data-no="<?php echo $TPL_V2["no"]?>" data-mode="del" type="button">삭제</button>
                    <br>
<?php }}?>


            </td>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<div class="bottom_btn_box">
	<div class="box_left">
		
	</div>
	<div  class="box_right">
		<div><?php echo $this->define('tpl_include_file_2',"goods/category_form.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?><button class="btn btn-primary btn_sumbit" data-mode="ins"  type="button">등록</button></div>
	</div>
</div>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");
	$(".btn_sumbit").click(function(){
		
		var mode=$(this).data("mode");

        if(mode=='ins'){
            if( $(".chk_no:checked").length <=0 ){
                alert('처리할 주문을 선택해주세요.');
                return;
            }

            if(!$("#category_1").val()){
                alert('카테고리를 선택해주세요.');
                return;
            }
            
            
            if(confirm('등록하시겠습니까?')){
                
                $("#mode").val(mode);
                $("#cate_form").submit();
            }
        }else if(mode=='del'){
            var no=$(this).data("no");
            if(confirm('삭제하시겠습니까?')){
                $("#no").val(no);
                $("#mode").val(mode);
                $("#cate_form").submit();
            }
        }
	});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>