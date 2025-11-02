<?php

/**
 * ValetDriver to rewrite base url
 * User: Alexander Korus
 * Date: 2019-02-16
 */

class LocalValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return void
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if (file_exists($sitePath . '/')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (file_exists($sitePath . $uri) &&
            !is_dir($sitePath . $uri) &&
            pathinfo($sitePath . $uri)['extension'] != 'php') {
            return $sitePath . $uri;

        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {

        if (strpos($uri, '/') === 0) {
            $_SERVER['QUERY_STRING'] = substr($uri, 1);
            return $sitePath.'/index.php';
        }

    }
}