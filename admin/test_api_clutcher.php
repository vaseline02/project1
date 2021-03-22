<?
$glb_root_cron="/www/html/ukk";
require_once($glb_root_cron."/lib/library.php");

/*
ID: jkim
PASSWORD: gTwmkPKAQPm7zfnfwg85YzgcAb7d8vv2qWMe57q4kkYDCo
*/


$date1 = new DateTime('now', new DateTimeZone('UTC')); 
$timestamp = $date1->format("Y-m-d H:i:s");
tydebug($timestamp);
$timestamp = gmdate("Y-m-d H:i:s");
tydebug($timestamp);
//$timestamp = "2020-03-24 07:29:46";


/*
$app_secret='gTwmkPKAQPm7zfnfwg85YzgcAb7d8vv2qWMe57q4kkYDCo';
$user='jkim';
*/
$app_secret='b3b5CJhbEfqi6LqeueHit9M9SsKUejjRbrwdqqc2hbY3qy';
$user='zig9';

$ver='1.2';


$arr_str=array(
"user"=>$user
,"timestamp"=>$timestamp
,"v"=>"1.2"
);

ksort($arr_str);


$str="";
foreach($arr_str as $k=>$v){
	$str.=$k.$v;		
}

$sign = strtoupper(md5($app_secret.$str.$app_secret));

tydebug($sign);

//$spuID="&spuID=1051";

//1051-137

$mp_params=array(
	"orderNo"=>"TM202004143"
	,"orderItems"=>array(
		array("SkuID"=>"518-144","Qty"=>1,"Price"=>146)
	)
);

/*
$mp_params=array(
	"orderNo"=>"TM202004143"
	,"message"=>"test"
);
*/

$timestamp= urlencode($timestamp);
$param="?timestamp=".$timestamp."&sign=".$sign."&user=".$user."&v=".$ver.$spuID;


$turl="http://ws.theclutcher.com/reseller-api/orders/delete".$param;
$turl="http://ws.theclutcher.com/reseller-api/orders/set".$param;

$turl="http://ws.theclutcher.com/reseller-api/products".$param;
$turl="http://ws.theclutcher.com/reseller-api/orders/set".$param;
tydebug($turl);

$strArrResult = request_curl($turl, 1, ($mp_params), $mp_header,$userpwd);
tydebug($strArrResult);
if( $strArrResult[3] != '200' ) {
	
	 //err_log('marketplace_api_error',$strArrResult[0]."/".$strArrResult[1]."/".$strArrResult[2],$strArrResult[3],'cron');
	 die;
	 return;
}

$strArrResult = json_decode($strArrResult[0],1);

tydebug($strArrResult);

function request_curla($url, $is_post=0, $data=array(), $header=null ,$userpwd=null) {
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL,$url);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_SSLVERSION,1);
	curl_setopt ($ch, CURLOPT_POST, $is_post);
	if($is_post) {
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt ($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt ($ch, CURLOPT_COOKIEFILE , '/tmp/mpc_cookies.txt');
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