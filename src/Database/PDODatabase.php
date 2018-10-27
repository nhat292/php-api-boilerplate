<?php

namespace PhpApi\Database;

class PDODatabase {

  private static $_instance = null;
  private $_stmt;

  public function __construct()
  {
    try {
      $config = include dirname(dirname(__DIR__)) . '/config.php' ?: [];
      $this->dbhost = new PDO('mysql:host=' . $config['DATABASE_HOST'] . ';dbname=' . $config['DATABASE_NAME'], $config['DATABASE_USERNAME'], $config['DATABASE_PASSWORD']);
    } 
    catch(PDOException $e)
    {
      $this->error = $e->getMessage();
    }
  }


  public static function getInstance() 
  {
    if(!isset(self::$_instance)) 
    {
      self::$_instance = new PDODatabase();
    }
    return self::$_instance;
  }

  
  public function query($query) 
  {
    $this->_stmt = $this->dbhost->prepare($query);
  }


  public function bind($param, $value, $type = null) 
  {
    if (is_null($type)) 
    {
      switch (true) 
      {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
        $type = PDO::PARAM_STR;
      }
    }
    $this->_stmt->bindValue($param, $value, $type);
  }


  public function execute() 
  {
    return $this->_stmt->execute();
  }


  public function resultSet() 
  {
    $this->execute();
    return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function rowCount() 
  {
    return $this->_stmt->rowCount();
  }


  public function single() 
  {
    $this->execute();
    return $this->_stmt->fetch(PDO::FETCH_ASSOC);
  }
}


/*
Query database and return a single row:

$database = SimplePDO::getInstance();
$database->query("SELECT `column` FROM `table` WHERE `columnValue` = :id");
$database->bind(':id', 123);
$result = $database->single();
Query database and return multiply rows:

$database = SimplePDO::getInstance();
$database->query("SELECT * FROM `table`");
$result = $database->resultSet();
Insert new row in database:

$database = SimplePDO::getInstance();
$database->query("INSERT INTO `users` (name, email) VALUES (:name, :email)");
$database->bind(':name', $name);
$database->bind(':name', $email);
$database->execute();
Update existing row:

$database = SimplePDO::getInstance();
$database->query("UPDATE `users` SET `name` = :name WHERE `id` = :id");
$database->bind(':name', $newName);
$database->bind(':id', $id);
$database->execute(); */