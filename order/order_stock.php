<?
include "../_header.php";

tydebug($_SESSION['sess']['m_id']=='jkm9424');
tydebug($_SERVER['DOCUMENT_ROOT']);
$tpl->define('tpl', $_SERVER['DOCUMENT_ROOT'].'/ukk_test/order/order_stock_shortage.php' );
$tpl->print_('tpl');
?>
