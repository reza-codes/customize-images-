<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['upload'])){

        $path_file = $_FILES['upload']['tmp_name'];
        $name_file = $_FILES['upload']['name'];
        $error_file= $_FILES['upload']['error'];
        $type_file = $_FILES['upload']['type'];
        $size_file = $_FILES['upload']['size'] / 1024;
        $extension = pathinfo($name_file,PATHINFO_EXTENSION);
        $full_path = "users/".$name_file;
        $array_extension = array("gif","svg","svgz","png","jpm","jpeg","jpg","bmp","btif","tif","dwg","ico","rgb","wbmp","webp");
        $check_mime_type = getimagesize($path_file);

    if($error_file > 0){
        header('Content-Type: application/json');
        $number_error_file = print_r($error_file);
        die(json_encode(['msg' => 'An error occur'.' #'.$number_error_file]));
    }elseif($check_mime_type === false){
        header('Content-Type: application/json');
        die(json_encode(['msg' => 'You can upload only images ,error(M-T)'])); // M-T --> Mime Type
    }elseif(!in_array(strtolower($extension),$array_extension)){ // strtolower() to force letters be lower case
        header('Content-Type: application/json');
        die(json_encode(['msg' => 'You can upload only images']));
    }elseif(file_exists($full_path)){
        header('Content-Type: application/json');
        die(json_encode(['msg' => 'file already exists.']));
    }elseif($size_file > 6000){
        header('Content-Type: application/json');
        die(json_encode(['msg' => 'your image is too large.']));
    }else{
        move_uploaded_file($path_file,$full_path);
        header('Content-Type: application/json');
        echo json_encode(['Name' => $name_file]);
    }

}