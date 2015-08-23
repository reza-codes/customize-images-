<script type="text/javascript" src="../jquery.uploadfile.js"></script>
<link rel="stylesheet" href="../profile/profile_image_CSS.css"/>
<link rel="stylesheet" href="../uploadfile.css"/>

<div class="main-box-dialog-customize-image">
        <table border="0" class="table_of_profile_image">
            <tr>
                <td align="center">
                    <div class="main-box-of-image-profile-customize">
                        <img src="../users/wallhaven-159296.jpg"  class="the-actual-image_1" alt="image tester" />
                        <div class="box-of-image-profile-customize">
                            <img src="../users/wallhaven-159296.jpg"  class="the-actual-image_2" alt="image tester"/>
                        </div>
                    </div>
                </td>
                <td rowspan="2">
                    <div style="width:100px;height:100px;background-color:green;"></div>
                    <div style="width:100px;height:100px;background-color:red;"></div>
                    <div style="width:100px;height:100px;background-color:blue;"></div>
                </td>
            </tr>
            <tr>
                <td align="center" >
                    <span style="display: inline-block;font: 25px bold;color:#ccc;">&#8722;</span>
                    <div class="main_slider_of_zoom" style="height: 3px;display: inline-block;outline: none;"></div>
                    <span style="display: inline-block;font: 25px bold;color:#ccc;">&#43;</span>
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    <form action="../main_functions.php"  method="post" enctype="multipart/form-data" id="form_image" name="form_image">
                        <div id="fileuploader">Upload Image</div>
                        <input type="file"  name="upload"  class="file_upload" style="display:none"/>
                    </form>
                </td>
                <td valign="top" align="center">
                    <input type="button" value="Save &#10004;"  class="button_of_upload_save"/>
                </td>
            </tr>
        </table>
    <div class="close-dialog"></div>
</div>

<!-- Modal dialog -->
<div class="modal_dialog">
        <table border="0" id="table_modal_dialog">
            <tr>
                <td>
                    <div class="modal_dialog_box">
                       <div class="modal_dialog-text">
                            <span class="span-label"><!-- msg --></span>
                        </div>
                        <div class="modal_dialog-box-button">
                            <div class="modal_dialog-button">
                                <span>OK</span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
</div>
<script type="text/javascript">

    var path_image = '../users/wallhaven-159296.jpg';
    $('#fileuploader').uploadFile({
        url:"../upload_image.php",
        autoSubmit:true,
        fileName:'upload',
        returnType:"json",
        showStatusAfterSuccess:false,
        onSuccess:function(files,data)
        {
            var value = data.Name;
            if(value){
                path_image = "../users/"+value;
                upload_image(path_image);
                //alert(" path : "+value);
            }else{
                $(".span-label").text(data.msg);

                /********************** dialog ******************/
                var _m_d = $(".modal_dialog");
                _m_d.fadeIn(100,function(){
                    $("#table_modal_dialog").animate({"margin-top":"9%","opacity":"1"},300);
                    $(".modal_dialog-button").click(function(){
                        _m_d.fadeOut(100);
                        $("#table_modal_dialog").animate({"margin-top":"0%","opacity":"0"},300);
                    });
                });
                /********************** dialog ******************/
            }
        }
    });

    upload_image(path_image);

    function upload_image (path_image){
        var s_img1_And_img2 = $(".the-actual-image_1,.the-actual-image_2");
        s_img1_And_img2.attr("src", path_image);

        var picRealWidth, picRealHeight;
        $("<img/>")
            .attr("src", s_img1_And_img2.attr("src"))
            .error(function() { console.log("error loading image"); })
            .load(function () {

                // start loading img with all process

                picRealWidth = this.width;   // Note: $(this).width() will not
                picRealHeight = this.height; // work for in memory images.

                var selector_of_actual_image = s_img1_And_img2,
                    width_actual_img = picRealWidth,
                    width_actual_img_for_calc = picRealWidth,
                    height_actual_img = picRealHeight,
                    height_actual_img_for_calc = picRealHeight,
                    area =  height_actual_img_for_calc * width_actual_img_for_calc;

                new_reload_img();

                function new_reload_img(){
                    'use strict';
                    var sign = "",
                        type_resize = "";
                    function real_width_AND_height_resize (type_resize,sign){
                        'use strict';
                        //   sign : addition(+) or  Subtraction(-)
                        //   type_resize : width or height

                        if(type_resize === "width"){
                            width_actual_img = 300,
                            var calc_residual_H = 300 - width_actual_img_for_calc,
                                abs_result_H = Math.abs(calc_residual_H) / width_actual_img_for_calc,
                                calc_width_with_increase = abs_result_H + width_actual_img_for_calc,
                                divide_W = area / calc_width_with_increase,
                                multiply_H = abs_result_H * divide_W ;
                            if (sign === "+"){
                                height_actual_img = height_actual_img + multiply_H ;
                            }else{
                                // sign will be = (-)
                                height_actual_img = height_actual_img - multiply_H ;
                            }
                        }else if (type_resize === "height"){
                            height_actual_img = 300,
                            var calc_residual_W = 300 - height_actual_img_for_calc,
                                abs_result_W = Math.abs(calc_residual_W) / height_actual_img_for_calc,
                                calc_width_height_increase = abs_result_W + height_actual_img_for_calc,
                                divide_H = area / calc_width_height_increase,
                                multiply_W = abs_result_W * divide_H;
                            if (sign === "+"){
                                width_actual_img = width_actual_img + multiply_W ;
                            }else{
                                // sign will be = (-)
                                width_actual_img = width_actual_img - multiply_W ;
                            }
                        }
                    }

                    //========  section 1 ================================//

                    if(width_actual_img < 300 && height_actual_img > 300){
                        // less than 300 px
                        type_resize = "width";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 1');

                    }
                    else if(width_actual_img == 300 && height_actual_img > 300){
                        // less than 300 px
                        type_resize = "width";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 2');

                    }
                    else if(width_actual_img < 300 && height_actual_img == 300){
                        // less than 300 px
                        type_resize = "width";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 3');

                    }

                    //========  section 2 ================================//
                    else if(width_actual_img > 300 && height_actual_img < 300){
                        // more than 300 px
                        type_resize = "height";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 4');

                    }
                    else if(width_actual_img > 300 && height_actual_img == 300){
                        // more than 300 px
                        type_resize = "height";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 5');

                    }

                    //========  section 3 ================================//

                    else if(height_actual_img < 300 && width_actual_img > 300){
                        // less than 300 px
                        type_resize = "height";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 6');

                    }
                    else if(height_actual_img < 300 && width_actual_img == 300){
                        // less than 300 px
                        type_resize = "height";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 7');

                    }

                    //========  section 4 ================================//

                    else if(height_actual_img > 300 && width_actual_img < 300){
                        // more than 300 px
                        type_resize = "width";
                        sign = "+";
                        real_width_AND_height_resize(type_resize,sign);
                        //alert('case 8');

                    }

                    //========  section 5 ================================//

                    else if(height_actual_img < 300 && width_actual_img < 300 && height_actual_img != width_actual_img) {
                        // less than 300 px
                        if (height_actual_img < width_actual_img) {
                            type_resize = "height";
                            sign = "+";
                            real_width_AND_height_resize(type_resize, sign);
                            //alert('H > W case 9');
                        } else if (height_actual_img > width_actual_img) {
                            type_resize = "width";
                            sign = "+";
                            real_width_AND_height_resize(type_resize, sign);
                            //alert('H < W case 10');
                        }else{
                            //alert('case 0,1');
                        }
                    }

                    //========  section 6 ================================//

                    else if(height_actual_img > 300 && width_actual_img > 300 && height_actual_img != width_actual_img){
                        if(height_actual_img < width_actual_img){
                            type_resize = "height";
                            sign = "-";
                            real_width_AND_height_resize(type_resize,sign);
                            //alert('H < W case 11');
                        }else if(height_actual_img > width_actual_img){
                            type_resize = "width";
                            sign = "-";
                            real_width_AND_height_resize(type_resize,sign);
                            //alert('H > W case 12');
                        }else{
                            //alert('case 0,2');
                        }
                        // more than 300 px

                    }

                    //========  section 7 ================================//

                    else if(height_actual_img == 300 && width_actual_img == 300){
                        height_actual_img = 300;
                        width_actual_img = 300;
                        //alert('case 13');
                    }
                    else if(height_actual_img == width_actual_img){
                        height_actual_img = 300;
                        width_actual_img = 300;
                        //alert('case 14');
                    }

                    //===================================  End of sections ==================================//

                    var P_width_actual_img = width_actual_img / 2 - 150,
                        P_height_actual_img = height_actual_img / 2 - 150;

                    selector_of_actual_image.css({width: width_actual_img, height: height_actual_img,top:-P_height_actual_img,left:-P_width_actual_img});

                    var W_M = 0,
                        H_M = 0,
                        the_order = 0;

                    $(".main_slider_of_zoom").slider({
                        min:0,
                        max:100,
                        value:0,
                        step:5,
                        slide:function(event ,ui){
                            var v_ui = (1+ ui.value /100),
                                W = width_actual_img * v_ui,
                                H = height_actual_img * v_ui ;

                            W_M = Math.floor(W) ;
                            H_M = Math.floor(H) ;

                            var P_W_M = W_M / 2 - 150,
                                P_H_M = H_M / 2 - 150;

                            selector_of_actual_image.stop(true).animate({width: W_M, height: H_M,top:-P_H_M,left:-P_W_M}, 200);
                            the_order = 1 ;
                        }
                    });

                    $(selector_of_actual_image).draggable({
                        cursor:"move",
                        drag:function(event, ui){
                            ui.position.left = Math.min( 0, ui.position.left);
                            ui.position.top = Math.min( 0, ui.position.top);
                            if(the_order == 1){
                                ui.position.left = Math.max( -W_M+300, ui.position.left);
                                ui.position.top = Math.max( -H_M+300, ui.position.top);
                            }else{
                                ui.position.left = Math.max( -width_actual_img+300, ui.position.left);
                                ui.position.top = Math.max( -height_actual_img+300, ui.position.top);
                            }
                            $(selector_of_actual_image).css({left: ui.position.left,top: ui.position.top});//NOTE: Do not use "$(this)"
                        }
                    });

                }
                ////////// end of load the img //////////
            });
    }

    /********************************* save and crop image ***************************/

    $(".button_of_upload_save").click(function(){

        var _doc_width = $(window).width(),
            _doc_height = $(window).height(),

            _b_1 = $(".box-of-image-profile-customize").offset(),
            _b_1_top = _b_1.top,
            _b_1_left = _b_1.left,
            _b_1_right = Math.abs( _doc_width - _b_1_left - 300),
            _b_1_bottom = Math.abs( _doc_height - _b_1_top - 300),

            selector_2 = $(".the-actual-image_2"),

            width_img_2 = selector_2.width(),
            height_img_2 = selector_2.height(),

            _i_1 = selector_2.offset(),
            _i_1_top = _i_1.top,
            _i_1_left = _i_1.left,
            _i_1_right = _doc_width - _i_1_left - width_img_2,
            _i_1_bottom = _doc_height - _i_1_top - height_img_2,

            calculate_crop_image_left = Math.abs(_b_1_left - _i_1_left),
            calculate_crop_image_top = Math.abs(_b_1_top - _i_1_top),
            calculate_crop_image_right = Math.abs(_b_1_right - _i_1_right),
            calculate_crop_image_bottom = Math.abs(_i_1_bottom - _b_1_bottom),

            src_image_crop = path_image.slice(9),
            send_jason={"width":width_img_2,
            "height":height_img_2,
            "left":calculate_crop_image_left,
            "top":calculate_crop_image_top,
            "right":calculate_crop_image_right,
            "bottom":calculate_crop_image_bottom,
            "src_image":src_image_crop};

        $.ajax({
            url:"../crop_image.php",
            type:"POST",
            dataType:"json",
            data: send_jason,
            success:function(data){
                $(".image-profile").css({background:"url("+data.src_img+")"});
                var selector_box_dialog = $(".main-box-dialog-customize-image");
                selector_box_dialog.remove();
                selector_box_dialog = null;
                // location.reload();   it's better to reload whole the page .
            }

        });

    });
    /************************** end of crop image ****************************/

    $(".close-dialog").click(function(){
        $(".main-box-dialog-customize-image").remove();
    });

</script>
