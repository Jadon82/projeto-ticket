<?php

class Db
{

  private static $conn;

  private static $config;

  public static function setEnv($config)
  {
    self::$config = $config;
  }

  public static function getConnection()
  {
    if (!self::$conn) {
      $dbConfig = self::$config['db'];
      if (!$dbConfig || !$dbConfig['driver']) {
        throw new Exception('Error in db config');
      }
      
      if ($dbConfig['driver'] === 'sqlite') {
        self::$conn = new PDO($dbConfig['uri']);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
    }

    if (!self::$conn) {
      throw new Exception('DB not initialized');
    }

    return self::$conn;
  }
}
