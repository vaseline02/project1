<?
include "../_header.php";

$page_title='메뉴등록';

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';
$sn=$_GET['sn'];
$checked['state']['y']='checked';

if($_POST['mode']){
	if($_POST['cateCheck']=='1'){
		$qr="menunm=:menunm
			,sort=:sort
			,state=:state				
			";

		$param=array(":menunm"=>$_POST["menunm"],":sort"=>$_POST["1depthSort"],":state"=>$_POST["1depthState"]);	

		if($_POST['mode']=='ins'){		
			$qry="insert into menu set
			".$qr."
			,reg_date=now()
			";	

		}

	}else if($_POST['cateCheck']=='2'){

		$qr="menu_snm=:menu_snm
			,menu_sn=:menu_sn
			,link=:link
			,sort=:sort
			,state=:state				
			";

		$param=array(":menu_snm"=>$_POST["menu_snm"],":menu_sn"=>$_POST["menu"],":link"=>$_POST["2depthLink"],":sort"=>$_POST["2depthSort"],":state"=>$_POST["2depthState"]);

		if($_POST['mode']=='ins'){				
			
			$qry="insert into menu_set set
			".$qr."
			,reg_date=now()
			";
			

		}else if($_POST['mode']=='mod'){


			$qry="update menu_set set
			".$qr."
			where sn=:sn
			";
			
			$param[':sn']=$_POST['sn'];
		}
	
	}

	if($res=$db->query($qry,$param)){

		msg("처리되었습니다","menu_reg.php");		
		
		
	}else{
		tydebug('err_res_chk');
	}
	
}


// 1차카테고리
$qry="select * from menu order by sort asc";
$res = $db->query($qry,$param);


foreach($res->results as $v){

	$cateLoop[]=$v;
}


if($_GET['sn']){
	// 2차카테고리
	$param=array(":sn"=>$_GET["sn"]);
	$qry="select * from menu_set where sn=:sn";

	$res=$db->query($qry,$param);
	$data=$res->results[0];

	$selected['menu_sn'][$data['menu_sn']]='selected';
	$checked['state'][$data['state']]='checked';
}

$tpl->assign(array(	
'cateLoop' => $cateLoop
));
$tpl->assign($data);

$tpl->print_('tpl');
?>
