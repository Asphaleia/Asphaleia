<?php
    class Database extends SQLite3
    {
        public function __construct()
        {
            $dbpath = '/home/vm/ownCloud/Work/PhpstormProjects/Asphaleia/config/firewall.db';

            if (file_exists($dbpath)) {
                $this->open($dbpath, SQLITE3_OPEN_READWRITE);
            } else {
                echo "<h1>Database connection failed</h1>";
                die();
            }
        }

        public function get_config($option) {
            $data = $this->prepare('SELECT value from config where option=:option');
            $data->bindValue('option', $option, SQLITE3_TEXT );
            $result = $data->execute();
            $result = $result->fetchArray();
            return $result['value'];
        }

        public function set_config($option, $value) {
            $option = SQLite3::escapeString($option);
            $value = SQLite3::escapeString($value);
            $value = "\"$value\"";
            $option = "\"$option\"";
            $this->query('update config set value ='.$value.' where option='.$option);
            return $this->check_error();
        }

        public function check_error() {
            return SQLite3::lastErrorCode();
        }

        public function __destruct() {
            $this->close();
        }
    }
?>