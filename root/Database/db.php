<?php

namespace root\Database;

use PDO;

class db
{
    private $PDO;
    private static $instance;

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $server = DB_SERVER;
        $dbname = DB_NAME;

        try {
            $this->PDO = new PDO("mysql:host=$server;dbname=$dbname", DB_USERNAME, DB_PASSWORD);
        } catch (\PDOException $e) {
            echo 'Connection error ' . $e->getMessage() . ' !';
            exit();
        }
        return $this->PDO;
     }

     public function execute($sql)
     {
         $result = $this->PDO->prepare($sql);
         $result->execute();

         if($result) {
             return $result->fetchAll(PDO::FETCH_ASSOC);
         }
         return null;
     }
}