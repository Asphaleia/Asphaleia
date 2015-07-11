<?php
class Controller
{
    var $database;
    var $addressobject;
    var $addressobjectgroup;
    var $chain;
    var $iptablerule;
    var $networkadapter;
    var $service;
    var $servicegroup;
    var $system;
    var $user;

    public function __construct()
    {
    }

    public function create_models() {
        $this->database = new Model('Database');
        $this->addressobject = new Model('Addressobject');
        $this->addressobjectgroup = new Model('Addressobjectgroup');
        $this->chain = new Model('Chain');
        $this->iptablerule = new Model('IptableRule');
        $this->networkadapter = new Model('Networkadapter');
        $this->service = new Model('Service');
        $this->servicegroup = new Model('Servicegroup');
        $this->system = new Model('System');
        $this->user = new Model('User');
    }

    // Include models
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function databasemodel($model, $database, $id = NULL)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model($database, $id);
    }

    // Print something one time
    public function view($view, $data = [])
    {
        require_once '../app/views/' . $view . '.html';
    }

    // Print table rows
    public function createRow($view, $data = [])
    {
        include '../app/views/' . $view . '.html';
    }

    public function IsXHttpRequest() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
}
?>