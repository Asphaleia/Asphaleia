<?php
/*
* Watch out!
* All changes in this class are away if you dont run "updaterule" in the end! 
* Only in this case, the changes are really in the database!
*/
class IptableRule extends Model
{
    /* id = Identification Number */
    var $id;
    /* input = interface id, NULL for output rule */
    var $input;
    /* output = interface id, NULLL for input rule */
    var $output;
    /* target = ACCEPT, DENY, ... */
    var $target;
    /* comment = iptables comment */
    var $comment;
    /* priority = priority number */
    var $priority;
    /* active = 0 = False, 1 = True */
    var $active;
    /* last_change = date, format = '2015-03-30 18:14:00 */
    var $last_change;
    /* chain_id = chain id */
    var $chain_id;

    /* Database for database connection */
    var $database;

    /* Constructor */
    public function __construct($database, $id = NULL)
    {
        $this->database = $database;
        if( $id != NULL ) {
            $this->id = $id;
            // Query the id and get other stuff
            $result = $database->querySingle('SELECT input, output, target, comment, priority, active, last_change, chain_id FROM iptables WHERE id = '.$id , true);
            $this->input = $result['input'];
            $this->output = $result['output'];
            $this->target = $result['target'];
            $this->comment = $result['comment'];
            $this->priority = $result['priority'];
            $this->active = $result['active'];
            $this->last_change = $result['last_change'];
            $this->chain_id = $result['chain_id'];
        }
    }

    /* Update this rule in the database */
    public function updateRule()
    {
        if( $this->id != NULL ) {
            /* Update this rule */
            // Get chain type
            $chain = new Chain($this->database, $this->chain_id);
            if( $chain->getChain_type() != "output" ) {
                $this->database->exec('UPDATE iptables SET input = '.$this->input.' WHERE id = '.$this->id);
            }
            if( $chain->getChain_type() != "input" ) {
                $this->database->exec('UPDATE iptables SET output = '.$this->output.' WHERE id = '.$this->id);
            }
            if( $this->comment == NULL ) {
                $this->comment = "";
            }
            $this->database->exec('UPDATE iptables SET target = "'.strtoupper($this->target).'", comment = "'.$this->comment.'", priority = '.$this->priority.', active = '.$this->active.', last_change = "'.$this->last_change.'", chain_id = '.$this->chain_id.' WHERE id = '.$this->id);
            $this->updateChange();
        } else {
            $this->database->exec('INSERT INTO iptables (input, output, target, comment, priority, active, last_change, chain_id) VALUES
                ("'.$this->input.'", "'.$this->output.'", "'.strtoupper($this->target).'", "'.$this->comment.'", "'.$this->priority.'", "'.$this->active.'", "'.$this->last_change.'", "'.$this->chain_id.'")');
            $this->id = $this->database->lastInsertRowid();
            $this->updateChange();
        }
    }

    /* Get all address objects for this rule, care about $type */
    public function getAddressObjectsByType($type)
    {
        // How many address objects/groups for this rule
        $numberHosts = 0;
        $objects = "";
        // Select all address objects
        $result = $this->database->query('SELECT address_objects.name AS objectname FROM iptablerule_address_object LEFT JOIN address_objects ON address_objects.id = iptablerule_address_object.addressid WHERE iptablerule_address_object.iptableid = '.$this->getId(). ' AND iptablerule_address_object.type = "'.$type.'"');
        while( $row = $result->fetchArray() ) {
            $objects[$numberHosts] = $row['objectname'];
            $numberHosts++;
        }
        // Select all address groups
        $result = $this->database->query('SELECT address_groups.name AS addressgroupname FROM iptablerule_address_group LEFT JOIN address_groups ON address_groups.id = iptablerule_address_group.groupid WHERE  iptablerule_address_group.iptableid = '.$this->getId(). ' AND iptablerule_address_group.type = "'.$type.'"');
        while( $row = $result->fetchArray() ) {
            $objects[$numberHosts] = "Group: ".$row['addressgroupname'];
            $numberHosts++;
        }
        return $objects;
    }

    private function updateChange()
    {
        $this->database->exec('INSERT INTO changes (iptableid) VALUES ('.$this->id.')');
    }

    public function deleteLinks()
    {
        $this->database->exec('DELETE FROM iptablerule_address_object WHERE iptableid = '.$this->id);
        $this->database->exec('DELETE FROM iptablerule_address_group WHERE iptableid = '.$this->id);
        $this->database->exec('DELETE FROM iptablerule_service_object WHERE iptableid = '.$this->id);
        $this->database->exec('DELETE FROM iptablerule_service_group WHERE iptableid = '.$this->id);
    }
    /* ID getter */
    public function getId() {
        return $this->id;
    }

    /* Input getter */
    public function getInput() {
        return $this->input;
    }

    /* Input setter */
    public function setInput($interfaceId) {
        $this->input = $interfaceId;
    }

    /* Output getter */
    public function getOutput() {
        return $this->output;
    }

    /* Output setter */
    public function setOutput($interfaceId) {
        $this->output = $interfaceId;
    }

    /* Target getter */
    public function getTarget() {
        return $this->target;
    }

    /* Target setter */
    public function setTarget($targetString) {
        $this->target = $targetString;
    }

    /* Comment getter */
    public function getComment() {
        return $this->comment;
    }

    /* Comment setter */
    public function setComment($comment) {
        $this->comment = $comment;
    }

    /* Priority getter */
    public function getPriority() {
        return $this->priority;
    }

    /* Priority setter */
    public function setPriority($priorityNumber) {
        $this->priority = $priorityNumber;
    }

    /* Active getter */
    public function getActive() {
        return $this->active;
    }

    /* Active setter */
    public function setActive($activeBool) {
        $this->active = $activeBool;
    }

    /* Last change getter */
    public function getLastChange() {
        return $this->last_change;
    }

    /* Last change setter */
    public function setLastChange() {
        // Get the time
        $this->last_change = time();
    }

    /* Chain id getter */
    public function getChainId() {
        return $this->chain_id;
    }

    /* Chain id setter */
    public function setChainId($chainId) {
        $this->chain_id = $chainId;
    }
}
?>