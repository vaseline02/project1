<?php /* Template_ 2.2.8 2019/11/27 14:10:42 /www/html/ukk_test2/data/skin/admin/member_set.htm 000001634 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title">멤버관리</h1>

<hr>

<div><button type="button" class="btn btn-sm btn-primary" onclick="popup('member_reg.php','member_reg','1100','900')">멤버등록</button></div>


<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th>아이디</th>
			<th>이름</th>
			<th>이메일</th>
			<th>모바일</th>
			<th>직급</th>
			<th>부서</th>
			<th>등록일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["id"]?></td>
			<td><?php echo $TPL_V1["name"]?></td>
			<td><?php echo $TPL_V1["email"]?></td>
			<td><?php echo $TPL_V1["mobile"]?></td>
			<td><?php echo $TPL_V1["position"]?></td>
			<td><?php echo $TPL_V1["team"]?>-<?php echo $TPL_V1["team_detail"]?></td>
			<td><?php echo $TPL_V1["join_time"]?></td>
			<td><button type="button" class="btn btn-sm btn-warning" onclick="popup('member_reg.php?m_no=<?php echo $TPL_V1["no"]?>','member_reg','1100','900')">정보수정</button></td>
		</tr>
<?php }}?>
	</tbody>
</table>


<script>
document.title="멤버관리";


function popup1(src,name,width,height)
{
	window.open(src,name,'width=300,height=300,scrollbars=1,resizable=1');
}

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>