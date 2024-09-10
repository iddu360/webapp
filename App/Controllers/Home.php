<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use Core\Session;
use \Core\View;

/**
 * Home controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */

class Home extends \Core\Controller
{

    /*
     * Session initialisieren
     */
    protected function before()
    {
       // placeholder for before handling
        Session::init();
    }

    /*
     * Zeigt die Startseite
     */
    public function indexAction()
    {
        $categories = Category::findAll();
        View::renderTemplate('Home/index.html', ['categories' => $categories]);
    }

    /*
     * Zeigt die Impressumsseite (View ist nur in Online-Version verfügbar und wird ist nicht in der Verisonsverwaltung
     * vorhanden)
     */
    public function imprintAction() {
        View::renderTemplate('imprint.html');
    }

    /*
     * Datenschutzerklärung anzeigen (View ist nur in Online-Version verfügbar und wird ist nicht in der Verisonsverwaltung
     * vorhanden)
     */
    public function dataPolicyAction() {
        View::renderTemplate('policy.html');
    }
}
