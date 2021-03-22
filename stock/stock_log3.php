<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
$page_title='반품리스트';

//몰명리스트 함수
$mall_list=get_mall_info();

$mode=$_POST["mode"];
$no=$_POST["no"];
$QUERY_STRING = $_SERVER['QUERY_STRING'];

$selected['date_type'][$_GET['date_type']]="selected";

if($_GET['s_date'] && $_GET['e_date']){
    $where[]="DATE_FORMAT(gsl.reg_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
    $where[]="log_type in ('2','3')";
	
    //품절후입고
    $qry="select gsl.*,g.goodsnm, gcl.cur_cnt from goods_soldout_log gsl
    left join goods g on (gsl.goodsno=g.no)
    left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
    where ".implode(" and ", $where)."
    order by gsl.no desc";

    $res=$db->query($qry);
    foreach($res->results as $v){
        if($v['log_type']=="1"){
            $v['lognm']="신규입고";
            $type="1";
        }elseif($v['log_type']=="2"){
            $v['lognm']="품절입고";
            $type="2";
        }elseif($v['log_type']=="3"){
            $v['lognm']="품절후반품입고";
            $type="2";
        }

        $v['psd_stock']=goods_psd_stock($v['goodsno']);

        $loop[]=$v;
    }

}

$tpl->assign(array(	
	'loop' => $loop
));
    
$tpl->print_('tpl');
?>
