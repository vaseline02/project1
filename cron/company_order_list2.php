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
*/
$qry="select ole.*, cc.company_code, ifnull(ml.no,0) as mallno, ml.upload_form_type as mall_upload_form_type,ml.mall_name as ml_mall_name, di.code as delivery_code  from t_order_list_excel_b ole 
left join company_code cc on (ole.p=cc.company_name and member_code !='')
left join mall_list ml on (cc.company_code=ml.mall_code)
left join delivery_info di on (ole.y=di.name)
order by c asc ";

$res=$db->query($qry);


foreach($res->results as $v){
    
    if(!$v['mallno']) $error[$v['p']]=$v['no'];

    $deli_codeno=reset(explode("_",$v['ai']));
    /*
    $query = "insert into order_list_b set
    csno='0'
    ,ordno='".$v['q']."'
    ,ori_ordno='".$v['q']."'
    ,bundle='0' 
    ,mall_name='".$v['ml_mall_name']."'
    ,mall_no='".$v['mallno']."'
    ,ord_date='".$v['c']."'
    ,reg_date='".$v['c']."'
    ,mod_date=''
    ,step='5'
    ,step2='0'
    ,mall_goodsnm='".$v['f']."'
    ,goodsnm='".$v['f']."'
    ,ori_goodsnm='".$v['f']."'
    ,goodsno='0'
    ,order_num='".$v['g']."'
    ,return_num='0'
    ,exchange_num='0'
    #,order_price='".str_replace(",","",$v['r'])."'
    ,settle_price='".str_replace(",","",$v['l'])."'
    ,order_cost=''
    ,deli_price='".str_replace(",","",$v['j'])."'
    ,deli_type='0'
    #,deli_codeno='".$deli_codeno."' 
    ,buyer='".$v['s']."'
    ,receiver='".$v['s']."'
    ,buyer_mobile='".$v['v']."'
    ,mobile='".$v['w']."'
    ,zipcode='".$v['t']."'
    ,address='".$v['u']."'
    ,commission='0'
    ,order_memo='".$v['x']."'
    ,courier_code='".$v['delivery_code']."'
    ,invoice='".$v['z']."'
    ,return_courier_code=''
    ,return_invoice=''
    ,memo='위탁수기업로드'
    #,cha_su='".$v['d']."'
    #,wms_ordno='".$v['e']."'
    ,copy_seq='0'
    ,upload_form_type='".$v['mall_upload_form_type']."'
    ,mall_key=''
	,mall_key2='".$v['r']."'
    ,reorder_yn='n'
    ,consumer_price='".$v['h']."'
    ,purchase_price='".$v['i']."'
    ,ent_code='".$v['ab']."'
    ";
    $db->query($query);
    */
    // tydebug($query);
}
tydebug($error);
?>