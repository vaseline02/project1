<?
$glb_root_cron="/www/html/ukk";
require_once($glb_root_cron."/lib/library.php");
$user_mkt="zig9";
$pwd_mkt="Vq5v1%@L7ax*";
$mp_header = ['USER_MKT:'.$user_mkt,'PWD_MKT:'.$pwd_mkt];

$loop=4;
$num = sprintf('%04d',$loop);

$ordno=date('Ymd').$num.date('H');
$receiver="ZIG9 Co.,Ltd.";
$address="GreenHill B/D-605, 453, Hwarang-ro, Nowon-gu, Seoul, Republic of korea";
$zipcode="01849";
$ISOcountry="KR";
$TypeShipping="Logistic";
$city="Seoul";

$mall_name="MINETTI";
$goodsno="1378003";
$size="UNI";
$qty="1";
$price="71,31"; //2.71.72_125.00 *0.7(30% discount)=87.50, 87.50/1.22(VAT)=EUR 71.72   후에db에서 계산.
$ReferencePrice="87,00";
$currency="EUR";

$mp_params=array(
"OrderId"=>$ordno
,"Retailer"=>$mall_name
,"BuyerInfo"=>array("Name"=>$receiver,   "Address"=>$address,   "ZipCode"=>$zipcode, "City"=>$city,   "ISOcountry"=>$ISOcountry,   "Courier"=>"",   "Notes"=>$memo,   "TypeShipping"=>$TypeShipping,   "Identification1"=>"",   "Identification2"=>"")
,"GoodsList"=>array("Good"=>array(
array("ID"=>$goodsno, "Size"=>$size, "Qty"=>$qty, "Price"=>$price,"ReferencePrice"=>$ReferencePrice, "Currency"=>$currency )
)
)
);

$userpwd="Marketplace:@Te7/8,n0?J";


$turl="http://atelier-hub.com/hub/GoodsPriceList";
$turl="http://atelier-hub.com/hub/GoodsList";

$turl="http://atelier-hub.com/hub/GetOrderShippingInfo?orderID=20200323000145";
$turl="http://atelier-hub.com/hub/CancelOrder?orderID=20200323000145";

$turl="http://atelier-hub.com/hub/ColorList";


$turl="http://atelier-hub.com/hub/CreateNewOrder";
$turl="http://atelier-hub.com/hub/GetOrderStatusByTs?date=20200403";

$turl="http://atelier-hub.com/hub/GoodsPriceList?goodslD=1378003";
//$strArrResult = request_curla($turl, 1, http_build_query($mp_params), $mp_header,$userpwd);
$strArrResult = request_curla($turl, 0, json_encode($mp_params), $mp_header,$userpwd);
tydebug($strArrResult);
if( $strArrResult[3] != '200' ) {
	
	 err_log('marketplace_api_error',$strArrResult[0]."/".$strArrResult[1]."/".$strArrResult[2],$strArrResult[3],'cron');
	 die;
	 return;
}

$strArrResult = json_decode($strArrResult[0],1);

tydebug($strArrResult);
foreach($strArrResult as $k=>$v){
	
	tydebug($k);
}


function request_curla($url, $is_post=0, $data=array(), $header=null ,$userpwd=null) {
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL,$url);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_SSLVERSION,1);
	curl_setopt ($ch, CURLOPT_POST, $is_post);
	if($is_post) {
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	}
	//curl_setopt ($ch, CURLOPT_COOKIESESSION, true);
	//curl_setopt ($ch, CURLOPT_COOKIEFILE , '/tmp/mpc_cookies.txt');
	curl_setopt ($ch, CURLOPT_TIMEOUT, 300);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_MAXREDIRS , 20);
	if($userpwd){
		curl_setopt($ch, CURLOPT_USERPWD , $userpwd);
	}




	if($header) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
	$result[0] = curl_exec ($ch);
	$result[1] = curl_errno($ch);
	$result[2] = curl_error($ch);
	$result[3] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
	return $result;
}
?>