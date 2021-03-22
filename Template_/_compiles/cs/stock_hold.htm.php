<?php /* Template_ 2.2.8 2020/06/30 10:28:37 /www/html/ukk_test/data/skin/cs/stock_hold.htm 000002972 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<style>
.search_td_width{width:800px;}
</style>
<script>
    function checkForm(){
        if(!$("input[name='cnt']").val()){
            alert("수량을 입력해주세요.");
            return false;
        }
    }
</script>
<form method="post" name="insForm" onsubmit="return checkForm()">
    <input type="hidden" name="mode" value="ins">
    <input type="hidden" name="goodsnm" value="<?php echo $TPL_VAR["goodsnm"]?>">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING']?>">  
	<table class="table table-bordered" >

		<tr>
			<th>상품명</th>
            <td class="search_td_width"><?php echo $TPL_VAR["goodsnm"]?></td>			            
        </tr>
        
        <tr>
			<th>수량</th>
            <td class="search_td_width"><input type="text" style="width:100px" name="cnt"></td>			            
        </tr>
        <tr>
			<th>메모</th>
            <td class="search_td_width"><input type="text" style="width:100%" name="memo"></td>			            
		</tr>
		
	</table>
	<center>
		<button class="btn btn-sm btn-primary" id="">등 록</button>
	</center>
</form>
<form method="post" name="listForm">
    <input type="hidden" name="mode" value="mod">
    <input type="hidden" name="no" value="">
    <input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING']?>">  
    <table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
        <thead>
            <tr>			
                <th>주문번호</th>
                <th>수량</th>
                <th>메모</th>
                <th width='200'>등록일</th>
                <th width='50'></th>
            </tr>
        </thead>	
        <tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
            <tr>			
                <td><?php echo $TPL_V1["order_no"]?></td>
                <td><?php echo number_format($TPL_V1["cnt"])?></td>
                <td><?php echo $TPL_V1["memo"]?></td>
                <td><?php echo $TPL_V1["reg_date"]?></td> 
                <td><button type="button" class="btn btn-sm btn-warning holdCancel" data-no=<?php echo $TPL_V1["no"]?>>해제</button></td>
            </tr>
<?php }}?>
        </tbody>
    </table>
</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".holdCancel").click(function(){
    if(confirm("해제하시겠습니까?")){
        var holdNo=$(this).data('no');
        $("input[name='no']").val(holdNo);
        $("form[name='listForm']").submit();
    }
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>