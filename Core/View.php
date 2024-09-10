<?php

namespace Core;

/**
 * Base view
 * User: Alexander Korus
 * Date: 2019-02-17
 */
class View
{

    /*
     * Rendert ein Twig Templatte und gibt Arguemente mit.
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('session', $_SESSION);
        }

        echo $twig->render($template, $args);
    }
}
