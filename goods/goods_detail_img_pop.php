<?
include "../_header.php";

$page_title='상세이미지';
$popup_chk=1; //메뉴 컨트롤

$GOODS=new goods();


$imgname=$_GET['imgname'];

$imgname=end(explode("/",$imgname));

$imgname=reset(explode(".jpg",$imgname));

$qry="select g.goodsnm,g.img_name,b.brandnm_en,b.brand_img_folder,b.brand_img_nm,g.img_step from goods g
join brand b on b.no=g.brandno
where (img_name='".$imgname."' or goodsnm='".$imgname."')
limit 1
";



$res=$db->query($qry);
$data=$res->results['0'];

//tydebug($data);

$brand_img_folder=$data['brand_img_folder'];
$brand_img_nm=$data['brand_img_nm']?$data['brand_img_nm']:$brand_img_folder."_case";
$goodsnm=($data['img_name'])?$data['img_name']:$data['goodsnm'];




$goods_detail=$GOODS->get_detail_img($data);

/*
tydebug(htmlspecialchars($goods_detail));

if($data['img_step']=='5' || $data['img_step']=='3'){

	$goods_detail='<div align="center"><br>
	<img src="'.$cfg['img_url'].'a/info/notice.jpg" /><br>

	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'.jpg"><br>

	<img src="'.$cfg['img_url'].'a/info/as.jpg" /><br> </div>';
}else if($data['img_step']=='4'){

	$goods_detail='<div align="center"><br>
	<img src="'.$cfg['img_url'].'a/info/notice.jpg" /><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$brand_img_folder.'_story.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_01.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_spec.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_02.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_03.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_04.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_05.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_06.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$goodsnm.'_07.jpg"><br>

	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$brand_img_folder.'_ETC.jpg"><br>
	<img src="'.$cfg['img_url'].'Design/web19/web/upload/WATCH/'.$brand_img_folder.'/'.$brand_img_nm.'.jpg"><br>
	<img src="'.$cfg['img_url'].'a/info/as.jpg" /><br> </div>';
}
*/
$tpl->print_('tpl');
?>
