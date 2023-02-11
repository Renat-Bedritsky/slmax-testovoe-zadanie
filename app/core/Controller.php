<?php
require_once 'app/core/View.php';

class Controller
{
    public $view;

    function __construct()
    {
        $this->view = new View;
    }
}