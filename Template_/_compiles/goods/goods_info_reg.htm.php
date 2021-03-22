<?php /* Template_ 2.2.8 2020/09/28 10:24:06 /www/html/ukk_test2/data/skin/goods/goods_info_reg.htm 000006620 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?></h3></div>
</div>
<?php if($GLOBALS["sess"]['h_level']>= 200){?>
※goods_info db에 컬럼추가 필요(후에 삭제를 고려하여 기능으로 추가 해야함)
<form method="post" name="goodsInfoForm">
<input type="hidden" name="mode" value="ins">
<input type="hidden" name="no" value="">
	<div class="row">
		<div class="col-lg-12">
			
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b></b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><button type="button" class="btn btn-primary checkForm" data-chk='1'>등록/수정</button></span>
							</div>							
						</div>
					</caption>
					<colgroup>
						<col width="12%" />
                        <col width="22%" />
                        <col width="12%" />
						<col width="22%" />
						<col width="15%" />
						<col width="19%" />
					</colgroup>
					<tbody>
                        <tr>
							<th scope="row">컬럼명</th>
							<td class="receive-title no-gutters">
                                <input type='text' class="form-control" name='colum_name'>
                            </td>
                            <th scope="row">이름</th>
							<td class="receive-title no-gutters">
                                <input type='text' class="form-control" name='info_name'>
                            </td>
							<th scope="row">필터사용여부(y/n)</th>
							<td class="receive-title no-gutters">
                                <input type='text' class="form-control" name='use_filter'>
                            </td>
                        </tr>						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>
<?php }?>
<form method="post" name="goodsInfoForm2">
<input type="hidden" name="mode" value="cate_update">

<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format(count($TPL_VAR["loop"]))?></b>건<?php if($TPL_VAR["category"]){?> <span>[<?php echo $TPL_VAR["category"]['catenm']?>]</span> <?php }?></span>
						<div class="input-group common-table-search">
<?php if($_GET['cate']){?>
                                <span class="input-group-btn"><button type="button" class="btn btn-primary checkForm" data-chk='2'>등록/수정</button></span>
<?php }?>
						</div>
					</div>
				</caption>
                <colgroup>
<?php if($_GET['cate']){?>
                    <col width="3%" />
<?php }?>
					<col width="20%"/>
                    <col/>
<?php if($_GET['cate']){?>
                    <col width="3%" />
<?php }?>
                    <col width="20%" />
                    
					<col/>
					
				</colgroup>
				<thead>
					<tr>
<?php if($_GET['cate']){?>
                        <th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
<?php }?>
						<th>컬럼명</th>
                        <th>이름</th>
<?php if($_GET['cate']){?>
                        <th>순서</th>
<?php }?>
						<th>등록일</th>
<?php if($GLOBALS["sess"]['h_level']>= 200){?>
						<th>필터사용</th>
						<th></th>
<?php }?>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr>
<?php if($_GET['cate']){?>
                        <td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" <?php echo $TPL_VAR["checked"][$TPL_V1["no"]]?>></td>
<?php }?>
						<td><?php echo $TPL_V1["colum_name"]?></td>
                        <td>
							<?php echo $TPL_V1["info_name"]?>

						</td>
<?php if($_GET['cate']){?>
                        <td class="receive-title no-gutters">
                            <input type='text' class="form-control" name='sort[<?php echo $TPL_V1["no"]?>]' value='<?php echo $TPL_VAR["sort"][$TPL_V1["no"]]?>' style="width:50px;">
                        </td>
<?php }?>
                        <td><?php echo $TPL_V1["reg_date"]?></td>
<?php if($GLOBALS["sess"]['h_level']>= 200){?>
						<td><?php echo $TPL_V1["use_filter"]?></td>
						<td>                    
                            <div class="input-group fileload-list-small-button">
                                <span class="input-group-btn"><button class="btn btn-danger del" data-no=<?php echo $TPL_V1["no"]?> data-mode="del" type="button">삭제</button></span>
                            </div>
                        </td>
<?php }?>
					</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".checkForm").click(function(){
    var chk=$(this).data('chk');
    var colum_name=$("input[name='colum_name']").val();
    var info_name=$("input[name='info_name']").val();

    if(chk=='1'){
        if(!colum_name){
            alert('컬럼명을 입력해주세요.');
            return false;
        }else if(!info_name){
            alert('이름을 입력해주세요.');
            return false;
        }else{        
            
            if(confirm("등록하시겠습니까?")){
                $("form[name=goodsInfoForm]").submit();
            }
        }
    }else if(chk=='2'){
        if(!$(".chk_no").is(":checked")){
            alert("선택된 속성이 없습니다.");
            return false;
        }else{			
            if(confirm("등록하시겠습니까?")){
                $("form[name=goodsInfoForm2]").submit();
            }
        }        
    }
});

$(".del").click(function(){
    var no=$(this).data("no");
    var mode=$(this).data("mode");

    $("input[name=mode]").val(mode);
    $("input[name=no]").val(no);

    if(confirm("삭제하시겠습니까?")){
        $("form[name=goodsInfoForm]").submit();
    }
});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>