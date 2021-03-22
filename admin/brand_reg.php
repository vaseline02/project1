<?
include "../_header.php";

$page_title='브랜드 등록/수정';

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';
$no=$_GET['no'];

if($_POST['mode']){
    $qr="brandnm=:brandnm
		,brandnm_en=:brandnm_en
        ,brand_img_folder=:brand_img_folder
		,brand_img_nm=:brand_img_nm
        ,memo=:memo				
        ,type=:type				
        ";

    $param=array(
        ":brandnm"=>$_POST["brandnm"]
		,":brandnm_en"=>$_POST["brandnm_en"]
        ,":brand_img_folder"=>$_POST["brand_img_folder"]
		,":brand_img_nm"=>$_POST["brand_img_nm"]
        ,":memo"=>$_POST["memo"]
        ,":type"=>$_POST["type"]
    );	

    if($_POST['mode']=='ins'){		
        $qry="insert into brand set
        ".$qr."
        ,save_time=now()
        ";	
    }else if($_POST['mode']=='mod'){
        $qry="update brand set
        ".$qr."
        where no=:no
        ";	
        $param[":no"]=$_POST["no"];
    }
	
	if($res=$db->query($qry,$param)){

		msg("처리되었습니다",-1);		
		
		
	}else{
		tydebug('err_res_chk');
	}
	
}

if($_GET['no']){
	// 2차카테고리
	$param=array(":no"=>$_GET["no"]);
	$qry="select * from brand where no=:no";

	$res=$db->query($qry,$param);
	$data=$res->results[0];
}
$type=$data['type']?$data['type']:"I";
$checked['type'][$type]="checked";
$tpl->assign($data);

$tpl->print_('tpl');
?>
