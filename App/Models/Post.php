<?php

namespace App\Models;

use PDO;

/**
 * Category model
 * User: Alexander Korus
 * Date: 2019-02-17
 */
class Post extends \Core\Model
{

    public $id;
    public $user_id;
    public $category_id;
    public $title;
    public $description;
    public $is_seller;
    public $created;
    public $pricing_base;
    public $price;
    public $category;
    public $user;
    public $images;


    public function __construct($id = null, $user_id = null, $category_id = null, $title = null, $description = null,
                                $is_seller = null, $created = null, $pricing_base = null, $price = null,
                                $category = null,  $user = null, $images = null) {

        // Attribute initialisieren
        $this->id = $id;
        $this->user_id = $user_id;
        $this->category_id = $category_id;
        $this->title = $title;
        $this->description = $description;
        $this->is_seller = $is_seller;
        $this->created = $created;
        $this->pricing_base = $pricing_base;
        $this->price = $price;
        $this->category = $category;
        $this->user = $user;
        $this->images = $images;

        parent::__construct();

    }

    /*
     * Sucht nach allen Anzeigen in der Datenbank und gibt diese zurück
     */
    public static function findAll(): ?array {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post');
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();
            foreach ($results as $key => $field) {
                $results[$key]["images"] = Image::findByPost($field["id"]);
            }

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /*
     * Sucht nach allen Posts mit der übergebenen Kategorie ID und gibt diese zurück
     */
    public static function findByCategory(int $id) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post where category_id = :id');
            $stmt->execute(array(
                ":id" => $id
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();

            foreach ($results as $key => $field) {
                $results[$key]["images"] = Image::findByPost($field["id"]);
            }

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    /*
     * Sucht nach allen Posts mit dem übergebenen Search Text im Title in der entsprechenden Kategorie
     */
    public static function findByTitleInCategory(string $searchText, int $categoryId) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post where category_id = :id and title like :text');
            $stmt->execute(array(
                ":id" => $categoryId,
                ":text" => "%". $searchText . "%"
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();

            foreach ($results as $key => $field) {
                $results[$key]["images"] = Image::findByPost($field["id"]);
            }

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    /*
     * Sucht nach allen Posts mit dem übergebenen Search Text im Title
     */
    public static function findByTitle(string $searchText) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post where title like :text');
            $stmt->execute(array(
                ":text" => "%" . $searchText . "%"
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();

            foreach ($results as $key => $field) {
                $results[$key]["images"] = Image::findByPost($field["id"]);
            }

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    /*
     * Sucht nach allen Posts mit der übergebenen ID
     * Befülllt die Attribute Images, Category und User mit den entsprechenden Daten zu dem Post
     */
    public static function findById(int $id): ?Post {


        $db = static::getDB();

        $stmt = $db->prepare('select * from post where id = :id');
        $stmt->execute(array(
            ':id' => $id
        ));

        if ($stmt->rowCount() > 0) {

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $result = $stmt->fetch();

            $post = new Post();
            $post->id = $result['id'];
            $post->user_id = $result['user_id'];
            $post->category_id = $result['category_id'];
            $post->title = $result['title'];
            $post->description = $result['description'];
            $post->is_seller = $result['is_seller'];
            $post->created = $result['created'];
            $post->pricing_base = $result['pricing_base'];
            $post->price = $result['price'];
            $post->images = Image::findByPost($post->id);
            $post->category = Category::find($post->category_id);
            $post->user = User::find($post->user_id);

            return $post;

        } else {
            return null;
        }



    }

    /*
     * Fügt eine neue Anzeige in der Datenbank hinzu
     */
    public function add(): bool {

        $rc = $this->db->last_insert_id('post', array(
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'is_seller' => $this->is_seller,
            'pricing_base' => $this->pricing_base,
            'price' => $this->price,
        ));

        if ($rc[0]) {
            $this->id = $rc[1];
            return true;
        } else {
            return false;
        }

    }


}
