<?
include "../_header.php";

$page_title='카테고리등록';

$catelist=get_cate_info();

$popup_chk=1; //메뉴 컨트롤
$mode=$_POST['mode'];

$category_1=$_POST['category_1']?$_POST['category_1']:"000";
$category_2=$_POST['category_2']?$_POST['category_2']:"000";
$category_3=$_POST['category_3']?$_POST['category_3']:"000";
$category_4=$_POST['category_4']?$_POST['category_4']:"000";
$catenm=$_POST['catenm'];
$view_yn=$_POST['view_yn']?$_POST['view_yn']:"Y";

if($mode=="ins"){
    try
    {
        $db->beginTransaction();
        
        if($category_1!="000"){
            $where[]="depth_1='".$category_1."'";
            if($category_2!="000"){
                $where[]="depth_2='".$category_2."'";
                if($category_3!="000"){
                    $where[]="depth_3='".$category_3."'";
                    $sub_where[]="depth_4!='000'";
                    $depthno="4";                    
                }else{
                    $sub_where[]="depth_3!='000'";
                    $depthno="3";
                }
            }else{
                $sub_where[]="depth_2!='000'";
                $depthno="2";
            }
        }else{
            $sub_where[]="depth_1!='000'";
            $depthno="1";
        }
        if($where){
            $add_where=" and ".implode(" and ",$where);
            $add_ins=",".implode(", ",$where);
        }
        if($sub_where)$add_sub_where=" and ".implode(" and ",$sub_where);


        $cqry="select 
        LPAD((c.depth_".$depthno."+1),3,0) as newdepth, 
        IFNULL(((select sort from category c2 where 1=1 ".$add_where." ".$add_sub_where." order by sort desc limit 1)+1),'1') as newsort 
        from category c where 1=1 ".$add_where;
        $cqry.="order by depth_".$depthno." desc limit 1";
        $cres=$db->query($cqry);
        $cateData=$cres->results[0];

        $iqry="insert into category set         
        catenm='".$catenm."'
        ".$add_ins."
        ,depth_".$depthno."='".$cateData['newdepth']."'
        ,view_yn='".$view_yn."'
        ,depth='".$depthno."'
        ,sort='".$cateData['newsort']."'
        ,reg_date=now()
        ";

        $db->query($iqry);
     
        $db->commit();
        MsgViewCloseReload("처리되었습니다");	

    }
    catch(Exception $e)
    {
        $db->rollBack();

        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        msg($s,"category_reg.php");
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
