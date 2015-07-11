<?php
class System
{
    var $pidfile;
    var $database;

    public function __construct($database)
    {
        $this->database = $database;
        $this->pidfile = $this->database->get_config('pidfile');
    }

    public function getPidContent()
    {
        $a = "";
        if ($this->agentRunning())
        {
            $a = "Running - " . file_get_contents($this->database->get_config("pidfile"));
        }
        else
        {
            $a = "Not running";
        }
        return $a;
    }

    public function getPidfile()
    {
        return $this->pidfile();
    }

    public function agentRunning()
    {
        $running = FALSE;
        if (file_exists($this->database->get_config("pidfile")))
        {
            $running = TRUE;
        }
        return $running;
    }
}
?>