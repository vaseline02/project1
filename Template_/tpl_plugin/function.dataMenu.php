<?php
function dataMenu(){
	global $db,$sess;

	$m_menu=str_replace("|","','",$sess['menu']);

	$qry="select m.menunm,ms.menu_snm,ms.link from menu m
	join menu_set ms on m.sn=ms.menu_sn
	where 1
	and m.state=:mst
	and ms.state=:msst
	and ms.sn in('".$m_menu."')
	order by m.sort,ms.sort
	";
	
	$param=array(":mst"=>"y",":msst"=>"y");
	$res=$db->query($qry,$param);


	foreach($res->results as $v){
		$menu[$v['menunm']][]=$v;
	}
		
	return $menu;
}
?>