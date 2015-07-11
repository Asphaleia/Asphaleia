<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updaterule" in the end! 
* Only in this case, the changes are really in the database!
*/
class Servicegroup
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
            $result = $database->querySingle('SELECT name, description FROM service_groups WHERE id = '.$id , true);
            $this->name = $result['name'];
            $this->description = $result['description'];
        }
    }

    public function updateHost()
    {
        if( $id != NULL ) {
            $this->database->querySingle('UPDATE service_groups SET
            	name = "'.$this->name.'",
            	description = "'.$this->description.'"
            	WHERE id = '.$id);
        } else {
            $this->database->querySingle('INSERT INTO service_groups (name, description) VALUES
            	("'.$this->name.'", "'.$this->description.'")');
        }
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
}
?>