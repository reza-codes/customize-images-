<?php

$status_check = false;
include_once("easyphpthumbnail.class.php");
// first of all must be resize the image before crop it .
if($status_check == false){
    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['src_image']){
        $src_image_fn = dirname(__FILE__)."/users/".$_POST['src_image'];
        $thumb = new easyphpthumbnail;
        $thumb -> Thumbwidth   = $_POST['width'];
        $thumb -> Thumbheight  = $_POST['height'];
        /****** $thumb -> Quality = 100;  if quality increased , the size of img will multiply many times *****/
        $thumb -> Inflate = true;
        $thumb -> Createthumb($src_image_fn,'file');
        $thumb = dirname(__FILE__)."/".$_POST['src_image'];
        if(copy($thumb,dirname(__FILE__)."/users/thumb/".$_POST['src_image'])){
            unlink($thumb);
            $status_check = true;
        }
    }
}
//  method (1)
//  After resize the image .. next step is crop it ..
if($status_check == true){
    $src_image_thumb = dirname(__FILE__)."/users/thumb/".$_POST['src_image'];
    $thumb = new easyphpthumbnail;
    $thumb -> Thumbwidth  = 300;
    $thumb -> Thumbheight  = 300;
    /****** $thumb -> Quality = 90;   if quality increased , the size of img multiply many times ******/
    $thumb -> Cropimage = array(1,1,$_POST['left'],$_POST['right'],$_POST['top'],$_POST['bottom']);
    $thumb -> Createthumb($src_image_thumb,'file');
    $thumb = dirname(__FILE__)."/".$_POST['src_image'];
    unlink(dirname(__FILE__)."/users/thumb/".$_POST['src_image']);
    if(copy($thumb,$src_image_thumb)){
        unlink($thumb);
        $status_check = false;
        $array_msg = array("success" => "crop image successful",
                           "src_img" => "../users/thumb/".$_POST['src_image']
                           );
        echo json_encode($array_msg);
    }
}
/*
 * Method (2) has problem with image of type PNG
if($status_check == true){
    $extension = pathinfo($_POST['src_image'],PATHINFO_EXTENSION);
    $dst_x = 0;
    $dst_y = 0;
    $src_x = 0;	    // Crop Start X
    $src_y = 0;	    // Crop Start Y
    $dst_w = 300;	// Thumb width
    $dst_h = 300;	// Thumb height
    $src_w = 300;	// $src_x + $dst_w
    $src_h = 300;	// $src_y + $dst_h
    $dst_image = imagecreatetruecolor($dst_w,$dst_h);
    if(strtolower($extension) == "image/jpeg" || 'image/pjpeg'){

        $src_image = imagecreatefromjpeg(dirname(__FILE__)."/users/thumb/".$_POST['src_image']);
        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        imagejpeg($dst_image, "users/thumb/".time()."new.jpg");
        //unlink(dirname(__FILE__)."/users/thumb/".$_POST['src_image']);
        echo $extension;

    }elseif(strtolower($extension) == "image/png"){

        $src_image = imagecreatefrompng(dirname(__FILE__)."/users/thumb/".$_POST['src_image']);
        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        imagepng($dst_image, "users/thumb/".time()."new.jpg",9);
        //unlink(dirname(__FILE__)."/users/thumb/".$_POST['src_image']);
        echo $extension;

    }
}*/
