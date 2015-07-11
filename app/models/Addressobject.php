<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updateObject" in the end! 
* Only in this case, the changes are really in the database!
*/
class Addressobject
{
    /* id = Identification Number */
    var $id;
    /* name = name of the host, network or what else */
    var $name;
    /* ipv4address, with /24 for subnetmask 255.255.255.0 */
    var $ipv4address;
    /* ipv6address */
    var $ipv6address;
    /* dnsname */
    var $dnsname;
    /* type = host or network */
    var $type;
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
            $result = $database->querySingle('SELECT name, ipv4address, ipv6address, dnsname, type, description FROM address_objects WHERE id = '.$this->id , true);
            $this->name = $result['name'];
            $this->ipv4address = $result['ipv4address'];
            $this->ipv6address = $result['ipv6address'];
            $this->dnsname = $result['dnsname'];
            $this->type = $result['type'];
            $this->description = $result['description'];
        }
    }

    public function updateObject()
    {
        if( $this->id != NULL ) {
            $this->database->querySingle('UPDATE address_objects SET name = "'.$this->name.'", ipv4address = "'.$this->ipv4address.'", ipv6address = "'.$this->ipv6address.'", dnsname = "'.$this->dnsname.'", type = "'.$this->type.'", description = "'.$this->description.'" WHERE id = '.$this->id);
        } else {
            $this->database->querySingle('INSERT INTO address_objects (name, ipv4address, ipv6address, dnsname, type, description) VALUES
            	("'.$this->name.'", "'.$this->ipv4address.'", "'.$this->ipv6address.'", "'.$this->dnsname.'", "'.$this->type.'", "'.$this->description.'")');
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

    /* Ipv4address getter */
    public function getIpv4address() {
        return $this->ipv4address;
    }

    /* Ipv4address setter */
    public function setIpv4address($ipv4address) {
        $this->ipv4address = $ipv4address;
    }

    /* Ipv6address getter */
    public function getIpv6address() {
        return $this->ipv6address;
    }

    /* Ipv6address setter */
    public function setIpv6address($ipv6address) {
        $this->ipv6address = $ipv6address;
    }

    /* Dnsname getter */
    public function getDnsname() {
        return $this->dnsname;
    }

    /* Dnsname setter */
    public function setDnsname($dnsname) {
        $this->dnsname = $dnsname;
    }

    /* Type getter */
    public function getType() {
        return $this->type;
    }

    /* Type setter */
    public function setType($type) {
        $this->type = $type;
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