<?php /* Template_ 2.2.8 2020/05/18 08:47:14 /www/html/ukk_test2/data/skin/goods/goods_barcode_reg.htm 000002373 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<form method="post" name="barcodeForm">
<input type="hidden" name="mode" value="ins">
<input type="hidden" name="dno" value="">
<input type="hidden" name="goodsnm" value="<?php echo $TPL_VAR["goodsnm"]?>">

<h1 class="page_title"></h1>
<table class="table table-bordered" >
    <tbody>
        <tr>
            <th>상품명</th>
            <td class="search_td_width"><?php echo $TPL_VAR["goodsnm"]?></td>                       
        </tr>        
        <tr>
            <th>바코드등록</th>
            <td><input type="text" name="barcode" style="width: 300px;"> <div type="button" class="btn btn-sm btn-primary checkForm" data-mode='ins'>등록</div></td>
        </tr>
    </tbody>
</table>

<hr>

<h1 class="page_title">바코드정보</h1>

<table id="" style="width:100%" class="listTable">
	<thead>
		<tr>			
           <th>바코드</th>			
           <th width='100px'></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>        
		<tr>			
       		<td><?php echo $TPL_V1["barcode"]?></td>			
       		<td style="text-align: center;"><div type="button" class="btn btn-sm btn-danger checkForm" data-mode="del" data-no="<?php echo $TPL_V1["no"]?>">삭제</div></td>			
		</tr>
<?php }}?>
	</tbody>
</table>

</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".checkForm").click(function (){
    var mode=$(this).data('mode');
    $("input[name='mode']").val(mode);
    if(mode=='ins'){        
        if(!$("input[name='barcode']").val()){
            alert('바코드를 입력해주세요.');
            return false;
        }else{
            $("form[name='barcodeForm']").submit();
        }
    }else if(mode=='del'){
        if(confirm('삭제하시겠습니까?')){
            var no=$(this).data('no');
            $("input[name='dno']").val(no)
            $("form[name='barcodeForm']").submit();
        }
    }
});
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>