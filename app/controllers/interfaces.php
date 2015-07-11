<?php
class Interfaces extends Controller
{
    /*
    * Display all interfaces
    */
    public function index($name = '')
    {
        // Open database
        $database = $this->model('Database');
        // Create table header
        $th = array('Interface', 'Name', 'IPv4 address', 'IPv4 mask', 'IPv4 broadcast', 'IPv6 address', 'dnsname', 'description', 'mac', 'type', 'mtu');
        $this->view('tableheader', $th);
        // Get interfaces
        $result = $database->query('SELECT id FROM interfaces');
        while ($row = $result->fetchArray())
        {
            // Create object
            $interface = $this->databasemodel('Networkadapter', $database, $row['id']);
            // Print row
            $this->createRow('interfaces/interfaces', $interface);
        }
        // Close database connection
        $database->close();
        // Close table
        echo "</table>";
    }
}
?>