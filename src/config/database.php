<?php

class Database{
    //Properties
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '56658378';
    private $dbname = 'slimapp';
    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
       //Set the dsn
       $dsn = 'mysql:host='. $this->host . ';dbname='. $this->dbname;
       //Set Options
       $options = array(
           PDO::ATTR_PERSISTENT => true,
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
       );
       //Create a PDO instance
       try
       {
           $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
       }
       catch(PDOException $e)
       {
           $this->error = $e->getMessage();
       }
    }
    //Function to query the database
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }
    //Function to bind values to paramas
    public function bind($param, $value, $type = null)
    {
        if (is_null($type))
        {
            switch (true)
            {
                case is_int ($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool ($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null ($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default :
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue ($param, $value, $type);
    }
    //Function to execute a PDO statemet
    public function execute()
    {
        return $this->stmt->execute();
    }
    //Funtion to return results
    public function results()
    {
       $this->execute();
       return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    //Function t return a single result
    public function single()
    {
        $this->execute();
         return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    //Function to count rows
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    //Funtion to retrieve the last Insert ID
    public function lastInsertId()
    {
       return $this->dbh->lastInsertId();
    }
}
