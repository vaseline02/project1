<?
include "../_header.php";

$aaaa=get_cate_info();

foreach($aaaa['001'] as $kk=>$vv){
    if(is_array($vv)){
        tydebug($kk);
    tydebug($vv['catenm']);
    } 
}
