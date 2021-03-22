<?php /* Template_ 2.2.8 2020/10/21 11:35:27 /www/html/ukk_test2/data/skin/cs/as_nav.htm 000004181 */ ?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="updateorder-contents">
	<div style="float:right;margin:10px"><button type="button" class="btn-sm btn-primary" onclick="popup('as_tot_search.php','as_tot_search','1100','900')">AS 통합검색</button></div>
	<div class="panel panel-default panel-stock margin20">	
		<div class="updateorder-process">
			<ol>
				<li>
					<a href="as_list.php?<?php echo $GLOBALS["nav_parm"]?>" id="nav_div"><div class="updateorder-box "><p>전체</p>
					<!--<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 0]){?><?php echo $GLOBALS["data_nav"][ 0]?><?php }else{?>0<?php }?></span>--></div></a>
				</li>
				<li style="padding-right:45px; padding-bottom:10px;font-size: 50px;">|</li>
				<li>
					<a href="as_list.php?s_as_status=0<?php echo $GLOBALS["nav_parm"]?>" id="nav_div0"><div class="updateorder-box "><p>0단계<br><?php echo $GLOBALS["cfg_as_status"][ 0]?></p>
					<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 0]){?><?php echo $GLOBALS["data_nav"][ 0]?><?php }else{?>0<?php }?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
				</li>
				<li>
					<a href="as_list.php?s_as_status=1<?php echo $GLOBALS["nav_parm"]?>" id="nav_div1"><div class="updateorder-box "><p>1단계<br><?php echo $GLOBALS["cfg_as_status"][ 1]?></p>
					<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 1]){?><?php echo $GLOBALS["data_nav"][ 1]?><?php }else{?>0<?php }?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
                </li>
                <li>
					<a href="as_list.php?s_as_status=2<?php echo $GLOBALS["nav_parm"]?>" id="nav_div2"><div class="updateorder-box "><p>2단계<br><?php echo $GLOBALS["cfg_as_status"][ 2]?></p>
					<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 2]){?><?php echo $GLOBALS["data_nav"][ 2]?><?php }else{?>0<?php }?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
                </li>
                <li>
					<a href="as_list.php?s_as_status=3<?php echo $GLOBALS["nav_parm"]?>" id="nav_div3"><div class="updateorder-box "><p>3단계<br><?php echo $GLOBALS["cfg_as_status"][ 3]?></p>
					<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 3]){?><?php echo $GLOBALS["data_nav"][ 3]?><?php }else{?>0<?php }?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
                </li>
                <li>
					<a href="as_list.php?s_as_status=4<?php echo $GLOBALS["nav_parm"]?>" id="nav_div4"><div class="updateorder-box "><p>4단계<br><?php echo $GLOBALS["cfg_as_status"][ 4]?></p>
					<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 4]){?><?php echo $GLOBALS["data_nav"][ 4]?><?php }else{?>0<?php }?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
                </li>
                <li>
					<a href="as_list.php?s_as_status=5<?php echo $GLOBALS["nav_parm"]?>" id="nav_div5"><div class="updateorder-box "><p>5단계<br><?php echo $GLOBALS["cfg_as_status"][ 5]?></p>
					<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 5]){?><?php echo $GLOBALS["data_nav"][ 5]?><?php }else{?>0<?php }?></span></div></a>
					<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="top:35px;" aria-hidden="true"></span>
                </li>
                <li>
					<a href="as_list.php?s_as_status=6<?php echo $GLOBALS["nav_parm"]?>" id="nav_div6"><div class="updateorder-box "><p>6단계<br><?php echo $GLOBALS["cfg_as_status"][ 6]?></p>
					<span class="updateorder-cnt"><?php if($GLOBALS["data_nav"][ 6]){?><?php echo $GLOBALS["data_nav"][ 6]?><?php }else{?>0<?php }?></span></div></a>					
				</li>
			</ol>
		</div>
	</div>		
</div>

<?php }?>