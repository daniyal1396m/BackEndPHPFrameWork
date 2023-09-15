<?php

namespace Core;

class Request
{
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
        );
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function post($param)
    {
        return $_POST[$param];
    }

    public static function get($param): string
    {
        return $_GET[$param];
    }
}
