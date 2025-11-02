<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 23:25
 */

namespace Core;

use App\Config;
use PDO;


class DBConnection
{

    //Variable um das PDO Objekt zu halten
    protected static $db;

    // Privater Konstruktor, die nicht von außen aufgerufen werden kann
    private function __construct() {

        try {
            // instanziert PDO zu der DB Variablen
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            self::$db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // Throw an Exception when an error occurs
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            //Ausgabe Error
            echo "Connection Error: " . $e->getMessage();
        }
    }

    // Statische get connection Methode. Erreichbar ohne Instanzierung
    public static function getConnection() {


        // Garantiert eine einzige Instanz des PDO, wenn kein Connection Objekt existiert
        // wird eins erstellt
        if (!self::$db) {
            //neues DBConnection Object.
            new DBConnection();
        }

        //Das Objekt zurückgeben.
        return self::$db;
    }


}