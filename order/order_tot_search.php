<?
include "../_header.php";

$page_title='주문 통합검색';

$popup_chk=1; //메뉴 컨트롤
$ORDER=new order();
/*리스트*/



$data_search = $ORDER->order_search_where();

if($data_search){

	$qry="select ol.* from order_list ol
	where 1
	and ol.step!='5' 
	".$data_search['where']."
	order by ol.mall_name,ol.ordno
	";

	$res = $db->query($qry,$data_search['param']);
	
	foreach($res->results as $v){
		
		//주문단계,링크로드
		$order_step_view=order_step_view($v);

		$v['step_lv']=$order_step_view['step_lv'];
		$v['step_lv_link']=$order_step_view['step_lv_link'];
	
		$loop[$v['ordno']][]=$v;		
	}

	//붙여넣기가 있으면 붙여넣기 순서로 재정렬
	if($_POST['order_search_ordno'] && count($_POST['order_search_ordno'])>1){
		
		$order_search_ordno_arr = paste_to_arr($_POST['order_search_ordno']);
		foreach($order_search_ordno_arr as $v){

			if($loop[$v]){
				foreach($loop[$v] as $v2){
					$tmp_arr[]=$v2;
				}
				
				unset($loop[$v]);
			}
		}
		$loop=$tmp_arr;
		
	}else{
		foreach($loop as $v){
			foreach($v as $v2){
				$tmp_arr[]=$v2;
			}
		}
		
		$loop=$tmp_arr;
	}

	$tpl->assign('loop',$loop);

}

$tpl->print_('tpl');
?>
