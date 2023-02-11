<?php

class View
{
    public function show($page)
    {
        if ($page == '404') {
            $this->getPage($page);
        }
        else {
            include_once ROOT . '/app/view/template/header.php';
            $this->getPage($page);
            include_once ROOT . '/app/view/template/footer.php';
        }
    }

    private function getPage($page)
    {
        $file = ROOT.'/app/view/' . $page . '.php';

        if(file_exists($file)){
            include_once $file;
        }
        else {
            echo '<h1 class="text-center">Страница не найдена</h1>';
        }
    }
}