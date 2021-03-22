<?
include "../_header.php";

$page_title='CS관리(회수확인-반품)';
$returnType='return';
$step='2';
$CANCEL=NEW cancel();

/*매장코드*/
$codedata=get_codedata('place','1'); 

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

/**
 * s_mall_no : 몰번호
 * s_receiver : 고객명
 * s_invoice : 송장번호
 * s_date : 주문일자 (시작)
 * e_date : 주문일자 (종료)
 * s_mall_goodsnm : 모델명
 * s_ordno : 주문번호
 */

$add_where[]="ci.return_type between '20' and '49'";
$add_where[]="cd.send_type='1'";
$add_where[]="ci.return_type!='0'";
$add_where[]="cd.order_list_no > '0'";

if(count($add_where)){
    /*리스트*/	    
    if(count($add_where)){
        $add_where=" and ".implode(" and ",$add_where);
    }
    $qry="select cd.mall_goodsnm, sum(cd.exchange_goods_num) as sum_egn, g.goodsnm, b.brand_img_folder from cs_info ci
    left join cs_detail cd on (ci.no=cd.cs_info_no) 
    left join goods g on (cd.goods_no=g.no) 
    left join brand b on (g.brandno = b.no)	
    where 1=1 $add_where group by goods_no";

    $res=$db->query($qry);
    $data=$res->results;

    foreach($data as $v){
        $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        $v['confirmNm']="미확인";
        $v['confirmColor']="red";
        //tydebug($v['goodsnm']);
        $listArr[$v['goodsnm']]=$v['sum_egn'];
        $loop[$v['goodsnm']]=$v;
    }	
        
    if($_POST['s_invoice']){
        
        $paste_arr = paste_to_arr($_POST['s_invoice']);
        //송장의 합계수량을 구한다.
        foreach($paste_arr as $v){
            $searchArr[$v]++;
        }	
        
        //반품되야될 리스트의 상품과 비교
        foreach($searchArr as $k=>$v){
            //검색한상품이 없을경우
            if(!$listArr[$k]){
                $notData[$k]++;
            //리스트의 수보다 검색수가 작을때
            }else if($v<$listArr[$k]){
                $loop[$k]['confirmNm']="수량차이(".$v.")";
            //리스트의 수보다 검색수가 클때
            }else if($v>$listArr[$k]){
                $loop[$k]['confirmNm']="확인";
                $loop[$k]['confirmColor']="blue";

                $notData[$k]++;
            //일치할경우
            }else{
                $loop[$k]['confirmNm']="확인";
                $loop[$k]['confirmColor']="blue";
            }
        }
    }
    
	$tpl->assign(array(	
    'loop' => $loop
    ,'notData' => $notData
	));
}

$tpl->print_('tpl');
?>
