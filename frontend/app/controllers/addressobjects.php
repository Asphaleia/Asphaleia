<?php
class Addressobjects extends Controller
{
	// default function
    public function index() {
        $data = [];
        $i = 0;
        $objects = $this->m_database->getAddressObjectIds();
        while ($row = $objects->fetchArray()) {
            $data[$i++] = $this->model('m_Addressobject', $row['id']);
        }
        $this->view('v_addressobjects', $data);
    }
    // update or add an object
    public function update() {
    	// New or old object
        if ( $_POST['id'] == "" ) {
            $_POST['id'] = "NULL";
        }
        // Create object
        $object = $this->model('m_Addressobject', $_POST['id']);
        // Set attributes
		$object->setName($_POST['name']);
		$object->setIpv4address($_POST['ipv4address']);
		$object->setDnsname($_POST['dnsname']);
		$object->setType($_POST['type']);
		$object->setDescription($_POST['description']);
		$object->updateObject();
		print $object->getId();
    }
    // delete an object
    public function delete() {
        // Create object
        $object = $this->model('m_Addressobject', $_POST['id']);
        $object->delete();
    }
}
?>