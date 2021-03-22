<?
include "../_header.php";member_chk();
require_once("../lib/page.class.php");
require_once("../lib/file.class.php");

$page_title='멤버등록/수정';
$popup_chk=1; //메뉴 컨트롤

if($_POST['mode']){

$qr="name=:name
	,email=:email
	,mobile=:mobile
	,position=:position
	,team=:team
	,team_detail=:team_detail
	,level=:level
	,state=:state
	";

if($_POST['chk_menu'])$qr.=",menu=:menu";



	$param=get_param(array("name","email","position","team","level","mobile","state"));	

	if($_POST['mode']=='ins'){
		
		$chkres=$db->query("select no from member where id='".$_POST['id']."'");
		if($chkres->results[0]['no']){
			msg("사용중인 아이디입니다",-1);
			die;
		}
		
		$qry="insert into member set
		".$qr."
		,id=:id
		,pw='".hash('sha256',$_POST['pw'])."'
		,join_time=now()
		";
		$param[':id']=$_POST['id'];

	}else if($_POST['mode']=='mod'){

		if($_POST['pw_chg']!=''){
			$add_qr=",pw='".hash('sha256',$_POST['pw_chg'])."'";
		}

		$qry="update member set
		".$qr."
		".$add_qr."
		,modify_time=now()
		where no=:no
		";
		
		$param[':no']=$_POST['m_no'];
	}
	
	$team_info=explode("-",$_POST['team']);
	$param[':team']=$team_info[0];
	$param[':team_detail']=$team_info[1];
	$param[':mobile']=implode("-",$_POST['mobile']);
    if($_POST['chk_menu'])$param[':menu']=implode("|",$_POST['chk_menu']);

	if($res=$db->query($qry,$param)){

		msg("처리되었습니다");
		
		if($_POST['mode']=='ins')$_GET['m_no']=$res->lastId;
		else if($_POST['mode']=='mod') $_GET['m_no']=$_POST['m_no'];
		
	}else{
		tydebug('err_res_chk');
	}


	
}


if($_GET['m_no']){
	
	$m_no=$_GET['m_no'];
	$mode='mod';

	$qry="select * from member where no=:no";
	$param=array(":no"=>$_GET['m_no']);
	$res = $db->query($qry,$param);
	$data=$res->results[0];

	$data['mobile']=explode("-",$data['mobile']);

	$data['menu']=explode("|",$data['menu']);
	
	foreach($data['menu'] as $v)$checked['menu'][$v]='checked';

	$selected['team'][$data['team']][$data['team_detail']]='selected';
	$selected['level'][$data['level']]='selected';
	$checked['state'][$data['state']]='checked';

}else{
	$mode='ins';
}

//부서 구성
$qry="select tm.teamnm ,td.team_dnm from team tm
join team_detail td on tm.no = td.team_no
";
$res = $db->query($qry);
foreach($res->results as $v){
	$arr_posi[$v['teamnm']][]=$v['team_dnm'];
}


//메뉴구성
$qry="select m.menunm,ms.menu_snm,ms.sn from menu m
join menu_set ms on m.sn=ms.menu_sn
where 1
and m.state=:mst
and ms.state=:msst
order by m.sort,ms.sort
";

$param=array(":mst"=>"y",":msst"=>"y");
$res=$db->query($qry,$param);

foreach($res->results as $v){
	$arr_menu[$v['menunm']][]=$v;
}

$tpl->assign(array('arr_menu'=>$arr_menu));
$tpl->assign($data);


$tpl->print_('tpl');
?>
