

/*** 할인액 계산 ***/
function getDcprice(price,dc,po)
{
	if(!po)po=100;
	if (!dc) return 0;
	var ret = (dc.match(/%$/g)) ? price * parseInt(dc.substr(0,dc.length-1)) / 100 : parseInt(dc);
	return parseInt(ret / po) * po;
}


function chkForm_old(form)
{
	if (typeof(mini_obj)!="undefined" || document.getElementById('_mini_oHTML')) mini_editor_submit();

	var reschk = 0;
	for (i=0;i<form.elements.length;i++){
		currEl = form.elements[i];
		if (currEl.disabled) continue;
		if (currEl.getAttribute("required")!=null || currEl.getAttribute("fld_esssential")!=null){
			if (currEl.type=="checkbox" || currEl.type=="radio"){
				if (!chkSelect(form,currEl,currEl.getAttribute("msgR"))) return false;
			} else {
				if (!chkText(currEl,currEl.value,currEl.getAttribute("msgR"))) return false;
			}
		}

		if (currEl.getAttribute("label")=='주민등록번호'  && currEl.getAttribute("name") == 'resno[]' && currEl.value.length>0){
			reschk = 1;

		}
		if (currEl.getAttribute("option")!=null && currEl.value.length>0){
			if (currEl.getAttribute("option")=="regPass" && !chkPassword(currEl)) return false;
			if (!chkPatten(currEl,currEl.getAttribute("option"),currEl.getAttribute("msgO"))) return false;
		}
		if (currEl.getAttribute("minlength")!=null){
			if (!chkLength(currEl,currEl.getAttribute("minlength"))) return false;
		}
	}
	if (form.password2){
		if (form.password.value!=form.password2.value){
			alert("비밀번호가 일치하지 않습니다");
			form.password.value = "";
			form.password2.value = "";
			return false;
		}
	}
	if (reschk && !chkResno(form)) return false;
	if (form.agreeyn){
		if (form.agreeyn[0].checked === false){
			alert("개인정보 수집 및 이용에 대한 안내에 동의 하셔야 작성이 가능합니다.");
			return false;
		}
	}

	if (form.chkSpamKey) form.chkSpamKey.value = 1;
	if (document.getElementById('avoidDbl')) document.getElementById('avoidDbl').innerHTML = "--- 데이타 입력중입니다 ---";
	return true;
}

function chkLength(field,len)
{
	text = field.value;
	if (text.trim().length<len){
		alert(len + "자 이상 입력하셔야 합니다");
		field.focus();
		return false;
	}
	return true;
}


function chkText(field,text,msg)
{
	text = text.trim();
	if (text==""){
		var caption = field.parentNode.parentNode.firstChild.innerText;
		if (!field.getAttribute("label")) field.setAttribute("label",(caption)?caption:field.name);
		if (!msg) msg = "[" + field.getAttribute("label") + "] 필수입력사항";
		//if (msg) msg2 += "\n\n" + msg;
		alert(msg);
		if (field.tagName!="SELECT") field.value = "";
		if (field.type!="hidden" && field.style.display!="none") field.focus();
		return false;
	}
	return true;
}

function chkSelect(form,field,msg)
{
	var ret = false;
	fieldname = eval("form.elements['"+field.name+"']");
	if (fieldname.length){
		for (j=0;j<fieldname.length;j++) if (fieldname[j].checked) ret = true;
	} else {
		if (fieldname.checked) ret = true;
	}
	if (!ret){
		if (!field.getAttribute("label")) field.getAttribute("label") = field.name;
		var msg2 = "[" + field.getAttribute("label") + "] 필수선택사항";
		if (msg) msg2 += "\n\n" + msg;
		alert(msg2);
		field.focus();
		return false;
	}
	return true;
}

function chkPatten(field,patten,msg)
{
	var regNum			= /^[0-9]+$/;
	var regEmail		= /^[^"'@]+@[._a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	var regUrl			= /^(http\:\/\/)*[.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	var regAlpha		= /^[a-zA-Z]+$/;
	var regHangul		= /[\uAC00-\uD7A3]/;
	var regHangulEng	= /[\uAC00-\uD7A3a-zA-Z]/;
	var regHangulOnly	= /^[\uAC00-\uD7A3]*$/;
	var regId			= /^[a-zA-Z0-9]{1}[^"']{3,15}$/;
	var regPass			= /^[\x21-\x7E]{10,16}$/;

	patten = eval(patten);
	if (!patten.test(field.value)){
		var caption = field.parentNode.parentNode.firstChild.innerText;
		if (!field.getAttribute("label")) field.setAttribute("label",(caption)?caption:field.name);
		var msg2 = "[" + field.getAttribute("label") + "] 입력형식오류";
		if (msg) msg2 += "\n\n" + msg;
		alert(msg2);
		field.focus();
		return false;
	}
	return true;
}

function chkRadioSelect(form,field,val,msg)
{
	var ret = false;
	fieldname = eval("form.elements['"+field+"']");
	if (fieldname.length){
		for (j=0;j<fieldname.length;j++){
			if (fieldname[j].checked) ret = fieldname[j].value;
		}
	} else {
		if (fieldname.checked) ret = true;
	}
	if (val != ret){
		alert(msg);
		return false;
	}
	return true;
}

function chkPassword(field)
{
	var passwordCount = 0;
	var digit	= /[0-9]/;
	var lower	= /[a-z]/;
	var upper	= /[A-Z]/;
	var punct	= /[~`!>@?\/<#\"\'$;:\]%.^,&[*()_+\-=|\\\{}]/;

	if (digit.test(field.value)) passwordCount++;
	if (lower.test(field.value)) passwordCount++;
	if (upper.test(field.value)) passwordCount++;
	if (punct.test(field.value)) passwordCount++;
	if (passwordCount < 2){
		alert("영문대문자(26개), 영문소문자(26개), 숫자(10개), 특수문자(32개) 중 \n\n2종류 이상을 조합하여 주세요.");
		return false;
	}

	return true;
}

function comma(x)
{
	var temp = "";
	var x = String(uncomma(x));

	num_len = x.length;
	co = 3;
	while (num_len>0){
		num_len = num_len - co;
		if (num_len<0){
			co = num_len + co;
			num_len = 0;
		}
		temp = ","+x.substr(num_len,co)+temp;
	}
	return temp.substr(1);
}

function uncomma(x)
{
	var reg = /(,)*/g;
	x = parseInt(String(x).replace(reg,""));
	return (isNaN(x)) ? 0 : x;
}


/*** 중앙 레이어 팝업창 띄우기 ***/
function centerLayer(s,w,h)
{
	if (!w) w = 600;
	if (!h) h = 400;

	var bodyW = document.body.clientWidth;
	var bodyH = window.innerHeight;

	if (typeof window.innerWidth=='undefined')
		bodyW=document.body.clientWidth;

	if (typeof window.innerHeight=='undefined')
		bodyH=document.body.clientHeight;


	var posX = (bodyW - w) / 2;
	var posY = (bodyH - h) / 2;

	var obj = document.createElement("div");
	var scrollTop=0;
	if (document.compatMode=='BackCompat')
	{
		scrollTop=document.body.scrollTop;
	}
	else{
		scrollTop=document.documentElement.scrollTop;
	}

	with (obj.style){
		position = "absolute";
		left = posX + document.body.scrollLeft+'px';
		top = posY + scrollTop+'px';
		width = w+'px';
		height = h+'px';
		backgroundColor = "#ffffff";
 		border = "4px solid #212121";
		marginLeft='0px';
		padding='0px';
	}
	obj.id = "centerLayer";
	document.body.appendChild(obj);

	/*** 아이프레임 ***/
	var ifrm = document.createElement("iframe");
	with (ifrm.style){
		width = w+'px' ;
		height = h+'px' ;
	}

	ifrm.style.padding='0px';
	ifrm.style.marginLeft='0px';
	ifrm.marginwidth='0px';
	ifrm.frameBorder = "no";
	ifrm.scrolling="no";
	obj.appendChild(ifrm);
	ifrm.src = s;
}

function closeCenterLayer()
{
	parent.document.body.removeChild(parent.document.getElementById('centerLayer') );
}


/*** Cookie 생성 ***/
function setCookie( name, value, expires, path, domain, secure ){

	var curCookie = name + "=" + escape( value ) +
		( ( expires ) ? "; expires=" + expires.toGMTString() : "" ) +
		( ( path ) ? "; path=" + path : "" ) +
		( ( domain ) ? "; domain=" + domain : "" ) +
		( ( secure ) ? "; secure" : "" );

	document.cookie = curCookie;
}

/*** Cookie 제거 ***/
function clearCookie( name ){

    var today = new Date();
    var expire_date = new Date(today.getTime() - 60*60*24*1000);
    document.cookie = name + "= " + "; expires=" + expire_date.toGMTString();
}

/*** Cookie 체크 ***/
function getCookie( name ){

	var dc = document.cookie;

	var prefix = name + "="

	var begin = dc.indexOf("; " + prefix);

	if ( begin == -1 ){

		begin = dc.indexOf(prefix);
		if (begin != 0) return null;
	}
	else begin += 2

	var end = document.cookie.indexOf(";", begin);

	if (end == -1) end = dc.length;

	return unescape(dc.substring(begin + prefix.length, end));
}


/*** Cookie 컨트롤 ***/
function controlCookie( name, elemnt ){

	if ( elemnt.checked ){

	    var today = new Date()
	    var expire_date = new Date(today.getTime() + 60*60*6*1000)

		setCookie( name=name, value='true', expires=expire_date, path='/' );
		if (_ID(name) == null) setTimeout( "self.close()" );
		else setTimeout( "_ID('" + name + "').style.display='none'" );
	}
	else clearCookie( name );

	return
}


$(document).ready(function() {
	$(".dblclear").dblclick(function(){ $(this).val("")});

	//그리드
	var display_height= $('table.display_s').data("height");
	$('.display_dt').DataTable({
		 "aoColumnDefs": [{ 'bSortable': false, 'aTargets': ["sorting_disabled"] }],
		 "scrollY":display_height+"px",
		 "scrollCollapse": true,
		 "paging": false,
		 "order": [],	
	});

	
    $('table.display_s').dataTable( {
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': ["sorting_disabled"] }],
		"scrollY":display_height+"px",
		"scrollCollapse": true,
		"paging":   false,
		"order": []
    } );

/*
    $('table.display_sort ,table.display').dataTable( {
//     "info":     false,
//     "scrollY":        "400px",	"scrollCollapse": true,
//     "jQueryUI":       true,

	"paging":   false,
	"order": []
    } );

*/

	//달력
    $( ".datepicker_common" ).datepicker({
		changeMonth: true,
	    changeYear: true,
		dateFormat: "yy-mm-dd",
		numberOfMonths: 2,
		showButtonPanel: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], 
  		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		onSelect:function(){
			var date = $(this).val();
			var arr_date = date.split("-");
			var lastDate = (new Date(arr_date[0], arr_date[1], "")).getDate();

			var now_date = new Date();
			var now_year = now_date.getFullYear();
			var now_month = now_date.getMonth();
			var now_day = now_date.getDate();

			if(arr_date[0] == now_year && eval(arr_date[1]) == (now_month+1) ){
				lastDate = now_day;
			}

			$(this).next("input[name='s_date[]']").val(arr_date[0]+"-"+arr_date[1]+"-"+lastDate);
		}
	});

	//달력
    $( ".datepicker_common_month" ).datepicker({
		changeMonth: true,
	    changeYear: true,
		dateFormat: "yy-mm",
		numberOfMonths: 2,
		showButtonPanel: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], 
  		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		onSelect:function(){
			var date = $(this).val();
			var arr_date = date.split("-");
						
			$(this).next("input[name='s_date[]']").val(arr_date[0]+"-"+arr_date[1]);
		}
	});

	$('.datepicker_click').click(function(){
		var target = $(this).attr("target");
		$('#'+target).datepicker().focus();
	});

	/*우편번호 검색*/
	$( '.searchAddress' ).click( function() {
		var addressWidth = 500; //팝업의 너비
		var addressHeight = 600; //팝업의 높이
		new daum.Postcode({
			oncomplete: function(data) {                                
				//우편번호
				$(".zipcode").val(data['zonecode']);
				//주소
				$(".address").val(data['address']);
			}
		}).open({
			left: (window.screen.width / 2) - (addressWidth / 2),
			top: (window.screen.height / 2) - (addressHeight / 2)
		});
	});

		
	//날짜 함수
	$(".dayChange").click(function(){
		var int=$(this).data('int');
		var type=$(this).data('type');
		var s_date_id=$(this).data('s_date_id');
		var e_date_id=$(this).data('e_date_id');

		var date = new Date();
		var start = new Date(Date.parse(date)-0* 1000 * 60 * 60 * 24);
		var today = new Date(Date.parse(date)-0* 1000 * 60 * 60 * 24);
		
		
		if(type=='day'){
			start.setDate(start.getDate()-int);
		}else if(type=='month'){
			start.setMonth(start.getMonth()-int);
		}else if(type=='year'){
			start.setFullYear(start.getFullYear()-int);
		}else if(type=='month_unit'){			
			var firstDayOfMonth = new Date( date.getFullYear(), (date.getMonth()-(int-1)) , 1 );
			var start = new Date( date.getFullYear(), (date.getMonth()-int) , 1 );
			var today = new Date ( firstDayOfMonth.setDate( firstDayOfMonth.getDate() - 1 ) );
			
			
			//alert(lastMonth.getFullYear() + "-" + (lastMonth.getMonth()+1) + "-" + lastMonth.getDate());
		}
		var yyyy = start.getFullYear();
		var mm = start.getMonth()+1;
		var dd = start.getDate();
		
		var t_yyyy = today.getFullYear();
		var t_mm = today.getMonth()+1;
		var t_dd = today.getDate();

		if(s_date_id){
			$("#"+s_date_id).val(yyyy+'-'+addzero(mm)+'-'+addzero(dd));
		}else{
			$("#s_date").val(yyyy+'-'+addzero(mm)+'-'+addzero(dd));
		}

		if(s_date_id){
			$("#"+e_date_id).val(t_yyyy+'-'+addzero(t_mm)+'-'+addzero(t_dd));
		}else{
			$("#e_date").val(t_yyyy+'-'+addzero(t_mm)+'-'+addzero(t_dd));
		}
		
//		$("#e_date").val(t_yyyy+'-'+addzero(t_mm)+'-'+addzero(t_dd));
		
	});

	//날짜 함수
	$(".dayChange_month").click(function(){
		var int=$(this).data('int');
		var type=$(this).data('type');
		var s_date_id=$(this).data('s_date_id');
		var e_date_id=$(this).data('e_date_id');

		var date = new Date();
		var start = new Date(Date.parse(date)-0* 1000 * 60 * 60 * 24);
		var today = new Date(Date.parse(date)-0* 1000 * 60 * 60 * 24);
		
		
		if(type=='day'){
			start.setDate(start.getDate()-int);
		}else if(type=='month'){
			start.setMonth(start.getMonth()-int);
		}else if(type=='year'){
			start.setFullYear(start.getFullYear()-int);
		}else if(type=='month_unit'){			
			var firstDayOfMonth = new Date( date.getFullYear(), (date.getMonth()-(int-1)) , 1 );
			var start = new Date( date.getFullYear(), (date.getMonth()-int) , 1 );
			var today = new Date ( firstDayOfMonth.setDate( firstDayOfMonth.getDate() - 1 ) );
			
			
			//alert(lastMonth.getFullYear() + "-" + (lastMonth.getMonth()+1) + "-" + lastMonth.getDate());
		}
		var yyyy = start.getFullYear();
		var mm = start.getMonth()+1;
		var dd = start.getDate();
		
		var t_yyyy = today.getFullYear();
		var t_mm = today.getMonth()+1;
		var t_dd = today.getDate();

		if(s_date_id){
			$("#"+s_date_id).val(yyyy+'-'+addzero(mm));
		}else{
			$("#s_date").val(yyyy+'-'+addzero(mm));
		}

		if(s_date_id){
			$("#"+e_date_id).val(t_yyyy+'-'+addzero(t_mm));
		}else{
			$("#e_date").val(t_yyyy+'-'+addzero(t_mm));
		}
		
		
	});
		

	$(".onlyNumber").keyup(function(event){
		var inputVal=$(this).val();
		$(this).val(inputVal.replace(/[^0-9-]/gi,''));

	});
});


//넘버만
$(document).on("keyup", ".number_only", function() {
	$(this).val( $(this).val().replace(/[^0-9]/gi,"") );
}); 

$(document).on("keyup", ".numeng_only", function() {
	$(this).val( $(this).val().replace( /[^0-9a-z]/gi, '' ) );
}); 

function validateEmail(sEmail){
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

	if (filter.test(sEmail)) {
		return true;
	}else{
		return false;
	}
}

function chk_all_box(obj,class_name){

	var chk_val = obj.checked;

	$("."+class_name+":not(:disabled)").prop("checked",chk_val);
}


function addzero(n){                        // 한자리가 되는 숫자에 "0"을 넣어주는 함수
    return n < 10 ? "0" + n: n;
}

function inNumber(e){
	var objTarget = e.srcElement || e.target;
	if(objTarget.type == 'text') {
		var value = objTarget.value;
		if(/[ㄱ-ㅎㅏ-ㅡ가-핳]/.test(value) || /[a-zA-Z]/.test(value)) {
			
			objTarget.value = objTarget.value.replace(/[ㄱ-ㅎㅏ-ㅡ가-핳]/g,''); // g가 핵심: 빠르게 타이핑할때 여러 한글문자가 입력되어 버린다.
			objTarget.value = objTarget.value.replace(/[a-zA-Z]/g,'');
		}
	}
}


function chkPW(){

	var pw = $("#passwd").val();
	var num = pw.search(/[0-9]/g);
	var eng = pw.search(/[a-z]/ig);
	var spe = pw.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);
	var mess="";

	if(pw.length < 8 || pw.length > 20){
		//$(".pwDiv").text("8자리 ~ 20자리 이내로 입력해주세요.");
		mess="8자리 ~ 20자리 이내로 입력해주세요.";
	}else if(pw.search(/\s/) != -1){
		//$(".pwDiv").text("비밀번호는 공백 없이 입력해주세요.");
		mess="비밀번호는 공백 없이 입력해주세요.";
	}else if(num < 0 || eng < 0 || spe < 0 ){
		//$(".pwDiv").text("영문,숫자, 특수문자를 혼합하여 입력해주세요.");
		mess="영문,숫자, 특수문자를 혼합하여 입력해주세요.";
	}else {
		//$(".pwDiv").text(''); 
		//$("#pwChk").val("1");
		mess="ok";
	}

	return mess;
}