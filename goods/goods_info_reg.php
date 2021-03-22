<?
include "../_header.php";

$page_title='상품속성정보';

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($mode=="ins"){
    try
    {
        $db->beginTransaction();

        $iqry="insert into category_goods_info set
        colum_name=:colum_name
        ,info_name=:info_name
		,use_filter=:use_filter
        ,reg_date=now()
        ";
        
        $param[':colum_name']=$_POST['colum_name'];
        $param[':info_name']=$_POST['info_name'];
		$param[':use_filter']=$_POST['use_filter'];
        $db->query($iqry,$param);
        
        $db->commit();
        msg('처리되었습니다',"goods_info_reg.php?".$QUERY_STRING);
        

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"goods_info_reg.php?".$QUERY_STRING);
    }  
}else if($mode=="del"){
    $no=$_POST["no"];

    $dqry="delete from category_goods_info where no='".$no."'";
    $db->query($dqry);

    msg("삭제되었습니다.","goods_info_reg.php?".$QUERY_STRING);

}else if($mode=="cate_update"){
    if($_GET['cate']){
        foreach($_POST['chk_no'] as $v){
            $array_no[]=$v;
            $array_sort[]=$_POST['sort'][$v];

			$gi_qry="select * from category_goods_info where no='".$v."'";
			$gi_res=$db->query($gi_qry);
			$gi_data=$gi_res->results[0];

			$array_colum_name[]=$gi_data['colum_name'];

        }

		if($array_colum_name){
			$dqry="delete from category_goods_info_detail where cate_code='".$_GET['cate']."' and colum_name not in ('".implode("','",$array_colum_name)."')";
			$db->query($dqry);
		}else{
			$dqry="delete from category_goods_info_detail where cate_code='".$_GET['cate']."'";
			$db->query($dqry);
		}
		
		
		foreach($array_colum_name as $ck=>$cv){
			$gid_qry="select * from category_goods_info_detail where cate_code='".$_GET['cate']."' and colum_name='".$cv."'";
			$gid_res=$db->query($gid_qry);
			$gid_data=$gid_res->results[0];

			if($gid_data){
				$uqry="update category_goods_info_detail set sort='".$array_sort[$ck]."' where cate_code='".$_GET['cate']."' and colum_name='".$cv."'";
				$db->query($uqry);
			}else{
				$iqry="insert into category_goods_info_detail set cate_code='".$_GET['cate']."', colum_name='".$cv."', sort='".$array_sort[$ck]."', detail_view_yn='N', reg_date=now()";
				$db->query($iqry);
			}
		}

        $implode_no=implode("|",$array_no);
        $implode_sort=implode("|",$array_sort);

        $goods_info=$implode_no.":".$implode_sort;
        $uqry="update category set goods_info='".$goods_info."' where depth_1='".$_GET['cate']."' and depth_2='000'";

        $db->query($uqry);
        msg("등록되었습니다.","goods_info_reg.php?".$QUERY_STRING);
    }else{
        msg("등록에 실패했습니다.","goods_info_reg.php?".$QUERY_STRING);
    }
}


if($_GET['cate']){
        
    $qry="select * from category c where depth_1='".$_GET['cate']."' and depth_2='000' order by no desc";
    $res=$db->query($qry);
    $category=$res->results[0];
	
	if($category['goods_info']){

		$ex_goodsInfoData=explode(":",$category['goods_info']);
		$ex_goodsInfoNo=explode("|",$ex_goodsInfoData[0]);
		$ex_goodsInfoSort=explode("|",$ex_goodsInfoData[1]);

		foreach($ex_goodsInfoSort as $sk=>$sv){		
			$infoSort[]=$sv."_".$ex_goodsInfoNo[$sk];
		}	
		natsort($infoSort);
	}
    $i=1;
    foreach($infoSort as $k=>$v){
        $infoNo=explode("_",$v);

        $checked[$infoNo[1]]="checked";
        $sort[$infoNo[1]]=$infoNo[0];

        $orderCase[]="when no=".$infoNo[1]." then ".$i;

        $i++;
    }
   
    $qry="select * from category_goods_info cgi ";
    if($orderCase){
        $qry.="order by case ".implode(" ",$orderCase)." else ".($i+1)." end, no";
    }else{
        $qry.="order by no";
    }

    $res=$db->query($qry);
	
    foreach($res->results as $v){
        $loop[]=$v;
    }

}else{
    $qry="select * from category_goods_info cgi order by no";
    $res=$db->query($qry);
    foreach($res->results as $v){
        $loop[]=$v;
    }

}

$tpl->assign(array(
    'brandlist'=>$brandlist
    ,'catelist'=>$catelist
    ,'loop'=>$loop
    ,'category'=>$category
    ,'checked'=>$checked
    ,'sort'=>$sort
));

$checked["status"][$status]="checked";
$checked["view_yn"][$view_yn]="checked";
    
$tpl->print_('tpl');
?>
