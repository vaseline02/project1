<?
include "../_header.php";

$page_title='재고이동';

$popup_chk=1; //메뉴 컨트롤
$codedata=get_codedata('place');
asort($codedata);

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_POST['mode']=='move'){
	try
    {
		$db->beginTransaction();

		$iqry="insert into stock_move_log set
		goodsno='".$_POST['no']."'
		,goodsnm='".$_POST['goodsnm']."'
		,quantity='".$_POST['moveCnt']."'
		,memo='".$_POST['memo']."'
		,s_move='".$_POST['s_cnt']."'
		,e_move='".$_POST['e_cnt']."'
		,admin_no='".$_SESSION['sess']['m_no']."'
		,admin_name='".$_SESSION['sess']['name']."'
		,reg_date=now()
		";

		$res=$db->query($iqry);
		$lastNo=$res->lastId;

		stock_io('move',$_POST['no'],$_POST['goodsnm'],-$_POST['moveCnt'],$lastNo,$_SERVER['REQUEST_URI'],$_POST['s_cnt'],$_POST['e_cnt']);
		stock_io('move',$_POST['no'],$_POST['goodsnm'],$_POST['moveCnt'],$lastNo,$_SERVER['REQUEST_URI'],$_POST['e_cnt'],$_POST['s_cnt']);

		
		
		$db->commit();

		MsgViewCloseReload('처리되었습니다.');
//		msg('처리되었습니다.','stock_move_reg.php?'.$QUERY_STRING);

		
	}
	catch(Exception $e)
	{
		$db->rollBack();

		$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
		msg($s,$returnUrl);
	}  
}

$qry="select * from goods g
left join goods_cnt_loc gcl on (g.no=gcl.goodsno)
where g.no='".$_GET['no']."'";
$res = $db->query($qry,$param);
$data=$res->results[0];

foreach($codedata as $k=>$v){
	$codedata[$k]['cnt']=$data['codeno_'.$v['no']];	
}

$tpl->assign(array(	
'data' => $data
));

$tpl->print_('tpl');
?>
