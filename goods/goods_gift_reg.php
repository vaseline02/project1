<?
include "../_header.php";

$page_title='사은품등록';

$brandlist=get_brand_info();
$catelist=get_cate_info();

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];

$gift_goodsno=$_POST['gift_goodsno'];
$brandno=$_POST['brandno'];
$category_1=$_POST['category_1']?$_POST['category_1']:"000";
$category_2=$_POST['category_2']?$_POST['category_2']:"000";
$category_3=$_POST['category_3']?$_POST['category_3']:"000";
$category_4=$_POST['category_4']?$_POST['category_4']:"000";
$goodsnm=$_POST['goodsnm'];
$status=$_POST['status']?$_POST['status']:"0";
$view_yn=$_POST['view_yn']?$_POST['view_yn']:"Y";

if($mode=="ins"){
    try
    {
        $db->beginTransaction();
        
        $goodsnm_array=paste_to_arr($goodsnm);

        if($category_1){
            $cqry="select * from category c where depth_1='".$category_1."' and depth_2='".$category_2."' and depth_3='".$category_3."' and depth_4='".$category_4."'";
            $cres=$db->query($cqry);
            $cateno=$cres->results[0]['no'];
        }

        if($goodsnm){
            foreach($goodsnm_array as $v){
                $gqry="select count(no) as cnt, no from goods g where goodsnm='".$v."'";
                $gres=$db->query($gqry);
                $goodsData=$gres->results[0];        

                if($goodsData['cnt']){

                    $iqry="insert into goods_freegift set 
                    gift_goodsno=:gift_goodsno
                    ,brandno=:brandno
                    ,categoryno=:categoryno
                    ,goodsno=:goodsno
                    ,view_yn=:view_yn
                    ,status=:status
                    ,reg_date=now()
                    ";
                    $param[":gift_goodsno"]=$gift_goodsno;
                    $param[":brandno"]=$brandno;
                    $param[":categoryno"]=$cateno?$cateno:"0";
                    $param[":goodsno"]=$goodsData['no'];
                    $param[":view_yn"]=$view_yn;
                    $param[":status"]=$status;

                    $db->query($iqry,$param);
                }
            }
        }else{
            $iqry="insert into goods_freegift set 
            gift_goodsno=:gift_goodsno
            ,brandno=:brandno
            ,categoryno=:categoryno
            ,goodsno=:goodsno
            ,view_yn=:view_yn
            ,status=:status
            ,reg_date=now()
            ";
            $param[":gift_goodsno"]=$gift_goodsno;
            $param[":brandno"]=$brandno;
            $param[":categoryno"]=$cateno?$cateno:"0";
            $param[":goodsno"]="0";
            $param[":view_yn"]=$view_yn;
            $param[":status"]=$status;

            $db->query($iqry,$param);
        }

        $db->commit();
        MsgViewCloseReload("처리되었습니다");	

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"goods_gift_reg.php");
    }  
}

$tpl->assign(array(
    'brandlist'=>$brandlist
    ,'catelist'=>$catelist
));

$checked["status"][$status]="checked";
$checked["view_yn"][$view_yn]="checked";
    
$tpl->print_('tpl');
?>
