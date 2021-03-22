<?php /* Template_ 2.2.8 2020/06/16 12:14:13 /www/html/ukk_test2/data/skin/admin/mall_order_seq.htm 000003084 */ 
$TPL_data_1=empty($TPL_VAR["data"])||!is_array($TPL_VAR["data"])?0:count($TPL_VAR["data"]);
$TPL_data_mall_1=empty($TPL_VAR["data_mall"])||!is_array($TPL_VAR["data_mall"])?0:count($TPL_VAR["data_mall"]);
$TPL_data_list_1=empty($TPL_VAR["data_list"])||!is_array($TPL_VAR["data_list"])?0:count($TPL_VAR["data_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<style>
#sortable { list-style-type: none; margin: 0; padding: 0;  }
#sortable li {padding:5px;margin:5px; }
#sortable li div{display:inline-block}
#sortable li div.del{color:red;cursor:pointer}

html>body #sortable li {padding:5px;margin:5px; }
.ui-state-highlight {}
</style>
<hr>
<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<table class="table table-bordered" >
	<tbody>		
        <tr>
			<th>분류</th>
			<td>
				<select name="upload_form_type" id="upload_form_type">
					<option value="">선택</option>						
<?php if($TPL_data_1){foreach($TPL_VAR["data"] as $TPL_V1){?>
					<option <?php echo $GLOBALS["selected"]['upload_form_type'][$TPL_V1]?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
			
		</tr>
		<tr>
			<th>몰명</th>
			<td>
				<select name="mallno" >
					<option value="">선택</option>
<?php if($TPL_data_mall_1){foreach($TPL_VAR["data_mall"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				<br/>( 필수값이 아님)
			</td>
		</tr>
	
	</tbody>
</table>

<center>
	<button type="button" class="btn-sm btn-primary reg" id="reg">등록/수정</button>
</center>



<div class="table_title">등록목록</div>
<ul id="sortable">
<?php if($TPL_data_list_1){foreach($TPL_VAR["data_list"] as $TPL_V1){?>
  <li class="ui-state-default">
	<div style="width:95%">
    <?php echo $TPL_V1["upload_form_type"]?>

<?php if($TPL_V1["mall_name"]){?>
		- <?php echo $TPL_V1["mall_name"]?>

<?php }?>
	<input type="hidden" name="sort[]" value="<?php echo $TPL_V1["no"]?>">
	</div>
	<div class="del">X</div>
  </li>
<?php }}?>
</ul>

<center>
	<button type="button" class="btn-sm btn-primary reg" id="sort">순서변경</button>
</center>
</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){

	$( "#sortable" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( "#sortable" ).disableSelection();

	$("#upload_form_type").change(function(){	
		$("#main_form").submit();
	});

	$(".reg").click(function(){
		$("#mode").val($(this).attr("id"));
		$("#main_form").submit();
	});
	$(".del").click(function(){
		if(confirm('삭제하시겠습니까?')){
			var del_no=$(this).closest("li").find("input[name='sort[]']").val();
		
			location.href="mall_order_seq.php?del="+del_no;
		}
	});
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>