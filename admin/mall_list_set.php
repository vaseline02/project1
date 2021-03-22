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

$qry="select * from mall_list order by d_code";

$res = $db->query($qry,$param);

foreach($res->results as $v){
	/*
    if($v['state']=='y') $v['state']="사용";
    else $v['state']="사용안함";
    */
    
    
    $sqry="select b.brandnm from mall_brand mb left join brand b on(mb.brand_no=b.no) where mall_no='".$v['no']."'";
    $sres=$db->query($sqry);
    foreach($sres->results as $mbv){	
        $v['brand_arr'][]=$mbv;
    }
// tydebug($v['brand']);

	$loop[]=$v;
}



$tpl->assign(array(	
'loop' => $loop
,'bloop' => $bloop
));

$tpl->print_('tpl');
?>
