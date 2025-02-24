<?php
require_once(ROOT.'/models/Task.php');
require_once(ROOT.'/models/User.php');
class UserController
{

    public function actionRegistration(){

        require_once(ROOT.'/views/reg.php');


        return true;
    }

    public function actionResultReg(){

        if(isset($_POST['send'], $_POST['login'], $_POST['email'], $_POST['password_1'], $_POST['password_2']) && !empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password_1']) && $_POST['password_1'] == $_POST['password_2']){


            $result = User::reg(['login'=>$_POST['login'],'email'=>$_POST['email'],'pass'=>$_POST['password_1']]);

            if($result) {
                $text = "Ви успішно зареєструвались";
            }
            else{
                $text = "Unlucky, Error";
            }
            if(isset($_SESSION['user']['lvl']) && $_SESSION['user']['lvl'] == 1){
                header("refresh:3;url=/user/reg");
            }
            else {
                header("refresh:3;url=/user/login");
            }
            require_once(ROOT . "/views/result.php");
        }
        elseif(isset($_POST['send'], $_POST['login'], $_POST['email'], $_POST['password_1'], $_POST['password_2']) && !empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password_1']) && $_POST['password_1'] != $_POST['password_2']){

            header("refresh:3;url=/user/reg");
            $text = "Паролі не співпадають";
            require_once(ROOT."/views/result.php");

        }
        else{
            header("refresh:3;url=/user/reg");
            $text = "Проблема передачі даних";
            require_once(ROOT."/views/result.php");
        }

        return true;
    }

    public function actionLogin(){

        require_once(ROOT.'/views/login.php');

        return true;
    }
    public function actionResultLog(){

        if(isset($_POST['send'], $_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){


            $result = User::login(['email'=>$_POST['email'],'pass'=>$_POST['password']]);

            if($result) {
                $text = "Ви успішно Увійшли";
                header("refresh:3;url=/all/task");
                require_once(ROOT . "/views/result.php");
            }
            else{
                $text = "Неправильно введені дані";
                header("refresh:3;url=/user/login");
                require_once(ROOT . "/views/result.php");
            }

        }
        else{
            header("refresh:3;url=/user/login");
            $text = "Проблема передачі даних";
            require_once(ROOT."/views/result.php");
        }

        return true;

    }

    public function actionExit(){

        User::exit();

        header('location:/index');

        return true;
    }

    public function actionDell(){

        if(isset($_POST['send'], $_POST['id'], $_POST['title'], $_POST['task_id']) && !empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['task_id'])){
            User::dell($_POST['id'], $_POST['title']);
        }

        header("location:/show/task/{$_POST['task_id']}");

        return true;
    }





}