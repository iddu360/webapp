<?php
/**
 * User: Alexander Korus
 * Date: 2019-02-17
 */

namespace App\Models;

use PDO;


class Category extends \Core\Model
{

    public $id;
    public $name;
    public $parent_category_id;
    public $icon;
    public $border;
    public $numberOfAds;

    /*
     * Sucht nach allen Kategorien und gibt diese zurück
     * Zählt die Anzahl der Anzeigen in einer Kategorie und gibt diese als numberOfAds zurück
     */
    public static function findAll()
    {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('SELECT c.*, count(p.id) as numberOfAds from category c left join 
              post p ON p.category_id = c.id GROUP by c.id');
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            $results = $stmt->fetchAll();

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * findet ein Kategorie mit der übergebenen ID
     */
    public static function find(int $id): ?Category {

        $db = static::getDB();

        $stmt = $db->prepare('select * from category where id = :id');
        $stmt->execute(array(
            ':id' => $id
        ));

        if ($stmt->rowCount() > 0) {

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            $result = $stmt->fetch();

            $category = new Category();
            $category->id = $result['id'];
            $category->name = $result['name'];
            $category->parent_category_id = $result['parent_category_id'];
            $category->icon = $result['icon'];
            $category->border = $result['border'];


            return $category;

        } else {
            return null;
        }

    }

}