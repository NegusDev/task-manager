<?php 
declare(strict_types=1);

namespace Core;

Class Router {
    public static function uri()
    {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
        // var_dump($_SERVER['REQUEST_URI']);
        // exit;
    }

    public static function fullURL()
    {
        return $_SERVER['REQUEST_URI'];
        // var_dump($_SERVER['REQUEST_URI']);
        // exit;
    }

    public static function get($url, $content)
    {
        $request_uri = self::uri();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($request_uri == $url) {
                if (is_callable($content)) {
                    $content();
                } else {
                    echo $content;
                }
                exit;
            }
        }
    }
    public static function post($url, $content)
    {

        $request_uri = self::uri();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($request_uri == $url) {
                if (is_callable($content)) {
                    $content();
                } else {
                    echo $content;
                }
                exit;
            }
        }
    }

    public static function put($url, $content)
    {

        $request_uri = self::uri();

        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            if ($request_uri == $url) {
                if (is_callable($content)) {
                    $content();
                } else {
                    echo $content;
                }
                exit;
            }
        }
    }

    public static function patch($url, $content)
    {
        $request_uri = self::uri();

        if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
            if ($request_uri == $url) {
                if (is_callable($content)) {
                    $content();
                } else {
                    echo $content;
                }
                exit;
            }
        }
    }

    public static function delete($url, $content)
    {
        $request_uri = self::uri();

        if ($_SERVER['REQUEST_METHOD'] == 'DELETE' ) {
            if ($request_uri == $url) {
                if (is_callable($content)) {
                    $content();
                } else {
                    echo $content;
                }
                exit;
            }
        }
    }


     public static function submit($method, $url, $content)
    {
        $request_uri = self::uri();
        if ($_SERVER['REQUEST_METHOD'] === $method) {
            if ($request_uri == $url) {
                if (is_callable($content)) {
                    $content();
                } else {
                    echo $content;
                }
                exit;
            }
        }
    }

}