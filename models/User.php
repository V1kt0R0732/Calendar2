<?php
require_once(ROOT.'/components/Db.php');
class User
{

    public static function reg($user){

        $db = Db::getConnection();

        $query = "insert into users (nick, password, email) values (:nick,sha1(:pass),:email)";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':nick',$user['login']);
        $stmt->bindValue(':pass',$user['pass']);
        $stmt->bindValue(':email',$user['email']);

        $num_row = $stmt->execute();

        if($num_row > 0){
            return true;
        }
        else{
            return false;
        }

    }

    public static function login($user){

        $db = Db::getConnection();

        $query = "select id, nick, email, password, status from users where password = sha1({$user['pass']}) and email = '{$user['email']}'";
        $result = $db->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if(isset($row) && !empty($row)){

            setcookie('user_login',$row['nick'], time()+60*60*24*30*3,'/');
            setcookie('user_email',$row['email'], time()+60*60*24*30*3,'/');
            setcookie('user_lvl', $row['status'], time()+60*60*24*30*3, '/');
            setcookie('user_id', $row['id'], time()+60*60*24*30*3, '/');


            $_SESSION['user']['login'] = $row['nick'];
            $_SESSION['user']['email'] = $row['email'];
            $_SESSION['user']['lvl'] = $row['status'];
            $_SESSION['user']['id'] = $row['id'];

            return true;
        }
        else{
            return false;
        }

    }

    public static function exit(){

        if(isset($_COOKIE['user_login']) && !empty($_COOKIE['user_login'])){
            setcookie('user_login','',time()-7200);
        }
        if(isset($_COOKIE['user_email']) && !empty($_COOKIE['user_email'])){
            setcookie('user_email','',time()-7200);
        }
        if(isset($_COOKIE['user_lvl']) && !empty($_COOKIE['user_lvl'])){
            setcookie('user_lvl','',time()-7200);
        }
        if(isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])){
            setcookie('user_id','',time()-7200);
        }
        if(isset($_COOKIE[session_name()]) && !empty($_COOKIE[session_name()])){
            setcookie(session_name(),'',time()-7200);
        }

        $_SESSION['user'] = [];

        session_destroy();

        return true;
    }

    public static function getWorkers(){

        $db = Db::getConnection();

        $query = "select id, nick, email from users where status = 2";
        $result = $db->query($query);
        $workers = [];
        $num = 0;
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $workers[$num]['id'] = $row['id'];
            $workers[$num]['name'] = $row['nick'];
            $workers[$num]['email'] = $row['email'];
            $num++;
        }


        return $workers;
    }

    public static function dell($id, $title){

        $db = Db::getConnection();

        $query = "delete from manage where idUser = {$id} and taskName = '{$title}'";
        $db->query($query);

        return true;
    }

    public static function print($array, $temp = 0){
        //print_r($array);
        if($temp < count($array)){
            echo "<li class='employee-item'><span>{$array[$temp]['nick']}</span><span class='remove-employee-button' id='time-spend'>Виконав за: {$array[$temp]['time']}</span></li>";
            $temp++;
            User::print($array, $temp);
        }
    }

    public static function getTime($project_id){

        $db = Db::getConnection();

        $query = "select nick, timeStart, timeEnd from project inner join task on project.id = task.projectId inner join manage on manage.idTask = task.id inner join users on users.id = manage.idUser where project.id = {$project_id} and manage.timeEnd is not null and task.status = 1;";
        $result = $db->query($query);
        $users = [];


        while($row = $result->fetch(PDO::FETCH_ASSOC)){

            $date1 = new DateTime($row['timeStart']);
            $date2 = new DateTime($row['timeEnd']);

            $interval = $date2->getTimestamp() - $date1->getTimestamp();

            $user_temp = true;
            for($i = 0; $i < count($users); $i++){
                if(isset($users[$row['nick']])){
                    $users[$row['nick']] += $interval;
                    $user_temp = false;
                }
            }
            if($user_temp){
                $users[$row['nick']] = $interval;
            }

        }

        //print_r($users);

        sort($users);

        //print_r($users);

        return $users;


    }


}