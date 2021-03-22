<?
$glb_root_cron="/www/html/khj_co";
require_once($glb_root_cron."/lib/library.php");

$db =  new DB($glb_root_cron."/conf/db.conf.php");

$admin_key="175CB9EBF744CAD5";
$admin_company="GLAMO";

//$mp_header = ['Content-Type' => 'Api-Key:'.$admin_key,'Api-Company:'.$admin_company,'Content-Type: application/json'];
$mp_header = ['Api-Key:'.$admin_key,'Api-Company:'.$admin_company,'Content-Type: application/json'];

$mp_params = array(
	"order_id"=>"TY20200403",
	"total_price"=>50.00,
	"shipping_address"=>array(
		"name"=>"kim"
		,"address"=>"korea"
		,"city"=>"seoul"
		,"region_code"=>"se"
		,"region"=>"seoul"
		,"postcode"=>"20019"
		,"country"=>"KOR"
		,"email"=>"naskkatm@nate.com"
		,"telephone"=>"010 9170 7176"
		,"company"=>"bc"
	),
	"billing_address"=>array(
		"name"=>"kim"
		,"address"=>"korea"
		,"city"=>"seoul"
		,"region_code"=>"se"
		,"region"=>"seoul"
		,"postcode"=>"20019"
		,"country"=>"KOR"
		,"email"=>"naskkatm@nate.com"
	),
	"items"=>array(
		array(
		"sku"=>"00611-005396Q#999",
		"size"=>"U",
		"quantity"=>1,
		"item_price"=>700.00
		)
	),

);

$mp_params=json_encode($mp_params);
tydebug($mp_params);
//$turl="https://www.zucchetticonsulting.com/marketplace/servlet/zcmk_listproducts";

$turl="https://www.zucchetticonsulting.com/marketplace/servlet/zcmk_createorder";

$strArrResult = request_curl($turl, 1, ($mp_params), $mp_header);

if( $strArrResult[3] != '200' ) {
	
	 tydebug($strArrResult);
	 err_log('marketplace_api_error',$strArrResult[0]."/".$strArrResult[1]."/".$strArrResult[2],$strArrResult[3],'cron_err');
	 die;
	 return;
}

$strArrResult = json_decode($strArrResult[0],1);

tydebug($strArrResult);


?>