<?php
require_once(ROOT.'/components/Db.php');
class Project
{

    public static function add($name){

        $db = Db::getConnection();

        $query = "insert into project (name) values (:name)";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':name',$name);

        $num_row = $stmt->execute();

        if($num_row > 0){
            return true;
        }
        else{
            return false;
        }

    }

    public static function getList(){

        $db = Db::getConnection();


        $query = "select id, name from project";
        $result = $db->query($query);

        $list = [];
        $num = 0;
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $query_count = "select id from task where projectId = {$row['id']} and status = 0";
            $result_count = $db->query($query_count);
            $count = $result_count->rowCount();
            $list[$num]['id'] = $row['id'];
            $list[$num]['name'] = $row['name'];
            $list[$num]['count'] = $count;
            for($i = 1; $i <= (count($_COOKIE)-5)/6; $i++){
                if($_COOKIE["task_status_$i"] == 0 && $_COOKIE["task_project_$i"] == $row['id']){
                    $list[$num]['count']++;
                }
            }
            $num++;
        }

        return $list;

    }
    public static function getListSearch($title){

        $db = Db::getConnection();

        $query = "select id, name from project";


        $search = str_replace(',',' ',$title);

        $array = [];
        $noWords = explode(' ',$search);
        foreach($noWords as $tmp){
            if(!empty($tmp)){
                $array[] = " name like '%{$tmp}%'";
            }
        }

        $str = implode(' or ',$array);

        if(!empty($str)){
            $query .= " where $str";
        }

        $result = $db->query($query);

        $list = [];
        $num = 0;
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $query_count = "select id from task where projectId = {$row['id']} and status = 0";
            $result_count = $db->query($query_count);
            $count = $result_count->rowCount();
            $list[$num]['id'] = $row['id'];
            $list[$num]['name'] = $row['name'];
            $list[$num]['count'] = $count;
            for($i = 1; $i <= (count($_COOKIE)-5)/6; $i++){
                if($_COOKIE["task_status_$i"] == 0 && $_COOKIE["task_project_$i"] == $row['id']){
                    $list[$num]['count']++;
                }
            }
            $num++;
        }

        //print_r($list);

        return $list;

    }

    public static function getListSearchUser($nick){

        $db = Db::getConnection();

        $query = "select distinct project.name as 'name', project.id as id from project inner join task on project.id = task.projectId inner join manage on task.id = manage.idTask inner join users on manage.idUser = users.id";

        $search = str_replace(',',' ',$nick);

        $array = [];
        $noWords = explode(' ',$search);
        foreach($noWords as $tmp){
            if(!empty($tmp)){
                $array[] = " users.nick like '%{$tmp}%'";
            }
        }

        $str = implode(' or ',$array);

        if(!empty($str)){
            $query .= " where $str";
        }
        //echo $query;

        $result = $db->query($query);

        $list = [];
        $num = 0;
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $query_count = "select id from task where projectId = {$row['id']} and status = 0";
            $result_count = $db->query($query_count);
            $count = $result_count->rowCount();
            $list[$num]['id'] = $row['id'];
            $list[$num]['name'] = $row['name'];
            $list[$num]['count'] = $count;
            for($i = 1; $i <= (count($_COOKIE)-5)/6; $i++){
                if($_COOKIE["task_status_$i"] == 0 && $_COOKIE["task_project_$i"] == $row['id']){
                    $list[$num]['count']++;
                }
            }
            $num++;
        }

        //print_r($list);

        return $list;

    }


    public static function getSuperList(){

        $db = Db::getConnection();

        $query = "select id, name from project";
        $result = $db->query($query);
        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){

            $list[$row['id']] = $row['name'];

        }


        return $list;
    }

    public static function getName($id){
        $db = Db::getConnection();

        $query = "select name from project where id = {$id}";
        $result = $db->query($query);

        return $result->fetch(PDO::FETCH_NUM)[0];

    }

    public static function getTime(){

        $db = Db::getConnection();

        $query = "select project.name as name, timeStart, timeEnd from project inner join task on project.id = task.projectId inner join manage on manage.idTask = task.id;";
        $result = $db->query($query);

        $list = [];

        while($row = $result->fetch(PDO::FETCH_ASSOC)){

            $date1 = new DateTime($row['timeStart']);
            $date2 = new DateTime($row['timeEnd']);

            $interval = $date2->getTimestamp() - $date1->getTimestamp();

            $temp = true;
            for($i = 0; $i < count($list); $i++){
                if(isset($list[$row['name']])){
                    $list[$row['name']] += $interval;
                    $temp = false;
                }
            }
            if($temp){
                $list[$row['name']] = $interval;
            }

        }



        //print_r($list);

        return $list;

    }



}