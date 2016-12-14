<?php

class DB {
    public static $instance = null;

    public static function getInstance() {
        if(self::$instance == null) {
            $ini = parse_ini_file('db.ini', true);

            if($ini !== false) {
                $openshift["host"] = getenv('OPENSHIFT_MYSQL_DB_HOST');

                if($openshift["host"] != "") {
                    $ini['host'] = $openshift["host"];
                }

                self::$instance = new PDO("mysql:host={$ini['host']}; dbname={$ini['database']}", $ini['username'], $ini['password']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec('SET NAMES utf8');
            }

        }

        return self::$instance;
    }
}