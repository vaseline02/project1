<?php /* Template_ 2.2.8 2020/10/23 09:21:13 /www/html/ukk_test2/data/skin/goods/category_search_form.htm 000005554 */ 
$TPL_catelist_1=empty($TPL_VAR["catelist"])||!is_array($TPL_VAR["catelist"])?0:count($TPL_VAR["catelist"]);?>
<select name="s_category_1" id="s_category_1" class="s_cate_chg" data-depth='1'>
    <option value="">== 1차카테고리 선택 ==</option>
<?php if($TPL_catelist_1){foreach($TPL_VAR["catelist"] as $TPL_K1=>$TPL_V1){?>
    <option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['s_category_1'][$TPL_K1]?>><?php echo $TPL_V1["catenm"]?></option>
<?php }}?>
</select>
<select name="s_category_2" id="s_category_2" class="s_cate_chg" data-depth='2'>
    <option value="">== 2차카테고리 선택 ==</option>                                   
<?php if($GLOBALS["s_category_1"]!='000'){?>
<?php if(is_array($TPL_R1=$TPL_VAR["catelist"][$GLOBALS["s_category_1"]])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='catenm'){?>
			<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['s_category_2'][$TPL_K1]?>><?php echo $TPL_V1["catenm"]?></option>  
<?php }?>
<?php }}?>
<?php }?>
</select>
<select name="s_category_3" id="s_category_3" class="s_cate_chg" data-depth='3'>
    <option value="">== 3차카테고리 선택 ==</option>             
<?php if($GLOBALS["s_category_2"]!='000'){?>
<?php if(is_array($TPL_R1=$TPL_VAR["catelist"][$GLOBALS["s_category_1"]][$GLOBALS["s_category_2"]])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='catenm'){?>
			<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['s_category_3'][$TPL_K1]?>><?php echo $TPL_V1["catenm"]?></option>  
<?php }?>
<?php }}?>
<?php }?>
</select>
<select name="s_category_4" id="s_category_4">
    <option value="">== 4차카테고리 선택 ==</option>        
<?php if($GLOBALS["s_category_3"]!='000'){?>
<?php if(is_array($TPL_R1=$TPL_VAR["catelist"][$GLOBALS["s_category_1"]][$GLOBALS["s_category_2"]][$GLOBALS["s_category_3"]])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='catenm'){?>
			<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['s_category_4'][$TPL_K1]?>><?php echo $TPL_V1["catenm"]?></option>  
<?php }?>
<?php }}?>
<?php }?>
</select>
<style>
.s_cate_chg {margin-right:1px}	
</style>
<script>
    $(".s_cate_chg").change(function (){
        var depth=$(this).data('depth');
        var data=$(this).val();
        var depth_1="000"; var depth_2="000"; var depth_3="000"; var depth_4="000";
        var addHtml_2=""; var addHtml_3=""; var addHtml_4="";
        var chg_depth=(depth+1);
        
        if(depth=='1'){
            depth_1=data;

            $('#s_category_2').children('option:not(:first)').remove();
            $('#s_category_3').children('option:not(:first)').remove();
            $('#s_category_4').children('option:not(:first)').remove();
        }else if(depth=='2'){
            depth_1=$("select[name='s_category_1']").val();
            depth_2=data;

            $('#s_category_3').children('option:not(:first)').remove();
            $('#s_category_4').children('option:not(:first)').remove();
        }else if(depth=='3'){
            depth_1=$("select[name='s_category_1']").val();
            depth_2=$("select[name='s_category_2']").val();
            depth_3=data;

            $('#s_category_4').children('option:not(:first)').remove();
        }                
        $.ajax({
            url: "../goods/gift_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "mode=cate&depth="+depth+"&depth_1="+depth_1+"&depth_2="+depth_2+"&depth_3="+depth_3+"&depth_4="+depth_4,
            success: function(data){                                           
                $.each(data,function(index, item){
//                    console.log(item);
                    $.each(item,function(index2, item2){                        
                        if (item2.constructor == Object) {
                            addHtml_2+="<option value='"+index2+"'>"+item2['catenm']+"</option>";
                            if(depth>='2'){
                                $.each(item2,function(index3, item3){                        
                                    if (item3.constructor == Object) {
                                        addHtml_3+="<option value='"+index3+"'>"+item3['catenm']+"</option>"; 
                                        if(depth>='3'){
                                            $.each(item3,function(index4, item4){         
                                                if (item4.constructor == Object) {
                                                    addHtml_4+="<option value='"+index4+"'>"+item4['catenm']+"</option>";                                        
                                                }                                        
                                            });     
                                        }                              
                                    }                                        
                                });     
                            }
                        }                        
                    });  
                    $('#s_category_'+chg_depth).append(eval("addHtml_"+chg_depth));           
                });
            }
        });
    });
</script>