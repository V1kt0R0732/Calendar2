<?php

session_start();

$array = $_SESSION['diagram']['project'];


$max_time = 0;
foreach($array as $label=>$value){
    $array[$label] = number_format($value/60/60,2,'.','');
    if($max_time < $array[$label]){
        $max_time = $array[$label];
    }
}

//print_r($array);

define('IMG_HEIGHT',400);
define('IMG_WIDTH', 600);

$img = imagecreatetruecolor(IMG_WIDTH,IMG_HEIGHT);

$background_color = imagecolorallocate($img,190,190,190);
$white_color = imagecolorallocate($img, 255, 255,255);
$black_color = imagecolorallocate($img, 0,0,0);
$orange_color = imagecolorallocate($img, 255,125, 0); // Колір Стовпця



imagefilledrectangle($img,0,0,IMG_WIDTH,IMG_HEIGHT,$background_color);

$col_width = IMG_WIDTH / (count($array) * 2);

imageline($img,50, 0, 50, IMG_HEIGHT, $white_color);
imageline($img,0, IMG_HEIGHT-23, IMG_WIDTH, IMG_HEIGHT-23, $white_color);
imageline($img,0, IMG_HEIGHT-1,50,IMG_HEIGHT-22,$white_color);

imagestring($img, 2, 3, IMG_HEIGHT - 23, 'Hour',$black_color);
imagestring($img, 2, 26, IMG_HEIGHT - 12, 'Name',$black_color);

if($max_time >= 100){
    for($i = 20; $i <= $max_time; $i+=20){
        $num_height = ($i / $max_time) * (IMG_HEIGHT - 50);
        if($i < 100){
            imagestring($img, 4, 15, IMG_HEIGHT - $num_height - 36,$i,$black_color);
        }
        else{
            imagestring($img, 4, 10, IMG_HEIGHT - $num_height - 36,$i,$black_color);
        }
        imageline($img,5,IMG_HEIGHT - $num_height - 20,IMG_WIDTH,IMG_HEIGHT - $num_height - 20, $black_color);
    }
}
elseif($max_time <= 10){
    for($i = 1; $i <= $max_time; $i++){
        $num_height = ($i / $max_time) * (IMG_HEIGHT - 50);
        if($i < 10){
            imagestring($img, 4, 15, IMG_HEIGHT - $num_height - 36,$i,$black_color);
        }
        else{
            imagestring($img, 4, 10, IMG_HEIGHT - $num_height - 36,$i,$black_color);
        }
        imageline($img,5,IMG_HEIGHT - $num_height - 20,IMG_WIDTH,IMG_HEIGHT - $num_height - 20, $black_color);
    }
}
else{
    for($i = 1; $i <= $max_time; $i+=1){
        $num_height = ($i / $max_time) * (IMG_HEIGHT - 50);
        if($i < 100){
            imagestring($img, 4, 15, IMG_HEIGHT - $num_height - 36,$i,$black_color);
        }
        else{
            imagestring($img, 4, 10, IMG_HEIGHT - $num_height - 36,$i,$black_color);
        }
        imageline($img,5,IMG_HEIGHT - $num_height - 20,IMG_WIDTH,IMG_HEIGHT - $num_height - 20, $black_color);
    }
}


$pix = 60;
foreach($array as $name=>$time){

    $col_height = ($time/$max_time) * (IMG_HEIGHT - 50);

    // 60 + x +

    imagefilledrectangle($img,$pix,IMG_HEIGHT-$col_height-20,$pix+$col_width,IMG_HEIGHT-25,$orange_color);
    imagefttext($img,14,0,$pix,IMG_HEIGHT-3,$black_color,'Shentox-Regular (RUS by Slavchansky)_0.ttf',$name);
    imagestring($img,5,$pix+($col_width/4),IMG_HEIGHT-$col_height-35,$time,$black_color);



    $pix += $col_width * 2;

    //echo $pix."|";
}




header('content-type:image/png');
imagepng($img);
imagedestroy($img);




?>