<?
include "../_header.php";member_chk();


switch($_POST['mode']){
	case "ins":

		$qry="insert into calendar set
		u_id='".$sess['m_id']."'
		,date_from='".$_POST['date_from']."'
		,date_to='".$_POST['date_to']."'
		,type='".$_POST['type']."'
		,title='".$_POST['title']."'
		,save_time=now()
		";
		break;
	case "mod":
		$qry="update calendar set
		u_id='".$sess['m_id']."'
		#,date_from='".$_POST['date_from']."'
		#,date_to='".$_POST['date_to']."'
		,type='".$_POST['type']."'
		,title='".$_POST['title']."'
		,save_time=now()
		where no='".$_POST['no']."'
		";
		break;
	case "mod_date":
		
		$qry="update stock_list set ";
		

		$qry="update calendar set
		u_id='".$sess['m_id']."'
		,date_from= date_from + INTERVAL '".$_POST['dayDelta']."' DAY
		,date_to= date_to + INTERVAL '".$_POST['dayDelta']."' DAY
		where no='".$_POST['no']."'
		";
		
		if($db->query($qry)){
			$sel_qry="select date_to from calendar where no='".$_POST['no']."'";
			$res=$db->query($sel_qry);

			$qry="update stock_list set calendar_date='".$res->results['0']['date_to']."'
			where group_id='".$_POST['group_id']."'
			";
		}
		

		break;
	case "del":
		
		$qry="delete from calendar where no='".$_POST['no']."'";
		
		break;
}






if($db->query($qry))echo "s";
else echo "f";

?>