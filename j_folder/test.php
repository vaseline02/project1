<?
include "../_header.php";


$qry="select * from order_list where reg_date<='2021-01-15' and etc_chk='0' and no not in ('899071','974461') order by no desc limit 10
";
$res=$db->query($qry);
$i1="0";
foreach($res->results as $v){
	//마스킹 함수
	$v=infoMasking($v,'order_list');

tydebug($v);

}


exit;
$qry="select g.goodsnm ,g.no,gi.goodsno,(select max(reg_date) from stock_list sl where sl.goodsno=g.`no`) regdt from goods g 
left join goods_info gi on g.no=gi.goodsno
having gi.goodsno is NULL";
$res=$db->query($qry);
foreach($res->results as $k=>$v){
$iqry="insert into goods_info set goodsno='".$v['no']."'";
$db->query($iqry);
}


exit;
$CANCEL=NEW cancel();

tydebug($_SESSION);

try
{
	$db->beginTransaction();
	$CANCEL->cs_cancel('15581','91');

	$db->commit();
}
catch(Exception $e)
{
	$db->rollBack();

	$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';;

	tydebug($s);
   // msg($s,"cs_reg.php?".$_POST['return_url']);
}  
   


//cs_cancel('12000');



exit;
//sms_send($title, $contents, $mobile, $etc_code, $etc_no, '0' ,$order_no);
//echo hash('sha256',"9876");
$_POST["123"]="1233";
$_POST["444"]="12312333";
$_POST["555"]="123231233";



$postArray="";
foreach($_POST as $pk=>$pv){
	if($pv){
		$postArray[]=$pk."=".$pv;
	}
}
$postValue=implode("|",$postArray);
tydebug($_POST);
tydebug($postValue);
tydebug($_SERVER);
$_SERVER['SERVER_NAME'];//서버아이피
$_SERVER['REMOTE_ADDR'];//접속자아이피
exit;
//
sms_send_ppurio('test','test1','01020426057');
/*
 * 응답값
 *
 *  <성공시>
 *    result : 'ok'                           - 전송결과 성공
 *    type   : 'sms'                          - 단문은 sms 장문은 lms 포토문자는 mms
 *    msgid  : '123456789'                    - 발송 msgid (예약취소시 필요)
 *    ok_cnt : 1                              - 발송건수
 *
 *  <실패시>
 *    result : 'invalid_member'               - 연동서비스 신청이 안 됐거나 없는 아이디
 *    result : 'under_maintenance'            - 요청시간에 서버점검중인 경우
 *    result : 'allow_https_only'             - http 요청인 경우
 *    result : 'invalid_ip'                   - 등록된 접속가능 IP가 아닌 경우
 *    result : 'invalid_msg'                  - 문자내용에 오류가 있는 경우
 *    result : 'invalid_names'                - 이름에 오류가 있는 경우
 *    result : 'invalid_subject'              - 제목에 오류가 있는 경우
 *    result : 'invalid_sendtime'             - 예약발송 시간에 오류가 있는 경우 (10분이후부터 다음해말까지 가능)
 *    result : 'invalid_sendtime_maintenance' - 예약발송 시간에 서버점검 예정인 경우
 *    result : 'invalid_phone'                - 수신번호에 오류가 있는 경우
 *    result : 'invalid_msg_over_max'         - 문자내용이 너무 긴 경우
 *    result : 'invalid_callback'             - 발신번호에 오류가 있는 경우
 *    result : 'once_limit_over'              - 1회 최대 발송건수 초과한 경우
 *    result : 'daily_limit_over'             - 1일 최대 발송건수 초과한 경우
 *    result : 'not_enough_point'             - 잔액이 부족한 경우
 *    result : 'over_use_limit'               - 한달 사용금액을 초과한 경우
 *    result : 'server_error'                 - 기타 서버 오류
 */

exit;
$rand_num = sprintf('%06d',rand(000000,999999));

$to = "jkm9424@naver.com";

$subject = "인증메일";

$contents = "인증코드 : ".$rand_num;

$headers = "From: 트랜드메카\r\n";



mail($to, $subject, $contents, $headers);


   exit;

$ORDER=new order();
$GOODS=new goods();


//재고확인해서 품절일경우 로그에넣는다.
$v['goodsnm']="H20HJ207 760 001 (M)";
$goods_stock=$GOODS->get_stock_deli_av(array($v['goodsnm']));

$totstock=$goods_stock->results['0']['totstock'];

//모델별 재고합
$qry="select g.goodsnm, gcl.codeno_130 from goods g 
join goods_cnt_loc gcl on g.no=gcl.goodsno
where g.goodsnm = '".$v['goodsnm']."'
group by g.goodsnm
";
tydebug($qry);
$res=$db->query($qry);
$stock_130=$res->results[0]['codeno_130'];

if($stock_130) $totstock=$totstock+$stock_130;

tydebug($stock_130);

tydebug($totstock);
if($totstock<=0){
//$this->stock_soldout_log($v['goodsno'],'1');
}




exit;
$qry="select * from (select *,
CASE
	WHEN (DATE_FORMAT(ssl2.reg_date, '%H')>'00' && DATE_FORMAT(reg_date, '%H')<='12' )
	THEN '오전'
	ELSE '오후'
END as time_group
from stock_soldout_log ssl2 where DATE_FORMAT(ssl2.reg_date, '%Y-%m-%d') between '2020-11-13' and '2021-01-13'
group by ssl2.type, ssl2.goodsno
) v where v.time_group='오후'
";

//DATE_FORMAT(ssl2.reg_date, '%Y-%m-%d')='".date("Y-m-d",time())."'
$res=$db->query($qry);
tydebug($res->results);

exit;

$psd_stock=goods_psd_stock("19205");

goods_soldout_log("1","19205",str_replace(",","",'1,000'));

//goods_soldout_log("1",$insert_id_goods,str_replace(",","",$v['3']));

tydebug($psd_stock);

exit;
$orderData['exchange_goods_num']="8";
$orderData['order_cost']="1^2^5|4^5^6";
$ex_cost=explode("|",$orderData['order_cost']);

$ordcost_array="";
$return_num=$orderData['exchange_goods_num'];
foreach($ex_cost as $v){
	$ex_data=explode("^",$v);
	
	if($ex_data[2]>=$return_num){
		$ordcost_array[]=$ex_data[0]."^".$ex_data[1]."^".$return_num;
		break;		
	}else{
		$ordcost_array[]=$ex_data[0]."^".$ex_data[1]."^".$ex_data[2];
		$return_num-=$ex_data[2];
	}
}

$order_cost=implode("|",$ordcost_array);
	tydebug($order_cost);

$ex_data=explode("^",$ex_cost['0']);
$ordcost=$ex_data[0]."^".$ex_data[1]."^".$orderData['exchange_goods_num'];
tydebug($ordcost);


exit;


//품절처리된 상품의 로그를 등록한다.
$chk_goods="4";
$chk_goodsnm="123";

$ORDER->stock_soldout_log($chk_goods,'1');

$res=$GOODS->get_stock_deli_av(array($chk_goodsnm));
tydebug($res->results[0]['totstock']);


exit;
$qry="select order_cost, goodsno, no from order_list where 
deli_codeno !='outside' 
and order_cost like '%^%'";
$res=$db->query($qry);
$i=1;
$j=1;
$c=1;
foreach($res->results as $v){
	$excost=explode("^",$v['order_cost']);

	$sqry="select goodsno from stock_list where no='".$excost[0]."'";
	$sres=$db->query($sqry);
	$sgoodsno=$sres->results[0]['goodsno'];

	if($v['goodsno']!=$sgoodsno){
		$sqry="select * from stock_list where goodsno='".$v['goodsno']."' and cost='".$excost[1]."' order by no desc limit 1";
		$sres=$db->query($sqry);
		$stockno=$sres->results[0]['no'];

		if($stockno){
			$order_cost=$stockno."^".$excost[1]."^".$excost[2];
			//tydebug($order_cost);	
		}else{
			$nstock[]=$i."-".$v['no']."_".$v['goodsno']."_".$v['order_cost']."_없음";
			$i++;
		}
		$c++;
		//$uqry="update order_liset set order_cost='".$order_cost."' where no='".$v['no']."'";
		
	}else{
		$ngoodsno[]=$j."-".$v['no']."_".$v['goodsno']."_".$v['order_cost']."_일치";
		$j++;
	}


}

tydebug($nstock);
tydebug($ngoodsno);
tydebug($c);
?>