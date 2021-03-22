<?
include "../_header.php";

$page_title='상품검색';

$popup_chk=1; //메뉴 컨트롤
$goodsno=$_GET['goodsno'];
$order_no=$_GET['order_no'];
$order_list_no=$_GET['order_list_no'];


/*리스트*/
if($_GET['s_goodsnm']){
    $paste_arr = paste_to_arr($_GET['s_goodsnm']);
    foreach($paste_arr as $v){
        $goodsnmArray[]="g.goodsnm like '%".$v."%' ";
    }
    if(count($goodsnmArray))$add_where[]="(".implode(" or ",$goodsnmArray).")";
}
if($_GET['s_goodsnmSub'])$add_where[]="g.goodsnm_sub like '%".$_GET['s_goodsnmSub']."%' ";

// if(count($add_where)){
//     $add_where=" and ".implode(" and ",$add_where);
// }

if($_GET && $add_where){
    $codedata=get_codedata('place','1');
    $cntArray="";
    foreach($codedata as $v){
        $cntArray[]="gcl.codeno_".$v['no'];        
    }
    if(count($cntArray)) $sumCnt=", (".implode("+",$cntArray).") as totalCnt";

        
    $_GET[page_num]=30;
    $field="g.*, b.brandnm, b.brand_img_folder ".$sumCnt."";
    $db_table="goods g
    left join brand b on (g.brandno=b.no)
    left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
    ";
    $_GET[sort]="modi_date desc, reg_date desc";

    $pg = new page($_GET[page],$_GET[page_num],$no_limit);
    $pg->field = $field;
    $pg->setQuery($db_table,$add_where,$_GET[sort]);
    $pg->exec();
    $qry=$pg->query;


    // $qry="select g.*, b.brandnm, b.brand_img_folder ".$sumCnt." from goods g
    // left join brand b on (g.brandno=b.no)
    // left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
    // where 1 ".$add_where."
    // order by modi_date desc, reg_date desc";
    // //tydebug($qry);
    $res = $db->query($qry);
    foreach($res->results as $v){
        $hqry="select count(no) as cnt from stock_hold where status='0' and goodsno='".$v['no']."'";
        $hres=$db->query($hqry);
        $hcount=$res->results[0]['cnt'];
        $v['hold_count']=$hcount;
        $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        $loop[]=$v;    
    }   
    $tpl->assign(array(
        'loop'=>$loop
        ,'pg'=>$pg
    ));
}
$tpl->print_('tpl');

?>