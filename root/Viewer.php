<?php

namespace root;

class Viewer
{
    private $page;
    private $title;
    private $data;

    public function __construct($page, $title, $data = [])
    {
        $this->page = $page;
        $this->title = $title;
        $this->data = $data;
    }

    public function getPage()
    {
        $pageName = str_replace('.', SEPARATOR, $this->page);

        $layout = $this->callPage(BASE_PATH . SEPARATOR . 'app' . SEPARATOR . 'views' . SEPARATOR . 'layouts' . SEPARATOR. 'main.php');
        $path = $this->callPage(BASE_PATH . SEPARATOR . 'app' . SEPARATOR . 'views' . SEPARATOR . $pageName . '.php');

        $content = str_replace('@yield', $path, $layout);
        $response = str_replace('@title', $this->title, $content);

        echo $response;
    }

    protected function callPage($page)
    {
        if (file_exists($page)) {
            ob_start();
            extract($this->data);
            require $page;
            return ob_get_clean();
        }
        return false;
    }

}