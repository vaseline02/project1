<?
$glb_root_cron="/www/html/ukk";
require_once($glb_root_cron."/lib/library.php");

$db =  new DB($glb_root_cron."/conf/db.conf.php");


$xml_url=$glb_sabang_api_url;

$time_now=date('H');
$res=file_get_contents("http://r.sabangnet.co.kr/RTL_API/xml_goods_info.html?xml_url=".$xml_url."/goods_regi".$time_now.".xml");
//$aaa=file_get_contents("http://r.sabangnet.co.kr/RTL_API/xml_category_info.html?xml_url=".$xml_url."/cate_search.xml");
//$aaa=file_get_contents("https://r.sabangnet.co.kr/RTL_API/xml_order_info.html?xml_url=".$xml_url."/order_info.xml");
//$xml = simplexml_load_string($res,'SimpleXMLElement', LIBXML_NOCDATA);
//$xml = json_decode( json_encode($xml) , 1);

$res=mb_convert_encoding($res,'utf-8','euc-kr');

$qry="insert into market_solution_sync_log set
log= '".addslashes($res)."',
sol_type='sabangnet',
reg_date=now()
";

if($db->query($qry,array(),'cron')){
	//24개 남기고 로그 삭제
	$qry="delete from market_solution_sync_log where no<(select min(a.no) from ( select no from market_solution_sync_log order by no desc limit 0,24 ) a )";
	$db->query($qry,array(),'cron');
	
}





?>