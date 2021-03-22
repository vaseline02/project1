<?
include "../_header.php";

$page_title='바코드확인';
$popup_chk=1; //메뉴 컨트롤

$add_where[]="ci.return_type in ('2','3')";
$add_where[]="cd.send_type='1'";
$add_where[]="cd.return_confirm='0'";
$add_where[]="cd.order_list_no > '0'";

if($_POST['mode']=='mod'){
    $qry="update cs_info ci left join cs_detail cd on (ci.no=cd.cs_info_no) set cd.return_confirm='1' where 1=1 and ".implode(' and ',$add_where);
    $db->query($qry);
    msg("처리되었습니다.","send_check.php");
}

if(count($add_where)){
    /*리스트*/	    
    if(count($add_where)){
        $add_where=" and ".implode(" and ",$add_where);
    }
    $qry="select cd.goods_no, cd.mall_goodsnm, sum(cd.exchange_goods_num) as sum_egn, g.goodsnm, b.brand_img_folder from cs_info ci
    left join cs_detail cd on (ci.no=cd.cs_info_no) 
    left join goods g on (cd.goods_no=g.no) 
    left join brand b on (g.brandno = b.no)	
    where 1=1 $add_where group by goods_no";

    $res=$db->query($qry);
    $data=$res->results;

    $allClean='0';
    foreach($data as $v){
        $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        $v['confirmNm']="미확인";
        $v['confirmColor']="red";
        $listArr[$v['goods_no']]=$v['sum_egn'];
        $loop[$v['goods_no']]=$v;
        $allClean++;
    }	
        
    if($_POST['s_barcode']){
        
        $barcode_arr = paste_to_arr($_POST['s_barcode']);
        //송장의 합계수량을 구한다.
        foreach($barcode_arr as $v){
            $qry="select gb.goodsno from goods_barcode gb where gb.barcode='".$v."'";
            $res=$db->query($qry);
            $goodsNo=$res->results[0]['goodsno'];
            
            //리스트의 바코드 상품이 없을떄나 등록되있지않은 바코드일때
            if(!$goodsNo || !$listArr[$goodsNo]){
                $notData[$v]++;
            }else{
                $searchArr[$goodsNo]++;
                $barcodeNum[$goodsNo]=$v;
            }            
        }	
        
        //반품되야될 리스트의 상품과 비교
        foreach($searchArr as $k=>$v){                       
            //리스트의 수보다 검색수가 작을때
            if($v<$listArr[$k]){
                $minuNum=$listArr[$k]-$v;
                $loop[$k]['confirmNm']="수량부족(".$minuNum.")";
            //리스트의 수보다 검색수가 클때
            }else if($v>$listArr[$k]){
                $loop[$k]['confirmNm']="확인";
                $loop[$k]['confirmColor']="blue";
                $notData[$barcodeNum[$k]]="초과(".($v-$listArr[$k]).")";

                $allClean--;
            //일치할경우
            }else{
                $loop[$k]['confirmNm']="확인";
                $loop[$k]['confirmColor']="blue";
                
                $allClean--;
            }
        }
    }
    
	$tpl->assign(array(	
    'loop' => $loop
    ,'notData' => $notData
    ,'allClean' => $allClean
	));
}
    
$tpl->print_('tpl');
?>
