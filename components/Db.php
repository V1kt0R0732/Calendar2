<?php

class Db
{

    public static function getConnection(){

        $param = require(ROOT.'/config/param.php');

        $dns = "mysql:host={$param['host']};dbname={$param['dbname']}";
        return new PDO($dns,$param['username'],$param['pass']);

    }


}