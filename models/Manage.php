<?php
require_once(ROOT.'/components/Db.php');
class Manage
{

    public static function add($task){

        $db = Db::getConnection();

        if(isset($task['num'])){
            $deadline = $_COOKIE["task_deadline_day_{$task['num']}"].' '.$_COOKIE["task_deadline_time_{$task['num']}"].':00';
            $query_add = "insert into task (projectId, title, text, deadline) values ({$_COOKIE["task_project_{$task['num']}"]},'{$_COOKIE["task_title_{$task['num']}"]}','{$_COOKIE["task_text_{$task['num']}"]}','{$deadline}')";
            $db->query($query_add);


            if(isset($_COOKIE["task_title_{$task['num']}"]) && !empty($_COOKIE["task_title_{$task['num']}"])){
                setcookie("task_title_{$task['num']}",'',time()-7200,'/');
            }
            if(isset($_COOKIE["task_text_{$task['num']}"]) && !empty($_COOKIE["task_text_{$task['num']}"])){
                setcookie("task_text_{$task['num']}",'',time()-7200,'/');
            }
            if(isset($_COOKIE["task_status_{$task['num']}"]) && !empty($_COOKIE["task_status_{$task['num']}"])){
                setcookie("task_status_{$task['num']}",'',time()-7200,'/');
            }
            if(isset($_COOKIE["task_deadline_day_{$task['num']}"]) && !empty($_COOKIE["task_deadline_day_{$task['num']}"])){
                setcookie("task_deadline_day_{$task['num']}",'',time()-7200,'/');
            }
            if(isset($_COOKIE["task_deadline_time_{$task['num']}"]) && !empty($_COOKIE["task_deadline_time_{$task['num']}"])){
                setcookie("task_deadline_time_{$task['num']}",'',time()-7200,'/');
            }
            if(isset($_COOKIE["task_project_{$task['num']}"]) && !empty($_COOKIE["task_project_{$task['num']}"])){
                setcookie("task_project_{$task['num']}",'',time()-7200,'/');
            }
            if(isset($_COOKIE["task_status_{$task['num']}"]) && !empty($_COOKIE["task_status_{$task['num']}"])){
                setcookie("task_status_{$task['num']}",'',time()-7200,'/');
            }

            $task['idTask'] = $db->lastInsertId($query_add);
        }

        $query = "insert into manage (idUser, idTask, timeStart) values ({$task['id_user']}, '{$task['idTask']}', now())";
        $db->query($query);

        return true;
    }

    public static function add_2($num){

        $task['num'] = $num;

        $db = Db::getConnection();

        $deadline = $_COOKIE["task_deadline_day_{$task['num']}"].' '.$_COOKIE["task_deadline_time_{$task['num']}"].':00';
        $query_add = "insert into task (projectId, title, text, deadline, status) values ({$_COOKIE["task_project_{$task['num']}"]},'{$_COOKIE["task_title_{$task['num']}"]}','{$_COOKIE["task_text_{$task['num']}"]}','{$deadline}', 1)";
        //echo $query_add;
        $db->query($query_add);

        if(isset($_COOKIE["task_title_{$task['num']}"]) && !empty($_COOKIE["task_title_{$task['num']}"])){
            setcookie("task_title_{$task['num']}",'',time()-7200,'/');
        }
        if(isset($_COOKIE["task_text_{$task['num']}"]) && !empty($_COOKIE["task_text_{$task['num']}"])){
            setcookie("task_text_{$task['num']}",'',time()-7200,'/');
        }
        if(isset($_COOKIE["task_status_{$task['num']}"]) && !empty($_COOKIE["task_status_{$task['num']}"])){
            setcookie("task_status_{$task['num']}",'',time()-7200,'/');
        }
        if(isset($_COOKIE["task_deadline_day_{$task['num']}"]) && !empty($_COOKIE["task_deadline_day_{$task['num']}"])){
            setcookie("task_deadline_day_{$task['num']}",'',time()-7200,'/');
        }
        if(isset($_COOKIE["task_deadline_time_{$task['num']}"]) && !empty($_COOKIE["task_deadline_time_{$task['num']}"])){
            setcookie("task_deadline_time_{$task['num']}",'',time()-7200,'/');
        }
        if(isset($_COOKIE["task_project_{$task['num']}"]) && !empty($_COOKIE["task_project_{$task['num']}"])){
            setcookie("task_project_{$task['num']}",'',time()-7200,'/');
        }
        if(isset($_COOKIE["task_status_{$task['num']}"])){
            setcookie("task_status_{$task['num']}",'',time()-7200,'/');
        }

        $task['idTask'] = $db->lastInsertId($query_add);


        $query = "insert into manage (idUser, idTask, timeStart, timeEnd) values ({$_COOKIE['user_id']}, {$task['idTask']}, now(), now())";
        //echo $query;
        $db->query($query);

        return true;

    }





}