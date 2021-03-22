<?php /* Template_ 2.2.8 2020/05/07 14:19:28 /www/html/ukk_test/data/skin/cs/return_check.htm 000003986 */ 
$TPL_notData_1=empty($TPL_VAR["notData"])||!is_array($TPL_VAR["notData"])?0:count($TPL_VAR["notData"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div2 a:after{width:90%}
</style>

<form id="sendForm" method="POST">
<input type="hidden" name="mode" value="">
<input type="hidden" name="no" value="">
<input type="hidden" name="code" value="">
<table id="" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
    <tr>
        <td style="width:40%; vertical-align: top;">
            <table class="table table-bordered" >
                <tr>
                    <th>송장번호</th>
                    <td style="height:621px"><textarea name="s_invoice" id="" style="height:100%; width:100%"><?php echo $_POST['s_invoice']?></textarea></td>	
<?php if(count($TPL_VAR["notData"])){?>	
                    <td style="height:621px;vertical-align: top; width:40%">
                        <table class="table table-bordered" >
                            <tr><th colspan=2>리스트에없는송장</th></tr>
                            <tr>
                                <th>송장번호</th>
                                <th>수량</th>
                            </tr>
<?php if($TPL_notData_1){foreach($TPL_VAR["notData"] as $TPL_K1=>$TPL_V1){?>
                            <tr>
                                <td><?php echo $TPL_K1?></td>		
                                <td style="text-align: center;"><?php echo $TPL_V1?></td>	                    	
                            </tr>
<?php }}?>
                        </table>
                        
                    </td>	                    	
<?php }?>
                </tr>
            </table>

        </td>
        <td style="text-align: center;">
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
                        <th>확인</th>
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
    </tr>	
</table>

<div class="bottom_btn_box">
	<div  class="box_left"></div>
	<div  class="box_right">
		<div type="button" class="btn btn-primary" onclick="popup('return_check.php','','1100','900')">확인</div>
	</div>
</div>

</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".returnMerge").click(function(){
   $("form[id='sendForm']").submit();
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>