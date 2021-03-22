<?
include "../_header.php";

$page_title='기타문자관리';

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];

if($_POST['mode']=='ins'){
    $send_type=$_POST['send_type'];
    $send_title=$_POST['send_title'];
    $send_contents=$_POST['send_contents'];
    $send_code="1";
    $qry="select code from sms_info where type='".$send_type."' order by code desc limit 1";
    $res=$db->query($qry);
    if($res->results) $send_code=($res->results[0]['code']+1);

    $iqry="insert into sms_info set
    code=:code
    ,title=:title
    ,contents=:contents
    ,type=:type
    ,reg_date=now()
    ";

    $iparam[":code"]=$send_code;
    $iparam[":title"]=$send_title;
    $iparam[":contents"]=$send_contents;
    $iparam[":type"]=$send_type;

    $db->query($iqry, $iparam);

    msg("처리되었습니다","sms_reg.php");	

}else if($_POST['mode']=='mod'){
    $send_check=$_POST['send_check'];

    foreach($send_check as $v){
        $ex_send_check=explode("_",$v);
        $uqry="update sms_info set
        title=:title
        ,contents=:contents
        where code=:code
        and type=:type
        ";
        $uparam[":title"]=$_POST["send_title_".$ex_send_check['0']][$ex_send_check['1']];
        $uparam[":contents"]=$_POST["send_contents_".$ex_send_check['0']][$ex_send_check['1']];
        $uparam[":type"]=$ex_send_check['0'];
        $uparam[":code"]=$ex_send_check['1'];

        $db->query($uqry,$uparam);
    }
    msg("처리되었습니다","sms_reg.php");	
}else if($_POST['mode']=='del'){
    $send_check=$_POST['send_check'];

    foreach($send_check as $v){
        $ex_send_check=explode("_",$v);
        $dqry="delete from sms_info 
        where code=:code
        and type=:type
        ";
        $dparam[":type"]=$ex_send_check['0'];
        $dparam[":code"]=$ex_send_check['1'];

        $db->query($dqry,$dparam);
    }
    msg("처리되었습니다","sms_reg.php");	
}

$qry="select * from sms_info";
$res=$db->query($qry);
foreach($res->results as $v){
    $data[$v['type']][$v['code']]=$v;
}

$tpl->assign(array(
    'data'=>$data
));
    
$tpl->print_('tpl');
?>
