<?

$xml_log=$sabang_cfg_info['URL'];

tydebug('start_api_sabang');

	tydebug("http://r.sabangnet.co.kr/RTL_API/".$xml_name.".html?xml_url=".$xml_log."/".$file_name);
	/*
	$res=file_get_contents("http://r.sabangnet.co.kr/RTL_API/".$xml_name.".html?xml_url=".$xml_log."/".$file_name);
	$res=mb_convert_encoding($res,'utf-8','euc-kr');
	*/

	$res=request_curl("http://r.sabangnet.co.kr/RTL_API/".$xml_name.".html?xml_url=".$xml_log."/".$file_name);
	$res=implode("/",$res);
	$res=mb_convert_encoding($res,'utf-8','euc-kr');

	tydebug($res);

	$qry="insert into market_solution_sync_log set
	log= '".addslashes($res)."',
	sol_type='sabangnet',
	reg_date=now()
	";

	if($db->query($qry,array(),'cron')){
		//24개 남기고 로그 삭제
		$qry="delete from market_solution_sync_log where no<(select min(a.no) from ( select no from market_solution_sync_log order by no desc limit 0,30 ) a )";
		$db->query($qry,array(),'cron');	
	}
	
tydebug('end_api_sabang');

?>