<?
include "../_header.php";

$page_title='업체코드 등록';

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];

if($mode=="ins"){
    try
    {
        $db->beginTransaction();
       
        
        $iqry="insert into company_code set
        account_name=:account_name
        ,company_name=:company_name
        ,company_code=:company_code
        ,company_name2=:company_name2
        ,remark=:remark
        ,member_code=:member_code
        ,member_name=:member_name
        ,status=:status
        ,delivery_code=:delivery_code
        ,delivery_name=:delivery_name
        ,member_code2=:member_code2
        ,member_name2=:member_name2
        ,status2=:status2
        ,delivery_name2=:delivery_name2
        ,sales=:sales
        ,reg_date=now()
        ";

        $iparam[":account_name"]=$_POST["account_name"];
        $iparam[":company_name"]=$_POST["company_name"];
        $iparam[":company_code"]=$_POST["company_code"];
        $iparam[":company_name2"]=$_POST["company_name2"];
        $iparam[":remark"]=$_POST["remark"];
        $iparam[":member_code"]=$_POST["member_code"];
        $iparam[":member_name"]=$_POST["member_name"];
        $iparam[":status"]=$_POST["status"];
        $iparam[":delivery_code"]=$_POST["delivery_code"];
        $iparam[":delivery_name"]=$_POST["delivery_name"];
        $iparam[":member_code2"]=$_POST["member_code2"];
        $iparam[":member_name2"]=$_POST["member_name2"];
        $iparam[":status2"]=$_POST["status2"];
        $iparam[":delivery_name2"]=$_POST["delivery_name2"];
        $iparam[":sales"]=$_POST["sales"];

        $db->query($iqry, $iparam);
        
        $db->commit();
        if($_POST['mode']=='ins' && $receipt_no){
            MsgViewCloseReload("처리되었습니다");	
        }else{
            msg("처리되었습니다","company_code_reg.php?".$_POST['return_url']);	
        }

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"company_code_reg.php?".$_POST['return_url']);
    }  
}


// 2차카테고리
$qry="select * from mall_list order by mall_name";

$res=$db->query($qry);
$mall_list=$res->results;

$tpl->assign($mall_list);

$tpl->print_('tpl');
?>
