<?php /* Template_ 2.2.8 2020/12/18 16:05:42 /www/html/ukk_test2/data/skin/outline/_header.htm 000003390 */ ?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!--<link rel="icon" href="../../favicon.ico">-->
<title>TM-erp</title>

<link href="//fonts.googleapis.com/css?family=Black+Han+Sans:400" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="../js/jquery-ui.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
<script src="../js/ScrollToPlugin.min.js"></script>
<link rel="stylesheet" type="text/css" href="../data/skin/css/datatables.min.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../data/skin/css/bootstrap.css">
<link rel="stylesheet" href="../data/skin/style.css">
<script src="../js/common.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link rel="stylesheet" href="../data/skin/css/fullcalendar.css">
<script src="../js/fullcalendar.min.js"></script>
<!--
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
-->

<link href="../data/skin/css/theme.default.min.css" rel="stylesheet">
<script src="../js/jquery.tablesorter.min.js"></script>
<script src="../js/jquery.tablesorter.widgets.min.js"></script>


<script src="../js/bootbox.min.js"></script>
<!-- 다음우편번호 -->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

</head>

<body>
<header class=""></header>
<div class="container">

<?php if(!$GLOBALS["popup_chk2"]){?>
	<!-- Navigation Menu -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-center">
			<div class="navbar-header">
				<a class="navbar-brand" href="../main/index.php">TREND MECCA Admin</a>
<?php if(!$GLOBALS["popup_chk"]){?>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php }?>
			</div>
			<div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
<?php if($GLOBALS["sess"]&&!$GLOBALS["popup_chk"]){?>
<?php $this->print_("top_menu",$TPL_SCP,1);?>

<?php }?>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
	<!-- Navigation Menu -->
	<div id="main_div" class="bgc1"></div>

	<div style="height:20px;"></div>
<?php }?>
	
<!-- Main Contents -->
<?php if($GLOBALS["popup_chk"]||$GLOBALS["popup_chk2"]){?>	
	<div class="maincontents_pop">
<?php }else{?>
	<div class="container maincontents">
<?php }?>