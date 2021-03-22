<?
include "../_header.php";

$page_title='주문업로드';
$GOODS=new goods();
if($_GET['mode']=='del_today_order' && $_GET['del_mall']){
	
	$add_where="and upload_form_type=:mall_name";

	$qry="select count(*) cnt from order_list where 
	step in('3','4')
	".$add_where."
	and reg_date=curdate()
	";
	
	$res=$db->query($qry,array(":mall_name"=>$_GET['del_mall']));

	$cnt=$res->results['0']['cnt'];
	
	if($cnt==0){

		$qry="delete from order_list 
		where 1
		".$add_where."
		and step in('".implode("','",$order_before_stock_step)."','6') 
		#and (step2='0' or step2>39)
		and reg_date=curdate()
		";//오늘 올린것 중에서 재고 빠지기 전까지의 주문(네비1~4번) + 외부발송건 ( 취소포함)

		$res=$db->query($qry,array(":mall_name"=>$_GET['del_mall']));

		msg("삭제처리되었습니다.","order_upload.php");
		
	}else{
		msg("재고처리된 주문이 있습니다.","order_upload.php");
	}
	
}



//몰정보
$mall_info=get_mall_info('y');

//도매주문수량
$res=$db->query("select count(*) cnt from wholesale_order where step='1' and refund='n' ");
$b2b_cnt=$res->results['0']['cnt'];


foreach($mall_info as $v){
	if($v['mall_gubun'])$arr_mall3[$v['upload_form_type']][]=$v['mall_name'];
	else if( $v['upload_form_type']!='B2B' && $v['upload_form_type']!='사방넷' && $v['upload_form_type']!='오피셜')$arr_mall[$v['upload_form_type']][]=$v['mall_name'];
	else if($v['upload_form_type']=='오피셜')$arr_mall2[$v['upload_form_type']][]=$v['mall_name'];
}
$arr_mall_add[]='사방넷';

 $cnt_mall=count($arr_mall);


 $arr_front = array_slice($arr_mall, 0, $cnt_mall-1); //처음부터 해당 인덱스까지 자름
 $arr_end = array_slice($arr_mall, $cnt_mall-1); //해당인덱스 부터 마지막까지 자름

 $arr_front['B2B'] = array('B2B');//새 값 추가
 $arr_front['사방넷'] = $arr_mall_add;//새 값 추가

 $arr_mall_tot[] = array_merge($arr_front, $arr_end);

 $arr_mall_tot[]=$arr_mall2;
 $arr_mall_tot[]=$arr_mall3;

//미처리 주문건  step 5는 처리종료( wms에 업로드까지 끝난 주문)
$qry="select count(*) cnt ,mall_name,upload_form_type from order_list where step not in('5') 
#and step2!='41'
and csno='0'
and reg_date = curdate() 
group by upload_form_type,mall_name ";
$res=$db->query($qry);
foreach($res->results as $v){
	
	if($v['upload_form_type']=='사방넷')$v['mall_name']='사방넷';
	if($v['upload_form_type']=='B2B')$v['mall_name']='B2B';
	
	$today_order_type[$v['upload_form_type']]+=$v['cnt'];
	$today_order[$v['upload_form_type']][$v['mall_name']]+=$v['cnt'];

	$tot_order+=$v['cnt'];
}

$tpl->assign(array(	
'arr_mall'=>$arr_mall_tot
,'arr_mall3'=>$arr_mall_tot2
,'arr_order_form'=>$arr_order_form
,'today_order'=>$today_order
,'today_order_type'=>$today_order_type
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
