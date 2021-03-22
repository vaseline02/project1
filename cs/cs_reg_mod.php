<?
include "../_header.php";

$page_title='CS관리';
$popup_chk=1; //메뉴 컨트롤

$ordno=$_GET['ordno'];

if(!$ordno){
    msg('잘못된 접근입니다.','close');
}

/*기본주문정보*/
$qry="select * from order_list ol
where ol.ordno='".$ordno."' order by ol.no desc limit 1";
$res = $db->query($qry);
$data=$res->results[0];

/*접수내용 */
 $qry="select ci.*, m.id from cs_info ci
 left join member m on (ci.admin_no=m.no)
 where ci.order_no='".$ordno."'
 order by ci.reg_date desc";

$res = $db->query($qry);
$csCount=0;
foreach($res->results as $v){
    $dqry="select * from cs_detail where cs_info_no='".$v['no']."'";
    $dres=$db->query($dqry);
    $sendCount='0';
    foreach($dres->results as $dv){

        if($dv['send_type']!='1') $sendCount++;
        
        $v['cs_detail'][]=$dv;

    }
    $v['send_count']=$sendCount;
    $v['cs_detail']=$dres->results;

    if($v['ing_type']=='1'){
        $v['ingColorType']="ingBlue";
    }else{
        $v['ingColorType']="ingRed";
    }
    $csCount++;
    $loop[]=$v;    
}
$tpl->assign($data);
$tpl->assign($csCount);
$tpl->assign(array(
    'loop'=>$loop
));

    
$tpl->print_('tpl');
?>
