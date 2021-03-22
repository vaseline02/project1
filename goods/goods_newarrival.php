<?
include "../_header.php";

mysql_query(" set names euckr ");

$qry = "
select sd.*
,sm.wd_marketprice
,tb.wd_img_folder
,tb.engName
,i.wd_img_cate_folder
,i.wd_cate
,(select count(1) from wd_size_data where modelstock_ like concat(substring_index(sd.modelstock_,'-', 1 ),'%')  ) as cnt_color
from wd_size_data sd
join wd_sprice_modellist sm on sd.modelstock_ = sm.wd_model_name
join itemCategory i on sd.category_id = i.id
join tBrandName tb on sd.brand_id = tb.id and tb.deleted='default' and wd_img_folder!=''
where 1
and sd.category_id in('2','3','26')
and sd.brand_id = '".$gb_brand_id."'
and sd.wd_img_name !=''
and sd.sync_tricyclo = 'y'
and sd.balance > 0
order by sd.first_photo_date desc ,sd.modelstock_
limit 50
";

$res = $db->query($qry);

while($row = $db->fetch($res)){

	$row['img_url']= "http://www.xgm1.com/vsun/".$row['wd_img_cate_folder']."/front/".$row['wd_img_name'].".jpg";
	$loop[] = $row;

	$img_data = @getimagesize($row['img_url']);

	if( is_array($img_data) ){
		$loop[] = $row;
	}
}

$tpl->assign(array(
			'loop' => $loop
			));

$tpl->print_('tpl');
?>
