<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-20
 * Time: 18:53
 */

namespace App\Controllers;


use Core\Session;
use \Core\View;

/**
 * Home controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */

class Category extends \Core\Controller
{

    /*
     * Session initialisieren
     */
    protected function before()
    {
        Session::init();
    }

    /*********************
     * GET Actions
     *********************/

    /*
     * Zeigt entweder eine Seite mit allen inseraten oder der entpsrechenden Kateogrie
     */
    public function indexAction()
    {

        // überprüfe ob die Seite mit einer ID aufgerufen wurde
        if (isset($this->route_params['id'])) {

            $categoryId = $this->route_params['id'];
            $category = \App\Models\Category::find($categoryId);
            $posts = \App\Models\Post::findByCategory($categoryId);

            $this->renderCategoryPage($posts, $category);

        } else {

            $posts = \App\Models\Post::findAll();
            $category = new \App\Models\Category();
            $category->name = "Alle";
            $this->renderCategoryPage($posts, $category);

        }
    }

    /*********************
     * POST Actions
     *********************/

    /*
     * Sucht Anzeigen in einer bestimmten Kategorie
     */
    public function searchAction() {

        $categoryId = $this->route_params['id'];
        $searchText = $_POST['searchText'];

        // Get categories, choosen category and corresponding posts
        $category = \App\Models\Category::find($categoryId);
        $posts = \App\Models\Post::findByTitleInCategory($searchText, $categoryId);

        $this->renderCategoryPage($posts, $category);

    }

    /*********************
     * Private Methods
     *********************/

    /*
     * Lädt alle Kategorien und rendert die Kategorie mit den übergebenen Daten
     */
    private function renderCategoryPage($posts, $category) {

        $categories = \App\Models\Category::findAll();

        View::renderTemplate('Category/index.html', array(
            "categories" => $categories,
            "category" => $category,
            "posts" => $posts
        ));

    }

}