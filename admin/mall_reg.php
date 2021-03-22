<?
include "../_header.php";

$page_title='메뉴등록';

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';
$no=$_GET['no'];
$checked['state']['y']='checked';


if($_POST['mode']){
    $qr="mall_name=:mall_name
        ,upload_form_type=:upload_form_type
        ,state=:state				
        ,sort=:sort
        ";

    $param=array(
        ":mall_name"=>$_POST["mall_name"]
        ,":upload_form_type"=>$_POST["upload_form_type"]
        ,":state"=>$_POST["state"]
        ,":sort"=>$_POST["sort"]
    );
    if($_POST['mode']=='ins'){				
        
        //코드 중복확인
        $res=$db->query("select count(no) as mallTotal from mall_list where mall_code=:mall_code",array(":mall_code"=>$_POST["mall_code"]));
        $data=$res->results[0];

        if($data['mallTotal']<1){
            $qry="insert into mall_list set
            ".$qr."
            ,mall_code=:mall_code
            ,reg_date=now()
            ";

            $param[':mall_code']=$_POST['mall_code'];

            if($res=$db->query($qry,$param)){
                MsgViewCloseReload("처리되었습니다.");			
            }else{
                tydebug('err_res_chk');
            }

        }else{
            msg("중복된 코드가 존재합니다.",-1);			
        }        

    }else if($_POST['mode']=='mod'){       
        $qry="update mall_list set
        ".$qr."
        where no=:no
        ";
        
        $param[':no']=$_POST['no'];

        if($res=$db->query($qry,$param)){
            MsgViewCloseReload("처리되었습니다.");			
        }else{
            tydebug('err_res_chk');
        }
    }
}

if($_GET['no']){
	// 2차카테고리
	$param=array(":no"=>$_GET["no"]);
	$qry="select * from mall_list where no=:no";

	$res=$db->query($qry,$param);
    $data=$res->results[0];
    
	$checked['state'][$data['state']]='checked';
}

$tpl->assign($data);

$tpl->print_('tpl');
?>
