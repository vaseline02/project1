<?php /* Template_ 2.2.8 2019/12/02 15:58:56 /www/html/ukk_test2/data/skin/goods/makePageHtml.htm 000000743 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title">상품페이지 html 생성</h1>

<hr>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td>
		<input type="file" name="excelFile[]" required/><button class="btn btn-sm btn-primary">업로드</button>
		</td>
    </tr>
</table>
</form>


<div><textarea name="" id="" style="width:1800px;height:800px"><?php echo $GLOBALS["html"]?></textarea></div>

<script>
document.title="상품페이지 html 생성";
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>