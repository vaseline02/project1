<?php /* Template_ 2.2.8 2021/03/05 14:23:19 /www/html/ukk_test2/data/skin/cs/daily_deli_info.htm 000010166 */ 
$TPL__courier_1=empty($GLOBALS["courier"])||!is_array($GLOBALS["courier"])?0:count($GLOBALS["courier"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>


<form enctype="multipart/form-data" id="search_form" method="post" >
<table class="table table-bordered" >
    <tr>
        <th>기간검색</th>
		<td>
			<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
				<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
				<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>7일</button>
				<button type="button" class="btn btn-default dayChange" data-int='15' data-type='day'>15일</button>
				<button type="button" class="btn btn-default dayChange" data-int='1' data-type='month'>1개월</button>
				<button type="button" class="btn btn-default dayChange" data-int='3' data-type='month'>3개월</button>
				<button type="button" class="btn btn-default dayChange" data-int='1' data-type='year'>1년</button>
				<!-- <button type="button" class="btn btn-primary">전체</button> -->
			</div>
			<div class="col-md-2 date-wrap">
				<div class="input-group">
					<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $_POST['s_date']?>" readonly />
					<span class="input-group-btn">
						<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
					</span>
				</div>
			</div>
			
			<p class="date-tilde">~</p>
			<div class="col-md-2 date-wrap">
				<div class="input-group">
					<input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $_POST['e_date']?>" readonly />
					<span class="input-group-btn">
						<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
					</span>
				</div>										
			</div>
		</td>
	</tr>
</table>
<center>
<button class="btn btn-primary">검 색</button>
</center>
</form>

<form method="post" id="main_form">
	<input type="hidden" name="comp_seq" id="comp_seq" >
</form>
<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<colgroup>
		<col width="5%" />
		<col width="5%" />
<?php if($TPL__courier_1){foreach($GLOBALS["courier"] as $TPL_V1){?>
		<col width="6%" />
<?php }}?>
		<col width="6%" />
		<col width="6%" />
		<col width="6%" />
		<col width="6%" />
	</colgroup>
	<thead>
		<tr>
			<th>날짜</th>
			<th>시제금</th>
<?php if($TPL__courier_1){foreach($GLOBALS["courier"] as $TPL_V1){?>
			<th><?php echo $TPL_V1?></th>
<?php }}?>
			<th>반품배송비(+)</th>
			<th>메모</th>
			<th></th>
			<th>합계</th>
		</tr>
	</thead>
	<tbody>

<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
		<tr class="date_line">
			<td><span class="r_date"><?php echo $TPL_K1?><?php if($TPL_I1== 0){?><br/>(금일)<?php }?></span></td>
			<td>
				<input type="hidden" class="courier_name" value="시제금" >
				<input type="hidden" class="courier_name_key" value="sije" >
				<input type="hidden" class="no" value="<?php echo $TPL_VAR["date_sije"][$TPL_K1]['no']?>" >
				<div>금액 : <input type="text" class="auto_save sije_price number_only" data-colname="price" size="6" value="<?php echo $TPL_VAR["date_sije"][$TPL_K1]['price']?>" ></div>
			</td>
<?php if(is_array($TPL_R2=($GLOBALS["courier"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<td class="courier_line">
				<input type="hidden" class="courier_name" value="<?php echo $TPL_V2?>" >
				<input type="hidden" class="courier_name_key" value="<?php echo $TPL_K2?>" >
				<input type="hidden" class="no" value="<?php echo $TPL_V1[$TPL_V2]['no']?>" >
				<div>수량 : <input type="text" class="auto_save cnt <?php echo $TPL_K2?>_cnt number_only" data-colname="cnt" size="6" value="<?php echo $TPL_V1[$TPL_V2]['cnt']?>" ></div>
				<div>금액 : <input type="text" class="auto_save price <?php echo $TPL_K2?>_price number_only" data-colname="price" size="6" value="<?php echo $TPL_V1[$TPL_V2]['price']?>" ></div>
			</td>
<?php }}?>
			<td>
				<input type="hidden" class="courier_name" value="반품배송비" >
				<input type="hidden" class="courier_name_key" value="return" >
				<input type="hidden" class="no" value="<?php echo $TPL_VAR["date_return"][$TPL_K1]['no']?>" >
				<div>금액 : <input type="text" class="auto_save return_price number_only" data-colname="price" size="6" value="<?php echo $TPL_VAR["date_return"][$TPL_K1]['price']?>" <?php echo $TPL_VAR["date_comp"][$TPL_K1]?>></div>
			</td>
			<td>
				<input type="hidden" class="no" value="<?php echo $TPL_VAR["date_memo"][$TPL_K1]['no']?>" >
				<textarea id="" cols="20" class="auto_save" data-colname="memo" rows="2" ><?php echo $TPL_VAR["date_memo"][$TPL_K1]['memo']?></textarea>
			</td>
			<td>
<?php if($TPL_VAR["date_comp"][$TPL_K1]!='disabled'){?><button type="button" class="btn btn-primary btn_comp" data-sijeseq="<?php echo $TPL_VAR["date_sije"][$TPL_K1]['no']?>">완료</button><?php }?>
			</td>
			<td class="line_num">
				<div>수량 : <span class="sum_cnt"></span> </div>
				<div>금액 : <span class="sum_price"></span> </div>
			</td>
		</tr>
<?php }}?>
	</tbody>
	<tfoot>
		<tr>
		<td>합계</td>
		<td><div>금액 : <span class="sum_sije"></span> </div></td>
<?php if($TPL__courier_1){foreach($GLOBALS["courier"] as $TPL_K1=>$TPL_V1){?>
			<td class="<?php echo $TPL_K1?>_sum ">
				<div>수량 : <span class="sum_cnt"></span> </div>
				<div>금액 : <span class="sum_price"></span> </div>
			</td>
<?php }}?>
		<td><div>금액 : <span class="sum_return"></span> </div></td>
		<td></td>
		<td></td>
		<td>
			<div>수량 : <span class="tot_sum_cnt"></span> </div>
			<div>금액 : <span class="tot_sum_price"></span> </div>
		</td>
		</tr>
	</tfoot>
</table>

<div style="width:100%;text-align:right;"><button type="button" class="btn btn-primary"> 등 록 </button></div>
<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
	</div>
	<div  class="box_right">
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>등록버튼을 누르거나 다른곳을 클릭시 저장됨</li>
  </ul>
</fieldset>

<?php }?>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	
	sum_line();

	$(".btn_comp").click(function(){

		if($(this).closest("tr").find(".sije_price").val()<1){
			alert('시제금을 입력해주세요');
			return false;
		}

		if(confirm('완료 하시겠습니까?')){
			$("#comp_seq").val( $(this).data("sijeseq") );
			$("#main_form").submit();
		}
	});

	$(".auto_save").blur(function(){			
		var dbname="daily_deli_info";
		var colname=$(this).data("colname");
		var this_val=$.trim($(this).val());
		
		var this_no_obj=$(this).closest("td").find(".no");
		var this_no=this_no_obj.val();

		var courier_name=$(this).closest("td").find(".courier_name").val();

		var this_date=$(this).closest("tr").find(".r_date").html();
		var target_colname='no';
		var target_data=this_no;
		var qry=qry_u='';

		if(colname=='memo')courier_name='memo';
	
		
		qry_u="update "+dbname+" set " +colname+"='"+this_val+"', time_date=now() where "+target_colname+"='"+target_data+"' ";
		qry="insert into "+dbname+" set courier_name='"+courier_name+"', "+colname+"='"+this_val+"' ,reg_date='"+this_date+"' ,time_date=now()   ";
		
		$.post("../ajax/db_ins_upd.php",{qry:qry,qry_u:qry_u,courier_name:courier_name,this_date:this_date},function(data){
			
			if(data!='false'){
				if(data!='ok'){
					this_no_obj.val(data);
				}
			}else{
				alert('수정오류 개발팀에 문의바랍니다.');
			}

			sum_line();
		});
		
	});
});

function sum_line(){

	$(".date_line").each(function(){

		var sum_cnt=0;
		var sum_price=0;

		var this_obj=$(this);

		var this_sije=this_obj.find(".sije_price").val();
		var this_return=this_obj.find(".return_price").val();

		this_obj.find(".cnt").each(function(){

			sum_cnt+=Number($(this).val());
		});

		this_obj.find(".price").each(function(){

			sum_price+=Number($(this).val());
		});
		
		this_obj.find(".sum_cnt").html(sum_cnt);
		this_obj.find(".sum_price").html(this_sije-sum_price+Number(this_return));

	});
	
	var sije_sum=0;
	$(".sije_price").each(function(){
		sije_sum+=Number($(this).val());
	});

	$(".sum_sije").html(comma(sije_sum));

	var return_sum=0;
	$(".return_price").each(function(){
		return_sum+=Number($(this).val());
	});

	$(".sum_return").html(comma(return_sum));
	
	
	
	$(".courier_line").each(function(){
		
		var courier_sum_cnt=0;
		var courier_sum_price=0;
		var this_obj=$(this);
		var courier_name_key=$(this).find(".courier_name_key").val();
		
		$("."+courier_name_key+"_cnt").each(function(){

			courier_sum_cnt+=Number( $(this).val() );
		});

		$("."+courier_name_key+"_price").each(function(){

			courier_sum_price+=Number( $(this).val() );
		});

		$("."+courier_name_key+"_sum").find(".sum_cnt").html(courier_sum_cnt);
		$("."+courier_name_key+"_sum").find(".sum_price").html(courier_sum_price);
	});
	
	var tot_cnt_sum=0;
	var tot_price_sum=0;
	$(".line_num").each(function(){
	
		tot_cnt_sum+=Number($(this).find(".sum_cnt").html());
		tot_price_sum+=Number($(this).find(".sum_price").html());

	});
	
	$(".tot_sum_cnt").html(comma(tot_cnt_sum));
	$(".tot_sum_price").html(comma(tot_price_sum));

}

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>