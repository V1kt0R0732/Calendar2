<li class="task-item">
    <h4>Задача <?=$temp+1?>: <?=$task[$temp]['title']?></h4>
    <p>Термін виконання: <?=$task[$temp]['ua_time']?></p>
    <p>Витрачено часу:</p>
    <p>
<!--        --><?php
//        if(!empty($task[$temp]['time']['year'])) echo 'Роки: '.$task[$temp]['time']['year'];
//        if(!empty($task[$temp]['time']['month'])) echo 'Місяці: '.$task[$temp]['time']['month'];
//        if(!empty($task[$temp]['time']['day'])) echo 'Дні: '.$task[$temp]['time']['day'].' - ';
//        if(!empty($task[$temp]['time']['hour'])){
//            if($task[$temp]['time']['hour'] < 10){
//                echo "0".$task[$temp]['time']['hour'];
//            }
//            elseif(empty($task[$temp]['time']['hour'])){
//                echo "00";
//            }
//            else{
//                echo $task[$temp]['time']['hour'];
//            }
//            echo ":";
//        }
//
//
//        ?>
        В будущем)
    </p>
</li>