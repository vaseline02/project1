<?php /* Template_ 2.2.8 2020/05/13 14:09:38 /www/html/ukk_test/data/skin/admin/stock_move.htm 000009079 */ 
$TPL_mall_name_1=empty($TPL_VAR["mall_name"])||!is_array($TPL_VAR["mall_name"])?0:count($TPL_VAR["mall_name"]);
$TPL_code_title_1=empty($TPL_VAR["code_title"])||!is_array($TPL_VAR["code_title"])?0:count($TPL_VAR["code_title"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td><input type="file" name="excelFile[]" required/><button class="btn btn-primary">업로드</button></td>
    </tr>
</table>
</form>
<?php }?>


<?php if($GLOBALS["print_xls"]!= 1){?>
<style>
    .mallLabel{ display:inline-block; width:180px; line-height:30px;}
</style>
<form method="get" id="glb_search_form">
<input type="hidden"name="print_xls" value="">

<table class="table table-bordered " >
	<tbody>
		<tr>
			<th>브랜드</th>
			<td><input name="s_brand" type="text" value="<?php echo $_REQUEST['s_brand']?>"></td>
			<th>모델명 다중검색</th>
			<td><textarea name="s_paste" id="" cols="30" rows="3"><?php echo $_REQUEST['s_paste']?></textarea></td>
        </tr>
        <tr>
            <th>코드명</th>
            <td colspan='3'>
<?php if($TPL_mall_name_1){foreach($TPL_VAR["mall_name"] as $TPL_V1){?>
                <label class="mallLabel" style="font-weight: normal;"><input type="checkbox" name="codeNo[]" value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["checked"]['codeNo'][$TPL_V1["no"]]?>><?php echo $TPL_V1["cd"]?></label>
<?php }}?>
            </td>
        </tr>
	</tbody>
</table>

<center style="margin-bottom:20px;">
<button class="btn btn-primary">검 색</button> 
<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
</center>
</form>

<?php }?>

<?php if($GLOBALS["print_xls"]!= 1){?>

<form method="post" id="main_form">
    <input type="hidden" name="mode" id="mode" value="move">
    <input type="hidden" name="s_brand" value="<?php echo $_REQUEST['s_brand']?>">
    <input type="hidden" name="s_paste" value="<?php echo $_REQUEST['s_paste']?>">
    <input type="hidden" name="codeNo" value="<?php echo urlencode(serialize($TPL_VAR["codeNo"]))?>">
    <input type="hidden" name="returnUrl" value="<?php echo $_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="no" value="">
    <div style="width:100%; overflow-x:auto;  white-space: nowrap;">
    <table id="" class="table table-bordered" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
        
            <colgroup>
            <!-- <col width="50px"/>체크박스 -->
            <col width="150px"/><!-- 브랜드 -->
<?php if($GLOBALS["print_xls"]!= 1){?>
            <col width="90px"/><!-- 이미지 -->
<?php }?>
            <col width="150px"/><!-- 모델명 -->
            <col width="150px">
<?php if($TPL_code_title_1){foreach($TPL_VAR["code_title"] as $TPL_V1){?>
            <col width="90px"/><!-- 재고 -->
<?php }}?>
            
        </colgroup>
        
            <tr>
                <!-- <th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th> -->
                <th>브랜드</th>
<?php if($GLOBALS["print_xls"]!= 1){?>
                <th>이미지</th>
<?php }?>
                <th>모델명</th>
                
                <th>재고이동</th>
                
<?php if($TPL_code_title_1){foreach($TPL_VAR["code_title"] as $TPL_V1){?>
                <th><?php echo $TPL_V1["cd"]?></th>
<?php }}?>
                
            </tr>
        
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
            
            <tr>
                <input type="hidden" name="goodsnm[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["goodsnm"]?>">
                <!-- <td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td> -->
                <td><?php echo $TPL_V1["brandnm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
                <td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
<?php }?>
                <td><?php echo $TPL_V1["goodsnm"]?></td>
                
                <td>
                    <div>
                    <select name="s_cnt[<?php echo $TPL_V1["no"]?>]">
                        <option value="">== 차감 ==</option>
<?php if(is_array($TPL_R2=$TPL_VAR["code_value"][$TPL_V1["no"]])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <option value=<?php echo $TPL_V2["no"]?>><?php echo $TPL_V2["cd"]?></option>
<?php }}?>
                    </select>
                    </div>
                    <div></div>
                    <div>
                        <select name="e_cnt[<?php echo $TPL_V1["no"]?>]">
                            <option value="">== 증가 ==</option>
<?php if(is_array($TPL_R2=$TPL_VAR["code_value"][$TPL_V1["no"]])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                            <option value=<?php echo $TPL_V2["no"]?>><?php echo $TPL_V2["cd"]?></option>
<?php }}?>
                        </select>
                    </div>
                    <div style="padding-top: 5px;">
                        <input type="text" name="moveCnt[<?php echo $TPL_V1["no"]?>]" style="width:70px;" placeholder="수량">
                        <div class="btn btn-primary checkForm" data-no=<?php echo $TPL_V1["no"]?>>이동</div> 
                    </div>
                </td>
                
<?php if(is_array($TPL_R2=$TPL_VAR["code_value"][$TPL_V1["no"]])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <td><?php echo $TPL_V2["cnt"]?></td>
<?php }}?>
                
            </tr>
<?php }}?>
       
    </table>
    </div>
   
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
</form>

<?php }else{?>

<div style="color: red; font-weight: bold;">*빨간 표시된 타이틀은 변경하시면 안됩니다.</div>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<colgroup>
        <col width="50px"/><!-- 브랜드 -->
        <col width="100px"/><!-- 브랜드 -->
        <col width="150px"/><!-- 모델명 -->
        <col width="50px">
        <col width="50px">
        <col width="50px">
<?php if($TPL_code_title_1){foreach($TPL_VAR["code_title"] as $TPL_V1){?>
        <col width="90px"/><!-- 재고 -->
<?php }}?>
        
	</colgroup>
	<thead>
		<tr>
            <th><div style="color: red;">상품고유코드</div></th>
            <th><div style="color: red;">브랜드</div></th>
            <th><div style="color: red;">모델명</div></th>
            <th><div>재고이동(차감)</div></th>
            <th><div>재고이동(증가)</div></th>
            <th><div>재고이동(수량)</div></th>
<?php if($TPL_code_title_1){foreach($TPL_VAR["code_title"] as $TPL_V1){?>
            <th><div style="color: red;"><?php echo $TPL_V1["cd"]?></div></th>
<?php }}?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
        
		<tr>
            <td><?php echo $TPL_V1["no"]?></td>            
            <td><?php echo $TPL_V1["brandnm"]?></td>            
            <td><?php echo $TPL_V1["goodsnm"]?></td>
            <td></td>
            <td></td>
            <td></td>           
<?php if(is_array($TPL_R2=$TPL_VAR["code_value"][$TPL_V1["no"]])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
            <td><?php echo $TPL_V2["cnt"]?></td>
<?php }}?>
            
		</tr>
<?php }}?>
	</tbody>
</table>
<?php }?>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
    $(".checkForm").click(function(){
        var scnt=$("select[name='s_cnt["+$(this).data('no')+"]']").val();
        var ecnt=$("select[name='e_cnt["+$(this).data('no')+"]']").val();
        var movecnt=$("input[name='moveCnt["+$(this).data('no')+"]']").val();
        
        if(!scnt){
            alert('차감위치를 선택해주세요.');
            return false;
        }else if(!ecnt){
            alert('증가위치를 선택해주세요.');
            return false;
        }else if(!movecnt){
            alert('수량을 등록해주세요.');
            return false;
        }else{
            $("input[name=no]").val($(this).data('no'));
            $("form[id='main_form']").submit();
        }
    });
	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#glb_search_form").submit();
		$("input[name='print_xls']").val("0");
	});

})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>