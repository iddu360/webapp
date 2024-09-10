<?php

namespace Core;

/**
 * Router
 * User: Alexander Korus
 * Date: 2019-02-17
 */
class Router
{


    protected $routes = [];


    protected $params = [];

    /*
     * Extrahiert die Route und die Route Parameter mit Regular Expressions und fügt diese der Routing Tabelle  hinzu
     */
    public function add($route, $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        // Konvertiert Variablen wie z.B. ID in eine entsprechende regular expression
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        // Fügt Start und Endebegrenzer sowie ein Case insensitive Flag hinzu
        $route = '/^' . $route . '$/i';

        // Beispiel: { "/^post" : {"controller": "Post", "action": "index"}
        $this->routes[$route] = $params;
    }

    /*
     * Getter für die Routes
     */
    public function getRoutes()
    {

        return $this->routes;
    }

    /*
     * Matched die URL mit der definierten Route und extrahiert entsprechend die Parameter
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            // Überprüfe, welche Route mit der URL Matched und speichere sie in eine Variable
            if (preg_match($route, $url, $matches)) {

                foreach ($matches as $key => $match) {
                    // Wenn der Key ein String ist, dann ist es ein Parameter
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /*
     * Getter für die Parameter
     */
    public function getParams()
    {
        return $this->params;
    }


    /*
     * Ruft die entsprechende Route zu der übergebenen URL auf und bereinigt diese um einen Controller zu erzeugen
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            // Überprüfen ob der Controller existiert
            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {

                    // Action im Controller aufrufen
                    $controller_object->$action();

                } else {
                    throw new \Exception("Method $action (in controller $controller) not found");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            throw new \Exception('No route matched.', 404);
        }
    }


    /*
     *  Entfernt Leerzeichen und erzeugt  Strings mit Capital Letters
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }


    /*
     * Konvertiert einen String in ein camelCase Format
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /*
     * Bereinigt die URL um die QueryString Variablen
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /*
     * Gibt den Namespace für Controller zurück
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}
