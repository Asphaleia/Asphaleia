<?php
class Search extends Controller
{
    function objects($params = NULL)
    {
        $database = $this->model('Database');
        $result = $database->query("SELECT id, name FROM address_objects WHERE name LIKE '%" . $params . "%' LIMIT 20");
        $array = array();
        $i = 0;
        while ($row = $result->fetchArray())
        {
            $array[$i++] = array(
                'name' => $row['name'],
                'id' => $row['id']
            );
        }
        $return = json_encode($array);
        echo json_encode($return);
        $database->close();
    }
}
?>