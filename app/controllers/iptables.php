<?php
class Iptables extends Controller
{
    var $database;

    public function __construct()
    {
        $this->create_models();
    }

    private function create_models() {
        $this->database = $this->model('Database');
    }

    // create the rules and print them
    public function index($params = [])
    {
        // Is this a valid chain id
        if(is_numeric($params[0]))
        {
            // Tabs
            $this->view('tab/tabbegin');
            $result = $this->database->query("SELECT id FROM chains");
            while ($row = $result->fetchArray())
            {
                $chain = $this->databasemodel('Chain', $this->database, $row['id']);
                // Create the tab overview
                $this->createRow('tab/createtab', [$chain, $params[0], '/asphaleia/public/iptables/index/'.$chain->getId()]);
            }
            // Close the tabs
            $this->view('tab/tabend');
            // Tab content
            // Create the header
            $chaintype = $this->createTableHeader($params);
            // Get the rules
            $result = $this->database->query("SELECT id FROM iptables WHERE chain_id = ".$params);
            // Print the rules
            while ($row = $result->fetchArray())
            {
                // Make the object
                $rule = $this->databasemodel('IptableRule', $this->database, $row['id']);
                $data = $this->getRuleData($rule, $chaintype);
                // Print the attributes
                $this->createRow('iptables/row', $data);
            }

            echo "</table>";
        }
    }

    // create the table chain headers
    private function createTableHeader($chainid)
    {
        $chain = $this->databasemodel('Chain', $this->database, $chainid);
        switch ($chain->getChain_type()) {
            case 'input':
                $th = array('Input', 'Source', 'Service', 'Target', 'Comment', 'Priority', 'Active', 'Edit');
                break;
            case 'output':
                $th = array('Output', 'Destination', 'Service', 'Target', 'Comment', 'Priority', 'Active', 'Edit');
                break;
            case 'forward':
                $th = array('Input', 'Source', 'Output', 'Destination', 'Service', 'Target', 'Comment', 'Priority', 'Active', 'Edit');
                break;
            default:
                # code...
                break;
        }
        $this->view('tableheader', $th);

        return $chain->getChain_type();
    }

    // Create the data array for output
    private function getRuleData($rule, $chaintype)
    {
        $i = 0;
        $data = [];
        // INPUT
        if ($chaintype == "forward" || $chaintype == "input")
        {
            // Input interface
            $interface = $this->databasemodel('Networkadapter', $this->database, $rule->getInput());
            $data[$i++] = $interface->getName();
            // Source
            $source = $rule->getAddressObjectsByType("source");
            $data[$i][0] = $this->createMoreObjectsOutput($source);
            $data[$i++][1] = $source[0]." ...";
        }
        // OUTPUT
        if ($chaintype == "forward" || $chaintype == "output")
        {
            // Output interface
            $interface = $this->databasemodel('Networkadapter', $this->database, $rule->getOutput());
            $data[$i++] = $interface->getName();
            // Destination
            $destination = $rule->getAddressObjectsByType("destination");
            $data[$i][0] = $this->createMoreObjectsOutput($destination);
            $data[$i++][1] = $destination[0]." ...";        }
        // SERVICE
        $data[$i++] = "comming soon";
        // TARGET
        $data[$i++] = $rule->getTarget();
        // COMMENT
        $data[$i][0] = $rule->getComment();
        $data[$i++][1] = $rule->cutDescription($rule->getComment());
        // Priority
        $data[$i++] = $rule->getPriority();
        // Active
        if ($rule->getActive() == 0)
        {
            $data[$i++] = '<span class="label label-default">disabled</span>';
        }
        else
        {
            $data[$i++] = '<span class="label label-success">enabled</span>';
        }
        $data[$i][0] = $rule->getChainId();
        $data[$i++][1] = $rule->getId();
        return $data;
    }

    // Create the more objects output
    private function createMoreObjectsOutput($data)
    {
        $dataString = "";
        for ($i=0; $i < sizeof($data); $i++)
        { 
            if($data[$i] != NULL)
            {
                if($i != 0)
                {
                    $dataString = $dataString.'&#13';
                }
                $dataString = $dataString.$data[$i];
            }
        }
        return $dataString;
    }
}
?>