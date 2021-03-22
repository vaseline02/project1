<?
include "../_header.php";

$qry = "
select sd.*
,sm.wd_marketprice
,tb.wd_img_folder
,tb.engName
,tb.now
,i.wd_img_cate_folder
from wd_size_data sd
join wd_sprice_modellist sm on sd.modelstock_ = sm.wd_model_name
join itemCategory i on sd.category_id = i.id
join tBrandName tb on sd.brand_id = tb.id and tb.deleted='default' and wd_img_folder!=''
where sd.no = '".$_GET['goodsno']."'
and sd.modelstock_ not like 'SAVOIR1%'
and sd.modelstock_ not in('SAVOIR2-01','SAVOIR2-01B','SAVOIR2-02','SAVOIR2-03','SAVOIR2-05')
and sd.modelstock_ not like 'VEUX1%'
and sd.modelstock_ not like 'VEUX2%'
and sd.modelstock_ not like 'THURSDAYPARTY%'
and sd.modelstock_ not like 'LALENTA%'
and sd.modelstock_ not like 'ROY%'
and sd.modelstock_ not like 'HENRIK%'
and sd.modelstock_ not like 'LAXV%'
and sd.modelstock_ not like '%RAF1001%'
and sd.modelstock_ not like '%RAF1002%'
and sd.modelstock_ not like '%RAF1003%'


";
$res = $db->query($qry);
while($row = $db->fetch($res)){
	if($row[now]=='브이선'){
		$row['img_url']= "http://www.xgm1.com/vsun/".$row['wd_img_cate_folder']."/front/".$row['wd_img_name'].".jpg";
		$row['img_detail_url']= "http://xgm1.com/vsun/".$row['wd_img_cate_folder']."/".$row['wd_img_name'].".jpg";

	}else{
		//다른사이트 접속시 다른브랜드 상품 보이게 
		if( $_GET[site_type] =='bs' ){
			$row['img_url']= "http://112.175.245.35/data/WDTNS/nomark/".$row['wd_img_folder']."/".$row['wd_img_cate_folder']."/".$row['wd_img_name'].".jpg";
			$row['img_detail_url']= "http://xgm1.com/".$row['wd_img_folder']."/".$row['wd_img_cate_folder']."/".$row['wd_img_name'].".jpg";

		}
	
	}

	
	$img_data = @getimagesize($row['img_url']);
	if( !is_array($img_data) ){
		msg("상품이 준비중입니다.",-1);
		
	}

	$data = $row;
}

if(!$data['modelstock_'])msg("상품이 준비중입니다.",-1);

$model_init = explode("-",$data['modelstock_']);
$model_init = reset($model_init);

$qry = "
select sd.modelstock_
,sd.no
,sd.wd_img_name
,sm.wd_marketprice
,tb.wd_img_folder
,tb.engName
,i.wd_img_cate_folder
from wd_size_data sd
join wd_sprice_modellist sm on sd.modelstock_ = sm.wd_model_name
join itemCategory i on sd.category_id = i.id
join tBrandName tb on sd.brand_id = tb.id and tb.deleted='default' and wd_img_folder!=''
where sd.modelstock_ like '".$model_init."-%'
and sd.modelstock_ != '".$data['modelstock_']."'
and sd.modelstock_ not like 'SAVOIR1%'
and sd.modelstock_ not in('SAVOIR2-01','SAVOIR2-01B','SAVOIR2-02','SAVOIR2-03','SAVOIR2-05')
and sd.modelstock_ not like 'VEUX1%'
and sd.modelstock_ not like 'VEUX2%'
and sd.modelstock_ not like 'THURSDAYPARTY%'
and sd.modelstock_ not like 'LALENTA%'
and sd.modelstock_ not like 'ROY%'
and sd.modelstock_ not like 'HENRIK%'
and sd.modelstock_ not like '%RAF1001%'
and sd.modelstock_ not like '%RAF1002%'
and sd.modelstock_ not like '%RAF1003%'
order by sd.modelstock_
";

$res = $db->query($qry);
while($row = $db->fetch($res)){

	$row['img_url']= "http://www.xgm1.com/vsun/".$row['wd_img_cate_folder']."/front/".$row['wd_img_name'].".jpg";

	$img_data = @getimagesize($row['img_url']);

	if( is_array($img_data) ){
		$model_line[] = $row;
	}
}


$tpl->assign($data);

$tpl->assign(array(

			'model_line' => $model_line
			));

$tpl->print_('tpl');
?>