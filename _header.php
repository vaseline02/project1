<?
@include dirname(__FILE__) . "/lib/library.php";

if(!strpos($_SERVER['PHP_SELF'],'member/login'))member_chk();

error_reporting(E_ALL&~E_NOTICE); 
//ini_set("display_errors", 1); 

$print_xls=$_REQUEST['print_xls'];

$tpl->define( array(
		'tpl'			=> $key_file
		,'header'		=> ''
		,'header_test'	=> 'outline/_header_test.htm'
		,'top_menu'	=> 'outline/_top_menu.htm'
		,'footer'		=> ''
		,'main_left'	=> 'outline/_main_left.htm'
		,'main_right'	=> 'outline/_main_right.htm'
));

if($print_xls!=1){
	$tpl->define( array(
			'header'		=> 'outline/_header.htm'
			,'footer'		=> 'outline/_footer.htm'
	));
}else{
	$no_limit='1';
}

spl_autoload_register('my_autoloader');

$my_page = explode( '/' , $_SERVER['PHP_SELF']);
$my_page = end($my_page);
$arrMobileAgent = array('iPhone','Mobile','UP.Browser','Android','BlackBerry','Windows CE','Nokia','webOS','Opera Mini','SonyEricsson','opera mobi','Windows Phone','IEMobile','POLARIS','lgtelecom','NATEBrowser','AppleWebKit');
$arrExAgent = array('Macintosh','OpenBSD','SunOS','X11','QNX','BeOS', 'OS\/2','Windows NT');

if(preg_match('/('.implode('|',$arrMobileAgent).')/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/('.implode('|',$arrExAgent).')/i', $_SERVER['HTTP_USER_AGENT'])){

	$is_mobile = "1";
	define("IS_MOBILE","mobile");
	$tpl->assign('is_mobile',$is_mobile);
}



if($print_xls==1){
	$xls_border=1;
	ini_set('memory_limit', -1);
	ini_set('max_execution_time',0);

	$arr_path = pathinfo( $_SERVER[PHP_SELF] );
	
	 //header( "Content-type: application/vnd.ms-excel" );
	// header( "Content-Disposition: attachment; filename={$arr_path[filename]}".date('Ymd').".xls" );
	// header( "Content-Description: PHP4 Generated Data");
	/*
	header( "Content-type: application/vnd.ms-excel; charset=utf-8" );
	header( "Content-Disposition: attachment; filename={$arr_path[filename]}".date('Ymd').".xls" );
	header( "Content-Description: PHP4 Generated Data" );
	*/
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

	if($_POST['search_noimg']){
		echo "<style>.td_img{width:80px;height:80px;} .td_img_sm{width:50px;height:50px;} .td_img img{height:70px;width:70px}";
	}

	echo "<style>br{mso-data-placement:same-cell;} .text_type{ mso-number-format:'\@'}</style>";
}else{	
	$xls_border=0;
}

/*주문 검색값 물고다니기*/
if($_POST['order_search_mall']){
	setcookie("order_search_mall", $_POST['order_search_mall'], time() + 3600, "/");
}else{
	setcookie("order_search_mall", "", 0, "/");
}

if($_POST['order_search_sdate']){
	setcookie("order_search_sdate", $_POST['order_search_sdate'], time() + 3600, "/");
}else{
	setcookie("order_search_sdate", "", 0, "/");
}

if($_POST['order_search_edate']){
	setcookie("order_search_edate", $_POST['order_search_edate'], time() + 3600, "/");
}else{
	setcookie("order_search_edate", "", 0, "/");
}

if($_POST['order_search_ordno']){
	setcookie("order_search_ordno", $_POST['order_search_ordno'], time() + 3600, "/");
}else{
	setcookie("order_search_ordno", "", 0, "/");
}

$_POST['order_search_mall']=$_REQUEST['order_search_mall'];
$_POST['order_search_sdate']=$_REQUEST['order_search_sdate'];
$_POST['order_search_edate']=$_REQUEST['order_search_edate'];
$_POST['order_search_ordno']=$_REQUEST['order_search_ordno'];
/*주문 검색값 물고다니기 end*/
if($_POST['search_noimg'])$checked['search_noimg']['1']='checked';


/*권한*/
if($_SESSION['sess']['h_level']>='150' || in_array($_SESSION['sess']['m_no'],array('120','24'))){$h_control['memu']=1;}
if($_SESSION['sess']['h_level']>='50'){$h_control['order']=1;}//주문단 컨트롤권한
if($_SESSION['sess']['h_level']>='60'){$h_control['calcu']=1;}//수익률 관련설정(업체관리,몰관리 등) 컨트롤 권한

if($_SESSION['sess']['h_level']=='200' || in_array($_SESSION['sess']['m_no'],array('75','50','24','28'))){$h_control['md_manager']=1;}

/*h제외..*/
//if(in_array($_SESSION['sess']['m_no'],array('24','136','100','90','97','69'))){$h_control['test_hide']=1;}
// 영업본부EC팀 딜정보 보일수있게 수정요청 03-04 곽두봉
if(in_array($_SESSION['sess']['m_no'],array('24','136','100','90','97','69','84','85','99','102','110','114','117','126','142'))){$h_control['test_hide']=1;}

//페이지 이동로그
if($_SESSION['sess']['m_no']){
		$postArray="";

	foreach($_POST as $pk=>$pv){
		if($pv){
			$pvarray="";
			if(is_array($pv)){				
				foreach($pv as $ppv){
					$pvarray[]=$ppv;
				}
			}else{
				$pvarray[]=$pv;
			}
			$postArray[]=$pk."=".implode(",",$pvarray);
		}
	}
	if($postArray)$postValue=@implode("|",$postArray);
	
	$log_qry="insert into log_page set
	m_no='".$_SESSION['sess']['m_no']."'
	,name='".$_SESSION['sess']['name']."'
	,page='".$_SERVER['PHP_SELF']."'
	,getlog='".$_SERVER['QUERY_STRING']."'
	,postlog='".addslashes($postValue)."'
	,servername='".$_SERVER['SERVER_NAME']."'
	,remoteaddr='".$_SERVER['REMOTE_ADDR']."'
	,reg_date=now()
	";
	
	$db->query($log_qry);
	
}

?>