<?php
require_once(ROOT.'/components/Db.php');
class Task
{

    public static function add($array){

        $db = Db::getConnection();

        $query = "insert into task (title, text, deadline, projectId) values (:title,:text,'{$array['deadline']}', '{$array['project']}')";
        //print_r($query);
        $stmt = $db->prepare($query);

        $stmt->bindValue(':title', $array['title']);
        $stmt->bindValue(':text', $array['text']);

        $stmt->execute();

        return true;

    }

    public static function getList($status){

        $db = Db::getConnection();

        $query = "select id, title, text, deadline, status from task where status = {$status}";
        $result = $db->query($query);
        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $users_str = '';
            $users_arr = [];
            $query_user = "select nick from users inner join manage on users.id = manage.idUser where idTask = '{$row['id']}'";
            $result_user = $db->query($query_user);
            $num = 0;
            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){
                if(!empty($users_str)){
                    $users_str .= ', ';
                }
                $users_str .= $row_user['nick'];
                $users_arr[$num] = $row_user;
                $num++;
            }



            $list[] = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time, 'status'=>$row['status'],'employees_str'=>$users_str,'employees_arr'=>$users_arr];
        }

        return $list;

    }
    public static function getList_page(){


        $db = Db::getConnection();

        $query_page = "select id from task where status = 1";
        $result_page = $db->query($query_page);

        $_SESSION['page']['count'] = ceil($result_page->rowCount()/$_SESSION['page']['note']);


        $skip = ($_SESSION['page']['active_page'] - 1) * $_SESSION['page']['note'];


        $query = "select id, title, text, deadline, status from task where status = 1 limit {$skip}, {$_SESSION['page']['note']}";

        $result = $db->query($query);

        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $users_str = '';
            $users_arr = [];
            $query_user = "select nick from users inner join manage on users.id = manage.idUser where idTask = '{$row['id']}'";
            $result_user = $db->query($query_user);
            $num = 0;
            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){
                if(!empty($users_str)){
                    $users_str .= ', ';
                }
                $users_str .= $row_user['nick'];
                $users_arr[$num] = $row_user;
                $num++;
            }



            $list[] = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time, 'status'=>$row['status'],'employees_str'=>$users_str,'employees_arr'=>$users_arr];
        }

        return $list;
    }


    public static function getListId($id, $status){

        $db = Db::getConnection();

        $query = "select task.id as id, title, text, deadline, task.status as status from task inner join manage on task.id = manage.idTask inner join users on users.id = manage.idUser where users.id = {$id} and task.status = {$status}";
        $result = $db->query($query);

        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $list[] = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time, 'status'=>$row['status']];
        }

        return $list;

    }

    public static function getTask($id, $status){

        $db = Db::getConnection();

        $query = "select id, title, text, deadline from task where id = {$id} and status = {$status}";
        $result = $db->query($query);


        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $users_str = '';
            $users_arr = [];
            $query_user = "select users.id as id, nick, timeStart, timeEnd, (timeEnd - timeStart) as time from users inner join manage on users.id = manage.idUser where idTask = '{$row['id']}'";
            $result_user = $db->query($query_user);
            $num = 0;
            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){
                if(!empty($users_str)){
                    $users_str .= ', ';
                }
                $users_str .= $row_user['nick'];
                

                $row_user['time'] /= 60;

                $user_time = '';

                if($row_user['time'] > 60){
                    $row_user['time'] /= 60;
                    if($row_user['time'] > 24){
                        $row_user['time'] /= 24;
                        if($row_user['time'] > 30){
                            $row_user['time'] /= 30;
                            if($row_user['time'] > 12){
                                $row_user['time'] /= 12;
                                $user_time .= 'Рік: '.floor($row_user['time']);
                                $row_user['time'] = ($row_user['time']-floor($row_user['time']))*12;
                            }
                            $user_time .= ' Місяць: '.floor($row_user['time']);
                            $row_user['time'] = ($row_user['time']-floor($row_user['time']))*30;
                        }
                        $user_time .= ' Дні: '.floor($row_user['time']);
                        $row_user['time'] = ($row_user['time']-floor($row_user['time']))*24;
                    }
                    $user_time .= ' Години: '.floor($row_user['time']);
                    $row_user['time'] = ($row_user['time']-floor($row_user['time']))*60;
                }
                $user_time .= ' Хвилини: '.floor($row_user['time']);
                $row_user['time'] = ($row_user['time']-floor($row_user['time']))*60;
                $user_time .= ' Секунди: '.round($row_user['time']);



                $users_arr[$num] = $row_user;
                $users_arr[$num]['time'] = $user_time;


                $num++;
            }



            $list = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time,'employees_str'=>$users_str,'employees_arr'=>$users_arr];
        }
        //print_r($list);

        return $list;

    }

    public static function getWorkerComplete(){

        $db = Db::getConnection();

        $query_page = "select task.id as id from task inner join manage on manage.idTask = task.id where status = 1 and idUser = {$_SESSION['user']['id']}";
        $result_page = $db->query($query_page);
        $_SESSION['page']['count'] = ceil($result_page->rowCount()/$_SESSION['page']['note']);



        $skip = ($_SESSION['page']['active_page'] - 1) * $_SESSION['page']['note'];

        $query = "select task.id as id, title, text, deadline, timeStart, timeEnd, task.status as status, (timeEnd-timeStart) as time from task inner join manage on task.id = manage.idTask inner join users on users.id = manage.idUser where users.id = {$_SESSION['user']['id']} and task.status = 1 order by time asc limit {$skip}, {$_SESSION['page']['note']}";
        $result = $db->query($query);

        $num = 0;
        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $list[$num] = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time, 'status'=>$row['status']];

            //print_r($row['time']);

            $row['time'] /= 60;

            $user_time = '';

            if($row['time'] > 60){
                $row['time'] /= 60;
                if($row['time'] > 24){
                    $row['time'] /= 24;
                    if($row['time'] > 30){
                        $row['time'] /= 30;
                        if($row['time'] > 12){
                            $row['time'] /= 12;
                            $user_time .= 'Рік: '.floor($row['time']);
                            $row['time'] = ($row['time']-floor($row['time']))*12;
                        }
                        $user_time .= ' Місяць: '.floor($row['time']);
                        $row['time'] = ($row['time']-floor($row['time']))*30;
                    }
                    $user_time .= ' Дні: '.floor($row['time']);
                    $row['time'] = ($row['time']-floor($row['time']))*24;
                }
                $user_time .= ' Години: '.floor($row['time']);
                $row['time'] = ($row['time']-floor($row['time']))*60;
            }
            if(floor($row['time']) != 0) {
                $user_time .= ' Хвилини: ' . floor($row['time']);
            }
            $row['time'] = ($row['time']-floor($row['time']))*60;
            $user_time .= ' Секунди: '.round($row['time']);

            $list[$num]['time_spend'] = $user_time;

            $num++;
        }

        //$list = Task::array_sort($list,'time_sec', 'asc');

        //print_r($list);

        return $list;
    }

    public static function dell($id, $title){

        $db = Db::getConnection();

        $query = "delete from task where id = {$id}";
        $db->query($query);

        $query_dell = "delete from manage where taskName = '{$title}'";
        $db->query($query_dell);

        return true;
    }

    public static function complete($id){

        $db = Db::getConnection();

        $query_task = "update task set status = 1 where id = {$id}";
        $db->query($query_task);

        $query_manage = "update manage set timeEnd = now() where idTask = {$id}";
        $db->query($query_manage);

        return true;
    }


    public static function array_sort($list, $param, $char){

        for($i = 0; $i < count($list); $i++){
            for($j = 0; $j < count($list)-1; $j++){
                if($list[$j][$param] > $list[$j+1][$param] && $char == 'asc'){
                    $tmp = $list[$j][$param];
                    $list[$j][$param] = $list[$j+1][$param];
                    $list[$j+1][$param] = $tmp;
                }
                elseif($list[$j][$param] < $list[$j+1][$param] && $char == 'desc'){
                    $tmp = $list[$j][$param];
                    $list[$j][$param] = $list[$j+1][$param];
                    $list[$j+1][$param] = $tmp;
                }
            }
        }

        return $list;
    }

    public static function getByProject($id){

        $db = Db::getConnection();

        $query = "select id, title, text, deadline, status from task where status = 0 and projectId = {$id}";
        $result = $db->query($query);
        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $users_str = '';
            $users_arr = [];
            $query_user = "select nick from users inner join manage on users.id = manage.idUser where idTask = '{$row['id']}'";
            $result_user = $db->query($query_user);
            $num = 0;
            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){
                if(!empty($users_str)){
                    $users_str .= ', ';
                }
                $users_str .= $row_user['nick'];
                $users_arr[$num] = $row_user;
                $num++;
            }



            $list[] = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time, 'status'=>$row['status'],'employees_str'=>$users_str,'employees_arr'=>$users_arr];
        }

        return $list;

    }
    public static function getByProject_all($id){

        $db = Db::getConnection();

        $query = "select id, title, text, deadline, status from task where projectId = {$id}";
        $result = $db->query($query);
        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $allTime = 0;
            $query_user = "select (TimeEnd-TimeStart) as allTime from users inner join manage on users.id = manage.idUser where idTask = {$row['id']}";
            $result_user = $db->query($query_user);
            $num = 0;
            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){

                $allTime += $row_user['allTime'];

            }



            $list[] = ['id'=>$row['id'], 'title'=>$row['title'], 'ua_time'=>$ua_time, 'all_time'=>$allTime];
        }

        return $list;

    }

    public static function test($id){

        $db = Db::getConnection();

        $query = "select id, title, text, deadline, status from task where projectId = {$id}";
        $result = $db->query($query);
        $list = [];

        $time_arr = ['year'=>0,'month'=>0,'day'=>0,'hour'=>0,'min'=>0,'sec'=>0,'allTime'=>0];

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $list_2 = [];
            $query_user = "select nick, TimeEnd, TimeStart from manage inner join users on users.id = manage.idUser where idTask = {$row['id']}";
            $result_user = $db->query($query_user);
            $num = 0;


            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){

                $list_2[$num] = [$row_user['TimeStart'],$row_user['TimeEnd'],];
                $date1 = new DateTime($row_user['TimeStart']);
                $date2 = new DateTime($row_user['TimeEnd']);

                $interval = $date2->getTimestamp() - $date1->getTimestamp();

                $interval /= 60;

                if($interval > 60){
                    $interval /= 60;
                    if($interval > 24){
                        $interval /= 24;
                        if($interval > 30){
                            $interval /= 30;
                            if($interval > 12){
                                $interval /= 12;
                                $time_arr['year'] += floor($interval);
                                $interval = ($interval-floor($interval))*12;
                            }
                            $time_arr['month'] += floor($interval);
                            $interval = ($interval-floor($interval))*30;
                        }
                        $time_arr['day'] += floor($interval);
                        $interval = ($interval-floor($interval))*24;
                    }
                    $time_arr['hour'] += floor($interval);
                    $interval = ($interval-floor($interval))*60;
                }

                $time_arr['min'] += floor($interval);
                $interval = ($interval-floor($interval))*60;
                $time_arr['sec'] += round($interval);

                $num++;
            }

            $switch = true;
            while($switch){
                $switch = false;
                if($time_arr['month'] >= 12){
                    $time_arr['month'] -= 12;
                    $time_arr['year']++;
                    $switch = true;
                }
                if($time_arr['day'] >= 30){
                    $time_arr['day'] -= 30;
                    $time_arr['month']++;
                    $switch = true;
                }
                if($time_arr['hour'] >= 24){
                    $time_arr['hour'] -= 24;
                    $time_arr['day']++;
                    $switch = true;
                }
                if($time_arr['min'] >= 60){
                    $time_arr['min'] -= 60;
                    $time_arr['hour']++;
                    $switch = true;
                }
                if($time_arr['sec'] >= 60){
                    $time_arr['sec'] -= 60;
                    $time_arr['min']++;
                    $switch = true;
                }
            }


            $list[] = ['id'=>$row['id'], 'title'=>$row['title'], 'ua_time'=>$ua_time, 'time'=>$time_arr];

        }

        //print_r($list);


        return $list;

    }



    public static function getByProjectNum($id){


        $db = Db::getConnection();

        $query_page = "select id from task where status = 1 and projectId = {$id}";
        $result_page = $db->query($query_page);
        $_SESSION['page']['count'] = ceil($result_page->rowCount()/$_SESSION['page']['note']);

        $skip = ($_SESSION['page']['active_page'] - 1) * $_SESSION['page']['note'];


        $query = "select id, title, text, deadline, status from task where status = 1 and projectId = {$id} limit {$skip}, {$_SESSION['page']['note']}";

        $result = $db->query($query);

        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $users_str = '';
            $users_arr = [];
            $query_user = "select nick from users inner join manage on users.id = manage.idUser where taskName = '{$row['title']}'";
            $result_user = $db->query($query_user);
            $num = 0;
            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){
                if(!empty($users_str)){
                    $users_str .= ', ';
                }
                $users_str .= $row_user['nick'];
                $users_arr[$num] = $row_user;
                $num++;
            }



            $list[] = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time, 'status'=>$row['status'],'employees_str'=>$users_str,'employees_arr'=>$users_arr];
        }

        return $list;
    }

    public static function projectFullInfo($id){

        $db = Db::getConnection();

        $query = "select id, title, text, deadline, status from task where and projectId = {$id}";
        $result = $db->query($query);
        $list = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $time = explode(' ', $row['deadline']);
            $time[1] = substr($time[1],0,5);
            $ua_time = explode('-', $time[0]);
            $ua_time = $ua_time[2].'-'.$ua_time[1].'-'.$ua_time[0];

            $users_str = '';
            $users_arr = [];
            $query_user = "select nick from users inner join manage on users.id = manage.idUser where taskName = '{$row['title']}'";
            $result_user = $db->query($query_user);
            $num = 0;
            while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)){
                if(!empty($users_str)){
                    $users_str .= ', ';
                }
                $users_str .= $row_user['nick'];
                $users_arr[$num] = $row_user;
                $num++;
            }



            $list[] = ['id'=>$row['id'], 'title'=>$row['title'],'text'=>$row['text'],'deadline_time'=>$time[1],'deadline_day'=>$time[0],'ua_time'=>$ua_time, 'status'=>$row['status'],'employees_str'=>$users_str,'employees_arr'=>$users_arr];
        }


        return $list;
    }

    public static function print($task, $temp = 0){
        if($temp < count($task)){
            require(ROOT.'/views/one_task.php');
            //echo $temp;
            $temp++;
            Task::print($task, $temp);
        }
    }


}