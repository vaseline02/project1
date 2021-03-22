<?php /* Template_ 2.2.8 2020/10/14 10:34:23 /www/html/ukk_test2/data/skin/goods/goods_info_view.htm 000002940 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<style>
    .view_screenshot {width:800px;}
    .product_common_spec{display:block; width:800px; margin:0 auto; list-style:none; font-size:0;}
    .product_common_spec li{width:800px; margin-bottom:3px; font-weight:normal; line-height:30px; vertical-align:top; border-bottom:1px solid #bfbfbf; font-family:'Chronicle','Times','Helvetica Neue'; font-weight:400; font-style: normal; font-size:14px; color:#424242; text-align:left;}
    .product_common_spec li span.spec_title{display:inline-block; float:left; width:40%; margin:0 0 0 0; color:000; font-weight:600;}
    .product_common_spec li span.spec_content{display:inline-block; width:300px;color:#2d2c2d;text-decoration:none}
    .product_common_spec li i.spec_jpg { color:#fff; }@media screen and (max-width:500px){.product_common_spec { max-width:300px; padding:20px;}
    .product_common_spec li{ font-size:12px;}}</style>
    
    <button type="button" id="img_down" data-goodsnm="<?php echo $TPL_VAR["loop"]['Model.No']?>">이미지출력</button> 
    <div></div>
    <div  style="padding-top:20px; padding:40px;" >
        <div id="view_screenshot" class="view_screenshot" style="text-align: center;">
            <ul class="product_common_spec">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_V1){?><li><span class="spec_title"><?php echo $TPL_K1?></span><span class="spec_content"><b><?php echo $TPL_V1?></b></span></li><?php }?>
<?php }}?>
            </ul>
        </div>
    </div>
    <a id="view_target" style="display: none"></a>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
    $(function(){
        $("#img_down").click(function(){
            var goodsnm=$(this).data("goodsnm")+'_spec';
            html2canvas($('#view_screenshot').get(0)).then(function(canvas){
                var el = document.getElementById("view_target");
                el.href = canvas.toDataURL("image/jpeg");
                el.download = goodsnm+'.jpg';
                el.click();
    /*
                var myImage=canvas.toDataURL();
                var link=document.createElement("a");
                link.download=canvas;
                link.href=myImage;
                document.body.appendChild(link);
                document.getElementById('img').appendChild(canvas);
                link.click();
                console.log(myImage);
                console.log(canvas);
                */
    //			document.getElementById('img').appendChild(canvas)
    //			canvas.click();
            });
        });
    });
    
    </script>