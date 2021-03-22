<?php /* Template_ 2.2.8 2020/05/11 10:04:01 /www/html/ukk_test/data/skin/cs/send_check.htm 000004678 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_notData_1=empty($TPL_VAR["notData"])||!is_array($TPL_VAR["notData"])?0:count($TPL_VAR["notData"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div1_1 a:after{width:90%}
</style>

<form id="sendForm" method="POST">
<input type="hidden" name="mode" value="">

<table id="" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
    <tr>
        <td style="width:25%; vertical-align: top;">
            <table class="table table-bordered" >
                <tr>
                    <th>바코드</th>
                    <td style="height:621px"><textarea name="s_barcode" id="" style="height:100%; width:100%"><?php echo $_POST['s_barcode']?></textarea></td>	
                    
                </tr>
            </table>

        </td>
        <td style="width:10%; text-align: center;">
            <div>=></div>
            <div type="button" class="btn btn-primary returnMerge" style="margin-top: 10px;">회수비교</div>
        </td>
        <td style="width:50%; vertical-align: top;">
            <div style="overflow: auto; height:621px;">
                <table id="" class="table table-bordered">
                    <tr>			
                        <th>모델명</th>
                        <th>이미지</th>
                        <th width='100'>반품수량</th>
                        <th>확인여부</th>
                    </tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>                               
                                
                    <tr class="<?php echo $TPL_V1["line_color"]?>">			
                        <td><?php echo $TPL_V1["goodsnm"]?></td>
                        <td class="td_img" style="text-align: center;"><?php echo $TPL_V1["img_url"]?></td>
                        <td style="text-align: center;"><?php echo $TPL_V1["sum_egn"]?></td>
                        <td style="text-align: center;"><span style="color:<?php echo $TPL_V1["confirmColor"]?>"><?php echo $TPL_V1["confirmNm"]?></span></td>
                    </tr>
<?php }}?>
                </table>
            </div>
        </td>
        <td> </td>
        <td style="height:621px;vertical-align: top; width:15%">
            <div style="overflow: auto; height:621px;">
            <table class="table table-bordered" >
                <tr><th colspan=2>리스트에없는바코드</th></tr>
                <tr>
                    <th>바코드</th>
                    <th>수량</th>
                </tr>
<?php if($TPL_notData_1){foreach($TPL_VAR["notData"] as $TPL_K1=>$TPL_V1){?>
                <tr>
                    <td><?php echo $TPL_K1?></td>		
                    <td style="text-align: center;"><?php echo $TPL_V1?></td>	                    	
                </tr>
<?php }}?>
            </table>
            </div>
        </td>	                    	
       
    </tr>	
</table>

<div class="bottom_btn_box">
	<div  class="box_left"></div>
	<div  class="box_right">
<?php if($TPL_VAR["allClean"]> 0){?>
        <div type="button" class="btn btn-primary confirmCheck" data-num='1'>확인</div>
<?php }elseif(count($TPL_VAR["notData"])){?>
        <div type="button" class="btn btn-primary confirmCheck" data-num='2'>확인</div>
<?php }else{?>
        <div type="button" class="btn btn-primary confirmCheck" data-num='3'>확인</div>
<?php }?>
		
	</div>
</div>

</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".returnMerge").click(function(){
   $("form[id='sendForm']").submit();
});
$(".confirmCheck").click(function(){
    var num=$(this).data('num');
    if(num=='1'){
        alert('확인되지않은 상품이 있습니다.');
        return false;
    }else if(num=='2'){
        if(confirm('리스트에 없는송장이 있습니다. \r\n확인처리하시겠습니까?')){
            $("input[name='mode']").val('mod');
            $("form[id='sendForm']").submit();
        }
    }else if(num=='3'){
        if(confirm('확인처리하시겠습니까?')){
            $("input[name='mode']").val('mod');
            $("form[id='sendForm']").submit();
        }
    }
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>