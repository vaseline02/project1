<?
include "../_header.php";

$page_title='문자관리';
$mode=$_POST["mode"];
$return_url=$_POST["return_url"];
$etc_code=$_POST["etc_code"];
$etc_no=$_POST["etc_no"];
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
    $ex_send_check=explode("_",$send_check);
    $title=$_POST['send_title_'.$ex_send_check[0]][$ex_send_check[1]];
    $contents=$_POST['send_contents_'.$ex_send_check[0]][$ex_send_check[1]];
    $mobile=$_POST['send_mobile'];

    $sendChcek=sms_send($title, $contents, $mobile, 'set');

    if($sendChcek)msg("발송되었습니다.",$return_url);	
}else if($mode=='each'){
    $title=$_POST['send_title'];
    $contents=$_POST['send_contents'];
    $mobile=$_POST['send_mobile'];

    $sendChcek=sms_send($title, $contents, $mobile, 'set');
    
    if($sendChcek)msg("발송되었습니다",$return_url);	
}

$smsCoin=sms_coin();

$qry="select * from sms_info";
$res=$db->query($qry);
foreach($res->results as $v){
    $data[$v['type']][$v['code']]=$v;
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
