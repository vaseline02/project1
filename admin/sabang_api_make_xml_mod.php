<?
$glb_root_cron="/www/html/ukk_test";
require_once($glb_root_cron."/lib/db.class.php");
require_once($glb_root_cron."/lib/lib.func.php");
require_once($glb_root_cron."/lib/goods.class.php");
require_once($glb_root_cron."/conf/config.php");
require_once($glb_root_cron."/conf/sabang.conf.php");


$db =  new DB($glb_root_cron."/conf/db.conf.php");
$GOODS=new goods();

$tday=date("Ymd");

$sabang_id=$sabang_cfg_info['ID'];
$sabang_key=$sabang_cfg_info['KEY'];


$qry="select filter_name,filter_name_en from goods_info_filter";
$res=$db->query($qry);

foreach($res->results as $v){
	$info_en_name[$v['filter_name']]=$v['filter_name_en'];
}

$xml_code = "";
$xml_code = "<?xml version=\"1.0\" encoding=\"euc-kr\"?>\n";  
$xml_code.="<SABANG_GOODS_REGI>\n";
$xml_code.="<HEADER>\n";
$xml_code.="\t<SEND_COMPAYNY_ID>".$sabang_id."</SEND_COMPAYNY_ID>\n";
$xml_code.="\t<SEND_AUTH_KEY><![CDATA[".$sabang_key."]]></SEND_AUTH_KEY>\n";
$xml_code.="\t<SEND_DATE><![CDATA[".$tday."]]></SEND_DATE>\n";
$xml_code.="\t<SEND_GOODS_CD_RT>Y</SEND_GOODS_CD_RT>\n";
$xml_code.="</HEADER>\n";	

/*카테고리 테이블 기준으로 속성분류코드 가져오기
$qry="select no,sabang_prop_code from category where sabang_prop_code!=''";
$res=$db->query($qry);

foreach($res->results as $v){
	$cate_prop[$v['no']]=$v['sabang_prop_code'];
}
*/

$qry="select g.no goodsno,g.*,gi.*,gcl.codeno_51,gcl.codeno_1
,c.sabang_prop_code 
,b.brandnm,b.brandnm_en,b.brand_img_folder
,gl.category
from goods g
join goods_info gi on g.no=gi.goodsno
join brand b on b.no=g.brandno
join goods_cnt_loc gcl on g.no=gcl.goodsno
join goods_link gl on g.no=gl.goodsno
join category c on c.no=gl.cateno
where 1
and g.goodsnm in ('CAH1210.BA0862')
#and g.no in ('71','15179','15183','19962','25456')
#and g.goodsnm in ('YA133516','YA133309','YA101204','YA101205','449647 BMJ1G 1000','165904 3G646 1100','EU06100WW0007 NA','112673','104227','118698','107685','126231','114519','114532','113207','126229','113002','123894','101896','CAH1210.BA0862')
";

$res=$db->query($qry);

tydebug($res);

foreach($res->results as $v){

if($v['brandnm'])$mall_goodsnm_brand[]=$v['brandnm'];
if($v['brandnm_en'])$mall_goodsnm_brand[]=$v['brandnm_en'];


$mall_goodsnm[]="[".implode(" ",$mall_goodsnm_brand)."]";


if($v['goodsnm'])$mall_goodsnm[]=$v['goodsnm'];
if($v['goodsnm_sub'])$mall_goodsnm[]=$v['goodsnm_sub'];
if($v['collection'])$mall_goodsnm[]=$v['collection'];
if($v['etc_info'])$mall_goodsnm[]=$v['etc_info'];
if($v['gender'])$mall_goodsnm[]=$v['gender'];
if($v['prod_type']=='시계')$mall_goodsnm[]=$v['movement'];
if($v['prod_type'])$mall_goodsnm[]=$v['prod_type'];

$mall_gnm=implode(" ",$mall_goodsnm);

$COMPAYNY_GOODS_CD=$v['goodsnm'];

//검색어
unset($GOODS_SEARCH);
$GOODS_SEARCH[]=$v['brandnm'];
$GOODS_SEARCH[]=$v['goodsnm'];
$GOODS_SEARCH[]=$v['brandnm']." ".$v['prod_type'];
$GOODS_SEARCH[]=$v['brandnm']." ".$v['movement'];
$GOODS_SEARCH[]=$v['collection'];
$GOODS_SEARCH[]=$v['brandnm']." ".$v['collection'];

$GOODS_SEARCH=implode(",",$GOODS_SEARCH);

$GOODS_GUBUN="";
$CLASS_CD1=str_replace(" ","",$v['brandnm_en']);
$CLASS_CD2="";
$CLASS_CD3="";

$ORIGIN=$v['origin'];
$GOODS_SEASON='7';
$SEX=($arr_sabang_gender[$v['gender']])?$arr_sabang_gender[$v['gender']]:'4';

//가용재고
foreach($psb_stock_loc as $pv){
	$psb_stock+=$v[$pv];
}


//재고위치
if($psb_stock>0)$STATUS="2";
else $STATUS="3";

$DELIV_ABLE_REGION='1';
$TAX_YN="1";  //나중에 물어봐야함
$DELV_TYPE="4"; //원가 어떻게 할지 나중에 물어봐야함



$GOODS_COST="";
$GOODS_PRICE=$v['consumer_price'];
$GOODS_CONSUMER_PRICE=$v['consumer_price'];
$CHAR_1_NM="모델명";




$CHAR_1_VAL=$v['goodsnm'].":".($psb_stock);


$brandnm_en=$v['brand_img_folder'];
$goodsnm=$v['img_name'];


$GOODS_REMARKS="<div>".addslashes($v['description'])."</div>";
foreach($imgs as $iv){	$GOODS_REMARKS.="<div><img src='".$iv."'></div>"; }

$PROP1_CD =$v['sabang_prop_code'];

unset($PROP_VAL);
foreach($code_prop[$PROP1_CD] as $prop_k=>$prop_v){

	$tmp_prop=$GOODS->goods_prop_style($prop_k,$prop_v,$v,$info_en_name);	

	$PROP_VAL[]=$tmp_prop;
}

tydebug($PROP_VAL);

$STOCK_USE_YN="Y";
$OPT_TYPE="9";


$xml_code.="<DATA>\n";	
$xml_code.="<GOODS_NM><![CDATA[".$mall_gnm."]]></GOODS_NM>\n";
$xml_code.="<COMPAYNY_GOODS_CD><![CDATA[".$COMPAYNY_GOODS_CD."_test]]></COMPAYNY_GOODS_CD>\n";
$xml_code.="<STATUS><![CDATA[".$STATUS."]]></STATUS>\n";
$xml_code.="<GOODS_COST><![CDATA[".$GOODS_COST."]]></GOODS_COST>\n";
$xml_code.="<GOODS_PRICE><![CDATA[".$GOODS_PRICE."]]></GOODS_PRICE>\n";
$xml_code.="<GOODS_CONSUMER_PRICE><![CDATA[".$GOODS_CONSUMER_PRICE."]]></GOODS_CONSUMER_PRICE>\n";
$xml_code.="<SKU_INFO>";
$xml_code.="<SKU_VALUE>".$CHAR_1_VAL."</SKU_VALUE>";
$xml_code.="</SKU_INFO>";
$xml_code.="</DATA>\n";	

}

$xml_code.="</SABANG_GOODS_REGI>\n";

$xml_name="xml_goods_info2";

$time_now=date('H');
$file_name = "stock_mod".$time_now.".xml"; //파일명지정
$dir_name = $glb_root_cron."/sabang_xml/".$file_name; //디렉토리지정

//$ttt=file_put_contents($dir_name,$xml_code); //파일 생성하는 함수 
$ttt=file_put_contents($dir_name,mb_convert_encoding($xml_code,'euc-kr','utf-8')); //파일 생성하는 함수 


//include($glb_root_cron."/admin/sabang_api_reg_goods.php");

var_dump($ttt);

echo "1";
?>