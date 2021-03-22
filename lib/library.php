<?
include dirname(__FILE__) . "/../Template_/Template_.class.php";
include dirname(__FILE__) . "/lib.func.php";
include dirname(__FILE__) . "/db.class.php";
include dirname(__FILE__) . "/../conf/config.php";
include dirname(__FILE__) . "/session.class.php";

session_start();

$tpl = new Template_;
$tpl->template_dir	= dirname(__FILE__)."/../data/skin";

$tpl->compile_dir	= dirname(__FILE__)."/../Template_/_compiles";

$tpl->prefilter	= "include_file";

$key_file = preg_replace( "'^.*$cfg[rootDir]/'si", "", $_SERVER['SCRIPT_NAME'] );
$key_file = preg_replace( "'\.php$'si", ".htm", $key_file );


$db =  new DB(dirname(__FILE__)."/../conf/db.conf.php");
//$db2 =  new DB2(dirname(__FILE__)."/../conf/db.conf.php");
$session =  new session();

$sess = $_SESSION['sess'];

?>