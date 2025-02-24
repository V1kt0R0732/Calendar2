<?php
session_start();

//print_r($_SESSION);

//$array = ['Robin'=>91800,'Gary'=>29100,'Bob'=>52400,'Mark'=>518400];

$array = $_SESSION['diagram']['task'];



$max_time = 0;
foreach($array as $label=>$value){
    $array[$label] = number_format($value/60/60,2,'.','');
    if($max_time < $array[$label]){
        $max_time = $array[$label];
    }
}

//print_r($array);


    define("IMG_WIDTH", 600);

    define("IMG_HEIGHT", 400);

    $img = imagecreatetruecolor(IMG_WIDTH, IMG_HEIGHT);

    $fonColor = imagecolorallocate($img, 192, 192, 192); // Колір Фона
    $colColor = imagecolorallocate($img, 0,191, 255); // Колір Стовпця
    $blackColor = imagecolorallocate($img, 0,0, 0); // Колір Рамки
    $whiteColor = imagecolorallocate($img, 255,255, 255); // Колір Рамки
    $greyColor = imagecolorallocate($img, 244,244, 244); // Колір Рамки
    //$Color = imagecolorallocate($img, 255,255, 255); // Колір Рамки


    $count_col = count($array); // кількість стовпців


    $width_col = (IMG_WIDTH - 16) / ($count_col * 2); // ширина стовпця

    $pix = 60; // Початкова позиція по осі x


    //echo $width_col;

    imagefilledrectangle($img, 0, 0, IMG_WIDTH, IMG_HEIGHT, $fonColor); // Фонова заливка

    imageline($img,0,IMG_HEIGHT, $pix,IMG_HEIGHT - 25,$whiteColor); // Діагональна лінія
    imageline($img,50,0, 50,IMG_HEIGHT,$whiteColor); // Вертикальна лінія
    imageline($img,0,IMG_HEIGHT-24, IMG_WIDTH,IMG_HEIGHT - 24,$whiteColor); // Горизонтальна лінія

    imagestring($img, 2, 4, IMG_HEIGHT - 25, 'Hour',$blackColor);
    imagestring($img, 2, 25, IMG_HEIGHT - 14, 'Name',$blackColor);

    if($max_time >= 10){
        for($i = 10; $i <= $max_time; $i+=10){
            $num_height = ($i / $max_time) * (IMG_HEIGHT - 50);
            if($i < 100){
                imagestring($img, 4, 15, IMG_HEIGHT - $num_height - 36,$i,$blackColor);
            }
            else{
                imagestring($img, 4, 10, IMG_HEIGHT - $num_height - 36,$i,$blackColor);
            }
            imageline($img,5,IMG_HEIGHT - $num_height - 20,IMG_WIDTH,IMG_HEIGHT - $num_height - 20, $greyColor);
        }
    }
    else{
        for($i = 0; $i <= $max_time; $i+=1){
            $num_height = ($i / $max_time) * (IMG_HEIGHT - 50);
            if($i < 100){
                imagestring($img, 4, 15, IMG_HEIGHT - $num_height - 36,$i,$blackColor);
            }
            else{
                imagestring($img, 4, 10, IMG_HEIGHT - $num_height - 36,$i,$blackColor);
            }
            imageline($img,5,IMG_HEIGHT - $num_height - 20,IMG_WIDTH,IMG_HEIGHT - $num_height - 20, $greyColor);
        }
    }



    foreach($array as $label => $value) {

        //echo $value;
        // озраховуємо висоту стовпчика пропорційно до максимального значення
        $col_height = ($value / $max_time) * (IMG_HEIGHT - 50);


        // Викликаємо функцію яка малює стовпчик
        imagefilledrectangle($img, $pix, IMG_HEIGHT - $col_height - 20, $pix + $width_col, IMG_HEIGHT - 25, $colColor);

        //Значення і лінія до стовпчика

        imagestring($img, 4, $pix+15, IMG_HEIGHT - $col_height - 35,$value,$blackColor);
        //imageline($img,5,IMG_HEIGHT - $col_height - 20,$pix + $width_col,IMG_HEIGHT - $col_height - 20, $blackColor);

        //Підпис під стопчиком
        imagestring($img, 5, $pix+15, IMG_HEIGHT - 20, $label, $blackColor);

        //Перехід до наступного стопчика

        $pix += $width_col * 2;

    }

    $max_hour = floor($max_time);
    //echo $max_hour;
    $h = IMG_HEIGHT-50;


//    while($max_hour > 0){
//        //echo "Success". $max_hour;
//        imagestring($img, 3, 20, IMG_HEIGHT - $h,$max_hour,$blackColor);
//        imageline($img,20,IMG_HEIGHT - $h,IMG_WIDTH-15,IMG_HEIGHT - $h,$whiteColor);
//
//        if($max_time <= 10){
//            $max_hour--;
//        }
//        elseif($max_time <= 30){
//            $max_hour -= 5;
//        }
//        elseif($max_time <= 50){
//            $max_hour -= 10;
//        }
//        else{
//            $max_hour -= 20;
//        }
//        $h -= 50;
//    }

    //Малюємо рамку навколо графіка
    imagerectangle($img, 0, 0, IMG_WIDTH-1, IMG_HEIGHT-1, $blackColor);

    //Виводимо зоображення
    header("content-type:image/png");

    imagepng($img);

    imagedestroy($img);

?>