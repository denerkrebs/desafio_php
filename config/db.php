<?php

class Database{
    public $connection;

    public function getConnection(){
        $this->conn = null;
  
        try{
            $this->conn = new PDO("pgsql:host=127.0.0.1 port=5432 dbname=desafio_php user=postgres password=root");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}