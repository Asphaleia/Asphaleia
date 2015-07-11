<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updaterule" in the end! 
* Only in this case, the changes are really in the database!
*/
class Addressobjectgroup
{
    /* id = Identification Number */
    var $id;
    /* name = name of the host, network or what else */
    var $name;
    /* description */
    var $description;

    /* Database for database connection */
    var $database;

    /* Constructor */
    public function __construct($database, $id = NULL)
    {
        $this->database = $database;
        if( $id != NULL ) {
            $this->id = $id;
            // Query the id and get other stuff
            $result = $database->querySingle('SELECT name, description FROM address_groups WHERE id = '.$id , true);
            $this->name = $result['name'];
            $this->description = $result['description'];
        }
    }

    // update or insert the new group
    public function updateGroup()
    {
        if( $this->id != NULL ) {
            $this->database->querySingle('UPDATE address_groups SET
            	name = "'.$this->name.'",
            	description = "'.$this->description.'"
            	WHERE id = '.$this->id);
        } else {
            $this->database->querySingle('INSERT INTO address_groups (name, description) VALUES ("'.$this->name.'", "'.$this->description.'")');
            $this->id = $this->database->lastInsertRowID();
        }
    }

    // Remove all object from the group
    public function removeObjects()
    {
        $this->database->querySingle("DELETE FROM address_objects_group WHERE groupid =" .$this->id."");
    }

    // Make the objects to the group
    public function addObject($objectid)
    {
        $result = $this->database->querySingle("SELECT count(objectid) FROM address_objects_group WHERE groupid = ".$this->id." AND objectid = ".$objectid);
        if( $result == 0 )
        {
            $this->database->querySingle('INSERT INTO address_objects_group (objectid, groupid) VALUES ("'.$objectid.'", "'.$this->id.'")');
        }
    }

    // Get all members as array
    public function getMember()
    {
        $member = [];
        $i = 0;
        $result = $this->database->query('SELECT objectid FROM address_objects_group WHERE groupid = '.$this->id);
        while ( $row = $result->fetchArray() ) {
            require_once 'Addressobject.php';
            $object = new Addressobject($this->database, $row['objectid']);
            $member[$i++] = $object;
        }
        return $member;
    }

    /* ID getter */
    public function getId() {
        return $this->id;
    }

    /* Name getter */
    public function getName() {
        return $this->name;
    }

    /* Name setter */
    public function setName($name) {
        $this->name = $name;
    }

    /* Description getter */
    public function getDescription() {
        return $this->description;
    }

    /* Description setter */
    public function setDescription($description) {
        $this->description = $description;
    }

    /* Get count of included objects */
    public function getCountObjects() {
        return $this->database->querySingle('SELECT count(objectid) FROM address_objects_group WHERE groupid = '. $this->id);
    }
}
?>