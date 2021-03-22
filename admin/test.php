<?
include "../_header.php";

$qry="select m.name,m.no
,(select min(cost) from timemecca1.stock where customer not in('반품','재고이동') and io='IN' and m_no=m.no and del_yn='N' ) cost1
,(select min(cost) from timemecca1.stock where io='IN' and m_no=m.no and del_yn='N') cost2
from timemecca1.model m
#where m.no='106'
having cost2<cost1";

$res=$db->query($qry);


foreach($res->results as $v){

	$qry="select no,m_no,cost,place,io,customer,invoice,memo from timemecca1.stock where io='IN' and del_yn='N' and cost<'".$v['cost1']."' and m_no='".$v['no']."' ";
	
	$res2=$db->query($qry);
	foreach($res2->results as $v2){
		
		$v2['cost1']=$v['cost1'];
		$v2['name']=$v['name'];
		$data[]=$v2;
		
	}
	
}

$tpl->print_('tpl');
?>