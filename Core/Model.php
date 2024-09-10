<?php

namespace Core;

/**
 * Base model
 * User: Alexander Korus
 * Date: 2019-02-17
 */
class Model
{

    protected $db;

    function __construct() {

        // Erzeugt ein Datenbankobjekt für das Model
        $this->db = new Database();

    }

    // gibt ein statisches PDO Objekt zurück
    protected static function getDB() {
        return DBConnection::getConnection();
    }

}
