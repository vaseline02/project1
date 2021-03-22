<?
include "../_header.php";member_chk();

$page_title='입고내역수정';
$popup_chk=1; //메뉴 컨트롤

$no=$_GET['no'];
$mode=$_REQUEST['mode'];
$page_type=$_GET['page_type'];

if($_POST['no']){
	

	try{		
		$db->beginTransaction();

		$qry="select count(*) cnt from stock_list where group_id=:group_id";
		$res=$db->query($qry,array(":group_id"=>$_POST['group_id']));
		$cnt=$res->results['0']['cnt'];
		
		if($cnt){


			$param=array(":group_id"=>$_POST['group_id']
				,":cost"=>$_POST['cost']
				,":cost_ori"=>$_POST['cost']
				,":stock_num_reg"=>$_POST['stock_num_reg']
				,":stock_num"=>$_POST['stock_num']
				,":now_cnt"=>$_POST['stock_num']
				,":memo"=>$_POST['memo'],":no"=>$_POST['no']);

			if($_POST['group_id_ori']!=$_POST['group_id']){
				$cqry="select date_from from calendar where group_id='".$_POST['group_id']."'";
				$cres=$db->query($cqry);
				$calendar_date=$cres->results[0]['date_from'];

				$set_add=",calendar_date=:calendar_date";
				$param[':calendar_date']=$calendar_date;
			}

			$qry="update stock_list set 
			group_id=:group_id
			,cost=:cost
			,cost_ori=:cost_ori
			,stock_num_reg=:stock_num_reg
			,stock_num=:stock_num
			,now_cnt=:now_cnt
			,memo=:memo 
			".$set_add."
			where no=:no 
			#and (state='0' or comp_chk='n')
			";
			$res=$db->query($qry,$param);

			if($res->count && $_POST['stock_num']!=$_POST['before_stock_num'] && $mode=='comp'){
				
				$cha=$_POST['stock_num']-$_POST['before_stock_num'];
				$okd=stock_io('stock',$_POST['goodsno'],$_POST['goodsnm'],$cha,$_POST['no'],$_SERVER['REQUEST_URI'],'3');
			}
			
			//해당 그룹에 제품이 없다면 달력 삭제
			unset($param);
			$qry="select count(*) cnt from stock_list where group_id=:group_id";
			$param[':group_id']=$_POST['group_id_ori'];
			$res=$db->query($qry,$param);
			
			
			if($res->results['0']['cnt']==0){
				$qry="delete from calendar where group_id=:group_id";
				$db->query($qry,$param);
			}
			$db->commit();
			MsgViewCloseReload('처리되었습니다.');
		}else if( $page_type=='1' ){

			$GOODS=new goods();

			$qry="select * from stock_list where no=:no";
			$res=$db->query($qry,array(":no"=>$_POST['no']));
			$vv=$res->results['0'];

			$cost=$GOODS->cal_stock_price($vv);

			$qry="update stock_list set 
			cost_std=:cost_std
			,cost=:cost
			,cost_ori=:cost_ori
			,stock_num_reg=:stock_num_reg
			,rate=:rate
			,duty_per=:duty_per
			,extra_expense=:extra_expense
			,charge=:charge
			,memo=:memo 
			where no=:no 
			";
			$param=array(
				":cost_std"=>$_POST['cost_std']
				,":cost"=>$cost
				,":cost_ori"=>$cost
				,":stock_num_reg"=>$_POST['stock_num_reg']
				,":rate"=>$_POST['rate']
				,":duty_per"=>$_POST['duty_per']
				,":extra_expense"=>$_POST['extra_expense']
				,":charge"=>$_POST['charge']
				,":memo"=>$_POST['memo']
				,":no"=>$_POST['no']);
				
			if($db->query($qry,$param)){
				$db->commit();
				MsgViewCloseReload('처리되었습니다.');
			}
		}else{

			$db->rollBack();
			msg("존재하지않는 그룹코드입니다.");
		}

	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}
}


$qry="select sl.*,b.brandnm,c.catenm from stock_list sl
left join brand b on sl.brandno = b.no
left join category c on sl.cateno = c.no
where sl.no=:no";

$res=$db->query($qry,array(":no"=>$no));

$data=$res->results['0'];

/* 데이터 입력시
try{
	
	$db->beginTransaction();
	
	$db->commit();
	msg('처리되었습니다.','stock_schedule.php');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}
*/

$tpl->assign($data);

$tpl->print_('tpl');
?>
