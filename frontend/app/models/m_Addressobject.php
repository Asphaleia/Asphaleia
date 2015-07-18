<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updateObject" in the end! 
* Only in this case, the changes are really in the m_database!
*/
class m_Addressobject
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

    /* m_database for m_database connection */
    var $m_database;

    /* Constructor */
    public function __construct($m_database, $id = NULL)
    {
        $this->m_database = $m_database;
        if( $id != NULL || $id != "NULL" ) {
            $this->id = intval($id);
            // Query the id and get other stuff
            $query = $this->m_database->prepare('SELECT name, ipv4address, ipv6address, dnsname, type, description FROM address_objects WHERE id=:id');
            $query->bindValue('id', $this->getId(), SQLITE3_TEXT );
            $result = $query->execute();
            $result = $result->fetchArray(SQLITE3_ASSOC);

            $this->name = $result['name'];
            $this->ipv4address = $result['ipv4address'];
            $this->ipv6address = $result['ipv6address'];
            $this->dnsname = $result['dnsname'];
            $this->type = $result['type'];
            $this->description = $result['description'];
        }
    }

    /* Update or insert a new object */
    public function updateObject()
    {
        if( $this->id != NULL ) {
            $this->m_database->querySingle('UPDATE address_objects SET name = "'.$this->name.'", ipv4address = "'.$this->ipv4address.'", ipv6address = "'.$this->ipv6address.'", dnsname = "'.$this->dnsname.'", type = "'.$this->type.'", description = "'.$this->description.'" WHERE id = '.$this->id);
        } else {
            $this->m_database->querySingle('INSERT INTO address_objects (name, ipv4address, ipv6address, dnsname, type, description) VALUES ("'.$this->name.'", "'.$this->ipv4address.'", "'.$this->ipv6address.'", "'.$this->dnsname.'", "'.$this->type.'", "'.$this->description.'")');
        }
        $this->id = $this->m_database->querySingle('SELECT last_insert_rowid()');
        return $this->getId();
    }

    /* Delete an object */
    public function delete()
    {
        $query = $this->m_database->prepare('DELETE FROM address_objects WHERE id=:id');
        $query->bindValue('id', $this->getId(), SQLITE3_TEXT );
        $query->execute();
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