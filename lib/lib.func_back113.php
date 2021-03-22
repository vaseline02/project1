<?
##기본설정
define('FILE_DIR', '../tmpfiles/');

function my_autoloader($class) {
    include '../lib/' . $class . '.class.php';
}

function login_chk(){

	global $sess;

	if($sess['m_id']){
		msg("현재 로그인 상태입니다. ","../main/index.php");
	}
}

function member_chk(){

	global $sess;

	if(!$sess['m_id']){
		msg("로그인이 필요합니다. ",'../member/login.php');
	}

	//등급별 접속제한
	if( !strpos($_SERVER['PHP_SELF'],"member/logout") ){
		if($sess['level']=='50' && !strpos($_SERVER['PHP_SELF'],"wholesale") ){
			msg("접근 권한이 없습니다. ",'../wholesale/main.php');
		}
		/*
		if($sess['level']<'50' && strpos($_SERVER['PHP_SELF'],"order") ){
			msg("접근 권한이 없습니다. ",-1);
		}
		*/
		
	}
}


$glb_sabang_api_url="http://erptest2.timemecca.com/sabang_xml";
$pageName=reset(explode(".",end(explode("/",$_SERVER['PHP_SELF']))));


/**/
/*주문단계중 재고 처리전단계*/
$order_before_stock_step=array('0','1','2');

function img_url($link,$brand_img_folder,$img_name='',$goodsnm){

	global $cfg,$print_xls;

	if(!$img_name)$img_name=$goodsnm;
	if($print_xls)$width_excel="width='72'";	

	return "<img ".$width_excel." class='td_img' src='".$cfg['img_url'].$link."/".$brand_img_folder."/".$img_name.".jpg' alt=''>";
}

### 시간 측정
function get_microtime($old,$new)
{
	$old = explode(" ", $old);
	$new = explode(" ", $new);
	$time['msec'] = $new[0] - $old[0];
	$time['sec']  = $new[1] - $old[1];
	if($time['msec'] < 0) {
		$time['msec'] = 1.0 + $time['msec'];
		$time['sec']--;
	}
	$ret = $time[sec] + $time[msec];
	return $ret;
}

### GET/POST변수 자동 병합
function getVars($except='', $request='')
{
	if ($except) $exc = explode(",",$except);
	if ( is_array( $request ) == false ) $request = $_REQUEST;
	foreach ($request as $k=>$v){
		if (isset($_COOKIE[$k])) continue; # 쿠키 제외(..sunny)
		if (!@in_array($k,$exc) && $v!=''){
			if (!is_array($v)) $ret[] = "$k=".urlencode(stripslashes($v));
			else {
				$tmp = getVarsSub($k,$v);
				if ($tmp) $ret[] = $tmp;
			}
		}
	}
	if ($ret) return implode("&",$ret);
}

function getVarsSub($key,$value)
{
	foreach ($value as $k2=>$v2){
		if ($v2!='') $ret2[] = $key."[".$k2."]=".urlencode(stripslashes($v2));
	}
	if ($ret2) return implode("&",$ret2);
}


function msg($msg,$code=null,$target='')
{
	//echo '<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">';
	echo "<script>alert('$msg')</script>";
	switch (getType($code)){
		case "null":
			return;
		case "integer":
			if ($code) echo "<script>history.go($code)</script>";
			exit;
		case "string":
			if ($code=="close") echo "<script>window.close()</script>";
			else go($code,$target);
			exit;
	}
}


function MsgViewCloseReload($Msg)
{
	  echo "<script language=JavaScript>
			alert('$Msg');
			opener.location.reload();
			self.close();
			</script>";
	return true;
}


function MsgReload($Msg,$code=null)
{
	echo "<script language=JavaScript>
		alert('$Msg');
		opener.location.reload();
		</script>";
	switch (getType($code)){
		case "null":
			return;
		case "integer":
			if ($code) echo "<script>history.go($code)</script>";
			exit;
		case "string":
			if ($code=="close") echo "<script>window.close()</script>";
			else go($code,$target);
			exit;
	}
	return true;
}

### 페이지 이동
function go($url,$target='')
{
	if ($target) $target .= ".";
	//echo '<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">';
	echo "<script>{$target}location.replace('$url')</script>";
	exit;
}

function tydebug($str){

		echo "<pre style='background-color:black;color:green;padding:0px;z-index:99999999999;margin:80px 20px 20px'>";
		print_r($str);
		echo "</pre>";

}


function tydebug1($str){
		
		if($_SESSION['sess']['m_id']=='naskka' || $_SESSION['sess']['m_id']=='jkm9424'){
		echo "<pre style='background-color:black;color:green;padding:0px;z-index:99999999999;margin:80px 20px 20px'>";
		print_r($str);
		echo "</pre>";
		}
}



function get_random_string($len = 10, $type = '') {
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numeric = '0123456789';
    $special = '`~!@#$%^&*()-_=+\\|[{]};:\'",<.>/?';
    $key = '';
    $token = '';
    if ($type == '') {
        $key = $lowercase.$uppercase.$numeric;
    } else {
        if (strpos($type,'09') > -1) $key .= $numeric;
        if (strpos($type,'az') > -1) $key .= $lowercase;
        if (strpos($type,'AZ') > -1) $key .= $uppercase;
        if (strpos($type,'$') > -1) $key .= $special;
    }
    for ($i = 0; $i < $len; $i++) {
        $token .= $key[mt_rand(0, strlen($key) - 1)];
    }
    return $token;
}


### 회원로그인 로그 남기기
function member_log( $m_id ){

	$log_msg = "";
	$log_msg .= date('Y-m-d H:i:s') . "\t";
	$log_msg .= $_SERVER['REMOTE_ADDR'] . "\t";
	$log_msg .= $m_id . "\n";

	error_log($log_msg, 3, $tmp = dirname(__FILE__) . "/../log/login_" . date('Ym') . ".log");
	@chmod( $tmp, 0707 );
}

###엑셀 읽기. 파일 클래스 필요.
function excel_read($unlink='',$start_row='2'){
	
	include "../Classes/PHPExcel.php";

	$objPHPExcel = new PHPExcel();

	// 엑셀 데이터를 담을 배열을 선언한다.
	$allData = array();

	// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
	//$filename = iconv("UTF-8", "EUC-KR", $_FILES['excelFile']['name']);

	$file=new file("../tmpfiles");
	$file_info=$file->upFiles();

	$filename=$file_info['excelFile'][0]['v_file'];
	$fileExt=$file_info['excelFile'][0]['ext'];

	try {

	   // 업로드한 PHP 파일을 읽어온다.
	   //$objReader = PHPExcel_IOFactory::createReader($inputFileType);	
	   $objReader = PHPExcel_IOFactory::createReaderForFile(FILE_DIR.$filename);	
	   //읽기전용으로 설정
	   $objReader->setReadDataOnly(true);
	   
	   $objPHPExcel=$objReader->load(FILE_DIR.$filename);
	   // $sheetsCount = $objPHPExcel -> getSheetCount();
		
		// 시트Sheet별로 읽기
		//for($sheet = 0; $sheet < $sheetsCount; $sheet++) {
			  $sheet=0;	
			  $objPHPExcel -> setActiveSheetIndex($sheet);
			  $activesheet = $objPHPExcel -> getActiveSheet();

			  $highestRow = $activesheet -> getHighestRow();             // 마지막 행
			  $highestColumn = $activesheet -> getHighestColumn();    // 마지막 컬럼

			  // 한줄읽기
			  for($row = $start_row; $row <= $highestRow; $row++) {

				// $rowData가 한줄의 데이터를 셀별로 배열처리 된다.
				$rowData = $activesheet -> rangeToArray("A" . $row . ":" . $highestColumn . $row, NULL, TRUE, FALSE);
				
				// $rowData에 들어가는 값은 계속 초기화 되기때문에 값을 담을 새로운 배열을 선안하고 담는다.
				//if($rowData[0][0])$allData[$row] = $rowData[0];
				$allData[$row] = $rowData[0];
			  }
				
			  if($unlink=='unlink')unlink(FILE_DIR.$filename);
			  return $allData;
		//}
	} catch(exception $exception) {
		echo $exception;
	}

}

//쿼리 파라미터값 형식생성( 선택적으로 $key에 해당하는 값들을 배열로 지정. member_reg.php 참고)
function get_param($key,$type='_POST'){

	if(is_array($key)){
		
		foreach($key as $v){
			//$data[":".$key]=if($type=='post')$_POST['']:$_GET[''];
			$data[":".$v]=$_REQUEST[$v];
		}

		return $data;
	}
}


//상단 서치박스에서 검색한 값으로 where절 만들기.
function get_search_where(){
	
	if($_REQUEST['select_detail']){
		foreach($_REQUEST['select_detail'] as $k=>$v){
			if($v){
				$where[]="gi.".$k."='".$v."'";	
				$selected['detail'][$k][$v]='selected';
			}
		}

	}

	if($_REQUEST['s_paste']){
		$s_paste=paste_to_arr($_REQUEST['s_paste']);
		if($s_paste){
			$s_paste_imp=implode("','",$s_paste);
			$where[]="g.goodsnm in ('".$s_paste_imp."')";	
		}
	}
	
	
	if($_REQUEST['s_view_hidden']!='1'){
		$where[]="g.hidden_yn='n'";	
		
	}else{
		$checked['s_view_hidden']['1']='checked';
	}
	
	//if($_POST['s_stock_cnt'])$where[]="gcl.cur_cnt='".$_POST['s_brand']."'";	

	if($_REQUEST['s_brand'])$where[]="b.brandnm like '".$_REQUEST['s_brand']."%'";
	if($_REQUEST['s_model'])$where[]="g.goodsnm like '".$_REQUEST['s_model']."%'";
	
	If($_REQUEST['s_img_step']){
		$where[]="g.img_step in('".implode("','",$_REQUEST['s_img_step'])."')";
		foreach($_REQUEST['s_img_step'] as $v)$checked['s_img_step'][$v]='checked';
	}

	if($_REQUEST['search_noimg'])$checked['search_noimg']['1']='checked';
	if($_REQUEST['chk_invoice'])$checked['chk_invoice']['1']='checked';

	$data['where']=$where;
	$data['checked']=$checked;
	$data['selected']=$selected;
	
	return $data;
}


//붙여넣기 배열로 변경. 붙여넣기검색시 쿼리결과를 재정렬할때 사용.
function paste_to_arr($paste){
	
	if($paste){
		$s_paste=explode("\n",$paste);
		$s_paste=array_map("trim",$s_paste);
		$s_paste=array_filter($s_paste);	
	}
	return $s_paste;
}

function get_codedata($type='',$v2='',$no=''){

	global $db;
	$where='';

	if($type){
		$where.=" and type=:type";
		$param[':type']=$type;
	}

	if($v2){
		if($v2=='main'){
			$where.=" and v4=1";
		}else{
			$where.=" and v2=:v2";
			$param[':v2']=$v2;
		}
	}
	if($no){
		$where.=" and no=:no";
		$param[':no']=$no;
	}


	if($type=='place')$orderby="order by v3";
		

	$qry="select no,type,cd,v,v2,v3 from codedata where 1 ".$where." ".$orderby;
	$res=$db->query($qry,$param);

	return $res->results;
}

//place_type별 불러오기
function get_codedata_type($type='',$v2='',$no='', $place_type=''){
   
	global $db;
	$where='';

	if($type){
		$where.=" and type=:type";
		$param[':type']=$type;
	}

	if($v2){
		if($v2=='main'){
			$where.=" and v4=1";
		}else{
			$where.=" and v2=:v2";
			$param[':v2']=$v2;
		}
	}
	if($no){
		$where.=" and no=:no";
		$param[':no']=$no;
    }
    
    if($place_type){
        $where.=" and place_type=:place_type";
		$param[':place_type']=$place_type;
    }


	$orderby="order by place_type, v*1";
		

	$qry="select no,type,cd,v,v2,v3,place_type from codedata where place_type!='' ".$where." ".$orderby;
    $res=$db->query($qry,$param);
    foreach($res->results as $v){
        $data[$v['place_type']][]=$v;
       
    }
    
	return $data;

}

function now_stock($goodsno,$loc){
	
	global $db;

	if(is_array($loc)){
		foreach($loc as $v)$column[]="codeno_".$v;
		$column=implode(",",$column);
	}else $column="*";

	$qry="select ".$column." from goods_cnt_loc where 1 and goodsno =:goodsno";
	$param[":goodsno"]=$goodsno;
	$res=$db->query($qry,$param);

	return $res->results['0'];
}

//column : order_list와 연결시킬수있는 컬럼  (column='' : order_list랑 매칭시킬수없음 , column='no' : order_list자체)
$arr_io_type['order_list']=array('column'=>'no','type'=>array('reserve','order','order_cancel','order_step_back'));
$arr_io_type['cs_detail']=array('column'=>'order_list_no','type'=>array('cs_hold','cs_hold_cancel','cs_return','cs_exchange','cs_exchange_b','re_order','repairing'));
$arr_io_type['order_hold_list']=array('column'=>'order_list_no','type'=>array('order_hold','order_hold_cancel'));
$arr_io_type['stock_list']=array('column'=>'','type'=>array('stock','move','stock_change','stock_deficient'));
$arr_io_type['other_cost_calcu']=array('column'=>'','type'=>array('return'));
$arr_io_type['reserve_list']=array('column'=>'reference_no','type'=>array('reserve_release'));
$arr_io_type['stock_quick']=array('column'=>'','type'=>array('quick_move'));
$arr_io_type['cs_bad']=array('column'=>'order_list_no','type'=>array('repaired'));
/*

*/
/*
stock 입고 - 입고예정에 재고추가, 수정,삭제에 의한 감소. (stock_list)
move  이동 - 총재고 변동없음. 로그두개 (stock_list)
reserve 예약 - move와 동일 (order_list)
reserve_release 예약해제 (reserve_list)
return 외부발송완료목록 국내입고반품 반환 (other_cost_calcu)
order 주문 (order_list)
order_cancel 주문취소 -주문처리 단계에서 주문취소. (order_list)
order_hold 발송대기 - 묶음 주문 중 일부가 품절일때 cs처리하기전에 재고를 잡아둔 주문상태. 발송대기 재고위치로 재고이동해둔 상태. 로그두개. 재고변동없음 (order_hold_list)
order_hold_cancel - 발송대기재고 원복 (order_hold_list)
order_d_hold 보류 
order_step_back - 전단계로 이동 4에서는 1로갈때 남음. (order_list)
cs_hold - cs접수 (cs_detail)
cs_hold_cancel - cs접수 철회 (cs_detail)
cs_return - cs반품 처리완료 (cs_detail)
cs_exchange - cs교환 발송완료 (cs_detail)
cs_exchange_b - cs교환 처리완료 (cs_detail)
re_order - 품절cs건 재주문 (cs_detail)
stock_yn-> 현제 사용안하지만 나중에 재고차감여부가 변경될경우를 위해 남겨놈
repairing -> cs반품시 하자로인한 재고 차감 (cs_detail)
repaired -> 하자 수리완료로인한 재고 등록 (cs_bad)
stock_change -> 재고조정 (stock_list)
stock_deficient -> 입고량부족시 예약제고에서 차감 (stock_list)
quick_move -> 퀵시트(stock_quick)
*/

//외부발송건중에 반품은 우리가 받는 것들이 있어서 우선 디비에 수동으로 넣어주고 메모에 외부발송 반품입고 라고 남김
function stock_io($io_type,$goodsno,$goodsnm,$cnt,$reference_no,$reference_page,$loc_f=0,$loc_b=0,$stock_yn='y'){	
	
	global $db,$sess,$cfg;
	
	
	if($io_type && $goodsno){
		
		/*
		if($cnt<0){
			
			$qry="select sum(cur_cnt) sumN from timemecca_test2.stock where m_no=:goodsno and cur_cnt>0 and place!='입고 예정'";
			$res=$db->query($qry,array(":goodsno"=>$goodsno));

			if($res->results['0']['sumN'] < abs($cnt)){
				throw new Exception("기존db에 재고가 부족하여 재고를 차감할수 없습니다.개발팀에 문의해주세요. ".$goodsno." ".$goodsnm." ".$reference_no, 1); 
				die;
			}
		}
		*/
		$qry="select stock_yn from goods where no=:goodsno";
		$res=$db->query($qry,array(":goodsno"=>$goodsno));
		$stock_yn=$res->results[0]['stock_yn'];
		
		$loc_cnt='0';
		$cur_cnt='0';

		if($stock_yn=='y'){
			$gcl=now_stock($goodsno);
			
			$code_col="codeno_".$loc_f;
			$loc_cnt=$gcl[$code_col] + $cnt;
			$cur_cnt=$gcl['cur_cnt'] + $cnt;
			
			if($loc_cnt<0 || $cur_cnt<0){ 
				throw new Exception($loc_f.'-재고부족 : '.$goodsno.":".$goodsnm.",총재고:".$gcl['cur_cnt'].",loc재고:".$gcl[$code_col].",요청:".$cnt, 1); 
			}
		}

		$qry="insert into stock_io_log set
		io_type=:io_type
		,goodsno=:goodsno
		,goodsnm=:goodsnm
		,cnt=:cnt
		,loc_cnt=:loc_cnt
		,cur_cnt=:cur_cnt
		,reference_no=:reference_no
		,reference_page=:reference_page
		,loc_f=:loc_f
		,loc_b=:loc_b
		,stock_yn=:stock_yn
		,m_no=:m_no
		,reg_date=now()
		";
		unset($param);
		$param[':io_type']=$io_type;
		$param[':goodsno']=$goodsno;
		$param[':goodsnm']=$goodsnm;
		$param[':cnt']=$cnt;
		$param[':loc_cnt']=$loc_cnt;
		$param[':cur_cnt']=$cur_cnt;
		$param[':reference_no']=$reference_no;
		$param[':reference_page']=$reference_page;
		$param[':loc_f']=$loc_f;
		$param[':loc_b']=$loc_b;
		$param[':stock_yn']=$stock_yn;
		$param[':m_no']=$sess['m_no'];

		$db->query($qry,$param);

		
		if($stock_yn=='y'){
			$qry="update goods_cnt_loc set
			cur_cnt=:cur_cnt
			,".$code_col."=:loc_cnt
			where goodsno=:goodsno
			";	
			unset($param);
			$param[':cur_cnt']=$cur_cnt;
			$param[':loc_cnt']=$loc_cnt;
			$param[':goodsno']=$goodsno;

			$db->query($qry,$param);
		}
		
		//return $qry;

		//재고 변동시 기존디비 임시 재고마춤처리. 도메페이지 기능을 유지하기 위해서.
		/*
		if( 
			($io_type!='move' || $loc_b==3)  
			&& ($io_type!='reserve')  
			&& ($io_type!='order_hold' || $cnt<0) 
			&& ($io_type!='cs_hold' || $cnt<0) 
			&& ($io_type!='cs_hold_cancel' || $cnt>0) 
			&& ($io_type!='order_hold_cancel' || $cnt>0) 
		    && $loc_f!=$cfg['hold_loc']
			&& $loc_f!='3'	
			&& $stock_yn=='y' ){
			
			if($cnt>0 ){

				$qry="select order_cost from order_list where no=:no";
				$res=$db->query($qry,array(":no"=>$reference_no));
				
				$order_cost=explode('^',$res->results['0']['order_cost']);
				$order_cost=$order_cost['1'];

				if(!$order_cost){
					$qry="select cost from stock_list where goodsno=:goodsno order by no desc limit 1";
					$res=$db->query($qry,array(":goodsno"=>$goodsno));

					$order_cost=$res->results['0']['cost'];
				}
				
				$mall_name=get_codedata('place','1',$loc_f);

				$qry="INSERT INTO timemecca_test2.stock(m_no, place, io, customer, cnt,cur_cnt, cost, memo, u_id) values (:goodsno,:loc_f,'IN',:io_type,:cnt,:cur_cnt,:cost,'신규erp재고 공유용',:u_id)
				";
				unset($param);
				$param[':goodsno']=$goodsno;
				$param[':loc_f']=$mall_name['0']['cd'];
				$param[':io_type']=$io_type;
				$param[':cnt']=$param[':cur_cnt']=$cnt;
				$param[':cost']=$order_cost;
				$param[':u_id']=$sess['m_no'];

				$db->query($qry,$param);
					
			}else if($cnt<0){
				$cnt=abs($cnt);

				$qry="select no,cur_cnt from timemecca_test2.stock where m_no=:goodsno and cur_cnt>0 and place!='입고 예정' order by save_time";
				$res=$db->query($qry,array(":goodsno"=>$goodsno));

				foreach($res->results as $v){
					
					if($cnt>0){
						if($v['cur_cnt']>=$cnt){
							$cur_cnt=$v['cur_cnt']-$cnt;
		
							$cnt=0;
						}else{
							$cur_cnt=0;
							$cnt-=$v['cur_cnt'];
						}
				
						$uqry="update timemecca_test2.stock set cur_cnt=:cur_cnt where no=:no";
						$db->query($uqry,array(":cur_cnt"=>$cur_cnt,":no"=>$v['no']));
					}
				}
				
				//if($cnt>0){ // 차감해야 하는 수량이 남는다면.
				//	throw new Exception("기존db에 재고가 부족하여 재고를 차감할수 없습니다. ".$goodsno." ".$goodsnm, 1); 
				//}
				

			}

		}
		*/
		
	}
}


function get_mall_info($state='',$no=''){

	global $db;

	if($state){
		$add_where=" and state=:state ";
		$param[':state']=$state;
	}

	if($no){
		$add_where.=" and no=:no ";
		$param[':no']=$no;
	}

	$qry="select * from mall_list where upload_form_type!='' ".$add_where." 
	order by 
	CASE
	WHEN upload_form_type = '셀피아'
	THEN 1
	WHEN mall_name = '타임메카'
	THEN 2
	WHEN mall_name = '스토어팜'
	THEN 3
	WHEN upload_form_type = 'B2B'
	THEN 4
	WHEN upload_form_type = '오피셜'
	THEN 5
	WHEN upload_form_type = '사방넷'
	THEN 6
	WHEN upload_form_type = '방송'
	THEN 7
	WHEN upload_form_type = '자체'
	THEN 8
	WHEN upload_form_type = '기타'
	THEN 100
	ELSE 9
	END , mall_name
	";

	$res=$db->query($qry,$param);

	return $res->results;
}




function chk_upload_form_type($mallnm){

	global $db;


	$qry="select upload_form_type from mall_list where mall_name=:mall_name
	";
	$param[':mall_name']=$mallnm;
	$res=$db->query($qry,$param);

	return $res->results['0']['upload_form_type'];
}





function get_brand_info($brandnm='',$no='', $type=''){

	global $db;

	if($brandnm){
		$add_where=" and brandnm=:brandnm ";
		$param[':brandnm']=$brandnm;
	}

	if($no){
		$add_where.=" and no=:no ";
		$param[':no']=$no;
	}

	if($type){
		$add_where.=" and type in ('".implode("','",$type)."') ";
	}

	$qry="select * from brand where 1=1 ".$add_where." order by brandnm ";
	

	$res=$db->query($qry,$param);

	return $res->results;
}


function get_cate_info($depth_1='000',$depth_2='000',$depth_3='000',$depth_4='000'){

    global $db;
    $cate_array=array();
    $qry="select c.* from category c where 1=1";
    if($depth_1!='000')	$qry.=" and c.depth_1='".$depth_1."'";
    if($depth_2!='000')	$qry.=" and c.depth_2='".$depth_2."'";
    if($depth_3!='000') $qry.=" and c.depth_3='".$depth_3."'";
    if($depth_4!='000') $qry.=" and c.depth_4='".$depth_4."'";
    $qry.=" order by c.depth_1,c.depth_2,c.depth_3,c.depth_4,c.sort";
    $res=$db->query($qry,$param);

    foreach($res->results as $v){
        
        if($v['depth_2']=='000'){
            $cate_array[$v['depth_1']]['catenm']=$v['catenm'];
        }else{
            if($v['depth_3']=='000'){
                $cate_array[$v['depth_1']][$v['depth_2']]['catenm']=$v['catenm'];
            }else{
                if($v['depth_4']=='000'){
                    $cate_array[$v['depth_1']][$v['depth_2']][$v['depth_3']]['catenm']=$v['catenm'];
                }else{
                    $cate_array[$v['depth_1']][$v['depth_2']][$v['depth_3']][$v['depth_4']]['catenm']=$v['catenm'];
                }
            }
        } 
    }

    # 출력샘플    
    // foreach($cate_array['001'] as $kk=>$vv){
    //     if(is_array($vv)){
    //         tydebug($kk);
    //         tydebug($vv['catenm']);
    //     } 
    // }

    return $cate_array;
}



function request_curl($url, $is_post=0, $data=array(), $header=null,$userpwd=null) {
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL,$url);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_SSLVERSION,1);
	curl_setopt ($ch, CURLOPT_POST, $is_post);
	if($is_post) {
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt ($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt ($ch, CURLOPT_COOKIEFILE , '/tmp/mp_cookies.txt');
	curl_setopt ($ch, CURLOPT_TIMEOUT, 300);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_MAXREDIRS , 20);

	if($header) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
	if($userpwd){
		curl_setopt($ch, CURLOPT_USERPWD , $userpwd);
	}
	$result[0] = curl_exec ($ch);
	$result[1] = curl_errno($ch);
	$result[2] = curl_error($ch);
	$result[3] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
	return $result;
}


function err_log( $VarName ,$contents,$contents2 ,$file_id = '' ){
	
	$arr_chk = explode(" ",trim( $contents ) );
	if( strtolower($arr_chk[0]) != "select"){
	
		$filename = dirname(__FILE__)."/../logs/debug".date("ymd")."_".$file_id.".txt";
		//$filename = "/ukk/logs/debug".date("ymd")."_".$file_id.".txt";
		
		$fileHandler = fopen($filename , "a");
		fwrite ($fileHandler, date("y-m-d H:i:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$_SESSION['sess']['m_id'] ."\t".$_SERVER['HTTP_USER_AGENT']
			."\r\n"		.$_SERVER['PHP_SELF']	."\t"	.$_SERVER['HTTP_REFERER'] 	."\t".$VarName."\t" );
		@fwrite ($fileHandler, "\r\n");
		@fwrite ($fileHandler, $contents );
		@fwrite ($fileHandler, "\r\n");
		@fwrite ($fileHandler, implode(":",$contents2) );
		@fwrite ($fileHandler, "\r\n");
		@fclose ($fileHandler);
		//chown($filename,'apache');
	}
}

function market_solution_code($sol_type='sabangnet'){
	
	global $db;
	
	$qry="select * from market_solution_code where sol_type=:sol_type";
	$res=$db->query($qry,array(":sol_type"=>$sol_type));

	foreach($res->results as $v){
		
		$data[$v['name']]=$v['code'];
	}

	return $data;
}

function market_solution_prop($sol_type='sabangnet'){
	
	global $db;
	
	$qryi="select * from market_solution_prop where sol_type=:sol_type";
	$resi=$db->query($qryi,array(":sol_type"=>$sol_type));

	

	foreach($resi->results as $v){
		$data[$v['code']][$v['prop_no']]=($v['col_name'])?$v['col_name']:$v['def_val'];
	}
	return $data;
}

function country_code($kr='',$en=''){
	global $db;
	
	$country=($kr)?$kr:$en;

	if($country){
		if($kr)$add_where=' and country=:country';
		if($en)$add_where=' and country_en=:country';
		$qry="select code,country,country_en from country_code where 1 ".$add_where." ";
		$res=$db->query($qry,array(":country"=>$country));

		return $res->results;
	}
}

function nameMasking($name){
    $middleMasking=preg_replace('/.(?=.$)/u','*',$name); // 홍○동 
    $endMasking=preg_replace('/.(?!.)/u','*',$name); // 홍길○
    $data="(
        concat(ol.buyer,ol.receiver) like '%".$name."%' 
        or concat(ol.buyer,ol.receiver) like '%".$middleMasking."%' 
        or concat(ol.buyer,ol.receiver) like '%".$endMasking."%'
        )";

    return $data;
}

function orderType($no){
	global $db;

	$oqry="select copy_seq, reorder_yn from order_list where no='".$no."'";
	$ores=$db->query($oqry);
	$odata=$ores->results[0];
	
	$oText='';
	
	if($odata['copy_seq']>0)$oText.=' 복사본';
	if($odata['reorder_yn']=='y')$oText.=' 품절재주문';

	return $oText;
	//tydebug($no);
	//tydebug($odata);
}

//택배사 조회 쿼리
function get_delivery_info(){
	global $db;
	$delivery_sql="select * from delivery_info where status='y' order by 
	CASE WHEN code='EPOST' THEN 1 WHEN code='CJGLS' THEN 2 WHEN code='DIRECT' THEN 3 ELSE 4 END";
	$delivery_reg=$db->query($delivery_sql);
	foreach($delivery_reg->results as $v){
		$delivery_data[$v['code']]=$v;
	}

	return $delivery_data;

}

//sms 발송
function sms_send($title, $contents, $mobile, $etc_code='', $etc_no=0, $send_number=0, $order_no=''){
    global $db;
    
    if(!$title){
        msg("제목이 존재하지않습니다.",$return_url);	
        return false;
    }

    if(!$contents){
        msg("제목이 존재하지않습니다.",$return_url);	
        return false;
    }

    if(!$mobile){
        msg("발송번호가 존재하지않습니다.",$return_url);	
        return false;
    }
    
    $mobile=str_replace("-","",$mobile);
    $response="";
     $url = '221.139.14.138/APIV2/sms_send';
     $apiParam = [
         'api_key' => 'ZOUYPNTUQYK0608', //key
         'msg' => $contents, //내용
         'subject' => $title, //제목sms_send
         'callback' => '15998246', //발신자번호
         'dstaddr' => $mobile, //수신자번호
         'send_reserve' => '0', //즉시발송,예약발송 선택 0:즉시발송,1:예약발송
         'call_block' => '0' //080수신여부 0:수신거부미사용, 1:수신거부 사용
     ];
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiParam));
     $response = curl_exec($ch);
    
     curl_close($ch);

    $qry="insert into sms_send_log set 
    title=:title
    ,contents=:contents
    ,mobile=:mobile
    ,page=:page
    ,etc_code=:etc_code
    ,etc_no=:etc_no
    ,send_number=:send_number
    ,return_code=:return_code
    ,order_no=:order_no
    ,admin_no=:admin_no
    ,admin_name=:admin_name
    ,reg_date=now()
	";
	
    $param[':title']=$title;
    $param[':contents']=$contents;
    $param[':mobile']=$mobile;
    $param[':page']=$_SERVER['REQUEST_URI'];
    $param[':etc_code']=$etc_code;
    $param[':etc_no']=$etc_no;
    $param[':send_number']=$send_number;
    $param[':return_code']=$response;
    $param[':order_no']=$order_no;
    $param[':admin_no']=$_SESSION['sess']['m_no'];
    $param[':admin_name']=$_SESSION["sess"]["name"];

    $db->query($qry,$param);

    return true;    
}
//문자 남은 수량 확인 api
function sms_coin(){
    $url = '221.139.14.138/APIV2/remainCoin';
    $apiParam = [
        'api_key' => 'ZOUYPNTUQYK0608',
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiParam));
    $response = curl_exec($ch);
    curl_close($ch);

    $response_decode=json_decode($response);
    return $response_decode->remainCoin;
}


function inarr_param($arr_inqry){ //배열을 받아 키와 파라미터 형태로 변경해줌.
	
	$inarr = array_combine(
		array_map(function($i){ return ':id'.$i; }, array_keys($arr_inqry)),
		$arr_inqry
	);

	return $inarr;
}

function getEntnmToMallname($mall_name){

	$mall_name=str_replace("셀피아","",$mall_name);
	$mall_name=str_replace("오피셜","",$mall_name);

	$mall_name=trim($mall_name);

	return $mall_name;
}


function get_time() { $t=explode(' ',microtime()); return (float)$t[0]+(float)$t[1]; }
/*
		$start = get_time();
		$end = get_time();
		$time = $end - $start;
		echo number_format($time,6) . " 초 걸림";
*/

function order_step_view($v){ //상품위치 노출

	global $cfg_order_step2,$cfg_order_step_link,$cfg_order_step_view;

	$link_qrystr='';
	if($v['step2']>40){
		$val['step_lv']='취소주문';
		$val['step_lv_link']=$cfg_order_step_link['41']['0'];
	}else{
		
		$val['step_lv']=$cfg_order_step_view[$v['step']][$v['step2']];
		$val['step_lv_link']=$cfg_order_step_link[$v['step']][$v['step2']];
		
		
		if($v['step']=='1' && $v['bundle']>0){
			$val['step_lv']=$cfg_order_step_view[$v['step']]['1'];
			$val['step_lv_link']=$cfg_order_step_link[$v['step']]['1'];
		}else if($v['step']=='1' && $v['bundle']==0){
			$val['step_lv']=$cfg_order_step_view[$v['step']]['0'];
			$val['step_lv_link']=$cfg_order_step_link[$v['step']]['0'];
		}

		if($v['step']=='2'){
			$add_nm='';
			if($v['bundle']>0){
				$link_qrystr.="&gubunb=1";
				$add_nm="(묶음)";
			}else{
				$link_qrystr.="&gubunb=0";
				$add_nm="(단품)";
			}
			
			if($v['step2']=='0'){
				if($v['reg_date']==date('Y-m-d') || $v['date']==date('Y-m-d') ){
					$link_qrystr.="&tday=1";
					
				}else{
					$link_qrystr.="&tday=2";
					$val['step_lv']="처리중 품절";
				}
			}
		}

		if($v['step']=='4'){
			$add_nm='';
			if($v['deli_codeno']==1){
				$link_qrystr.="&deli_codeno=1";
				$add_nm='(사무실)';
			}else if($v['deli_codeno']==125){
				$link_qrystr.="&deli_codeno=125";
				$val['step_lv']="재고확보요청";
				$add_nm='(원마)';
			}else{
				$link_qrystr.="&deli_codeno=51";
				$add_nm='(3PL)';
			}

			if($v['step2']=='2')$add_nm='';
		}

		if($v['step']=='5'){
			//$val['step_lv']=$v['courier_code']."<br/>".$v['invoice'];
			$val['step_lv']="출고완료";
		}
		
		if($add_nm)$val['step_lv'].=$add_nm;
		$val['step_lv_link'].=$link_qrystr;
	}

	return $val;
}


//주문서에 넘어오는 모델명 추출 패턴
function filter_goodsnm($val){
	
	$val=end(explode("=",$val));
	//$val=end(explode(":",$val));
	$val=trim($val);
	if(preg_match("/선택[0-9]{1,3}\.\s*/",$val)) $gname=end(preg_split("/선택[0-9]{1,3}\.\s*/",$val));
	else  $gname=$val;

	return $gname;
}



/*사은품*/	
function goods_freegift(){
	
	global $db;
	
	$qry="select gf.*,g.goodsnm giftnm from goods_freegift gf
	join goods g on gf.gift_goodsno = g.no
	where gf.view_yn='Y'
	";
	$res=$db->query($qry);
	
	foreach($res->results as $v){
		
		if($v['categoryno']=='0' && $v['goodsno']=='0'){

			$gift_set['brand'][$v['brandno']][]=$v['giftnm'];
		}else if($v['categoryno']!='0' && $v['goodsno']=='0'){
			
			$gift_set['cate'][$v['brandno']][$v['categoryno']][]=$v['giftnm'];
		}else if( $v['goodsno']!='0'){

			$gift_set['goods'][$v['brandno']][$v['goodsno']][]=$v['giftnm'];	
		}

	}

	return $gift_set;
}


function get_goods_gift($v,$k,$giftinfo){
	
	global $db;
	
	$qry="select g.brandno,g.no,gl.cateno from goods g 
	left join goods_link gl on g.no= gl.goodsno
	where g.goodsnm = :goodsnm";
	$res=$db->query($qry,array(":goodsnm"=>$v['goodsnm']));
	
	$brandno=$res->results['0']['brandno'];
	$cateno=$res->results['0']['cateno'];
	$goodsno=$res->results['0']['no'];
	
	$data=array();
	if($giftinfo['brand'][$brandno])$data=array_merge($data,$giftinfo['brand'][$brandno]);
	if($giftinfo['cate'][$brandno][$cateno])$data=array_merge($data,$giftinfo['cate'][$brandno][$cateno]);
	if($giftinfo['goods'][$brandno][$goodsno])$data=array_merge($data,$giftinfo['goods'][$brandno][$goodsno]);
	
	if($data){
		$loop_gift=1;
		foreach($data as $giftv){
		
			$val[$k."_".$loop_gift]=$v;
			
			$val[$k."_".$loop_gift]['order_price']=0;
			$val[$k."_".$loop_gift]['settle_price']=0;
			$val[$k."_".$loop_gift]['deli_price']=0;
			$val[$k."_".$loop_gift]['mall_goodsnm']="[사은품]".$val[$k."_".$loop_gift]['mall_goodsnm'];
			$val[$k."_".$loop_gift]['goodsnm']=$giftv;
			$val[$k."_".$loop_gift]['ori_goodsnm']=$giftv;
			$loop_gift++;
		}
	}

	return $val;
}

function spec_filter(){
	global $db;

	$qry="select gif.filter_name,cgi.colum_name from goods_info_filter gif
	join category_goods_info cgi on gif.category_goods_info_no=cgi.no and cgi.use_filter='y'
	";		
	$res=$db->query($qry);
	foreach($res->results as $v){
		$filter[$v['colum_name']][]=$v['filter_name'];
	}

	return $filter;
}

function stock_loc($main=0){
	global $db;
	
	$loc['data']['총재고']="cur_cnt";
	$loc['data']['입고예정']="codeno_3";
	$loc['qry'][]="gcl.cur_cnt";
	$loc['qry'][]="gcl.codeno_3";

	if($main=='main')$add_where=" and v4=1 ";
	$qry="select cd,no from codedata where v2=1 ".$add_where." order by v3";
	$res=$db->query($qry);
	foreach($res->results as $v){
		$loc['qry'][]="gcl.codeno_".$v['no'];
		$loc['data'][$v['cd']]="codeno_".$v['no'];
	}

	return $loc;
}

function reserve_indb($order_list_no, $order_hold_no='0', $cnt, $memo='', $stock_loc){
	global $db;

	if(!$order_list_no || !$cnt || !$stock_loc) return false;

	$qry="select ol.* from order_list ol where ol.no='".$order_list_no."'";
	$res=$db->query($qry);
	$data=$res->results[0];

	if($order_hold_no) $hold_add=",order_hold_no='".$order_hold_no."'";
	
	$iqry="insert into reserve_list set
		goodsno='".$data['goodsno']."'
		,cnt='".$cnt."'
		,memo='".$memo."'
		,reference_no='".$order_list_no."'
		".$hold_add."
		,stock_loc='".$stock_loc."'
		,reg_date=now()
		,admin_no='".$_SESSION['sess']['m_no']."'
		";		
		//tydebug($iqry);
	$db->query($iqry);

	return true;
}


//구어드민 재고복원기능. 발송대기에서 이동할 시( order_hold.php에서도 사용중.. 수정시 참고)
function guadmin_stock_ctl($goodsno,$cnt,$loc,$inout,$ordseq='0',$memo){
	global $db;
	$table_name="timemecca_test2.stock";	

	$qry="select o.ordno,ml.d2_name,o.buyer,o.receiver,o.settle_price from order_list o 
	join mall_list ml on o.mall_no=ml.no
	where o.no=:no";	
	$res=$db->query($qry,array(":no"=>$ordseq));
	$odata=$res->results['0'];

	$last_cost=0;
	if(strtolower($inout)=='in'){
		$qry="select cost from ".$table_name." where m_no='".$goodsno."' and io='IN' and cost>0 order by no desc limit 1";
		$res=$db->query($qry);
		$last_cost=$res->results['0']['cost'];
	}

//err_log("qry",$qry,"","_cchk");

	$qry="insert into ".$table_name." set
	m_no=:m_no
	,place=:place
	,io=:io
	,customer=:customer
	,cnt=:cnt
	,cost=:cost
	,order_id=:order_id
	,buyer=:buyer
	,receiver=:receiver
	,sale_price=:sale_price
	,invoice=:invoice
	,memo=:memo
	,u_id=:u_id
	";
	
	if($loc=='51')$place='3자물류';
	else if($loc=='1')$place='사무실';

	$buyer=($odata['buyer'])?$odata['buyer']:"0";
	$receiver=($odata['receiver'])?$odata['receiver']:"0";
	$sale_price=($odata['settle_price'])?$odata['settle_price']:"0";
	$invoice=($odata['d2_name'])?$odata['d2_name']:"0";
	$customer=($odata['d2_name'])?$odata['d2_name']:"0";
	$order_id=($odata['ordno'])?$odata['ordno']:"0";

	if($ordseq=='0'){
		$customer='재고이동';
		$order_id='0';
	}

	$param=array(":m_no"=>$goodsno
	,":place"=>$place
	,":io"=>$inout
	,":customer"=>$customer
	,":cnt"=>$cnt
	,":cost"=>$last_cost
	,":order_id"=>$order_id
	,":buyer"=>$buyer
	,":receiver"=>$receiver
	,":sale_price"=>$sale_price
	,":invoice"=>$invoice
	,":memo"=>$memo
	,":u_id"=>$_SESSION['sess']['m_id']
	);

//err_log("uqry",$qry,$param,"_cchk");

	$res=$db->query($qry,$param);

	gu_recalc_stock($goodsno,$place);
	
}


function guadmin_stock_ctl2($goodsno,$cnt,$loc,$inout,$ordseq='0',$memo,$diff_price=0){
	global $db;
	
	$table_name="timemecca_test2.stock";	

	$qry="select o.ordno,ml.d2_name,o.buyer,o.receiver,o.settle_price from order_list o 
	join mall_list ml on o.mall_no=ml.no
	where o.no=:no";	
	$res=$db->query($qry,array(":no"=>$ordseq));
	$odata=$res->results['0'];

	$last_cost=0;
	if(strtolower($inout)=='in'){
		$qry="select cost from ".$table_name." where m_no='".$goodsno."' and io='IN' and cost>0 order by no desc limit 1";
		$res=$db->query($qry);
		$last_cost=$res->results['0']['cost'];
	}

//err_log("qry",$qry,"","_cchk");

	$qry="insert into ".$table_name." set
	m_no=:m_no
	,place=:place
	,io=:io
	,customer=:customer
	,cnt=:cnt
	,cost=:cost
	,order_id=:order_id
	,buyer=:buyer
	,receiver=:receiver
	,sale_price=:sale_price
	,invoice=:invoice
	,memo=:memo
	,u_id=:u_id
	";
	
	if($loc=='51')$place='3자물류';
	else if($loc=='1')$place='사무실';

	$buyer=($odata['buyer'])?$odata['buyer']:"0";
	$receiver=($odata['receiver'])?$odata['receiver']:"0";
	$sale_price=($odata['settle_price'])?$odata['settle_price']:"0";
	$invoice=($odata['d2_name'])?$odata['d2_name']:"0";
	$customer=($odata['d2_name'])?$odata['d2_name']:"0";
	$order_id=($odata['ordno'])?$odata['ordno']:"0";

	$sale_price-=$diff_price;

	if($ordseq=='0'){
		$customer='재고이동';
		$order_id='0';
	}

	$param=array(":m_no"=>$goodsno
	,":place"=>$place
	,":io"=>$inout
	,":customer"=>$customer
	,":cnt"=>$cnt
	,":cost"=>$last_cost
	,":order_id"=>$order_id
	,":buyer"=>$buyer
	,":receiver"=>$receiver
	,":sale_price"=>$sale_price
	,":invoice"=>$invoice
	,":memo"=>$memo
	,":u_id"=>$_SESSION['sess']['m_id']
	);

//err_log("uqry",$qry,$param,"_cchk");

	$res=$db->query($qry,$param);

	gu_recalc_stock($goodsno,$place);
	
}




// 입출고 내역 재고 모델별, 장소별 재계산
function gu_recalc_stock($m_no, $place) {
	global $db;
	// 재계산
	$table_name="timemecca_test2.stock";
	
	$qry="select * from ".$table_name." where del_yn = 'N' and io = 'IN' and m_no = $m_no and place = '$place' order by save_time";
	$res=$db->query($qry);
	$in=$res->results;

	$qry="select sum(cnt) cnt from ".$table_name." where del_yn = 'N' and io = 'OUT' and m_no = $m_no and place = '$place' order by save_time";
	$res=$db->query($qry);
	$out_cnt=intval($res->results['0']['cnt']);

	$in_idx = 0;
	$finished = false;

	

	if (sizeof($in)) { // 입고가 있는 경우
		for($i=0; $i<sizeof($in); $i++) {
			if ($finished) {
				$db->query("update ".$table_name." set cur_cnt = cnt where no = ".$in[$i]["no"]);

				err_log("ff","update ".$table_name." set cur_cnt = cnt where no = ".$in[$i]["no"],'',"_cchk");
				continue;
			}
			$in_cnt = intval($in[$i]["cnt"]);

			$out_cnt -= $in_cnt;
			if ($out_cnt > 0) {
				if ($i == sizeof($in)-1) { // 마지막 입고인데도 $out_cnt가 남아있다면 over해서 출고한 것이다.
					$db->query("update ".$table_name." set cur_cnt = ".(-$out_cnt)." where no = ".$in[$i]["no"]);
				} else {
					$db->query("update ".$table_name." set cur_cnt = 0 where no = ".$in[$i]["no"]);
				}
			} else {
				$db->query("update ".$table_name." set cur_cnt = ".abs($out_cnt)." where no = ".$in[$i]["no"]);
				$finished = true;
			}
		}
	} else if ($out_cnt > 0) { // 입고가 없고 출고만 있는 경우
		$db->query("update ".$table_name." set cur_cnt = -cnt where del_yn = 'N' and io = 'OUT' and m_no = $m_no and place = '$place'");
	}
	
}


function memo_indb($excel_data){
	global $db;
	foreach($excel_data as $k=>$v){
		/*
		$chkqry="select memo from order_list where goodsnm='".$v[0]."' and ordno='".$v[6]."' and mall_name='".$v[21]."' ";
		$chkres=$db->query($chkqry);
		
		$now_memo=$chkres->results[0]['memo'];

		if(trim($now_memo)==trim($v[16])){ //다운받을시와 업로드시 메모 값이 같으면
		*/
			$uqry="update order_list set memo=concat(ifnull(memo,''),' ','".$v[16]."')
			where goodsnm='".$v[0]."' and ordno='".$v[6]."' and mall_name='".$v[21]."'
			";
			$db->query($uqry);
		/*
		}else{
			$dup_key[]=$k;
		}
		*/
		if($dup_key)$return_data=" ".implode(",",$dup_key)." 열 데이터미적용(변경사항있음)";
		return $return_data;
	}

}

function order_return_url(){
	$QUERY_STRING="";
	if($_COOKIE['order_search_mall']) $QUERY_STRING.="&order_search_mall=".$_COOKIE['order_search_mall']."";
	if($_COOKIE['order_search_sdate']) $QUERY_STRING.="&order_search_sdate=".$_COOKIE['order_search_sdate']."";
	if($_COOKIE['order_search_edate']) $QUERY_STRING.="&order_search_edate=".$_COOKIE['order_search_edate']."";
	if($_COOKIE['order_search_ordno']) $QUERY_STRING.="&order_search_ordno=". urlencode($_COOKIE['order_search_ordno'])."";

	return $QUERY_STRING;
}


function chk_mallnm($mallnm){
	
	if($mallnm=='티몬')$data='티켓몬스터';
	else $data=$mallnm;
	return $data;
}

function data_trim($data){
	

	foreach($data as $k=>$v){
		
		if(!is_array($data[$k]))$data[$k]=trim($v);
	}

	return $data;
}

/*
type
1 : 신규입고
2 : 품절재입고
3 : 반품으로인한 품절재입고
*/
function goods_soldout_log($log_type, $goodsno, $stock_num){
	global $db;

	$qry="insert into goods_soldout_log set
	goodsno='".$goodsno."'
	,log_type='".$log_type."'
	,stock_num='".$stock_num."'
	,reg_date=now()
	";
	$db->query($qry);

	if($log_type=="3"){
		$qry="update goods set hidden_yn='n' where no='".$goodsno."'";
		$db->query($qry);
	}

}

function goods_psd_stock($goodsno){
	global $db;
	global $psb_stock_loc;

	$qry="select * from goods g
	left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
	where g.no='".$goodsno."'
	";
	$res=$db->query($qry);
	$goodsData=$res->results[0];

	foreach($psb_stock_loc as $psb_v){
		$psb_stock+=$goodsData[$psb_v];
	}	

	return $psb_stock;
}
?>
