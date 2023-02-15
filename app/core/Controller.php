<?php
require_once 'app/core/View.php';

class Controller
{
    public $view, $kitWords;

    function __construct()
    {
        $this->view = new View;
        if (!isset($_COOKIE['language'])) setcookie('language', 'en');

        if (!file_exists('app/components/language/' . $_COOKIE['language'] . '.php')) {
            setcookie('language', 'en');
            $_COOKIE['language'] = 'en';
        }
        
        $this->kitWords = include('app/components/language/' . $_COOKIE['language'] . '.php');
    }
}
