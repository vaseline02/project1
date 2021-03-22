<?
include "../_header.php";

$page_title='재고이동내역';
$formType='cs';
// tydebug($_SERVER);
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
//몰정보
$mall_info=get_mall_info('y');


$codedata=get_codedata('place');
asort($codedata);

foreach($mall_info as $v){
	//if($v['upload_form_type']!='사방넷')$arr_mall[$v['upload_form_type']][]=$v['mall_name'];
	$arr_mall[$v['upload_form_type']][]=$v['mall_name'];
}

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

$add_where[]="(sil.io_type in ('order','order_d_hold','cs_exchange','quick_move','cs_return','cs_cancel','repairing','repaired','cs_send') or (sil.io_type='move' and (sil.reference_page like '%/stock_move%' or sil.reference_page like '%/stock_comp%')))";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="sil.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($_GET['s_goodsnm'])$add_where[]="sil.goodsnm like '%".$_GET['s_goodsnm']."%' ";
if($_GET['s_reference_no'])$add_where[]="sil.reference_no='".$_GET['s_reference_no']."' ";
if($_GET['s_order_no']){
	$array_having[]="ordno='".$_GET['s_order_no']."' ";
}

if($_GET['s_mall']){
	$array_having[]="upload_form_type='".$_GET['s_mall']."' ";

	$selected['s_mall'][$_GET['s_mall']]='selected';
}

if($array_having){
	$add_having=" having ".implode(" and ",$array_having);
}

if($_GET['s_codedata']){
    $add_where[]="c.no = '".$_GET['s_codedata']."' ";
    $selected['s_codedata'][$_GET['s_codedata']]='selected';
}

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

# 성함(구매자,수령자,접수자), 연락처, 주문번호, 송장번호, 모델명
if($add_where){
	$selectForm="( CASE ";
	foreach($arr_io_type as $k=>$v){
		$io_type="'".implode("','",$v['type'])."'";	
	
		//if($v['column']!=''){
		if($v['column']=="no"){
			$selectForm.="
			WHEN sil.io_type in (".$io_type.")
			THEN(
			";
			//order_list
			if($v['column']=="no"){		
				$selectForm.="select CONCAT(ol.ordno,'|',ol.upload_form_type,'|',ol.settle_price,'|',ol.mall_name) from ".$k." ol where no=sil.reference_no";
			}else if($v['column']!=""){
				//$selectForm.="select CONCAT(ol.ordno,'|',ol.upload_form_type,'|',ol.settle_price) from ".$k." sub_table left join order_list ol on (ol.no=sub_table.".$v['column'].") where sub_table.no=sil.reference_no";
			}
			$selectForm.=")";
		}
	}
	$selectForm.=" ELSE '' END) as ordcol";

	$_GET[page_num]=100;
	$field="*";
	$db_table="(select *
	, SUBSTRING_INDEX(SUBSTRING_INDEX(ordcol, '|', 1), '|', -1) as ordno
	, SUBSTRING_INDEX(SUBSTRING_INDEX(ordcol, '|', 2), '|', -1) as upload_form_type
    , SUBSTRING_INDEX(SUBSTRING_INDEX(ordcol, '|', 3), '|', -1) as settle_price  
    , SUBSTRING_INDEX(SUBSTRING_INDEX(ordcol, '|', 4), '|', -1) as mall_name  
    from (
	select sil.*, c.cd as codename, m.name, 
	".$selectForm."
	from stock_io_log sil
    left join codedata c on (sil.loc_f=c.no)
	left join member m on (sil.m_no=m.no)
    where ".implode(" and ", $add_where)."    
	) v ".$add_having." ) vv
	";
	$_GET[sort]="no desc,reg_date desc";

	$pg = new page($_GET[page],$_GET[page_num],$no_limit);

	$pg->field = $field;
	$pg->setQuery($db_table,$where,$_GET[sort]);
	$pg->exec();
    $qry=$pg->query;
    
    //tydebug($qry);


/*
	$qry="select *
	, SUBSTRING_INDEX(SUBSTRING_INDEX(ordcol, '|', 1), '|', -1) as ordno
	, SUBSTRING_INDEX(SUBSTRING_INDEX(ordcol, '|', 2), '|', -1) as upload_form_type
	, SUBSTRING_INDEX(SUBSTRING_INDEX(ordcol, '|', 3), '|', -1) as settle_price  
	from (
	select sil.*, c.cd as codename, m.name, 
	".$selectForm."
	from stock_io_log sil
    left join codedata c on (sil.loc_f=c.no)
	left join member m on (sil.m_no=m.no)
    where ".implode(" and ", $add_where)."
	) v ".$add_having." order by no desc,reg_date desc
    ";
	//tydebug($qry);
*/
/*
	$qry="select sil.*, c.cd as codename, m.name
	,(select ordno from order_list where no=sil.reference_no and sil.io_type in (".$io_type.") and sil.reference_no not in ('','0')) ordno
	,(select upload_form_type from order_list where no=sil.reference_no and sil.io_type in (".$io_type.") and sil.reference_no not in ('','0')) upload_form_type
	from stock_io_log sil
    left join codedata c on (sil.loc_f=c.no)
	left join member m on (sil.m_no=m.no)
    where ".implode(" and ", $add_where)."
	".$add_having."
    order by sil.no desc,reg_date desc
    ";*/
	//tydebug($qry);
	$res = $db->query($qry);

	foreach($res->results as $v){
        $v['io']=$cfg_stock_io[$v['io_type']];
      
        
        if($v['io_type']=="move"){
			if(strpos($v['reference_page'], '/stock_move') !== false) {  

				$sqry="select * from stock_move_log where no='".$v['reference_no']."'";
				$sres=$db->query($sqry);
				$v['memo']=$sres->results[0]['memo'];
			}else if(strpos($v['reference_page'], '/stock_comp') !== false){
				$sqry="select c.title from stock_list sl 
				left join calendar c on (sl.group_id=c.group_id)
				where sl.no='".$v['reference_no']."'";
				//tydebug1($sqry);
				$sres=$db->query($sqry);
				$v['memo']=$sres->results[0]['title'];
			}

        }else if($v['io_type']=="quick_move"){
            $sqry="select * from stock_quick where no='".$v['reference_no']."'";
            $sres=$db->query($sqry);
            $v['memo']=$sres->results[0]['memo'];

        }else if($v['io_type']=="cs_return" || $v['io_type']=="repairing"  || $v['io_type']=="repaired"){

            $sqry="select ol.ordno, ol.settle_price, ol.mall_name from cs_detail cd
            left join order_list ol on (cd.order_list_no=ol.no)
            where cd.no='".$v['reference_no']."'";
            $sres=$db->query($sqry);
            $csData=$sres->results[0];
            $v['ordno']=$csData['ordno'];
            $v['settle_price']=$csData['settle_price'];
            $v['mall_name']=$csData['mall_name'];

        }else if($v['io_type']=="cs_exchange" || $v['io_type']=="cs_send"){
            $sqry="select * from order_list ol
            where ol.csno='".$v['reference_no']."'";
            $sres=$db->query($sqry);
            $csData=$sres->results[0];
            $v['ordno']=$csData['ordno'];
            $v['settle_price']=$csData['settle_price'];
            $v['mall_name']=$csData['mall_name'];

        }
        
		$loop[]=$v;
	}
}
    

$tpl->assign(array(	
'loop' => $loop
,'arr_mall' => $arr_mall
,'pg' => $pg
));

$tpl->print_('tpl');
?>
