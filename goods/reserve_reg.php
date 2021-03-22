<?
include "../_header.php";

$page_title='예약재고등록';

$popup_chk=1; //메뉴 컨트롤
$goodsno=$_REQUEST['goodsno'];
$order_no=$_GET['order_no'];
$order_list_no=$_REQUEST['order_list_no'];


/*리스트*/
if($_POST['s_goodsnm']){
    $paste_arr = paste_to_arr($_POST['s_goodsnm']);
    foreach($paste_arr as $v){
        $goodsnmArray[]="g.goodsnm like '%".$v."%' ";
    }
    if(count($goodsnmArray))$add_where[]="(".implode(" or ",$goodsnmArray).")";
}
if($_POST['s_goodsnmSub'])$add_where[]="g.goodsnm_sub like '%".$_POST['s_goodsnmSub']."%' ";

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}


if($_POST['mode']=='reserve_ins'){

	try
		{
		$db->beginTransaction();

		$qry="select g.goodsnm,gcl.codeno_51,gcl.codeno_1 from goods_cnt_loc gcl 
		join goods g on g.no=gcl.goodsno
		where gcl.goodsno=:goodsno";
		$res=$db->query($qry,array(":goodsno"=>$_POST['gno']));
		
		foreach($res->results as $v){
			
			if( ($v['codeno_'.$_POST['codeno']]<$_POST['gcnt']) ){
				msg('재고가 부족합니다','reserve_reg.php');
				die;
			}
		}
		$goodsnm=$res->results['0']['goodsnm'];

		$okd=stock_io('reserve',$_POST["gno"],$goodsnm,-$_POST["gcnt"],$_POST["order_list_no"],$_SERVER['REQUEST_URI'],$_POST["codeno"],$cfg['hold_loc']);
		$okd=stock_io('reserve',$_POST["gno"],$goodsnm,$_POST["gcnt"],$_POST["order_list_no"],$_SERVER['REQUEST_URI'],$cfg['hold_loc'],$_POST["codeno"]);

		$qry="insert into reserve_list set
		goodsno=:goodsno
		,cnt=:cnt
		,memo=:memo
		,reference_no=:reference_no
		,stock_loc=:stock_loc
		,reg_date=now()
		,admin_no=:admin_no
		";

		$param[':goodsno']=$_POST['gno'];
		$param[':cnt']=$_POST['gcnt'];
		$param[':memo']=$_POST['memo'];
		$param[':reference_no']=$_POST['order_list_no'];
		$param[':stock_loc']=$_POST['codeno'];
		$param[':admin_no']=$_SESSION['sess']['m_no'];
		
		if($db->query($qry,$param)){

			guadmin_stock_ctl($param[':goodsno'],$param[':cnt'],$param[':stock_loc'],'out',$param[':reference_no'],'교환예약');
		}
	

		$db->commit();
		MsgViewCloseReload('처리되었습니다.');

	}catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}
	
}
 $codedata=get_codedata('place','main');
if($_POST && $add_where){
   
    $cntArray="";
    foreach($codedata as $v){
        $cntArray[]="gcl.codeno_".$v['no'];        
    }
    if(count($cntArray)) $sumCnt=" , ".implode(",",$cntArray);

    $qry="select g.*, b.brandnm, b.brand_img_folder ".$sumCnt." from goods g
    left join brand b on (g.brandno=b.no)
    left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
    where 1 ".$add_where."
    order by modi_date desc, reg_date desc";
    $res = $db->query($qry);
    foreach($res->results as $v){
        $hqry="select count(no) as cnt from stock_hold where status='0' and goodsno='".$v['no']."'";
        $hres=$db->query($hqry);
        $hcount=$res->results[0]['cnt'];
        $v['hold_count']=$hcount;
        $v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
        $loop[]=$v;    
    }   
    $tpl->assign(array(
        'loop'=>$loop
    ));
}
$tpl->print_('tpl');

?>