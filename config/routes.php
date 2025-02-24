<?php
return array(

    'show/complete/task/([0-9]+)'=>'calendar/completeTaskShow/$1',
    'complete/task/show/([0-9]+)'=>'calendar/completeShow/$1',
    'complete/task'=>'calendar/complete',
    'dell/task'=>'calendar/taskDell',
    'show/task/([0-9]+)'=>'calendar/detail/$1',

    'manage/add'=>'calendar/manageAdd',

    'user/dell'=>'user/dell',
    'user/exit'=>'user/exit',
    'user/resultLog'=>'user/resultLog',
    'user/login'=>'user/login',
    'user/resultReg'=>'user/resultReg',
    'user/reg'=>'user/registration',

    'all/project'=>'calendar/projectShow',
    'all/task'=>'calendar/show',
    'add/task'=>'calendar/add',

    'projects/all'=>'calendar/projectAll',
    'project/detail/([0-9]+)'=>'calendar/projectFullInfo/$1',
    'show/project/complete/([0-9]+)/([0-9]+)'=>'calendar/showCompleteTask/$1/$2',
    'show/project/([0-9]+)'=>'calendar/taskShow/$1',
    'add/project'=>'calendar/projectAdd',

    'index'=>'calendar/index'
);