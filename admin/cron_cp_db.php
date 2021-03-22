<?php
$glb_root_cron="/www/html/ukk_test";
require_once($glb_root_cron."/lib/db.class.php");
require_once($glb_root_cron."/lib/lib.func.php");

$db =  new DB($glb_root_cron."/conf/db.conf.php");


$yoil=date('w');

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'mecca12#';
$dbname = 'new_erp_backup'.$yoil;

exec("mysqldump --user=$dbuser --password='$dbpass' --host=$dbhost new_erp > ".$glb_root_cron."/admin/ddd_back.sql");
sleep(5);

$qry="drop database $dbname";
if($db->query($qry,array(),'cron')){
	$qry="create database $dbname";
	if($db->query($qry,array(),'cron')){
		exec("mysql --user=$dbuser --password='$dbpass' --host=$dbhost $dbname < ".$glb_root_cron."/admin/ddd_back.sql");
	}
}

?>
