<?php /* Template_ 2.2.8 2020/11/27 18:10:03 /www/html/ukk_test2/data/skin/outline/_footer.htm 000003217 */ ?>
</div>
	<!-- Main Contents -->
</div>


<footer style="min-height:50px;">

</footer>

</div>
<!--<textarea name="" id="tttt" cols="30" rows="10"></textarea>-->
<div id="hidden_img_layer" style="position:absolute;display:none;border:1px solid orange"></div>
</body>


<script type="text/javascript">

function popup(src,name,width,height)
{
	window.open(src,name,'width='+width+',height='+height+',scrollbars=1,resizable=1');
}


// 값 검증용 함수들.
function required(a){for(var i in a)if($(a[i][0]).val()==""){alert(a[i][1]);$(a[i][0]).select();return 0;}return 1;}

$(function(){
	$("input[type='checkbox']").click(function(){

		var th_cnt=$(this).closest("tr").find("th").length;
		
		if(th_cnt==0){

			if($(this).is(":checked")){
				$(this).closest("tr").addClass("chk_row_color");	
			}else{
				$(this).closest("tr").removeClass("chk_row_color");	
			}
		}
	});
});


//ajax커서
$( document ).ajaxStart(function() {
	//마우스 커서를 로딩 중 커서로 변경
	$('html').css("cursor", "wait"); 
});
$( document ).ajaxStop(function() {
	//마우스 커서를 원래대로 돌린다
	$('html').css("cursor", "auto"); 
});

//이미지 확대보기
$(document).on("mouseover",".td_img",function(e){

	var img_src = $(this).find("img").attr("src");
	var img_top = $(window).scrollTop() + 100;
	var img_left = e.pageX + 100;

	$("#hidden_img_layer").html("<img src='"+img_src+"' />");
	$("#hidden_img_layer").css({"display":"block","top":img_top+"px","left":img_left+"px"});
}).on("mouseout",".td_img",function(){

	$("#hidden_img_layer").css("display","none");
});


//이미지 상세 확대보기
//$(document).on("dblclick",".td_img",function(e){
	
$(".td_img>img").dblclick(function(){

	var img_src = $(this).attr("src");
	popup('../goods/goods_detail_img_pop.php?imgname='+img_src,'','1000','1000');
});


//상품상세팝업
$(".goods_detail_pop").click(function(){
	var goodsno=$(this).data("goodsno");
	popup('../goods/goods_detail_pop.php?goodsno='+goodsno,'goods_detail_pop','1200','900');
});

//이미지 확대보기
$(document).on("mouseover",".td_img_sm",function(e){

var img_src = $(this).find("img").attr("src");
var img_top = $(window).scrollTop() + 100;
var img_left = e.pageX + 50;

$("#hidden_img_layer").html("<img src='"+img_src+"' style='width:400px'/>");
$("#hidden_img_layer").css({"display":"block","top":img_top+"px","left":img_left+"px"});
}).on("mouseout",".td_img_sm",function(){

$("#hidden_img_layer").css("display","none");
});


//submit_ok_chk를 클래스로 값이 0이면 오류 1이면 처리. 상품명이나 필수체크항목에서 사용.
function chkform(){

	var chksub=1;
	var chk_val='';
	$(".submit_ok_chk").each(function(){
		
		if( $(this).val()==0 ){
			chksub=0;
			chk_val=$(this).attr("alt");
			return false;
		}

	});

	if(chksub){
		if(confirm('처리하시겠습니까?'))return true;
		else return false;
	}else{
		alert('['+chk_val+'] 필수사항');
		return false;
	}
}



</script>

</html>