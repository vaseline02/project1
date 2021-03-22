<?

#xls_file/order_test_excel.xlsx
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);

include "../_header.php";

/*
$qry="select g.*, m.no as mno, m.name as mname from timemecca190426.model m
left join  goods g  on (g.goodsnm=m.name)
";
$res=$db->query($qry);
foreach($res->results as $v){
    if(!$v['goodsnm']) $error[]=$v['mname'];
}

tydebug($error);

exit;

$qry="select ole.*, cc.company_code, ifnull(g.no,0) as goodsno, ifnull(ml.no,0) as mallno, ml.upload_form_type as mall_upload_form_type,ml.mall_name as ml_mall_name  from t_order_list_excel_2020 ole 
left join goods g on (ole.n=g.goodsnm)
left join company_code cc on (ole.g=cc.company_name and member_code !='')
left join mall_list ml on (cc.company_code=ml.mall_code)
where ole.ai in ('51_8_7','1_8_7')
order by c asc";
*/

$qry="select ole.*, ml.mall_code, ifnull(g.no,0) as goodsno, ifnull(ml.no,0) as mallno, ml.upload_form_type as mall_upload_form_type,ml.mall_name as ml_mall_name  from t_order_list_excel_2020 ole 
left join goods g on (ole.n=g.goodsnm)
#left join company_code cc on (ole.g=cc.company_name and member_code !='')
left join mall_list ml on (ole.g=ml.d2_name)
where ole.ai in ('1_9_1')
order by c asc";

$res=$db->query($qry);
exit;

foreach($res->results as $v){
    
    if(!$v['goodsno']) $error[]=$v['n'];

    $deli_codeno=reset(explode("_",$v['ai']));
    
	if(!$v['v'])$v['v']=$v['u'];
	if(!$v['u'])$v['u']=$v['v'];

    $query = "insert into order_list set
    csno='0'
    ,ordno='".$v['f']."'
    ,ori_ordno='".$v['f']."'
    ,bundle='0' 
    ,mall_name='".$v['ml_mall_name']."'
    ,mall_no='".$v['mallno']."'
    ,ord_date='".$v['c']."'
    ,reg_date='".$v['b']."'
    ,mod_date=''
    ,step='5'
    ,step2='0'
    ,mall_goodsnm='".$v['o']."'
    ,goodsnm='".$v['n']."'
    ,ori_goodsnm='".$v['n']."'
    ,goodsno='".$v['goodsno']."'
    ,order_num='".$v['q']."'
    ,return_num='0'
    ,exchange_num='0'
    ,order_price='".str_replace(",","",$v['r'])."'
    ,settle_price='".str_replace(",","",$v['r'])."'
    ,order_cost=''
    ,deli_price='0'
    ,deli_type='0'
    ,deli_codeno='".$deli_codeno."' 
    ,buyer='".$v['i']."'
    ,receiver='".$v['t']."'
    ,buyer_mobile='".$v['v']."'
    ,mobile='".$v['u']."'
    ,zipcode='".$v['w']."'
    ,address='".$v['x']."'
    ,commission='0'
    ,order_memo='".$v['ab']."'
    ,courier_code='CJGLS'
    ,invoice='".$v['h']."'
    ,return_courier_code=''
    ,return_invoice=''
    ,memo='수기업로드'
    ,cha_su='".$v['d']."'
    ,wms_ordno='".$v['e']."'
    ,copy_seq='0'
    ,upload_form_type='".$v['mall_upload_form_type']."'
    ,mall_key=''
	,mall_key2=''
    ,reorder_yn='n'
    ";
    $db->query($query);
    // tydebug($query);
}
tydebug($error);
?>