<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 22:53
 */

namespace Core;

use PDO;

class Database
{

    private $pdo;

    public function __construct()
    {
        // Erzeugt, wenn nicht schon vorhanden eine PDO Instanz, und damit die DB Connection
        $this->pdo = DBConnection::getConnection();
    }

    // Getter für die PDO Instanz
    public function pdo() {

        return $this->pdo;

    }

    // Selektiert in der Datenbank Daten mit dem übergebenen SQL und gibt diese als Array zurück
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {

        $sth = $this->pdo->prepare($sql);

        foreach ($array as $key => $value) {

            $sth->bindValue("$key", $value);
        }

        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    // Fügt die übergebenen Daten in die entsprechende Tabelle ein
    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->pdo->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }



        return $sth->execute();

    }

    // Fügt die übergebenen Daten in die entsprechende Tabelle ein und gibt den Returncode mit der erzeugten ID zurück
    public function last_insert_id($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->pdo->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {

            $sth->bindValue(":$key", $value);
        }


        $returncode = $sth->execute();
        $lastinsertid = $this->pdo->lastinsertid();

        return array($returncode, $lastinsertid);

    }

    // Ändert die übergebenen Daten in einer bestehenden Tabelle
    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = NULL;
        foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $sth = $this->pdo->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }

    // Löscht Daten aus der übergebenen Tabelle anhand der übergebenen WHERE-Clause
    public function delete($table, $where, $limit = 1)
    {
        return $this->pdo->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

}