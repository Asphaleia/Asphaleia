<?php
class Add extends Controller
{
    /*
    * Display groupadd
    */
    // Add objectgroup
    public function objectgroup($param = NULL)
    {
        if( isset($_POST['id']) )
        {
            $this->insertDataObjectgroup($_POST);
        }
        $data = [];
        $member = [];
        $database = $this->model('Database');
        if( $param != NULL && is_numeric($param[0]) )
        {
            $id = $param[0];
        }
        else
        {
            $id = NULL;
        }
        $group = $this->databasemodel('Addressobjectgroup', $database, $id);
        if( $param != NULL )
        {
            $member = $group->getMember();
        }
        $data[0] = $group;
        $data[1] = $member;
        $database->close();

        $this->view('add/objectgroup', $data);
    }
    // Add object
    public function object($param = NULL)
    {
        $data = [];
        $database = $this->model('Database');
        if( $param != NULL && is_numeric($param[0]) )
        {
            $id = $param[0];
        }
        else
        {
            $id = NULL;
        }
        $data[0] = $this->databasemodel('Addressobject', $database, $id);
        $database->close();

        $this->view('add/object', $data);
    }
    // ajax request insert data
    public function insertDataObjectgroup($data)
    {
        // Connect to db
        $database = $this->model('Database');
        // Get the id
        $id = $data['id'];
        // Make the group
        $group = $this->databasemodel('Addressobjectgroup', $database, $id);
        $group->setName($data['name']);
        $group->setDescription($data['description']);
        // Insert the group
        $group->updateGroup();
        // Get the members
        if( isset($data['member']) )
        {
            $member = $data['member'];
            // Delete the old members
            $group->removeObjects();
            // Insert the members
            for ($i=0; $i < sizeof($member); $i++) { 
                $group->addObject($member[$i]);
            }   
        }
        $database->close();
    }

}
?>