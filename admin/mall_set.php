<?
include "../_header.php";

$page_title='몰관리';

if($_POST['mode']){
    if($_POST['mode']=='del'){
        if($_POST["no"]){
            $db->query("delete from mall_list where no=:no",array(":no"=>$_POST['no']));
            msg('삭제되었습니다.','mall_set.php');
        }else{
            msg('정상처리되지 않았습니다.','mall_set.php');
        }
    }
}

$qry="select * from mall_list order by sort, mall_name ";

$res = $db->query($qry,$param);

foreach($res->results as $v){
    if($v['state']=='y') $v['state']="사용";
    else $v['state']="사용안함";
    
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
