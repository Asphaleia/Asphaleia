<?php
class App
{
    protected $controller = 'dashboard';

    protected $method = 'index';

    protected $params = [];

    //private $search = FALSE;

    public function __construct()
    {
        $url = $this->parseUrl();
        $breadcumb = array();

        if(file_exists('../app/controllers/' . $url[0] . '.php'))
        {
            $this->controller = $url[0];
            unset($url[0]);
        }

        $breadcumb[0] = $this->controller;
        //if($this->controller == "search")
        //{
        //    $this->search = TRUE;
        //}

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller();

        if(isset($url[1]))
        {
            if(method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $breadcumb[1] = $this->method;

        $this->params = $url ? array_values($url) : [];

        // extracet cause Ajax
        //if(!$this->search)
        //{
        //    require_once '../app/views/templates/normal/header.php';
        //    $this->controller->view('breadcumb', $breadcumb);
        //}

        if (!$this->controller->IsXHttpRequest()) {
            //require_once '../app/views/templates/normal/header.php';
            require_once '../app/views/templates/normal/header.php';
            $this->controller->view('breadcumb', $breadcumb);
        }

        // Call controller and method
        call_user_func_array([$this->controller, $this->method], $this->params);

        if (!$this->controller->IsXHttpRequest()) {
            require_once '../app/views/templates/normal/footer.php';
        }

        // extracet cause Ajax
        //if(!$this->search)
        //{
        //    require_once '../app/views/templates/normal/footer.php';
        //}
    }

    public function parseUrl()
    {
        if(isset($_GET['url']))
        {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
?>