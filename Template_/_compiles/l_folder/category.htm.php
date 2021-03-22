<?php /* Template_ 2.2.8 2021/03/19 14:52:06 /www/html/ukk_test2/data/skin/l_folder/category.htm 000012596 */ 
$TPL_catelist_1=empty($TPL_VAR["catelist"])||!is_array($TPL_VAR["catelist"])?0:count($TPL_VAR["catelist"]);?>
<table class="table">
	<tbody>
		<tr>
			<th>카테고리</th>
			<td>
				<select name="category_1" id="category_1" class="cate_chg" data-depth='1'>
					<option value="">== 1차카테고리 선택 ==</option>
<?php if($TPL_catelist_1){foreach($TPL_VAR["catelist"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['category_1'][$TPL_K1]?>><?php echo $TPL_V1["catenm"]?></option>
<?php }}?>
				</select>
				<select name="category_2" id="category_2" class="cate_chg" data-depth='2'>
					<option value="">== 2차카테고리 선택 ==</option>                                   
<?php if($GLOBALS["category_1"]!='000'){?>
<?php if(is_array($TPL_R1=$TPL_VAR["catelist"][$GLOBALS["category_1"]])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='catenm'){?>
							<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['category_2'][$TPL_K1]?>><?php echo $TPL_V1["catenm"]?></option>  
<?php }?>
<?php }}?>
<?php }?>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<form  id="cateForm" name="cateForm" method="POST">
	<div class="option-searchbox-hide searchbox-goods-detail">
		<table class="table">
			<tbody id="tb">				
				<tr>
					<th>카테고리2</th>
					<td>
						<select name="category1_1" id="category1_1" class="cate_chg2" data-depth='1'>
							<option value="">== 1차카테고리 선택 ==</option>
<?php if($TPL_catelist_1){foreach($TPL_VAR["catelist"] as $TPL_K1=>$TPL_V1){?>
							<option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$GLOBALS["category1_1"]){?>selected<?php }?>><?php echo $TPL_V1["catenm"]?></option>
<?php }}?>
						</select>
						<select name="category1_2" id="category1_2" class="cate_chg2" data-depth='2'>
							<option value="">== 2차카테고리 선택 ==</option>                                   
<?php if($GLOBALS["category1_1"]!='000'){?>
<?php if(is_array($TPL_R1=$TPL_VAR["catelist"][$GLOBALS["category1_1"]])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='catenm'){?>
									<option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$GLOBALS["category1_2"]){?>selected<?php }?>><?php echo $TPL_V1["catenm"]?></option>  
<?php }?>
<?php }}?>
<?php }?>
						</select>
						<input type="button" onclick="select_add('html');" id="add" value="+">
						<input type="text" id="sel_cnt" name="sel_cnt" value="<?php if($GLOBALS["sel_cnt"]){?><?php echo $GLOBALS["sel_cnt"]?><?php }else{?>2<?php }?>">
						<input type="text" id="total_cnt" name="total_cnt" value="<?php if($GLOBALS["total_cnt"]){?><?php echo $GLOBALS["total_cnt"]?><?php }else{?>1<?php }?>">
						<input type="text" id="idx_arr" name="idx_arr" >
					</td>

				</tr>
			</tbody>
		</table>
	</div>
	<div>
		<input type="button" value="저장" onclick="save();">
	</div>
</form>
<input type="text" id="c2_1" value="<?php echo $GLOBALS["category2_1"]?>">
<input type="text" id="c2_2" value="<?php echo $GLOBALS["category2_2"]?>">
<input type="text" id="c3_1" value="<?php echo $GLOBALS["category3_1"]?>">
<input type="text" id="c3_2" value="<?php echo $GLOBALS["category3_2"]?>">
<input type="text" id="c4_1" value="<?php echo $GLOBALS["category4_1"]?>">
<input type="text" id="c4_2" value="<?php echo $GLOBALS["category4_2"]?>">
<input type="text" id="c5_1" value="<?php echo $GLOBALS["category5_1"]?>">
<input type="text" id="c5_2" value="<?php echo $GLOBALS["category5_2"]?>">
<?
tydebug( $TPL_VAR["catelist"]);
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
$(function(){
	var total_cnt = $("#total_cnt").val();
	
	if(total_cnt > 2){		
		select_add('db');
	}

}) ;

function select_add(flag){

	var cnt = $("#sel_cnt").val(); //다음 셀렉트박스 번호
	var total_cnt = $("#total_cnt").val(); // 총 추가된 셀렉트 박스 갯수
	var catelist = <?echo json_encode( $TPL_VAR["catelist"]);?>; //카테고리 항목
	
	var next_cnt_1 = '';
	var next_cnt_2 = '';
	var select_box = " ";
	
	if(flag == 'db'){

		var idx_arr = [];
		
		for(var i=2; i<=total_cnt; i++){
			next_cnt_1 = "category"+i+"_1";
			next_cnt_2 = "category"+i+"_2";
			
			var c1 = $("#c"+i+"_1").val();
			var c2 = $("#c"+i+"_2").val();
			
			select_box += "<tr id='tr_"+i+"'><th></th><td>";
			
			select_box += "<select name='"+next_cnt_1+"' id='"+next_cnt_1+"' onchange=\"chg(this, '"+i+"');\" data-depth='1'>";
			
			select_box += "<option value=''>== 1차카테고리 선택 == "+next_cnt_1+"</option> ";
						
			$.each(catelist, function(idx, val){	
				if(c1 == idx){
					select_box += "<option value='"+idx+"' selected>"+val.catenm+"</option>";
				}else{
					select_box += "<option value='"+idx+"'>"+val.catenm+"</option>";
				}				
			});

			select_box += "</select>  ";

			select_box += "<select name='"+next_cnt_2+"' id='"+next_cnt_2+"' onchange=\"chg(this, '"+i+"');\" data-depth='2'>";
			
			select_box += "<option value=''>== 2차카테고리 선택 == "+next_cnt_2+"</option>";
			
			$.each(catelist[c1], function(idx, val){
				if(idx != 'catenm'){
					if(c2 == idx){
						select_box += "<option value='"+idx+"' selected>"+val.catenm+"</option>";
					}else{
						select_box += "<option value='"+idx+"'>"+val.catenm+"</option>";
					}
				}
			});			
			
			select_box += "</select>  ";			
			select_box += "<input type='button' onclick=\"select_del('"+i+"');\" value='-'>";
			select_box += "<input type='text' id='sel_"+i+"' value='"+i+"'>";
			select_box += "</td></tr>";

			idx_arr.push(i);

			$('input[name="idx_arr"]').val(idx_arr);
		}
		

	}else if(flag == 'html'){
		next_cnt_1 = "category"+cnt+"_1"; // 다음 셀렉트 박스의 1차 카테고리 name,id
		next_cnt_2 = "category"+cnt+"_2"; // 다음 셀렉트 박스의 2차 카테고리 name,id
		
		
		var category = '<?echo  $GLOBALS["category1_1"];?>'; //문자열로 받기 '' 로 감싸면 문자열로 인식
		
		select_box += "<tr id='tr_"+cnt+"'><th></th><td>";
		
		select_box += "<select name='"+next_cnt_1+"' id='"+next_cnt_1+"' onchange=\"chg(this, '"+cnt+"');\" data-depth='1'>";
		
		select_box += "<option value=''>== 1차카테고리 선택 == "+next_cnt_1+"</option> ";

		$.each(catelist, function(idx, val){
			select_box += "<option value='"+idx+"'>"+val.catenm+"</option>";
		});
		select_box += "</select>  ";

		select_box += "<select name='"+next_cnt_2+"' id='"+next_cnt_2+"' onchange=\"chg(this, '"+cnt+"');\" data-depth='2'>";
		
		select_box += "<option value=''>== 2차카테고리 선택 == "+next_cnt_2+"</option>";
		
		if(category !='000'){
			$.each(catelist[category], function(idx, val){
				if(idx != 'catenm'){
					select_box += "<option value='"+idx+"'>"+val.catenm+"</option>";
				}
			});
		}

		select_box += "</select>  ";
		
		select_box += "<input type='button' onclick=\"select_del('"+cnt+"');\" value='-'>";
		select_box += "<input type='text' id='sel_"+cnt+"' value='"+cnt+"'>";
		select_box += "</td></tr>";

		var idx_str = $('input[name="idx_arr"]').val();

		if(idx_str != ''){
			var idx_arr = idx_str.split(',')
		}else{
			var idx_arr = [];
		}
		
		idx_arr.push(cnt);

		$('#sel_cnt').val((+cnt+1));
		$('#total_cnt').val((+total_cnt+1));
		$('input[name="idx_arr"]').val(idx_arr);
	}	
	
	$('#tb').append(select_box);

	if($('#total_cnt').val() >=5){
		$("#add").hide();
	}
}

function select_del(cnt){
	var total_cnt = $('#total_cnt').val();
	$('#total_cnt').val((+total_cnt-1));

	var idx_str = $('input[name="idx_arr"]').val();
    var idx_arr = idx_str.split(',')

	var idx_arr2 = [];

	for(var i=0; i<idx_arr.length; i++){
		if(idx_arr[i] != cnt){
			idx_arr2.push(idx_arr[i]);
		}
	}

	if($('#total_cnt').val() <5){
		$("#add").show();
	}

	$('input[name="idx_arr"]').val(idx_arr2);
	$("#tr_"+cnt).remove();

}

function chg(e, cnt){
	var depth = $(e).data('depth');
	var data = $(e).val();
	
	var depth_1="000"; var depth_2="000";
	var addHtml_2=""; 
	var chg_depth=(depth+1);

	if(depth=='1'){
		depth_1=data;
		$('#category'+cnt+'_2').children('option:not(:first)').remove();
					
	}else if(depth=='2'){
		depth_1=$("select[name='category'"+cnt+"'_1']").val();
		depth_2=data;
	}

	$.ajax({
            url: "../l_folder/category_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "depth="+depth+"&depth_1="+depth_1+"&depth_2="+depth_2,
            success: function(data){                                           
                $.each(data,function(index, item){
					console.log(item);
                    $.each(item,function(index2, item2){       
                        if (item2.constructor == Object) {
                            addHtml_2+="<option value='"+index2+"'>"+item2['catenm']+"</option>";
                        }                        
                    });  
                    $('#category'+cnt+'_'+chg_depth).append(eval("addHtml_"+chg_depth));           
                });
            }
        });

}


function save(){
	var total_cnt = $("#total_cnt").val();
	var idx_str = $('input[name="idx_arr"]').val();
    var idx_arr = idx_str.split(',')
	idx_arr.unshift("1");	
	
	for(var i=0; i<idx_arr.length; i++){
		var s1 = s2 = '';
		s1 = $("#category"+idx_arr[i]+"_1 option:selected").val();
		s2 = $("#category"+idx_arr[i]+"_2 option:selected").val();

		if(s1 == '000' || s2 == '000' || !s1 || !s2){
			alert('카테고리를 선택해주세요.');
			return false;
		}
	}

	$("#cateForm").submit();

}



$(function(){
	$(".cate_chg").change(function (){

		var depth = $(this).data('depth');
		var data = $(this).val();

		var depth_1="000"; var depth_2="000";
        var addHtml_2=""; 
        var chg_depth=(depth+1);

		if(depth=='1'){
            depth_1=data;
            $('#category_2').children('option:not(:first)').remove();
			            
        }else if(depth=='2'){
            depth_1=$("select[name='category_1']").val();
            depth_2=data;
        }

		$.ajax({
            url: "../l_folder/category_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "depth="+depth+"&depth_1="+depth_1+"&depth_2="+depth_2,
            success: function(data){                                           
                $.each(data,function(index, item){
					console.log(item);
                    $.each(item,function(index2, item2){       
                        if (item2.constructor == Object) {
                            addHtml_2+="<option value='"+index2+"'>"+item2['catenm']+"</option>";
                        }                        
                    });  
                    $('#category_'+chg_depth).append(eval("addHtml_"+chg_depth));           
                });
            }
        });
	});

	$(".cate_chg2").change(function (){
	
		var depth = $(this).data('depth');
		var data = $(this).val();

		var depth_1="000"; var depth_2="000";
        var addHtml_2=""; 
        var chg_depth=(depth+1);

		if(depth=='1'){
            depth_1=data;
           $('#category1_2').children('option:not(:first)').remove();
			            
        }else if(depth=='2'){
            depth_1=$("select[name='category1_1']").val();
            depth_2=data;
        }

		$.ajax({
            url: "../l_folder/category_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "depth="+depth+"&depth_1="+depth_1+"&depth_2="+depth_2,
            success: function(data){                                           
                $.each(data,function(index, item){
                    $.each(item,function(index2, item2){     
                        if (item2.constructor == Object) {
                            addHtml_2+="<option value='"+index2+"'>"+item2['catenm']+"</option>";
                        }                        
                    });  
                    $('#category1_'+chg_depth).append(eval("addHtml_"+chg_depth));           
                });
            }
        });
	});


})


</script>