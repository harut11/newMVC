<?php

namespace root;

class Viewer
{
    private $page;
    private $title;
    public $response = null;

    public function __construct($page, $title)
    {
        $this->page = $page;
        $this->title = $title;
    }

    public function getPage()
    {
        $pageName = str_replace('.', SEPARATOR, $this->page);

        $layout = BASE_PATH . SEPARATOR . 'app' . SEPARATOR . 'Views' . SEPARATOR . 'Layouts' . SEPARATOR. 'main.php';
        $path =  BASE_PATH . SEPARATOR . 'app' . SEPARATOR . 'Views' . SEPARATOR . ucfirst($pageName) . '.php';

        $this->response = str_replace('@yield', $path, $layout);
        $this->response = str_replace('@title', $this->title, $this->response);
        dd($this->response);

        require $this->response;
    }


}