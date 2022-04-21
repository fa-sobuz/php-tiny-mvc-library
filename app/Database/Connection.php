<?php


namespace App\Database;


use PDO;
use PDOException;


class Connection
{
    private static PDO $pdo;

    private static function connect(): PDO
    {
        if (!isset(self::$pdo)) {
            try {

                $servername = "";
                $dbname = "";
                $username = "";
                $password = "";
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // set the PDO error mode to exception
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$pdo;
    }

    public static function pdo(): PDO
    {
        return self::connect();
    }
}