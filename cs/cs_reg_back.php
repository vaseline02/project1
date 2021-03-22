<?
include "../_header.php";

$page_title='CS관리';

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';
$no=$_GET['no'];

if($_POST['mode']){
	
    $qr="order_list_no=:order_list_no
        ,goods_no=:goods_no
        ,return_type=:return_type
        ,contents=:contents
        ,receiver=:receiver
        ,zipcode=:zipcode
        ,address=:address
        ,mall_goodsnm=:mall_goodsnm
        ,mobile=:mobile
        ,ing_type=:ing_type
        ,admin_no=:admin_no
        ,admin_name=:admin_name
        ,order_no=:order_no
        ,exchange_goods_no=:exchange_goods_no
        ,exchange_goods_nm=:exchange_goods_nm
        ,diff_price=:diff_price
        ";

    $param=array(
        ":order_list_no"=>$_POST["order_list_no"]
        ,":goods_no"=>$_POST["goods_no"]
        ,":return_type"=>$_POST["return_type"]
        ,":contents"=>$_POST["contents"]
        ,":receiver"=>$_POST["receiver"]
        ,":zipcode"=>$_POST["zipcode"]
        ,":address"=>$_POST["address"]
        ,":mall_goodsnm"=>$_POST["mall_goodsnm"]
        ,":mobile"=>$_POST["mobile"]
        ,":ing_type"=>$_POST["ing_type"]
        ,":admin_no"=>$_SESSION["sess"]["m_no"]
        ,":admin_name"=>$_SESSION["sess"]["name"]
        ,":order_no"=>$_POST["order_no"]
        ,":exchange_goods_no"=>$_POST["exchange_goods_no"]
        ,":exchange_goods_nm"=>$_POST["exchange_goods_nm"]
        ,":diff_price"=>$_POST["diff_price"]
    );	
    if($_POST['mode']=='ins'){
        $qry="insert into cs_claim set
        ".$qr."
        ,reg_date=now()
        ";	
    }else if ($_POST['mode']=='mod'){
        $qry="update cs_claim set
        ".$qr."
        where no=:no
        ";	
        $param[':no']=$_POST['claim_no'];
    }

	if($res=$db->query($qry,$param)){

		msg("처리되었습니다",-1);		
		
		
	}else{
		tydebug('err_res_chk');
	}
	
}

/*리스트*/
$qry="select ol.*,g.goodsnm,b.brand_img_folder from order_list ol 
left join goods g on (ol.goodsno=g.no) 
left join brand b on g.brandno = b.no
where ol.no=".$no." ";
$res = $db->query($qry);
$data=$res->results[0];
$data['img_url']=img_url($cfg['img_600_logo'],$data['brand_img_folder'],$data['goodsnm']);

$qry="select cc.*, m.id from cs_claim cc
 left join member m on (cc.admin_no=m.no)
 where cc.order_list_no='".$no."'
 order by cc.reg_date desc";
$res = $db->query($qry);
$contentsHtml="";
foreach($res->results as $v){
    if($v['ing_type']=='1'){
        $v['ingColorType']="ingBlue";
    }else{
        $v['ingColorType']="ingRed";
    }
    $loop[]=$v;    
}

$tpl->assign($data);
$tpl->assign(array(
    'loop'=>$loop
));

$tpl->print_('tpl');
?>
