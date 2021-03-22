<?
include "../_header.php";member_chk();
require_once("../lib/file.class.php");

if($_FILES){
	$excel_data=excel_read('unlink');

	$white_img="this.src=/'//sineorb3.cafe24.com/web/product/space.jpg/'";
	$f_img_src="//sineorb3.cafe24.com/Design/web19/web/upload/WATCH";

	$first_data=reset($excel_data);
	
	$html.="";
	$html.="<!-- 오늘의반값 상세페이지 시작 -->\n";
	$html.="<div class='oban_wrap'>\n";
	$html.="<div class='oban_top'><img src='//timemecca.co.kr/design/kr/sale_".$first_data[1]."_".$first_data[6]."/A_1.jpg' alt=''></div>\n";
	$html.="<ol class='oban_list'>\n";

	$loop=1;

	foreach($excel_data as $k=>$v){

	$html.="\t<!-- 상품 ".$loop." -->\n";
	$html.="\t<li data-obancustomer='".number_format($v[3])."' data-obansell='".number_format($v[4])."'> <!-- 소비자가, 판매가 -->\n";
	
	$html.="\t";
	$html.='<a href="javascript:void(0);" class="oban_popOpen" data-obanimg="';
	$html.="\n";

	
	if($v['7']!='5'){

	//$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[1]."_story.jpg' ><br>\n";
	$html.="\t\t".$f_img_src."/".$v[1]."/".$v[1]."_story.jpg' ><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[2]."_01.jpg' ><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[2]."_spec.jpg' ><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[2]."_02.jpg' ><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[2]."_03.jpg'><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[2]."_04.jpg' ><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[2]."_05.jpg' ><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[2]."_06.jpg' ><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[1]."_case.jpg'><br>\n";
	//$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[1]."_end.jpg'><br>\n";
	$html.="\t\t<img src='".$f_img_src."/".$v[1]."/".$v[1]."_end.jpg\n";

	}else{
		$html.="http://obaku.kr/Design/web19/web/upload/WATCH/".$v[1]."/".$v[2].".jpg";
	}

	$html.="\t";
	$html.='"> <!-- 상세이미지 -->';
	$html.="\n";
	
	$html.="\t<span class='oban_num'></span>\n";
	$html.="\t\t<!-- 상품정보 -->\n";
	$html.="\t\t<div class='oban_model'> <!-- 상품명, 모델명 -->\n";
	$html.="\t\t\t<p>".$v[1]."</p>\n";
	$html.="\t\t\t<strong>".$v[2]."</strong>\n";
	$html.="\t\t</div>\n";
	$html.="\t\t<div class='oban_img'><img src='//sineorb3.cafe24.com/Design/web19/web/product/big/".$v[1]."/".$v[2].".jpg'></div> <!-- 대표 썸네일이미지 -->\n";
	$html.="\t\t<span class='oban_benefit'>".$v[5]."</span>\n";
	$html.="\t\t<!-- 상품정보 -->\n";
	$html.="\t</a>\n";
	$html.="\t</li>\n";
	$html.="\t<!--// 상품 ".$loop." -->\n";
	$loop++;
	}

	$html.="</ol>\n";
	$html.="</div>\n";
	$html.="<!-- 오늘의반값 상세페이지 종료 -->";

	unset($excel_data);
}

$tpl->print_('tpl');
?>
