<?
include "../_header.php";

$page_title='상품속성값설정(필터)';

$category=get_cate_info();

$QUERY_STRING = $_SERVER['QUERY_STRING'];

$catecode=$_GET['catecode'];

$mode=$_POST['mode'];
$no=$_POST['no'];
$filter_name=$_POST['filter_name'];
$filter_name_en=$_POST['filter_name_en'];


if($mode=="ins"){
	$sqry="select count(gif.no) as cnt from goods_info_filter gif where gif.category_goods_info_no='".$no."' and gif.filter_name='".$filter_name[$no]."'";
	$sres=$db->query($sqry);
	$scount=$sres->results[0]['cnt'];

	if(!$scount){
		$iqry="insert into goods_info_filter set
		category_goods_info_no='".$no."'
		,filter_name='".$filter_name[$no]."'
		,filter_name_en='".$filter_name_en[$no]."'
		,reg_date=now()
		";
		$db->query($iqry);

		msg('등록되었습니다.',"goods_info_filter.php?".$QUERY_STRING);
	}else{
		msg('중복된데이터가 있습니다.',"goods_info_filter.php?".$QUERY_STRING);
	}
	
}else if($mode=="del"){
	$dqry="delete from goods_info_filter where no='".$no."'";
	$db->query($dqry);
	msg('삭제되었습니다.',"goods_info_filter.php?".$QUERY_STRING);
}else if($mode=="mod"){
	$mod_filter_name=$_POST['mod_filter_name'];
	$mod_filter_name_en=$_POST['mod_filter_name_en'];
 
	$uqry="update goods_info_filter	set 
	filter_name='".$mod_filter_name[$no]."'
	,filter_name_en='".$mod_filter_name_en[$no]."'
	where no='".$no."'";

	$db->query($uqry);
	msg('수정되었습니다.',"goods_info_filter.php?".$QUERY_STRING);
}


if($catecode){
	$qry="select c.goods_info from category c where c.depth_1='".$catecode."' and c.depth_2='000'";
	$res=$db->query($qry);
	$goodsInfoData=$res->results[0]['goods_info'];

	$ex_goodsInfoData=explode(":",$goodsInfoData);
	$ex_goodsInfoNo=explode("|",$ex_goodsInfoData[0]);
	$ex_goodsInfoSort=explode("|",$ex_goodsInfoData[1]);

	foreach($ex_goodsInfoSort as $sk=>$sv){		
		$infoSort[]=$sv."_".$ex_goodsInfoNo[$sk];
	}	
	natsort($infoSort);
	
	foreach($infoSort as $ik=>$iv){		
		$infoNo=end(explode("_",$iv));

		$sqry="select * from category_goods_info cgi where cgi.no='".$infoNo."' and use_filter='y' order by no desc";
		$sres=$db->query($sqry);
		foreach($sres->results as $sv){
			$fsql="select * from goods_info_filter where category_goods_info_no='".$sv['no']."' order by filter_name ";
			$fres=$db->query($fsql);
			$sv['filter']=$fres->results;

			$loop[]=$sv;
		}
	}
}
$selected['catecode'][$catecode]="selected";

$tpl->assign(array(	
	'loop'=>$loop
	,'category'=>$category
));
    
$tpl->print_('tpl');
?>
