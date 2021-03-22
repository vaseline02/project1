<?php /* Template_ 2.2.8 2020/10/22 14:14:48 /www/html/ukk_test2/data/skin/goods/event_price.htm 000008482 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<style>
</style>


<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td>
			<select name="upload_sel" id="">
				<option value="1">타임메카 행사가</option>
				<option value="2">EC 행사가</option>
			</select>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary">업로드</button>
		</td>
    </tr>
</table>
</form>
<?php }?>

<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>




<table class=" display <?php if($GLOBALS["print_xls"]!= 1){?>display_s<?php }?> nowrap" data-height="700"  border="<?php echo $GLOBALS["xls_border"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>

<?php }?>
	<thead>
		<tr>
			<th rowspan=2>브랜드</th>
			<th rowspan=2>분류</th>
			<th rowspan=2>이미지</th>
			<th rowspan=2>모델명</th>
			<th rowspan=2>타임메카 행사가<br/>5%</th>
			<th rowspan=2>수익률</th>
			<th rowspan=2>EC 행사가<br/>15%</th>
			<th rowspan=2>수익률</th>
			<th rowspan=2>제휴몰<br/>15%</th>
			<th rowspan=2>수익률</th>
			<th rowspan=2>수량</th>
			<th rowspan=2>입고예정</th>
			<th rowspan=2>소비자가</th>
			<th rowspan=2>입고이력</th>
			<th rowspan=2>원가평균</th>
			
			<th colspan="3">7일</th>
			<th colspan="3">15일</th>
			<th colspan="3">1달</th>
			<th colspan="3">3달</th>
			<th colspan="3">6달</th>
			<th colspan="3">6달비율</th>
			<th rowspan=2>수정일</th>
			
		</tr>
		<tr>
			<th class="data_num">타임메카<br/>스토어팜</th>
			<th class="data_num">EC</th>
			<th class="data_num">B2B</th>
			<th class="data_num">타임메카<br/>스토어팜</th>
			<th class="data_num">EC</th>
			<th class="data_num">B2B</th>
			<th class="data_num">타임메카<br/>스토어팜</th>
			<th class="data_num">EC</th>
			<th class="data_num">B2B</th>
			<th class="data_num">타임메카<br/>스토어팜</th>
			<th class="data_num">EC</th>
			<th class="data_num">B2B</th>
			<th class="data_num">타임메카<br/>스토어팜</th>
			<th class="data_num">EC</th>
			<th class="data_num">B2B</th>
			<th class="data_num">타임메카<br/>스토어팜</th>
			<th class="data_num">EC</th>
			<th class="data_num">B2B</th>

		</tr>	
	</thead>
	<tbody>
	
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["brandnm"]?> <?php if($GLOBALS["print_xls"]!= 1){?><input type="hidden" class="chk_no" value="<?php echo $TPL_V1["goodsno"]?>"><?php }?></td>
			<td><?php echo $TPL_V1["prod_type"]?></td>
			<td class="td_img" ><?php echo $TPL_V1["img_url"]?></td>
			<td class="text_type">
<?php if($GLOBALS["print_xls"]!= 1){?><a href="#" onclick="popup('event_price_log.php?goodsno=<?php echo $TPL_V1["goodsno"]?>','event_price_log','1100','900')"><?php }?>
				<?php echo $TPL_V1["goodsnm"]?>

<?php if($GLOBALS["print_xls"]!= 1){?></a><?php }?>
			</td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<!--<input type="text" class="cal auto_save" data-colname="tm_price" name="tm_price[]" value="<?php echo $TPL_V1["tm_price"]?>">-->
				<?php echo number_format($TPL_V1["tm_price"])?>

<?php }else{?>
				<?php echo number_format($TPL_V1["tm_price"])?>

<?php }?>

			</td>
			<td><?php echo $TPL_V1["tm_per"]?>%</td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<!--<input type="text" class="cal auto_save cal_sangsi " data-colname="ec_price" name="ec_price[]"  value="<?php echo $TPL_V1["ec_price"]?>">-->
				<?php echo number_format($TPL_V1["ec_price"])?>

<?php }else{?>
				<?php echo number_format($TPL_V1["ec_price"])?>

<?php }?>
			</td>

			<td><?php echo $TPL_V1["ec_per"]?>%</td>
			<td class="sangsi"><?php echo number_format($TPL_V1["sangsi_price"])?></td>
			<td><?php echo $TPL_V1["sangsi_per"]?>%</td>
			<td><?php echo number_format($TPL_V1["cur_cnt"])?></td>
			<td><?php echo number_format($TPL_V1["codeno_3"])?></td>
			<td><?php echo number_format($TPL_V1["c_price"])?></td>
			<td class="text_type">
<?php if(is_array($TPL_R2=$TPL_V1["stock_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<?php echo $TPL_V2["now_cnt"]?> / <?php echo number_format($TPL_V2["cost"])?>

					<br>
<?php }}?>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<button type="button" onclick="popup('return_stock_pop.php?no=<?php echo $TPL_V1["no"]?>','return_stock_pop','1100','900')">반품입고(<?php echo number_format($TPL_V1["return_order_cnt"])?>)</button>
<?php }?>
			</td>
			<td class="savg"><?php echo number_format($TPL_V1["stock_average"])?></td>
			
			<td><?php echo $TPL_V1["tm7"]?></td>
			<td><?php echo $TPL_V1["ec7"]?></td>
			<td><?php echo $TPL_V1["b2b7"]?></td>
			<td><?php echo $TPL_V1["tm15"]?></td>
			<td><?php echo $TPL_V1["ec15"]?></td>
			<td><?php echo $TPL_V1["b2b15"]?></td>
			<td><?php echo $TPL_V1["tm1m"]?></td>
			<td><?php echo $TPL_V1["ec1m"]?></td>
			<td><?php echo $TPL_V1["b2b1m"]?></td>
			<td><?php echo $TPL_V1["tm2m"]?></td>
			<td><?php echo $TPL_V1["ec2m"]?></td>
			<td><?php echo $TPL_V1["b2b2m"]?></td>
			<td><?php echo $TPL_V1["tm3m"]?></td>
			<td><?php echo $TPL_V1["ec3m"]?></td>
			<td><?php echo $TPL_V1["b2b3m"]?></td>
			<td><?php echo $TPL_V1["tm_per6m"]?>%</td>
			<td><?php echo $TPL_V1["ec_per6m"]?>%</td>
			<td><?php echo $TPL_V1["b2b_per6m"]?>%</td>
			<td><?php echo $TPL_V1["mod_date"]?></td>
			
	
		</tr>
<?php }}?>
	</tbody>
</table>


<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");

$('table.display_xscroll').dataTable( {
	"aoColumnDefs": [{ 'bSortable': false, 'aTargets': ["sorting_disabled"] }],
	"scrollCollapse": true,
	"paging":   false,
	"scrollY": "800px",
    "scrollX": true,
	"order": []
} );

$(".cal").keyup(function(){
/* -3000원에 타임메카는 100000 이상 제품만 조건 추가해야됨*/
	if( $(this).val().length>4 ){
		var clac=0;
		var clac2=0;
		var cha=3000;
		var avg=uncomma($(this).closest("tr").find(".savg").html());
		
		if( $(this).data("colname")=="tm_price" && $(this).val()>=100000){
			cha=0;
		}
		
		
		clac=( $(this).val()-avg-cha)/$(this).val()*100;
		
		$(this).closest("td").next().html(clac.toFixed(2)+'%');

		if($(this).hasClass("cal_sangsi") ){
			var target=$(this).closest("tr").find(".sangsi");
			target.html(Math.round($(this).val()*1.07/1000)*1000);

			if( parseInt(target.html)>=300000 ){
				target.html=target.html-1000;
			}else{
				target.html=target.html-100;
			}

			//
			target.next().html( ((target.html()-avg-3000 )/target.html()*100).toFixed(2) +'%' );
		}
	}
});

$(".cal").keydown(function(){
	var key = event.keyCode;
	//var focused = $(':focus');
    if(key==37){
    //왼쪽
    }else if(key==38){
    //위     
		$(this).val( parseInt($(this).val())+1000 );
    }else if(key==39){
    //오른쪽    
    }else if(key==40){
    //아래    
		$(this).val( parseInt($(this).val())-1000 );
    }
});


$(".auto_save").keyup(function(){
	var tday=getToday();
	var colname=$(this).data("colname");
	var this_val=$(this).val();
	var this_no=$(this).closest("tr").find(".chk_no").val();
	
	$.post("../ajax/db_update.php",{dbname:"goods_sale_period",target_colname:"goodsno",target_data:this_no
	,colname:colname
	,colname_data:this_val
	,colname2:'mod_date'
	,colname_data2:tday
	},function(data){
		if(data!='1'){
			alert(data);
		}
	});
	
});


function getToday(){
    var now = new Date();
    var year = now.getFullYear();
    var month = now.getMonth() + 1;    //1월이 0으로 되기때문에 +1을 함.
    var date = now.getDate();

    if((month + "").length < 2){        //2자리가 아니면 0을 붙여줌.
        month = "0" + month;
    }
     // ""을 빼면 year + month (숫자+숫자) 됨.. ex) 2018 + 12 = 2030이 리턴됨.
    return today = ""+year+'-'+ month +'-'+ date; 
}
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>