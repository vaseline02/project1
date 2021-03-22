<?
include "../_header.php";

$page_title='카테고리관리';

$mode=$_POST["mode"];

if($mode=='del'){
    $no=$_POST["no"];

    $dqry="delete from category where no='".$no."'";
    $db->query($dqry);

    msg("삭제되었습니다.","category_list.php");
}

$_GET[page_num]=100;
$field="c.*, concat(depth_1,depth_2,depth_3,depth_4) as catecode
,IF(c.depth_1!='000',(select catenm from category c1 where c1.depth_1=c.depth_1 and c1.depth_2='000' and c1.depth_3='000' and c1.depth_4='000'),'') as cate_1
,IF(c.depth_2!='000',(select catenm from category c2 where c2.depth_1=c.depth_1 and c2.depth_2=c.depth_2 and c2.depth_3='000' and c2.depth_4='000'),'') as cate_2
,IF(c.depth_3!='000',(select catenm from category c3 where c3.depth_1=c.depth_1 and c3.depth_2=c.depth_2 and c3.depth_3=c.depth_3 and c3.depth_4='000'),'') as cate_3
,IF(c.depth_4!='000',(select catenm from category c4 where c4.depth_1=c.depth_1 and c4.depth_2=c.depth_2 and c4.depth_3=c.depth_3 and c4.depth_4=c.depth_4),'') as cate_4
";
$db_table="category c ";
$_GET[sort]="depth_1, depth_2, depth_3, depth_4, sort";

$pg = new page($_GET[page],$_GET[page_num],$no_limit);
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);
$pg->exec();
$qry=$pg->query;

$res = $db->query($qry);

foreach($res->results as $v){
    $cate_where=array();
    $gqry="select count(goodsno) as g_cnt from goods_link where cateno='".$v['no']."'";
    $gres=$db->query($gqry);
    $v['g_cnt']=$gres->results[0]['g_cnt'];

    for($i=1;$i<=$v['depth'];$i++){
        $now_depth="depth_".$i;
        $cate_where[]=$now_depth."='".$v[$now_depth]."'";
    }
    
    $cqry="select count(no) as c_cnt from category where 1=1 and ".implode(" and ", $cate_where)." and depth>".$v['depth'];   
    $cres=$db->query($cqry);
    $v['c_cnt']=$cres->results[0]['c_cnt'];
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	
));

$tpl->print_('tpl');
?>
