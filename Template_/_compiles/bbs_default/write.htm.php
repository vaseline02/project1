<?php /* Template_ 2.2.8 2020/12/17 10:01:52 /www/html/ukk_test2/data/skin/bbs_default/write.htm 000005326 */ 
$TPL_cate_data_1=empty($TPL_VAR["cate_data"])||!is_array($TPL_VAR["cate_data"])?0:count($TPL_VAR["cate_data"]);
$TPL_img_1=empty($TPL_VAR["img"])||!is_array($TPL_VAR["img"])?0:count($TPL_VAR["img"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<form method="post" name="boardform" action="indb.php" enctype="multipart/form-data">
<input type="hidden" name="sn" value="<?php echo $GLOBALS["sn"]?>">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="board_id" value="<?php echo $GLOBALS["board_id"]?>">
<table class="table table-bordered" >

<?php if($GLOBALS["_GET"]['view']!='main'){?>
	<tr>
		<th>분류</th>
		<td>
			<select name="cate" id="" >
<?php if($TPL_cate_data_1){foreach($TPL_VAR["cate_data"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["sn"]?>" <?php echo $GLOBALS["selected"]['cate'][$TPL_V1["sn"]]?>><?php echo $TPL_V1["cate_name"]?></option>
<?php }}?>
			</select>
<?php if($GLOBALS["sess"]["h_level"]== 200){?>
			<button  type="button" class="btn btn-primary" onclick="javascript:cate_pop('<?php echo $GLOBALS["board_id"]?>');">분류추가</button>
<?php }?>
		</td>
	</tr>
<?php }?>
	<tr>
		<th>제목</th>
		<td>
			<input type="text" name="subject" value="<?php echo $TPL_VAR["subject"]?>" class="width_100" <?php echo $TPL_VAR["mod_type"]?>>
		</td>
	</tr>
	<tr>
		<th>내용</th>
		<td><textarea name="contents" id="" style="height:240px;width:100%" <?php echo $TPL_VAR["mod_type"]?>><?php echo $TPL_VAR["contents"]?></textarea></td>
	</tr>

	<?
	if($view_alarm && $_GET['viewpage']!='main'){
	?>
	<tr>
		<th>알림</th>
		<td>

			<div style="border:1px solid #ccc;padding:2px;margin:2px">
				<input type="radio" name="alarm_mw" value="m" <?=$checked[alarm_mw][m]?>>매월 첫째주
				<input type="radio" name="alarm_mw" value="w" <?=$checked[alarm_mw][w]?>>매주

				<input type="checkbox" name="alarm_d[]" value="1" <?=$checked[alarm_d][1]?> style="margin-left:40px">월
				<input type="checkbox" name="alarm_d[]" value="2" <?=$checked[alarm_d][2]?>>화
				<input type="checkbox" name="alarm_d[]" value="3" <?=$checked[alarm_d][3]?>>수
				<input type="checkbox" name="alarm_d[]" value="4" <?=$checked[alarm_d][4]?>>목
				<input type="checkbox" name="alarm_d[]" value="5" <?=$checked[alarm_d][5]?>>금
			</div>
			<div style="border:1px solid #ccc;padding:2px;margin:2px">
				<input type="checkbox" name="alarm_team[]" value="MD" <?=$checked[alarm_team][MD]?>>엠디팀
				<input type="checkbox" name="alarm_team[]" value="DS" <?=$checked[alarm_team][DS]?>>디자인팀
				<input type="checkbox" name="alarm_team[]" value="RD" <?=$checked[alarm_team][RD]?>>부사장님
			</div>
		</td>
	</tr>
	<?}?>

<?php if($TPL_VAR["sn"]){?>
	<tr>
		<th>파일<!--<br>(클릭 다운로드)--></th>
		<td>
		<!--<a href='download.php?sn=<?php echo $TPL_VAR["sn"]?>&board_id=<?php echo $GLOBALS["board_id"]?>'>-->
<?php if($TPL_img_1){foreach($TPL_VAR["img"] as $TPL_V1){?>
		<div><img src='../bbs_default/img/<?php echo $TPL_V1?>' style='margin-bottom:10px;width:1200px'></div>
<?php }}?>
		<!--</a>-->
		</td>
	</tr>
<?php }?>

<?php if($GLOBALS["_GET"]['view']!='main'){?>
	<tr>
		<th>파일</th>
		<td id="file_td">
			<div style='margin-top:5px'><input multiple type="file" name="board_file[]"><button type="button" id="file_add">+</button></div>

		</td>
	</tr>
<?php }?>
</table>
<?php if($GLOBALS["_GET"]['view']!='main'){?>
<div style="text-align:center;margin:30px">
	<button type="button" class="btn btn-primary" onclick="ins_db();">등록/수정</button>
	<?if($sn && $MD_ADMIN){?>
	<button type="button" class="btn btn-danger" onclick="del_list('<?php echo $GLOBALS["sn"]?>','<?php echo $GLOBALS["board_id"]?>','del')" >삭제</button>
	<?}?>
	<button type="button" class="btn btn-primary" onclick="self.close();">닫기</button>

</div>
<?php }else{?>
<div style="text-align:center;margin:30px">
<button type="button" class="btn btn-primary" onclick="self.close();">닫기</button>
</div>
<!--
<div class="close_day" style="border:1px solid #000;padding:3px;width:200px;text-align:center;right:10px;margin:30px auto;cursor:pointer">더이상 보지 않기</div>
-->
<?php }?>
</form>

<script>

$(function(){
	$(".close_day").click(function(){

		var date = new Date();
		var day_no = date.getDate();
		var sn  = $("input[name='sn']").val();
		var ntime = 24 - date.getHours();
		date.setTime(date.getTime() + (ntime * 60 * 60 * 1000));
		$.cookie("alarm_pop"+day_no+sn, "1", { expires: date, path: '/' });
		self.close();
	});
});



function ins_db(){
	$("form[name='boardform']").submit();
}

function cate_pop(id){
	var pop = window.open("cate_set.php?board_id="+id,"cate_pop","width=320,height=500");
	pop.focus();
}


$(function(){
	$("#file_add").click(function(){
		$("#file_td").append("<div style='margin-top:5px'><input multiple type='file' name='board_file[]'></div>");
	});
});

function del_list(sn,bid,mode){
	if(confirm('삭제하시겠습니까?')){

		document.location.href = 'indb.php?mode='+mode+'&sn='+sn+'&board_id='+bid;
	}
}

</script>

<?php $this->print_("footer",$TPL_SCP,1);?>