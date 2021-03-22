<?
include "../_header.php";

$page_title='재고이동 내역';
$popup_chk=1; //메뉴 컨트롤
$codeno = $_GET['codeno'];
$goodsno = $_GET['no']; 


if(!$codeno || !$goodsno){
    msg('잘못된 접근입니다.','close');
}


if($codeno == 87 ){
	$column = '방송';
}else if($codeno == 55){
	$column = '마케팅매입';
}else if($codeno == 104){
	$column = '외부샘플';
}


$qry = "select sil.*,
(select cd from codedata where sil.loc_b = no and type = 'PLACE') as loc_b_place,
(select cd from codedata where sil.loc_f = no and type = 'PLACE') as loc_f_place 
from stock_io_log sil
where sil.goodsno = ".$goodsno." 
and sil.loc_f = ".$codeno."
and sil.cnt > 0 
and sil.io_type = 'move' 
order by sil.reg_date desc ";

$res=$db->query($qry);

foreach($res->results as $v){

	if(strpos($v['reference_page'], '/stock_move') !== false) {  

		$sqry="select * from stock_move_log where no='".$v['reference_no']."'";
		$sres=$db->query($sqry);
		$v['memo']=$sres->results[0]['memo'];

	}else if(strpos($v['reference_page'], '/stock_comp') !== false){

		$sqry="select c.title from stock_list sl 
		left join calendar c on (sl.group_id=c.group_id)
		where sl.no='".$v['reference_no']."'";
		$sres=$db->query($sqry);
		$v['memo']=$sres->results[0]['title'];

	}

	$loop[] = $v;
}


$tpl->assign(array(	
	'loop' => $loop
));


$tpl->print_('tpl');
?>