<?php /* Template_ 2.2.8 2020/09/25 09:15:10 /www/html/ukk_test2/data/skin/outline/_top_menu.htm 000002497 */  $this->include_("dataMenu");?>
<?/*?>
<ul class="nav navbar-nav">
<?php if(is_array($TPL_R1=dataMenu())&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $TPL_K1?><span class="caret"></span></a>
	  <ul class="dropdown-menu" role="menu">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<li><a href="<?php echo $TPL_V2["link"]?>"><?php echo $TPL_V2["menu_snm"]?></a></li>
<?php }}?>
	  </ul>
	</li>
<?php }}?>
<!--
	<li><a href="#about">About1</a></li>
	<li><a href="#contact">Contact</a></li>
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
	  <ul class="dropdown-menu" role="menu">
		<li><a href="#">Action11</a></li>
		<li><a href="#">Another action</a></li>
		<li><a href="#">Something else here</a></li>
		<li class="divider"></li>
		<li class="dropdown-header">Nav header</li>
		<li><a href="#">Separated link</a></li>
		<li><a href="#">One more separated link</a></li>
	  </ul>
	</li>
-->
</ul>
<ul class="nav navbar-nav navbar-right">
	<li class="active"><a href="../member/logout.php"><?php echo $GLOBALS["sess"]["name"]?> 님 로그아웃<span class="sr-only">(current)</span></a></li>
</ul>
<?*/?>


<ul class="nav navbar-nav navbar-main">
<?php if(is_array($TPL_R1=dataMenu())&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $TPL_K1?><span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<li><a href="<?php echo $TPL_V2["link"]?>"><?php echo $TPL_V2["menu_snm"]?></a></li>
<?php }}?>
		</ul>
	</li>
<?php }}?>
</ul>
<ul class="nav navbar-nav navbar-right nav-login">
	<li class="active"><span class="user-icon"  onclick="popup('../admin/member_reg.php?m_no=<?php echo $GLOBALS["sess"]['m_no']?>','member_reg','1100','900')"><?php echo $GLOBALS["sess"]["name"]?> 님</span><a href="../member/logout.php" class="nav-logout">로그아웃<span class="sr-only">(current)</span></a></li>
</ul>