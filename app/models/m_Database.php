<?php
    class m_Database extends SQLite3 {
        public function __construct() {
            $dbpath = "/usr/share/asphaleia/app/config.db";

            if (is_writable($dbpath)) {
                $this->open($dbpath, SQLITE3_OPEN_READWRITE);
            } else {
                echo "<h1>Database connection failed</h1>";
                die();
            }
        }

        public function add_session($session_id, $username, $timestamp, $source_ip, $browser_agent) {
            $query = $this->prepare('INSERT INTO sessions (session_id, username_id, login_time, source_ip, browser_agent)
                                    VALUES (:session_id, (SELECT id from user where username=:username), :login_time, :source_ip, :browser_agent)');

            $query->bindValue('session_id', $session_id, SQLITE3_TEXT );
            $query->bindValue('username', $username, SQLITE3_TEXT );
            $query->bindValue('login_time', $timestamp, SQLITE3_TEXT );
            $query->bindValue('source_ip', $source_ip, SQLITE3_TEXT );
            $query->bindValue('browser_agent', $browser_agent, SQLITE3_TEXT );

            $query->execute();
            return $this->return_last_error();
        }

        public function delete_session($session_id, $username) {
            $query = $this->prepare('DELETE FROM sessions where session_id=:session_id and username_id=(SELECT id from user where username=:username)');

            $query->bindValue('session_id', $session_id, SQLITE3_TEXT );
            $query->bindValue('username', $username, SQLITE3_TEXT );

            $query->execute();
            return $this->return_last_error();
        }

        public function get_sessions_by_username($username) {
            $query = $this->prepare('select * from sessions where username_id=(select id from user where username=:username)');

            $query->bindValue('username', $username, SQLITE3_TEXT );

            $result = $query->execute();

            $result = $result->fetchArray(SQLITE3_ASSOC);

            if (empty($result)) {
                return false;
            } else {
                return $result;
            }
        }

        public function return_last_error() {
            return SQLite3::lastErrorCode();
        }

        public function __destruct() {
            $this->close();
        }
    }

?>