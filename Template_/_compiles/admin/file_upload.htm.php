<?php /* Template_ 2.2.8 2020/05/14 14:25:57 /www/html/ukk_test/data/skin/admin/file_upload.htm 000000663 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td><input type="file" name="excelFile[]" required/><button class="btn btn-primary">업로드</button></td>
    </tr>
</table>
</form>
<?php }?>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>