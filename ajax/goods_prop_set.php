<?
include "../_header.php";
	
if($_POST['mode']=='ins'){

	$qry="select col_name from market_solution_prop where no='".$_POST['seq']."'";
	$res=$db->query($qry);

	$data=$res->results['0']['col_name'];

	if($_POST['prop_val']){

		if($data){
			$data=$data."|".$_POST['prop_val'];
		}else{
			$data=$_POST['prop_val'];
		}
	}

	$qry="update market_solution_prop set
	col_name='".$data."'
	where no='".$_POST['seq']."'
	";

}else if($_POST['mode']=='reset'){
	$qry="update market_solution_prop set
	col_name=''
	where no='".$_POST['seq']."'
	";
}else if($_POST['mode']=='def_set'){
	$qry="update market_solution_prop set
	def_val='".$_POST['prop_val']."'
	where no='".$_POST['seq']."'
	";
}
if($db->query($qry))echo "1";
else echo "false";

?>