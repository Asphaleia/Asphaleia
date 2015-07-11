<?php
class Menu
{
    var $url;
    public function __construct()
    {
        // Get the url
        $this->parseUrl();
        // Require some things
        require_once '../app/models/System.php';
        require_once '../app/models/Database.php';
        // new objects
        $database = new Database();
        $system = new System($database);
        // If it is add item, make no menu
        if ($this->url[0] == "add")
        {
            $this->view('menu/search');
        }
        elseif ($this->url[0] == "search")
        {
            // Do not print any item in menu for searching something
            // Here maybe comes the ajax...
        }
        else
        {
            // View the menu items
            $this->view('menu/header', $system);
            $this->view('menu/menu');   
        }
        // Close database connection
        $database->close();
    }

    public function view($view, $data = [])
    {
        require_once '../app/views/' . $view . '.html';
    }

    public function parseUrl()
    {
        if(isset($_GET['url']))
        {
            $this->url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    public function checkActiveMenu($menu)
    {
        $active = "";
        if ($this->url[0] == $menu)
        {
            $active = " active";
        }
        elseif (!isset($this->url[0]) and $menu == "dashboard")
        {
            $active = " active";
        }
        echo $active;
    }
}
?>