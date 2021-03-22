<?
include "../_header.php";member_chk();

$page_title='상품카테고리관리';

$QUERY_STRING = $_SERVER['QUERY_STRING'];
$mode=$_POST['mode'];

$catelist=get_cate_info();
$category_1=$_POST['category_1']?$_POST['category_1']:"000";
$category_2=$_POST['category_2']?$_POST['category_2']:"000";
$category_3=$_POST['category_3']?$_POST['category_3']:"000";
$category_4=$_POST['category_4']?$_POST['category_4']:"000";

$s_category_1=$_GET['s_category_1']?$_GET['s_category_1']:"000";
$s_category_2=$_GET['s_category_2']?$_GET['s_category_2']:"000";
$s_category_3=$_GET['s_category_3']?$_GET['s_category_3']:"000";
$s_category_4=$_GET['s_category_4']?$_GET['s_category_4']:"000";

$selected['s_category_1'][$_GET['s_category_1']]="selected";
$selected['s_category_2'][$_GET['s_category_2']]="selected";
$selected['s_category_3'][$_GET['s_category_3']]="selected";
$selected['s_category_4'][$_GET['s_category_4']]="selected";

if($mode=="ins"){
    foreach($_POST['chk_no'] as $v){
        $sqry="select * from category where 
        depth_1='".$category_1."'
        and depth_2='".$category_2."'
        and depth_3='".$category_3."'
        and depth_4='".$category_4."'
        ";
        $sres=$db->query($sqry);
        $cateNo=$sres->results[0]['no'];

        $sqry="select count(no) as cnt from goods_link where 
        goodsno='".$v."'
        and category='".$category_1.$category_2.$category_3.$category_4."'
        ";
        $sres=$db->query($sqry);
        $linkCnt=$sres->results[0]['cnt'];

        if(!$linkCnt){
            $iqry="insert into goods_link set
            goodsno='".$v."'
            ,cateno='".$cateNo."'
            ,category='".$category_1.$category_2.$category_3.$category_4."'
            ";
            $db->query($iqry);
        }
    }
    msg('처리되었습니다.','goods_cate.php?'.$QUERY_STRING);
}else if($mode=="del"){

    $dqry="delete from goods_link where no='".$_POST['no']."'";
    $db->query($dqry);
    msg('처리되었습니다.','goods_cate.php?'.$QUERY_STRING);
}

if($_GET['s_paste']){
	$s_paste=paste_to_arr($_GET['s_paste']);
	if($s_paste){
		$s_paste_imp=implode("','",$s_paste);
		$where[]="g.goodsnm in ('".$s_paste_imp."')";	
	}
}
if($_GET['s_brand'])$where[]="b.brandnm like '".$_GET['s_brand']."%'";
if($_GET['s_model'])$where[]="g.goodsnm like '".$_GET['s_model']."%'";
if($_GET['s_category_1'])$where[]="g.no in (select goodsno from goods_link gl where category='".$s_category_1.$s_category_2.$s_category_3.$s_category_4."')";



$_GET[page_num]=100;
$field="g.*,b.brandnm,b.brand_img_folder,gcl.*";
$db_table="goods g
left join brand b on g.brandno = b.no
join goods_cnt_loc gcl on g.no=gcl.goodsno
";

if($_GET['s_paste'])$no_limit=1;

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);

$pg->exec();
$qry=$pg->query;

$res = $db->query($qry);

foreach($res->results as $v){
	
    $sqry="select gl.*, c.no as cno, concat(depth_1,depth_2,depth_3,depth_4) as catecode
    ,IF(c.depth_1!='000',(select catenm from category c1 where c1.depth_1=c.depth_1 and c1.depth_2='000' and c1.depth_3='000' and c1.depth_4='000'),'') as cate_1
    ,IF(c.depth_2!='000',(select catenm from category c2 where c2.depth_1=c.depth_1 and c2.depth_2=c.depth_2 and c2.depth_3='000' and c2.depth_4='000'),'') as cate_2
    ,IF(c.depth_3!='000',(select catenm from category c3 where c3.depth_1=c.depth_1 and c3.depth_2=c.depth_2 and c3.depth_3=c.depth_3 and c3.depth_4='000'),'') as cate_3
    ,IF(c.depth_4!='000',(select catenm from category c4 where c4.depth_1=c.depth_1 and c4.depth_2=c.depth_2 and c4.depth_3=c.depth_3 and c4.depth_4=c.depth_4),'') as cate_4
    from goods_link gl 
    left join category c on (
        substring(gl.category, 1, 3)=c.depth_1
        and if(substring(gl.category, 4, 3),substring(gl.category, 4, 3),'000')=c.depth_2
        and if(substring(gl.category, 7, 3),substring(gl.category, 7, 3),'000')=c.depth_3
        and if(substring(gl.category, 10, 3),substring(gl.category, 10, 3),'000')=c.depth_4
    )
    where goodsno='".$v['no']."'";
    
    $sres=$db->query($sqry);
    
	$v['cate']=$sres->results;
		
	if($print_xls){
		if($_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}else{
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
	}
	$loop[$v['goodsnm']]=$v;
}

//붙여넣기가 있으면 붙여넣기 순서로 재정렬
if($_GET['s_paste']){
	
	$paste_arr = paste_to_arr($_GET['s_paste']);
	foreach($paste_arr as $v){

		if($loop[$v]){
			$tmp_arr[]=$loop[$v];
			unset($loop[$v]);
		}
	}
	$loop=$tmp_arr;
}



$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg
,'catelist'=>$catelist
));

$tpl->print_('tpl');
?>
