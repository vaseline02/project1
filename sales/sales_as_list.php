<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
$page_title='더존입출고';

/*
$time = time(); 
$_GET['s_date']=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$_GET['e_date']=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 
*/
//몰명리스트 함수
$mall_list=get_mall_info();

$mode=$_POST["mode"];
$no=$_POST["no"];
$QUERY_STRING = $_SERVER['QUERY_STRING'];

$selected['date_type'][$_GET['date_type']]="selected";

if($_GET['date_type'] && $_GET['s_date'] && $_GET['e_date']){
    //하자등록
    if($_GET['date_type']=='2'){
        //$where[]="DATE_FORMAT(cb.reg_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
		$where[]="step not in ('61') and DATE_FORMAT(cb.reg_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
        $date_column="cb.reg_date";
    //양품전환
    }else if($_GET['date_type']=='1'){
        $where[]="step in ('60','62')";
        $where[]="DATE_FORMAT(cb.mod_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
        $date_column="cb.mod_date";
    //폐기
	}else if($_GET['date_type']=='3'){
         //$where[]="DATE_FORMAT(cb.reg_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
		$where[]="step in ('61') and DATE_FORMAT(cb.mod_date,'%Y-%m-%d') between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
        $date_column="cb.mod_date";
    }

    $qry="select cb.*, DATE_FORMAT(".$date_column.",'%Y%m%d') as date_column, g.goodsnm as g_goodsnm, b.brandnm  from cs_bad cb
    left join goods g on (cb.goods_no=g.no)
    left join brand b on (g.brandno=b.no)
    where ".implode(" and ", $where)."
    order by ".$date_column." desc
    ";

    $res=$db->query($qry);
    foreach($res->results as $v){
        $ex_cost=explode("^",$v['cost']);
        $v['cost']=$ex_cost[1];
        $v['division']=($_GET['date_type']=="3")?"2":$_GET['date_type'];
        $v['date']=$v['date_column'];
        if($_GET['date_type']=="1"){
			$codeList=get_codedata('PLACE','','66');

			//tydebug($codeList);
			$v['place_code']=$codeList[0]['place_code'];
            //$v['place_code']="9091";
			$v['etc_text']="상품불량AS필요";
        }else if($_GET['date_type']=="2"){
            $v['place_code']="1010";
			$v['etc_text']="상품불량AS필요";
        }else if($_GET['date_type']=="3"){
            $v['place_code']="9091";
			$v['etc_text']="폐기";
        }
       
        $loop[]=$v;
    }
}

$tpl->assign(array(	
	'loop' => $loop
	,'mall_list' => $mall_list
));
    
$tpl->print_('tpl');
?>
