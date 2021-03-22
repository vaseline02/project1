<?
include "../_header.php";

//io_type 반품 / cs_return loc_f
//io_type 교환접수시 / cs_hold -1 loc_f
//io_type 교환완료시 / cs_exchange
//io_type 교환접수건 반품완료시 / cs_exchange_b loc_f


$codedata=get_codedata('place','1');

foreach($codedata as $v){
	$place_name[$v['no']]=$v['cd'];
}
$add_where[]="cd.no in ('".implode("','",$_POST['chk_no'])."')";

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
   
$qry="
select v.* from (
    select 'return' as codename, cd.*
        , ol.courier_code, ol.invoice, ol.order_num, ol.mall_no as ol_mall_no, ol.mall_name, ol.deli_codeno, ol.buyer, ol.receiver, ol.mobile, ol.order_price as order_price
        , g.no as gno, g.goodsnm
        , ml.mall_code
        , sil.loc_f
    from 
    cs_detail cd
    left join order_list ol on (cd.order_list_no=ol.no)
    left join goods g on (cd.goods_no=g.no) 
    left join brand b on (g.brandno = b.no)	
    left join mall_list ml on (cd.mall_no=ml.no)
    left join stock_io_log sil on (cd.no=sil.reference_no and sil.io_type in ('cs_return','cs_exchange_b'))
    where 1=1 ".$add_where."
    union
    select 'exchange' as codename, cd.*
        , ol.courier_code, ol.invoice, ol.order_num, ol.mall_no as ol_mall_no, ol.mall_name, ol.deli_codeno, ol.buyer, ol.receiver, ol.mobile, (ol.order_price+cd.diff_price) as order_price
        , g.no as gno, g.goodsnm 
        , ml.mall_code
        , sil.loc_f
    from 
    cs_detail cd
    left join order_list ol on (cd.order_list_no=ol.no)
    left join goods g on (cd.exchange_goods_no=g.no) 
    left join brand b on (g.brandno = b.no)	
    left join mall_list ml on (cd.mall_no=ml.no)
    left join stock_io_log sil on (cd.no=sil.reference_no and sil.io_type='cs_hold' and sil.cnt<0)
    where 1=1 ".$add_where." and cd.exchange_goods_no != 0
) v order by v.end_reg_date desc
";
$res = $db->query($qry);
foreach($res->results as $v){
    if($v['codename']=="return"){
        $v['inout']="IN";
    }else if($v['codename']=="exchange"){
        $v['inout']="OUT";
    }
    $v['ent_name']=$v['mall_name'];
    $v['ent_name'].=" ".$v['upload_form_type'];
    $v['place_name']=$place_name[$v['loc_f']];
    $v['order_num']=$v['exchange_goods_num'];
    
    if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
    $loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));


/*리스트 . 구 재고 어드민에 올리는 형식을 다운받기 위해서 임시로 만들어서 사용.*/

// if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";

// $param = $db->inqry_param($_POST['chk_no']);

// $qry="select o.*,ml.mall_code,ml.ent_nm from order_list o
// join mall_list ml on o.mall_no=ml.no
// where o.no in (".implode(",",array_keys($param)).")
// ".$add_where."
// ";

// $res = $db->query($qry,$param);


// $bf_ordno='';
// $color_key=0;
// $list_num=1;

// foreach($res->results as $v){
// 	$v['place_name']=$place_name[$v['deli_codeno']];

// 	if($v['upload_form_type']=='셀피아')$v['tot_price']=$v['order_price']*$v['order_num'];
// 	else $v['tot_price']=$v['order_price'];

// 	$v['ent_name']=($v['ent_nm'])?$v['ent_nm']:$v['mall_name'];
// 	$v['ent_name'].=" ".$v['upload_form_type'];
	
// 	$loop[]=$v;
// }

// $tpl->assign(array(	
// 'loop' => $loop
// ));

$tpl->print_('tpl');
?>