<?php
include "../_header.php";

$mode=$_POST['mode'];

if($mode=='cate'){
    $depth=$_POST['depth'];
    $depth_1=$_POST['depth_1'];
    $depth_2=$_POST['depth_2'];
    $depth_3=$_POST['depth_3'];
    $depth_4=$_POST['depth_4'];

    if($depth=="1"){
        $catelist=get_cate_info($depth_1);
    }else if($depth=="2"){  
        $catelist=get_cate_info($depth_1,$depth_2);
    }else if($depth=="3"){
        $catelist=get_cate_info($depth_1,$depth_2,$depth_3);
    }

    echo json_encode($catelist);
}else if($mode=='goods'){
    $val=$_POST['val'];
    $goodsnm=paste_to_arr($val);
    foreach($goodsnm as $v){
        $qry="select count(no) as cnt from goods g where goodsnm='".$v."'";
        $res=$db->query($qry);
        $cnt=$res->results[0]['cnt'];
        if(!$cnt) $not_goodsnm[]=$v;
    }
    echo json_encode($not_goodsnm);
}
?>