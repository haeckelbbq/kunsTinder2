<?php
/*
* Design Pattern Singleton
* man möchte nur 1 Obj+ekt in der Klasse haben
*/

class Db
{
    private static object $dbh;

    public static function getConnection() : object
    {
        if (!isset(self::$dbh))
        {
            try {
                self:: $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWD); //$dbh = data base handle // handle = ressource
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
        return  self::$dbh;
    }


}