<?
include "../_header.php";

$page_title='문자관리';
$popup_chk=1; //메뉴 컨트롤
$mode=$_POST["mode"];
$return_url=$_POST["return_url"];
$etc_code=$_POST["etc_code"];
$etc_no=$_POST["etc_no"];
$order_no=$_POST["order_no"];
$order_list_no=$_POST["order_list_no"];
$sms_type=$_POST["sms_type"];


if($_GET['etc_code']=='as'){
	$typeno='4';
}else if($_GET['etc_code']=='cs'){
	$typeno='5';
}

$sms_coin=sms_coin();

if($mode=='receipt'){
    foreach($_POST['send_contents'] as $k=>$v){
        
        $qry="update sms_info set 
        contents=:contents
        where code=:code and type=:type";

        $param[':code']=$k;
        $param[':type']='1';
        $param[':contents']=$v;

        $db->query($qry,$param);

    }
    msg("처리되었습니다",$return_url);	
}else if($mode=='etc'){
    $send_check=$_POST['send_check'];

    $title=$_POST['send_title'][$send_check];
    $contents=$_POST['send_contents'][$send_check];
    $mobile=paste_to_arr($_POST['send_mobile']);
	foreach($mobile as $v){
		$ordno="";
		$smsEx=explode("(",$v);
		$mobileNumber=trim($smsEx[0]);
		if($smsEx[1]) $ordno=trim(reset(explode(")",$smsEx[1])));
		if($sms_type=="1"){
			$sendChcek=sms_send($title, $contents, $mobileNumber, $etc_code, $etc_no, '0' ,$ordno);
		}else if ($sms_type=="2"){
			$sendChcek=sms_send_ppurio($title, $contents, $mobileNumber, $etc_code, $etc_no, '0' ,$ordno);
		}

	}

    msg("처리되었습니다",$return_url);	
}else if($mode=='each'){
    $title=$_POST['send_title'];
    $contents=$_POST['send_contents'];
	$mobile=paste_to_arr($_POST['send_mobile']);

	foreach($mobile as $v){
		$ordno="";
		$smsEx=explode("(",$v);
		$mobileNumber=trim($smsEx[0]);
		if($smsEx[1]) $ordno=trim(reset(explode(")",$smsEx[1])));
		
		if($sms_type=="1"){
			$sendChcek=sms_send($title, $contents, $mobileNumber, $etc_code, $etc_no, '0' ,$ordno);
		}else if ($sms_type=="2"){
			$sendChcek=sms_send_ppurio($title, $contents, $mobileNumber, $etc_code, $etc_no, '0' ,$ordno);
		}
		
	}

    msg("처리되었습니다",$return_url);	
}

//$smsCoin=sms_coin();

$qry="select * from sms_info where type in ('1','".$typeno."')";
$res=$db->query($qry);
foreach($res->results as $v){
    $data[$v['type']][$v['code']]=$v;
}

//tydebug($data);
if($_GET['order_no']){
	$sqry="select mobile,ordno from order_list ol where ordno='".$_GET['order_no']."'";
	$sres=$db->query($sqry);
	$receiver_mobile=trim($sres->results[0]['mobile']."(".$sres->results[0]['ordno'].")");
	$readonly_chk="readonly";
}

if($_POST['order_list_no']){
	$ex_order_list_no=explode(",",$_POST['order_list_no']);

	foreach($ex_order_list_no as $v){
		$sqry="select mobile,ordno from order_list ol where no='".$v."'";
		$sres=$db->query($sqry);
		$ordData=$sres->results[0];
		$receiver_mobile[$ordData['ordno']]=$ordData['mobile'];
	}
	$receiver_mobile_val="";
	foreach($receiver_mobile as $rk=>$rv){
		$receiver_mobile_val[]=$rv."(".$rk.")";
	}
	$receiver_mobile=trim(implode("\n",$receiver_mobile_val));

	$readonly_chk="readonly";
//	tydebug($receiver_mobile);
	//중복제거
	//$receiver_mobile=array_unique($receiver_mobile);
//	$receiver_mobile=trim(implode("\n",$receiver_mobile));

	
}

$lqry="select * from sms_send_log order by reg_date desc limit 100";
$lres=$db->query($lqry);
foreach($lres->results as $lv){
    $loop[]=$lv;
}
$tpl->assign(array(
    'data'=>$data
    ,'loop'=>$loop
));

$tpl->print_('tpl');

?>
