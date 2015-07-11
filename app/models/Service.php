<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updateService" in the end! 
* Only in this case, the changes are really in the database!
*/
class Service
{
    /* id = Identification Number */
    var $id;
    /* name = name of the host, network or what else */
    var $name;
    /* protocol, icmp, udp, tcp */
    var $protocol;
    /* source ports */
    var $source_ports;
    /* destination ports */
    var $destination_ports;
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
            $result = $database->querySingle('SELECT name, protocol, source_ports, destination_ports, description FROM service_objects WHERE id = '.$id , true);
            $this->name = $result['name'];
            $this->protocol = $result['protocol'];
            $this->source_ports = $result['source_ports'];
            $this->destination_ports = $result['destination_ports'];
            $this->description = $result['description'];
        }
    }

    public function updateService()
    {
        if( $id != NULL ) {
            $this->database->querySingle('UPDATE service_objects SET
            	name = "'.$this->name.'",
            	protocol = "'.$this->protocol.'",
            	source_ports = "'.$this->source_ports.'",
            	destination_ports = "'.$this->destination_ports.'",
            	description = "'.$this->description.'"
            	WHERE id = '.$id);
        } else {
            $this->database->querySingle('INSERT INTO service_objects (name, protocol, source_ports, destination_ports, description) VALUES
            	("'.$this->name.'", "'.$this->protocol.'", "'.$this->source_ports.'", "'.$this->destination_ports.'", "'.$this->description.'")');
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

    /* Protocol getter */
    public function getProtocol() {
        return $this->protocol;
    }

    /* Protocol setter */
    public function setProtocol($protocol) {
        $this->protocol = $protocol;
    }

    /* Source_ports getter */
    public function getSource_ports() {
        return $this->source_ports;
    }

    /* Source_ports setter */
    public function setSource_ports($source_ports) {
        $this->source_ports = $source_ports;
    }

    /* Destination_ports getter */
    public function getDestination_ports() {
        return $this->destination_ports;
    }

    /* Destination_ports setter */
    public function setDestination_ports($destination_ports) {
        $this->destination_ports = $destination_ports;
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