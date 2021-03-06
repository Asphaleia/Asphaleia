<?php
Class App {
    protected $controller;

    protected $controllername = 'dashboard';

    protected $method = 'index';

    protected $params = [];

    public function __construct() {
        // Sanitize user input
        $array = $_POST;
        foreach ($array as $key => $dangerous) {
            $_POST[$key] = addslashes(strip_tags(trim($dangerous)));
        }
        $array = $_GET;
        foreach ($array as $key => $dangerous) {
            $_GET[$key] = addslashes(strip_tags(trim($dangerous)));
        }

        $url = $this->parseUrl();

        if(file_exists("../app/controllers/" .  $url[0] . ".php")) {
            $this->controllername = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controllername . '.php';

        $this->controller = new $this->controllername;
        $this->controller->create_models($this->controllername);

        if ($this->controllername !== "auth") {
            $this->controller->check_loggedin($this->controllername, $this->method);
        }

        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                echo "<h1>Method " . $url[1] . " doesn't exist!</h1>";
                die();
            }
        }

        $this->params = $url ? array_values($url) : [];

        // If request is no ajax, display header, menu and footer
        if (!$this->controller->m_std->IsXHttpRequest() && $this->controllername !== "auth") {
            $this->controller->view('v_header');
            $this->controller->view('v_menu');
        }

        call_user_func_array([$this->controller, $this->method], $this->params);

        if (!$this->controller->m_std->IsXHttpRequest() && $this->controllername !== "auth") {
            $this->controller->view('v_footer');
        }
    }

    public function parseUrl() {
        if(isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
?>