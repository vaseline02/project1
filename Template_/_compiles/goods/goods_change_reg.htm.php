<?php /* Template_ 2.2.8 2021/03/15 14:52:48 /www/html/ukk_test2/data/skin/goods/goods_change_reg.htm 000005075 */ 
$TPL_spec_1=empty($TPL_VAR["spec"])||!is_array($TPL_VAR["spec"])?0:count($TPL_VAR["spec"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<form method="post" name="goodsChangeForm">
<input type="hidden" name="mode" value="mod">
<input type="hidden" name="no" value="<?php echo $TPL_VAR["no"]?>">
<input type="hidden" name="member_level" value="<?php echo $GLOBALS["member_level"]?>">

<h1 class="page_title"></h1>
<table class="table table-bordered" >
    <tbody>
        <tr>
            <th style="width:200px;">모델명</th>
            <td class="search_td_width" style="height:45px"><?php echo $TPL_VAR["goodsnm"]?>(<?php echo $TPL_VAR["goodsnm_sub"]?>)</td>                       
        </tr>        
<?php if($GLOBALS["member_level"]=='1'){?>
        <tr>
            <th style="width:200px;">변경모델명(모델명1)</th>
            <td><input type="text" name="goodsnm" style="width: 300px;"></td>
        </tr>
<?php }?>
		<tr>
            <th style="width:200px;">변경모델명(모델명2)</th>
            <td><input type="text" name="goodsnm_sub" style="width: 300px;"></td>
        </tr>
    </tbody>
</table>
<center style="margin-bottom:20px; padding-top: 10px;">
     <div type="button" class="btn btn-sm btn-primary checkForm" data-mode='mod'>변경</div>
</center>
</form>

<form method="post" id="linkForm" name="linkForm">
<input type="hidden" name="mode" value="link">
<input type="hidden" name="no" value="<?php echo $TPL_VAR["no"]?>">
<h1 class="page_title"></h1>

<table class="table table-bordered" >
    <tbody>
        <tr>
            <th style="width:200px;">유튜브 경로</th>
            <td><input type="text" name="link" style="width:800px;" value="<?php echo $TPL_VAR["youtube_link"]?>"></td>	
        </tr>		
    </tbody>
</table>
<center style="margin-bottom:20px; padding-top: 10px;">
     <div type="button" class="btn btn-sm btn-primary checkForm" data-mode='link'>변경</div>
</center>

</form>

<?php if($GLOBALS["cate_code"]!='000'){?>
<form method="post" id="specForm" name="specForm">
<input type="hidden" name="mode" value="spec">
<input type="hidden" name="no" value="<?php echo $TPL_VAR["no"]?>">
<h1 class="page_title"></h1>

<table class="table table-bordered" >
    <tbody>
        <tr>
<?php if($TPL_spec_1){foreach($TPL_VAR["spec"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=($TPL_VAR["gi"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
				<tr>
					<th style="width:200px;"><?php echo $TPL_V2?></th>
<?php if($TPL_K2=='warranty'||$TPL_K2=='import'||$TPL_K2=='bezel'){?>
					<td>
						<input type="checkbox" name="<?php echo $TPL_K2?>" id="<?php echo $TPL_K2?>_Y" value="Y" <?php if($TPL_V1["spec_data"][$TPL_K2]=='Y'){?> checked <?php }?>
						onclick="checkOnlyOne(this, '<?php echo $TPL_K2?>')"><label for="<?php echo $TPL_K2?>_Y">Y</label>
						<input type="checkbox" name="<?php echo $TPL_K2?>" id="<?php echo $TPL_K2?>_N" value="N" <?php if($TPL_V1["spec_data"][$TPL_K2]=='N'){?> checked <?php }?> 
						onclick="checkOnlyOne(this, '<?php echo $TPL_K2?>')"><label for="<?php echo $TPL_K2?>_N">N</label>
					</td>	
<?php }else{?>
					<td><input type="text" name="<?php echo $TPL_K2?>" style="width:800px;" value="<?php echo $TPL_V1["spec_data"][$TPL_K2]?>"></td>			
<?php }?>
				</tr>
<?php }}?>
<?php }}?>
        </tr>		
    </tbody>
</table>
<center style="margin-bottom:20px; padding-top: 10px;">
     <div type="button" class="btn btn-sm btn-primary checkForm" data-mode='spec'>변경</div>
</center>

</form>
<?php }?>
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".checkForm").click(function (){
    var mode=$(this).data('mode');
    $("input[name='mode']").val(mode);
	var level=$("input[name='member_level']").val();

    if(mode=='mod'){        
        if(!$("input[name='goodsnm']").val() && !$("input[name='goodsnm_sub']").val()){
            alert('변경할 모델명을 입력해주세요.');
            return false;
        }else{
			if(confirm('변경하시겠습니까?')){
		       $("form[name='goodsChangeForm']").submit();
			}
        }
    }else if(mode=='link'){
		/*if(!$("input[name='link']").val()){
			alert('변경할 유튜브 경로를 입력해주세요.');
			$("input[name='link']").focus();
			return false;
		}else{*/
			if(confirm('변경하시겠습니까?')){
				$("form[name='linkForm']").submit();
			}
		//}	
	}else if(mode=='spec'){
		if(confirm('변경하시겠습니까?')){
			$("form[name='specForm']").submit();
		}
	}
});

function checkOnlyOne(e, choose)  {
	 var obj = document.getElementsByName(choose);
	
    for(var i=0; i<obj.length; i++){
        if(obj[i] != e){
            obj[i].checked = false;
        }
    }
}

</script>

<?php $this->print_("footer",$TPL_SCP,1);?>