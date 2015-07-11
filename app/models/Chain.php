<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updateChain" in the end! 
* Only in this case, the changes are really in the database!
*/
class Chain
{
    /* id = Identification Number */
    var $id;
    /* name = name of the chain */
    var $name;
    /* chain types: input, output, forward */
    var $chain_type;
    /* last change timestamp */
    var $last_change;
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
            $result = $database->querySingle('SELECT name, chain_type, last_change, description FROM chains WHERE id = '.$id , true);
            $this->name = $result['name'];
            $this->chain_type = $result['chain_type'];
            $this->last_change = $result['last_change'];
            $this->description = $result['description'];
        }
    }

    public function updateChain()
    {
        if( $this->id != NULL ) {
            $this->database->querySingle('UPDATE chains SET
                name = "'.$this->name.'",
                chain_type = "'.$this->chain_type.'",
                last_change = "'.$this->last_change.'",
                description = "'.$this->description.'"
                WHERE id = '.$this->id);
        } else {
            $this->database->querySingle('INSERT INTO chains (name, chain_type, last_change, description) VALUES
                ("'.$this->name.'", "'.$this->chain_type.'", "'.$this->last_change.'", "'.$this->description.'")');
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

    /* Chain_type getter */
    public function getChain_type() {
        return $this->chain_type;
    }

    /* Chain_type setter */
    public function setChain_type($chain_type) {
        $this->chain_type = $chain_type;
    }

    /* Last_change getter */
    public function getLast_change() {
        return $this->last_change;
    }

    /* Last_change setter */
    public function setLast_change($last_change) {
        $this->last_change = $last_change;
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