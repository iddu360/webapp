<?php

namespace Core;

/**
 * Base controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */
abstract class Controller
{

    /*
     * Parameter die vom Router übergeben werden
     */
    protected $route_params = [];

    /*
     * Beim initialisieren des Controllers werden die Route Parameter übergeben
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /*
     * Wird aufgerufen, wenn eine Funktion von diesem Controller aufgerufen wird.
     * Hängt "Action" an den übergebene Methodennamen und überprüft ob diese existiert.
     * Ruft Before und After Methoden auf, um generelles Handling zu vereinfachen
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }


    protected function before()
    {

    }


    protected function after()
    {

    }
}
