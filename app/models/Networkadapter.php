<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updateInterface" in the end! 
* Only in this case, the changes are really in the database!
*/
class Networkadapter
{
    /* id = Identification Number */
    var $id;
    /* Interface in Linux style (eth0) */
    var $interface;
    /* Name the administrator gives the interface */
    var $name;
    /* ipv4 address */
    var $ipv4address;
    /* ipv6 address */
    var $ipv6address;
    /* dnsname */
    var $dnsname;
    /* description */
    var $description;
    /* subnetmask */
    var $mask;
    /* broadcast (v4) */
    var $bcast;
    /* MAC address */
    var $mac;
    /* ethernet, or wlan ... */
    var $type;
    /* mtu */
    var $mtu;

    /* Constructor */
    public function __construct($database, $id = NULL)
    {
        $this->database = $database;
        if( $id != NULL ) {
            $this->id = $id;
            // Query the id and get other stuff
            $result = $database->querySingle('SELECT interface, name, ipv4address, ipv6address, dnsname, description, mask, bcast, mac, type, mtu FROM interfaces WHERE id = '.$this->id , true);
            $this->interface = $result["interface"];
            $this->name = $result["name"];
            $this->ipv4address = $result["ipv4address"];
            $this->ipv6address = $result["ipv6address"];
            $this->dnsname = $result["dnsname"];
            $this->description = $result["description"];
            $this->mask = $result["mask"];
            $this->bcast = $result["bcast"];
            $this->mac = $result["mac"];
            $this->type = $result["type"];
            $this->mtu = $result["mtu"];
        }
    }

    public function updateInterface()
    {
        // future feature
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

    /* Interface getter */
    public function getInterface(){
        return $this->interface;
    }
    /* Interface setter */
    public function setInterface($interface){
        $this->interface=$interface;
    }

    /* ipv4address getter */
    public function getIpv4address(){
        return $this->ipv4address;
    }
    /* ipv4address setter */
    public function setIpv4address($ipv4address){
        $this->ipv4address=$ipv4address;
    }

    /* ipv6address getter */
    public function getIpv6address(){
        return $this->ipv6address;
    }
    /* ipv6address setter */
    public function setIpv6address($ipv6address){
        $this->ipv6address=$ipv6address;
    }

    /* dnsname getter */
    public function getDnsname(){
        return $this->dnsname;
    }
    /* dnsname setter */
    public function setDnsname($dnsname){
        $this->dnsname=$dnsname;
    }

    /* mask getter */
    public function getMask(){
        return $this->mask;
    }
    /* mask setter */
    public function setMask($mask){
        $this->mask=$mask;
    }

    /* bcast getter */
    public function getBcast(){
        return $this->bcast;
    }
    /* bcast setter */
    public function setBcast($bcast){
        $this->bcast=$bcast;
    }

    /* mac getter */
    public function getMac(){
        return $this->mac;
    }
    /* mac setter */
    public function setMac($mac){
        $this->mac=$mac;
    }
    /* type getter */
    public function getType(){
        return $this->type;
    }
    /* type setter */
    public function setType($type){
        $this->type=$type;
    }

    /* mtu getter */
    public function getMtu(){
        return $this->mtu;
    }
    /* mtu setter */
    public function setMtu($mtu){
        $this->mtu=$mtu;
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