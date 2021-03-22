<?
include "../_header.php";

$page_title='상품상세정보';

$popup_chk=1; //메뉴 컨트롤

$cate_code=$_GET['cate_code'];
$goodsnm=$_GET['goodsnm'];

$qry="select g.*,gi.*,b.brandnm from goods g 
	left join goods_info gi on (g.no=gi.goodsno)
	left join brand b on (g.brandno=b.no)
	where g.goodsnm='".$goodsnm."'
	";
$res=$db->query($qry);
$goodsData=$res->results[0];

$loop['Model.No']=$goodsnm;
$loop['Brand']=$goodsData['brandnm'];

$qry="select cgid.*, cgi.info_name  from category_goods_info_detail cgid
left join category_goods_info cgi on (cgid.colum_name=cgi.colum_name)
where cgid.cate_code='".$cate_code."'
and cgid.detail_view_yn='Y'
order by cgid.sort asc
";

$res=$db->query($qry);
foreach($res->results as $v){

	$goodsData[$v['colum_name']]=str_replace("|",",",$goodsData[$v['colum_name']]);

	if($v['colum_name']=='width' || $v['colum_name']=='height'){
		if($loop['Size(사이즈)']){
			if($goodsData[$v['colum_name']]) $loop['Size(사이즈)'].=" x ".$goodsData[$v['colum_name']];
		}else{
			if($goodsData[$v['colum_name']]) $loop['Size(사이즈)'].=$goodsData[$v['colum_name']];
		}
	}else if($cate_code=='002' && ($v['colum_name']=='width2' || $v['colum_name']=='height2')){
		if($loop['Size(버클 사이즈)']){
			if($goodsData[$v['colum_name']]) $loop['Size(버클 사이즈)'].=" x ".$goodsData[$v['colum_name']];
		}else{
			if($goodsData[$v['colum_name']]) $loop['Size(버클 사이즈)'].=$goodsData[$v['colum_name']];
		}
	}else if($cate_code=='003' && ($v['colum_name']=='width2' || $v['colum_name']=='height2')){
		if($loop['Size(팬던트 사이즈)']){
			if($goodsData[$v['colum_name']]) $loop['Size(팬던트 사이즈)'].=" x ".$goodsData[$v['colum_name']];
		}else{
			if($goodsData[$v['colum_name']]) $loop['Size(팬던트 사이즈)'].=$goodsData[$v['colum_name']];
		}
	}else{
		$info_name=$cfg_goods_info[$cate_code][$v['colum_name']]?$cfg_goods_info[$cate_code][$v['colum_name']]:$v['info_name'];

		$array_name=$v['info_name_en']."(".$info_name.")";
		$loop[$array_name]=$goodsData[$v['colum_name']];
	}
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
