<?
include "../_header.php";

$page_title='몰 정보 수정';

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';
$no=$_GET['no'];
$checked['state']['y']='checked';


$brand_list=get_brand_info("","",array('O','A'));

if(!$h_control['calcu']){
	$readonlay='readonly';
	$disabled='disabled';
}

if($_POST['mode']){

#,d_type=:d_type
$qr="mall_name=:mall_name
	,mall_code=:mall_code
	,wms_mallnm=:wms_mallnm
	,d_name=:d_name				
	,d2_name=:d2_name
	,sales_code=:sales_code
	,sales_team=:sales_team
	,c_mem_name=:c_mem_name
	,upload_form_type=:upload_form_type
	,state=:state
	,m_no=:m_no
	,d_code=:d_code
	,d2_code=:d2_code
	";
	

//,":d_type"=>$_POST["d_type"]
$param=array(
	":mall_name"=>$_POST["mall_name"]
	,":mall_code"=>$_POST["mall_code"]
	,":wms_mallnm"=>$_POST["wms_mallnm"]
	,":d_name"=>$_POST["d_name"]
	,":d2_name"=>$_POST["d2_name"]
	,":sales_code"=>$_POST["sales_code"]
	,":sales_team"=>$_POST["sales_team"]
	,":c_mem_name"=>$_POST["c_mem_name"]
	#,":brand"=>$_POST["brand"]
	,":upload_form_type"=>$_POST["upload_form_type"]
	,":state"=>$_POST["state"]
	,":m_no"=>$_SESSION['sess']['m_no']
	,":d_code"=>$_POST["d_code"]
	,":d2_code"=>$_POST["d2_code"]
	
);

	if($_POST['mode']=='mod'){
		$add_where=" and no!=:no"; 
		$param_chk[':no']=$_POST['no'];
	}
	
	$param_chk[":d_code"]=$_POST["d_code"];
	$param_chk[":d2_code"]=$_POST["d2_code"];


	
	//코드 중복확인
	$qry="select count(no) as mallTotal from mall_list where d_code=:d_code and d2_code=:d2_code ".$add_where." ";
	$res=$db->query($qry,$param_chk);
	$data=$res->results[0];

	if($data['mallTotal']<1){

		if($_POST['mode']=='ins'){	

			$qry="insert into mall_list set
			".$qr."			
			,reg_date=now()
			";

			if($res=$db->query($qry,$param)){
				$lastMallNo=$res->lastId;
				
				if($_POST['brand_no']){
					foreach($_POST['brand_no'] as $bv){
						$sqry="select brandnm from brand where no='".$bv."'";
						$sres=$db->query($sqry);
						$brandnm=$sres->results[0]['brandnm'];		
						
						
						if(!$brandCnt){
							$iqry="insert into mall_brand set
							mall_no='".$lastMallNo."'
							,brand_no='".$bv."'
							,mall_name='".$_POST["mall_name"]."'
							,brand_name='".$brandnm."'
							,reg_date=now()	
							";			
							$db->query($iqry);
						}
					}
				}

				MsgViewCloseReload("처리되었습니다.");			
			}else{
				tydebug('err_res_chk');
			}

		}else if($_POST['mode']=='mod'){       
			$qry="update mall_list set
			".$qr."
			,reg_date=now()
			where no=:no
			";

			$param[':no']=$_POST['no'];
			if($res=$db->query($qry,$param)){
				
				if($_POST['brand_no']){
					$dqry="delete from mall_brand where mall_no='".$no."' and brand_no not in('".implode("','",$_POST['brand_no'])."')";
					$db->query($dqry);

					foreach($_POST['brand_no'] as $bv){
						$sqry="select brandnm from brand where no='".$bv."'";
						$sres=$db->query($sqry);
						$brandnm=$sres->results[0]['brandnm'];		

						$sqry="select count(no) as cnt from mall_brand where mall_no='".$no."' and brand_no='".$bv."'";
						$sres=$db->query($sqry);
						$brandCnt=$sres->results[0]['cnt'];		
						
						if(!$brandCnt){
							$iqry="insert into mall_brand set
							mall_no='".$no."'
							,brand_no='".$bv."'
							,mall_name='".$_POST["mall_name"]."'
							,brand_name='".$brandnm."'
							,reg_date=now()	
							";			
							$db->query($iqry);
						}
					}
				}else{
					$dqry="delete from mall_brand where mall_no='".$no."'";
					$db->query($dqry);
				}

				
				MsgViewCloseReload("처리되었습니다.");			
			}else{
				tydebug('err_res_chk');
			}
		}

		
	}else{
		msg("중복된 코드가 존재합니다.",-1);			
	}        

    
}

$qry="select upload_form_type from mall_list where upload_form_type!='' group by upload_form_type";
$res=$db->query($qry);

foreach($res->results as $v){
	$upload_form_type[]=$v['upload_form_type'];
}

if($_GET['no']){
	// 2차카테고리
	$param=array(":no"=>$_GET["no"]);
	$qry="select * from mall_list where no=:no";

	$res=$db->query($qry,$param);
    $data=$res->results[0];
    
	$selected['state'][$data['state']]='selected';
}

$sqry="select * from mall_brand where mall_no='".$no."'";
$sres=$db->query($sqry);
foreach($sres->results as $mbv){	
	$checked['brand'][$mbv['brand_no']]="checked";
}


$tpl->assign($data);
$tpl->assign(array(
	'brand_list'=>$brand_list

));

$tpl->print_('tpl');
?>
