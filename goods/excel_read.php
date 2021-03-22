<?php
include "../_header.php";
require_once("../lib/file.class.php");





$ddata=excel_read();

echo "<pre>";
print_r($ddata);
echo "</pre>";




?>