<?php
require_once(ROOT.'/models/Task.php');
require_once(ROOT.'/models/User.php');
require_once(ROOT.'/models/Manage.php');
require_once(ROOT.'/models/Project.php');
class CalendarController
{

    public function actionIndex(){

        //print_r($_COOKIE);


        $projects = Project::getList();




        require_once(ROOT.'/views/index.php');
        //require_once(ROOT.'/views/test_html.php');


        return true;
    }

    public function actionAdd(){

        if(isset($_POST['title'], $_POST['data'], $_POST['text'], $_POST['project']) && !empty($_POST['project']) && !empty($_POST['title']) && !empty($_POST['data'])){

            $deadline = explode('T', $_POST['data']);

            $now = [Date('Y-m-d'), Date('H:i')];


            if($deadline[0] == $now[0]){ // В один день знач не в БД

                if(isset($_COOKIE) && !empty($_COOKIE) && count($_COOKIE) > 5){
//                    for($i = 1; $i <= count($_COOKIE)/3; $i++){
//                        setcookie("task_title_$i", '', time()-7200);
//                        setcookie("task_deadline_$i", '', time()-7200);
//                        setcookie("task_text_$i", '', time()-7200);
//                    }
                    $num = ((count($_COOKIE)-5)/6)+1;
                    setcookie("task_title_$num", $_POST['title'], time()+60*60*24*30*3,'/');
                    setcookie("task_deadline_time_$num", $deadline[1], time()+60*60*24*30*3,'/');
                    setcookie("task_text_$num", $_POST['text'], time()+60*60*24*30*3,'/');
                    setcookie("task_deadline_day_$num", $deadline[0], time()+60*60*24*30*3,'/');
                    setcookie("task_project_$num", $_POST['project'], time()+60*60*24*30*3,'/');
                    setcookie("task_status_$num", 0, time()+60*60*24*30*3,'/');

                }
                else{
                    setcookie('task_title_1',$_POST['title'],time()+60*60*24*30*3,'/');
                    setcookie('task_deadline_time_1', $deadline[1], time()+60*60*24*30*3,'/');
                    setcookie("task_text_1", $_POST['text'], time()+60*60*24*30*3,'/');
                    setcookie("task_deadline_day_1", $deadline[0], time()+60*60*24*30*3,'/');
                    setcookie("task_project_1", $_POST['project'], time()+60*60*24*30*3,'/');
                    setcookie("task_status_1", 0, time()+60*60*24*30*3,'/');

                }

                $text = 'Задача успешно створена!';

            }
            else{
                // Тут должна буть
                // Детальна перевірка на скіки днів і запис в БД

                $data = explode('-',$deadline[0]);
                $now = explode('-', Date('Y-m-d'));

                $time = $deadline[0].' '.$deadline[1].':00';

                if($data[0] == $now[0]){
                    if($data[1] == $now[1]){
                        if($data[2] > $now[2]){
                            Task::add(['title'=>$_POST['title'],'deadline'=>$time,'text'=>$_POST['text'], 'project'=>$_POST['project']]);
                            $text = 'Задача успешно створена!';
                        }
                        else{
                            $text = 'Ця дата вже пройшла';
                        }
                    }
                    elseif($data[1] > $now[1]) {
                        Task::add(['title' => $_POST['title'], 'deadline' => $time, 'text' => $_POST['text'], 'project'=>$_POST['project']]);
                        $text = 'Задача успешно створена!';
                    }
                    else{
                        $text = 'Ця дата вже пройшла';

                    }
                }
                elseif($data[0] > $now[0]){
                    Task::add(['title'=>$_POST['title'],'deadline'=>$time,'text'=>$_POST['text'], 'project'=>$_POST['project']]);
                    $text = 'Задача успешно створена!';
                }
                else{
                    $text = 'Ця дата вже пройшла';
                }

            }

            header("refresh:3;url=/index");
            require_once(ROOT.'/views/result.php');
        }


        return true;
    }

    public function actionShow(){

        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {

            //print_r($_COOKIE);
            //print_r($_SESSION);

            $tasks = [];

            if (isset($_COOKIE['task_text_1']) && !empty($_COOKIE['task_text_1'])) {
                //print_r($_COOKIE);
                    $superList = Project::getSuperList();
                    //print_r($superList);
                for ($i = 1; $i <= (count($_COOKIE) - 5) / 6; $i++) {
                    $time = explode('-', $_COOKIE["task_deadline_day_$i"]);
                    $time = $time[2] . '-' . $time[1] . '-' . $time[0];
                    $tasks[] = ['id'=>0, 'project'=>$superList[$_COOKIE["task_project_$i"]], 'num'=>$i, 'title' => $_COOKIE["task_title_$i"], 'status' => $_COOKIE["task_status_$i"], 'deadline_time' => $_COOKIE["task_deadline_time_$i"], 'deadline_day' => $_COOKIE["task_deadline_day_$i"], 'text' => $_COOKIE["task_text_$i"], 'ua_time' => $time];
                }
            }


            if (isset($_SESSION['user']['lvl']) && $_SESSION['user']['lvl'] == 1) {
                $workers = User::getWorkers();
                $list = Task::getList(0);
                //print_r($list);

                //$users = User::getList();
                $path = ROOT . '/views/admin_tasks.php';
            } elseif (isset($_SESSION['user']['lvl']) && $_SESSION['user']['lvl'] == 2) {
                $list = Task::getListId($_SESSION['user']['id'],0); // Ще в розроботкі
                $path = ROOT . '/views/tasks.php';
            }

            if (isset($list) && !empty($list)) {
                foreach ($list as $task) {
                    $tasks[] = $task;
                }
            }
            //print_r($tasks);

            //print_r($_COOKIE);
            require_once($path);

        }
        else{
            header('location:/user/login');

        }

        return true;
    }

    public function actionManageAdd(){

        if(isset($_POST['send'], $_POST['worker'], $_POST['time']) && !empty($_POST['worker']) && !empty($_POST['time'])){

            $array = ['id_user'=>$_POST['worker'],'time'=>$_POST['time']];
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $array['idTask'] = $_POST['id'];
            }

            if(isset($_POST['num']) && !empty($_POST['num'])){
                $array['num'] = $_POST['num'];
            }
            Manage::add($array);
            //print_r($array);
        }
        if(isset($_POST['tmp']) && !empty($_POST['tmp'])){
            header("location:/show/project/{$_POST['tmp']}");
        }
        else {
            header('location:/all/task');
        }

        return true;
    }

    public function actionDetail($id){

        $task = Task::getTask($id, 0);
        $workers = User::getWorkers();

        //print_r($task);

        require_once(ROOT.'/views/admin_detail.php');

        return true;
    }
    public function actionTaskDell(){

        if(isset($_POST['send'], $_POST['id'], $_POST['title']) && !empty($_POST['id']) && !empty($_POST['title'])) {
            Task::dell($_POST['id'], $_POST['title']);

            header("refresh:3;url=/all/task");
            $text = "Задача усішно видалена";
            require_once(ROOT . '/views/result.php');
        }

        return true;
    }

    public function actionComplete(){

        if(isset($_POST['send'], $_POST['id']) && !empty($_POST['id'])){

            Task::complete($_POST['id']);

        }
        elseif(isset($_POST['num']) && !empty($_POST['num'])){

            Manage::add_2($_POST['num']);

        }

        header('refresh:3;url=/all/task');
        $text = "Завдання виконано";
        require_once(ROOT.'/views/result.php');

        return true;
    }

    public function actionCompleteShow($page){

        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {

            $_SESSION['page']['note'] = 3;

            if (isset($page) && !empty($page)) {
                $_SESSION['page']['active_page'] = $page;
            } else {
                $_SESSION['page']['active_page'] = 1;
            }

            if($_SESSION['user']['lvl'] == 1) {

                $workers = User::getWorkers();
                $tasks = Task::getList_page();


                //print_r($_SESSION['page']);
                if (isset($_SESSION['page']['count']) && !empty($_SESSION['page']['count'])) {
                    require_once(ROOT . '/views/admin_complete.php');
                } else {
                    header("refresh:2;url=/all/task");
                    $class = 'error';
                    $text = "Не має виконаних завдань.";
                    require_once(ROOT.'/views/result.php');
                }
            }
            else{

                $tasks = Task::getWorkerComplete();

                if (isset($_SESSION['page']['count']) && !empty($_SESSION['page']['count'])) {
                    require_once(ROOT . '/views/complete.php');
                } else {
                    require_once(ROOT . '/views/complete.php');
                }

            }
        }
        else{
            header('location:/user/login');
        }


        return true;
    }

    public function actionCompleteTaskShow($id){ // Detail Admin

        $task = Task::getTask($id, 1);

        //print_r($task);

        require_once(ROOT.'/views/admin_complete_detail.php');


        return true;
    }

    public function actionProjectAdd(){

        if(!isset($_POST['send'])) {
            require_once(ROOT . '/views/project_add.php');
        }
        elseif(isset($_POST['send'], $_POST['name']) && !empty($_POST['name'])){

            Project::add($_POST['name']);

            $text = "Проект успішно створено";

            header('refresh:3;url=/add/project');

            require_once(ROOT.'/views/result.php');

        }


        return true;
    }

    public function actionProjectShow(){

        if(isset($_POST['title'], $_POST['send']) && !empty($_POST['title'])){
            $projects = Project::getListSearch($_POST['title']);
        }
        elseif(isset($_POST['nick'], $_POST['send']) && !empty($_POST['nick'])){
            $projects = Project::getListSearchUser($_POST['nick']);
        }
        else{
            $projects = Project::getList();
        }


        require_once(ROOT.'/views/project_show.php');


        return true;
    }

    public function actionTaskShow($id){

        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {

            //print_r($_COOKIE);

            if($_SESSION['user']['lvl'] == 1) {

                $workers = User::getWorkers();
                $tasks = Task::getByProject($id);
                //print_r($tasks);
                for($i = 1; $i <= (count($_COOKIE)-5)/6; $i++){
                    if($_COOKIE["task_project_$i"] == $id){
                        $ua_time = explode('-', $_COOKIE["task_deadline_day_$i"]);
                        $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];
                        $tasks[] = [
                            'title'=>$_COOKIE["task_title_$i"],
                            'text'=>$_COOKIE["task_text_$i"],
                            'deadline_time'=>$_COOKIE["task_deadline_time_$i"],
                            'deadline_day'=>$_COOKIE["task_deadline_day_$i"],
                            'status'=>$_COOKIE["task_status_$i"],
                            'ua_time'=>$ua_time,
                            'employees_str'=>'',
                            'employees_arr'=>[],
                            'num'=>$i
                        ];
                    }
                }

                //print_r($tasks);
                //print_r($workers);
                //print_r($_COOKIE);

//                for($i = 0; $i < count($tasks); $i++){
//
//                    $temp = true;
//                    $employees = [];
//                    $num = 0;
//                    foreach($workers as $worker){
//                        if(!empty($task['employees_arr'])){
//                            $tmp = true;
//                            foreach($task['employees_arr'] as $employ){
//                                if($worker['name'] == $employ['nick']){
//                                    $tmp = false;
//                                }
//                            }
//                            if($tmp){
//                                $temp = false;
//                                $employees[$num]['id'] = $worker['id'];
//                                $employees[$num]['name'] = $worker['name'];
//                                $num++;
//                            }
//                        }
//                        else{
//                            $temp = false;
//                            $employees[$num]['id'] = $worker['id'];
//                            $employees[$num]['name'] = $worker['name'];
//                            $num++;
//                        }
//                    }
//
//                    $tasks[$i]['employees_arr'] = $employees;
//                }
                //print_r($tasks);

                require_once(ROOT . '/views/admin_tasks_2.php');
            }
            else{

                $tasks = Task::getWorkerComplete();


                require_once(ROOT.'/views/tasks.php');

            }
        }
        else{
            header('location:/user/login');
        }



        return true;
    }

    public function actionShowCompleteTask($project, $page){

        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {

            $_SESSION['page']['note'] = 3;

            if (isset($page) && !empty($page)) {
                $_SESSION['page']['active_page'] = $page;
            } else {
                $_SESSION['page']['active_page'] = 1;
            }

            if($_SESSION['user']['lvl'] == 1) {

                $workers = User::getWorkers();
                $tasks = Task::getByProjectNum($project);


                //print_r($_SESSION['page']);
                if (isset($_SESSION['page']['count']) && !empty($_SESSION['page']['count'])) {
                    require_once(ROOT . '/views/admin_complete_2.php');
                } else {
                    $class = 'error';
                    $text = 'Не має виконаних завддань';
                    require_once(ROOT.'/views/result.php');
                    header("refresh:2;url=/show/project/{$project}");


                }
            }
            else{

                $tasks = Task::getWorkerComplete();

                if (isset($_SESSION['page']['count']) && !empty($_SESSION['page']['count'])) {
                    require_once(ROOT . '/views/complete.php');
                } else {
                    require_once(ROOT . '/views/complete.php');
                }

            }
        }
        else{
            header('location:/user/login');
        }

        return true;
    }

    public function actionProjectFullInfo($id){

        $projectName = Project::getName($id);

        $tasks = Task::test($id);

        $_SESSION['diagram']['task'] = User::getTime($id);

        $allTime = 0;
        foreach($_SESSION['diagram']['task'] as $name=>$value){
            $allTime += $value;
        }

        //print_r($_SESSION);


        //print_r($allTime);
        //print_r($users);

        //print_r($testTask);

        //$tasks_test = Task::getByProject_all($id);

        for($i = 1; $i <= (count($_COOKIE)-5)/6; $i++){
            if($_COOKIE["task_project_$i"] == $id){
                $ua_time = explode('-', $_COOKIE["task_deadline_day_$i"]);
                $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];
                $tasks[] = [
                    'title'=>$_COOKIE["task_title_$i"],
                    'text'=>$_COOKIE["task_text_$i"],
                    'deadline_time'=>$_COOKIE["task_deadline_time_$i"],
                    'deadline_day'=>$_COOKIE["task_deadline_day_$i"],
                    'status'=>$_COOKIE["task_status_$i"],
                    'ua_time'=>$ua_time,
                    'employees_str'=>'',
                    'employees_arr'=>[],
                    'num'=>$i
                ];
            }
        }
        //print_r($tasks);

        require_once(ROOT.'/views/admin_project_detail.php');




        return true;
    }

    public function actionProjectAll(){

        $project_list = Project::getSuperList();

        $_SESSION['diagram']['project'] = Project::getTime();


        $allTime = 0;
        foreach($_SESSION['diagram']['project'] as $name=>$value){
            $allTime += $value;
        }
        $allTime = $allTime/3600;


        //print_r($allTime);

        require_once(ROOT.'/views/projects_all.php');

        return true;
    }




}