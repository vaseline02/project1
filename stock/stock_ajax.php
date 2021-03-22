<?php
include "../_header.php";


$mode=$_POST['mode'];
if($mode=='groupCheck'){
    $group_id=$_POST['group_id'];
    
    $qry="select count(no) as cnt from stock_list where group_id='".$group_id."'";
    $res = $db->query($qry);
    $data=$res->results[0];

    echo json_encode($data);
}
?>