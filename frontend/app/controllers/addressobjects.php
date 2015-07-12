<?php
class Addressobjects extends Controller
{
    public function index() {
        $data = [];
        $i = 0;
        $objects = $this->m_database->getAddressObjectIds();
        while ($row = $objects->fetchArray()) {
            $data[$i++] = $this->model('m_Addressobject', $row['id']);
        }
        $this->view('v_addressobjects', $data);
    }
}
?>