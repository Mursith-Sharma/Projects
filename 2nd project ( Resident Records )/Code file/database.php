<?php
class Database
{
  public static $conn = null;

  public static function getconnection()
  {
    if (Database::$conn === null)
    {
       $hostname ='localhost';
       $username ='root';
       $password = '';
       $databasename = 'resident_db';

       $connection = new mysqli($hostname, $username, $password, $databasename);
       if ($connection->connect_error)
       {
          die("Connection failed: " . $connection->connect_error);
       }
       else
       {
          Database::$conn = $connection;
          return Database::$conn;
       }
    }
    else
    {
      return Database::$conn;
    }
  }
}
?>
