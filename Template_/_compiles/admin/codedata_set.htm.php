<?php /* Template_ 2.2.8 2020/05/12 10:24:31 /www/html/ukk_test2/data/skin/admin/codedata_set.htm 000005356 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<table id="" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
    <tr>
        <td style="width:30%; vertical-align: top;">
            <form id="codedataFormin" method="POST">
                <input type="hidden" name="code" value="IN">
                <input type="hidden" name="mode" value="ins">
                <input type="hidden" name="no" value="">
                <div style="overflow: auto; height:700px;">
                <table class="table table-bordered">
                    <tr>
                        <th colspan='2'>IN</th>
                    </tr>
                    <tr>
                        <th>이름</th>
                        <th></th>
                    </tr>
                    
<?php if(is_array($TPL_R1=$TPL_VAR["loop"]["IN"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <tr>
                        <td width="100%"><?php echo $TPL_V1["cd"]?></td>
                        <td><div type="button" class="btn btn-sm btn-danger checkForm" data-id="in" data-mode="del" data-no=<?php echo $TPL_V1["no"]?>>삭제</div></td>
                    </tr>
<?php }}?>
                </table>
                </div>
                <hr>
                <div><input type="text" style="width:85%" name="codedataName"> <div class="btn btn-primary checkForm" data-id="in"  data-mode="ins">등록</div></div>
            </form>
        </td>
        <td> </td>
        <td style="width:30%; vertical-align: top;">
            <form id="codedataFormout" method="POST">
                <input type="hidden" name="code" value="OUT">
                <input type="hidden" name="mode" value="ins">
                <input type="hidden" name="no" value="">
                <div style="overflow: auto; height:700px;">
                <table class="table table-bordered">
                    <tr>
                        <th colspan='2'>OUT</th>
                    </tr>
                    <tr>
                        <th>이름</th>
                        <th></th>
                    </tr>
                    
<?php if(is_array($TPL_R1=$TPL_VAR["loop"]["OUT"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <tr>
                        <td width="100%"><?php echo $TPL_V1["cd"]?></td>
                        <td><div type="button" class="btn btn-sm btn-danger checkForm" data-id="out" data-mode="del" data-no=<?php echo $TPL_V1["no"]?>>삭제</div></td>
                    </tr>
<?php }}?>
                </table>
                </div>
                <hr>
                <div><input type="text" style="width:85%" name="codedataName"> <div class="btn btn-primary checkForm" data-id="out" data-mode="ins">등록</div></div>
            </form>
        </td>
        <td> </td>
        <td style="width:30%; vertical-align: top;">
            <form id="codedataFormplace" method="POST">
                <input type="hidden" name="code" value="PLACE">
                <input type="hidden" name="mode" value="ins">
                <input type="hidden" name="no" value="">
                <div style="overflow: auto; height:700px;">
                <table class="table table-bordered">
                    <tr>
                        <th>PLACE<div style="color: red;">*PLACE 삭제시 개발팀에 문의해주세요.</div></th>
                    </tr>
                    <tr>
                        <th>이름</th>
                    </tr>
                    
<?php if(is_array($TPL_R1=$TPL_VAR["loop"]["PLACE"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <tr>
                        <td width="100%"><?php echo $TPL_V1["cd"]?></td>
                        <!-- <td><div type="button" class="btn btn-sm btn-danger checkForm" data-id="place" data-mode="del" data-no=<?php echo $TPL_V1["no"]?>>삭제</div></td> -->
                    </tr>
<?php }}?>
                </table>
                </div>
                <hr>
                <div><input type="text" style="width:85%" name="codedataName"> <div class="btn btn-primary checkForm" data-id="place" data-mode="ins">등록</div></div>
            </form>
        </td>
    </tr>
</table>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".checkForm").click(function (){
    var formName=$("form[id='codedataForm"+$(this).data('id')+"']");
    var codeName=formName.find('input[name="codedataName"]').val();
    var mode=$(this).data('mode');

    formName.find('input[name="mode"]').val(mode);
    
    if(mode=='ins'){
        if(!codeName){
            alert('코드명을 입력해주세요.');
            return false;
        }else{
            if(confirm('등록하시겠습니까?')){
                formName.submit();
            }
            
        }
    }else if(mode=='del'){
        formName.find('input[name="no"]').val($(this).data('no'));

        if(confirm('삭제하시겠습니까?')){
                formName.submit();
        }
        
    }
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>