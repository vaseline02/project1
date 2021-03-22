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

if($_POST['mode']=='direct'){
	
	$add_where=" and g.no in ('".implode("','",$_POST['chk_no'])."')";
}else{
	$add_where="and g.goodsnm in ('CAR201V.FT6046','CAY2112.BA0927')";
}

$sabang_id=$sabang_cfg_info['ID'];
$sabang_key=$sabang_cfg_info['KEY'];

#$code_info=market_solution_code('sabangnet');
$code_prop=market_solution_prop('sabangnet');
$info_en_name=info_en_name();

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
,c.sabang_prop_code,c.depth_1
,b.brandnm,b.brandnm_en,b.brand_img_folder,b.brand_img_nm
,gl.category
,gc.cut_type,gc.th_num
from goods g
join goods_info gi on g.no=gi.goodsno
join brand b on b.no=g.brandno
join goods_cnt_loc gcl on g.no=gcl.goodsno
left join goods_link gl on g.no=gl.goodsno
left join category c on c.no=gl.cateno
left join goods_cut gc on gc.brandno=g.brandno
where 1
".$add_where."
";

$res=$db->query($qry);

//묶음구분
foreach($res->results as $v){

	$extmp=explode($cfg_size_cut_patten[$v['cut_type']],$v['goodsnm']);
	
	unset($line_name);
	foreach($extmp as $exk=>$exv){
		if($exk>=$v['th_num'])break;
		$line_name[]=$exv;
	}

	$data[implode($cfg_size_cut_patten[$v['cut_type']],$line_name)][]=$v;
}

tydebug($data);

die;
foreach($res->results as $v){

$mall_gnm=$GOODS->get_mall_goodsnm($v);

if($v['goodsnm_mall'])$mall_gnm=$v['goodsnm_mall'];

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
unset($CLASS_CD2);
if($cfg_sabang_cate['2'][$v['depth_1']]){

	foreach($cfg_sabang_cate['2'][$v['depth_1']] as $cv){
		$CLASS_CD2[]=$v[$cv];
	}
	$CLASS_CD2=implode(" ",$CLASS_CD2);
}else{
	$CLASS_CD2=$v['prod_type'];
}

$CLASS_CD3="";


$ORIGIN=$v['origin'];
$GOODS_SEASON='7';
$SEX=($arr_sabang_gender[$v['gender']])?$arr_sabang_gender[$v['gender']]:'4';

//가용재고
foreach($psb_stock_loc as $pv){
	$psb_stock+=$v[$pv];
}

if($psb_stock>0)$STATUS="2";
else $STATUS="3";

$DELIV_ABLE_REGION='1';
$TAX_YN="1";  //나중에 물어봐야함
$DELV_TYPE="4"; //원가 어떻게 할지 나중에 물어봐야함



$GOODS_COST="";
$GOODS_PRICE=$v['consumer_price'];
$GOODS_CONSUMER_PRICE=$v['consumer_price'];
$CHAR_1_NM="모델명";

$CHAR_1_VAL=$v['goodsnm']."^^".($psb_stock);

$goods_detail=$GOODS->get_detail_img($v);

//tydebug(htmlspecialchars($goods_detail));



/*인보이스 */

$inv_qry="select import_no,img_name from import_licence where goodsno='".$v['no']."' order by no desc limit 1";
$inv_res=$db->query($inv_qry);

foreach($inv_res->results as $inv_v){

	$invoice_img=$cfg['img_url']."a/coupang/invoice/".$inv_v['img_name'];
	$IMPORTNO=$inv_v['import_no'];
}	



$GOODS_REMARKS="<div>".addslashes($v['description'])."</div>";
foreach($imgs as $iv){	$GOODS_REMARKS.="<div><img src='".$iv."'></div>"; }

$PROP1_CD =$v['sabang_prop_code'];

unset($PROP_VAL);
foreach($code_prop[$PROP1_CD] as $prop_k=>$prop_v){

	$tmp_prop=$GOODS->goods_prop_style($prop_k,$prop_v,$v,$info_en_name);	

	$PROP_VAL[]=$tmp_prop;
}

$STOCK_USE_YN="Y";
$OPT_TYPE="9";



$xml_code.="<DATA>\n";	
$xml_code.="<GOODS_NM><![CDATA[".$mall_gnm."]]></GOODS_NM>\n";
##$xml_code.="<GOODS_KEYWORD><![CDATA[".."]]></GOODS_KEYWORD>\n";
$xml_code.="<MODEL_NM><![CDATA[".$v['goodsnm']."]]></MODEL_NM>\n";
$xml_code.="<MODEL_NO><![CDATA[".$v['goodsnm']."]]></MODEL_NO>\n";
$xml_code.="<BRAND_NM><![CDATA[".$v['brandnm']."]]></BRAND_NM>\n";
$xml_code.="<COMPAYNY_GOODS_CD><![CDATA[".$COMPAYNY_GOODS_CD."_test]]></COMPAYNY_GOODS_CD>\n";
$xml_code.="<GOODS_SEARCH><![CDATA[".$GOODS_SEARCH."]]></GOODS_SEARCH>\n";
$xml_code.="<GOODS_GUBUN>".$GOODS_GUBUN."</GOODS_GUBUN>\n";
$xml_code.="<CLASS_CD1><![CDATA[".$CLASS_CD1."]]></CLASS_CD1>\n";
$xml_code.="<CLASS_CD2><![CDATA[".$CLASS_CD2."]]></CLASS_CD2>\n";
$xml_code.="<CLASS_CD3><![CDATA[".$CLASS_CD3."]]></CLASS_CD3>\n";
##$xml_code.="<CLASS_CD4><![CDATA[".."]]></CLASS_CD4>\n";
##$xml_code.="<PARTNER_ID><![CDATA[".."]]></PARTNER_ID>\n";
##$xml_code.="<DPARTNER_ID><![CDATA[".."]]></DPARTNER_ID>\n";
$xml_code.="<MAKER><![CDATA[".$v['brandnm']."]]></MAKER>\n";
$xml_code.="<ORIGIN><![CDATA[".$ORIGIN."]]></ORIGIN>\n";
##$xml_code.="<MAKE_YEAR><![CDATA[".."]]></MAKE_YEAR>\n";
##$xml_code.="<MAKE_DM><![CDATA[".."]]></MAKE_DM>\n";
$xml_code.="<GOODS_SEASON>".$GOODS_SEASON."</GOODS_SEASON>\n";
$xml_code.="<SEX>".$SEX."</SEX>\n";
$xml_code.="<STATUS><![CDATA[".$STATUS."]]></STATUS>\n";
$xml_code.="<DELIV_ABLE_REGION>".$DELIV_ABLE_REGION."</DELIV_ABLE_REGION>\n";
$xml_code.="<TAX_YN>".$TAX_YN."</TAX_YN>\n";
$xml_code.="<DELV_TYPE>".$DELV_TYPE."</DELV_TYPE>\n";
##$xml_code.="<DELV_COST>".."</DELV_COST>\n";
##$xml_code.="<BANPUM_AREA>".."</BANPUM_AREA>\n";
$xml_code.="<GOODS_COST><![CDATA[".$GOODS_COST."]]></GOODS_COST>\n";
$xml_code.="<GOODS_PRICE><![CDATA[".$GOODS_PRICE."]]></GOODS_PRICE>\n";
$xml_code.="<GOODS_CONSUMER_PRICE><![CDATA[".$GOODS_CONSUMER_PRICE."]]></GOODS_CONSUMER_PRICE>\n";
$xml_code.="<CHAR_1_NM><![CDATA[".$CHAR_1_NM."]]></CHAR_1_NM>\n";
$xml_code.="<CHAR_1_VAL><![CDATA[".$CHAR_1_VAL."]]></CHAR_1_VAL>\n";
##$xml_code.="<CHAR_2_NM><![CDATA[".."]]></CHAR_2_NM>\n";
##$xml_code.="<CHAR_2_VAL><![CDATA[".."]]></CHAR_2_VAL>\n";

##$xml_code.="<IMG_PATH><![CDATA[".$IMG_PATH."]]></IMG_PATH>\n";
##$xml_code.="<IMG_PATH1><![CDATA[".$IMG_PATH1."]]></IMG_PATH1>\n";
##$xml_code.="<IMG_PATH2><![CDATA[".$IMG_PATH1."]]></IMG_PATH2>\n";

foreach($IMG_PATH as $ik=>$iv){
	
	if($ik==0){
		$xml_code.="<IMG_PATH><![CDATA[".$iv."]]></IMG_PATH>\n";
	}else{
		$xml_code.="<IMG_PATH".$ik."><![CDATA[".$iv."]]></IMG_PATH".$ik.">\n";
	}
}

$xml_code.="<IMG_PATH24><![CDATA[".$invoice_img."]]></IMG_PATH24>\n";
$xml_code.="<GOODS_REMARKS><![CDATA[".$goods_detail."]]></GOODS_REMARKS>\n";
##$xml_code.="<CERTNO><![CDATA[".."]]></CERTNO>\n";
##$xml_code.="<AVLST_DM>".."</AVLST_DM>\n";
##$xml_code.="<AVLED_DM>".."</AVLED_DM>\n";
##$xml_code.="<ISSUEDATE>".."</ISSUEDATE>\n";
##$xml_code.="<CERTDATE>".."</CERTDATE>\n";
##$xml_code.="<CERT_AGENCY><![CDATA[".."]]></CERT_AGENCY>\n";
##$xml_code.="<CERTFIELD><![CDATA[".."]]></CERTFIELD>\n";
##$xml_code.="<MATERIAL>".."</MATERIAL>\n";
$xml_code.="<STOCK_USE_YN><![CDATA[".$STOCK_USE_YN."]]></STOCK_USE_YN>\n";
$xml_code.="<OPT_TYPE><![CDATA[".$OPT_TYPE."]]></OPT_TYPE>\n";
$xml_code.="<PROP_EDIT_YN>Y</PROP_EDIT_YN>\n";
$xml_code.="<PROP1_CD>".$PROP1_CD."</PROP1_CD>\n";

foreach($PROP_VAL as $pk=>$pv ){
	$xml_code.="<PROP_VAL".($pk+1)."><![CDATA[".$pv."]]></PROP_VAL".($pk+1).">\n";
}

##$xml_code.="<PACK_CODE_STR><![CDATA[".."]]></PACK_CODE_STR>\n";
##$xml_code.="<GOODS_NM_EN><![CDATA[".."]]></GOODS_NM_EN>\n";
##$xml_code.="<GOODS_NM_PR><![CDATA[".."]]></GOODS_NM_PR>\n";
##$xml_code.="<GOODS_REMARKS2><![CDATA[".."]]></GOODS_REMARKS2>\n";
##$xml_code.="<GOODS_REMARKS3><![CDATA[".."]]></GOODS_REMARKS3>\n";
##$xml_code.="<GOODS_REMARKS4><![CDATA[".."]]></GOODS_REMARKS4>\n";
$xml_code.="<IMPORTNO><![CDATA[".$IMPORTNO."]]></IMPORTNO>\n";
##$xml_code.="<GOODS_COST2><![CDATA[".."]]></GOODS_COST2>\n";
##$xml_code.="<ORIGIN2><![CDATA[".."]]></ORIGIN2>\n";
##$xml_code.="<EXPIRE_DM><![CDATA[".."]]></EXPIRE_DM>\n";
##$xml_code.="<SUPPLY_SAVE_YN><![CDATA[".."]]></SUPPLY_SAVE_YN>\n";
##$xml_code.="<DESCRITION><![CDATA[".."]]></DESCRITION>\n";



$xml_code.="</DATA>\n";	

}

$xml_code.="</SABANG_GOODS_REGI>\n";


$xml_name="xml_goods_info";

$time_now=date('H');
$file_name = "goods_regi".$time_now.".xml"; //파일명지정
$dir_name = $glb_root_cron."/sabang_xml/".$file_name; //디렉토리지정

//$ttt=file_put_contents($dir_name,$xml_code); //파일 생성하는 함수 
$ttt=file_put_contents($dir_name,mb_convert_encoding($xml_code,'euc-kr','utf-8')); //파일 생성하는 함수 


include($glb_root_cron."/admin/sabang_api_reg_goods.php");

var_dump($ttt);

echo "1";
?>