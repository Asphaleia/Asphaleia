<?php
class Configuration extends Controller
{
    public function index()
    {
        // data[types][0-4]
        // data[configoption][0-x][0 = option, 1 = value, 2 = description]
        $database = $this->model('Database');
        // Config types
        $data = array(
            "frontend" => array(),
            "agent" => array(),
            "admin" => array(),
            "firewalling" => array()
            );
        for ($i=0; $i < sizeof($data); $i++)
        {
            $result = $database->query('SELECT option, value, description FROM config WHERE editable_via_gui = 1 AND type = "' . key($data) . '"');
            $a = 0;
            while ($row = $result->fetchArray())
            {
                $data[key($data)][$a][0] = $row['option'];
                $data[key($data)][$a][1] = $row['value'];
                $data[key($data)][$a++][2] = $row['description'];
            }
            next($data);
        }
        $this->view('configuration/configuration', $data);
    }
}
?>