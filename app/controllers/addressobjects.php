<?php
class Addressobjects extends Controller
{
    // Define global vars
    var $database;

    public function __construct() {
        $this->create_models();
    }

    // Creates all needed models as global vars
    private function create_models() {
        $this->database = $this->model('Database');
    }

    /*
    * Display all objects
    */
    public function objects()
    {
        // Create the tab overview
        $this->view('objects/objectstabs', 'objects');
        // Create table header
        $th = array('Name', 'DNS name', 'IPv4 address', 'IPv6 address', 'Type', 'Edit');
        $this->view('tableheader', $th);
        // Create table content
        $result = $this->database->query("SELECT id FROM address_objects");
        while ($row = $result->fetchArray())
        {
            // Create object
            $addressobject = $this->databasemodel('Addressobject', $database, $row['id']);
            // Print row
            $this->createRow('objects/objects', $addressobject);
        }
        // Create table footer
        $this->view('objects/tablefooter');
    }

    public function objectgroups()
    {
        // Create the tab overview
        $this->view('objects/objectstabs', 'objectgroups');
        // Create table header
        $th = array('Name', 'Description', 'Count objects', 'Edit');
        $this->view('tableheader', $th);
        // Create content
        $result = $this->database->query("SELECT id FROM address_groups");
        while ($row = $result->fetchArray())
        {
            // Create object
            $addressgroup = $this->databasemodel('Addressobjectgroup', $database, $row['id']);
            // Print row
            $this->createRow('objects/objectgroups', $addressgroup);
        }
        $this->view('objects/objectgroups');
        // Tablefooter
        $this->view('objects/tablefooter');
    }
}
?>