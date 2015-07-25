<?php
    class Controller {
        public $m_database;
        public $m_exec;
        public $m_std;
        public $m_session;

        /* This function creates all necessary models */
        public function create_models($controller) {
            $this->m_database = $this->model('m_Database');
            $this->m_exec = $this->model('m_Exec');
            $this->m_std = $this->model('m_Std');
            $this->m_session = $this->model('m_Session');
        }

        public function check_loggedin($controller) {
            if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                $this->m_session->setUsername($_SESSION['username']);
                $this->m_session->setPassword($_SESSION['password']);

                // Check if user is logged in
                // Checks for correct password, browser agent, source_ip and if the sessions is expired
                // if everything is ok, the session timestamp will be updated
                if (!$this->m_session->check_password() or !$this->m_session->check_other_params($this->m_database->get_sessions_by_username($_SESSION['username'])) or time() - $_SESSION['timestamp'] > intval($this->m_database->get_config('idle') * 60)) {
                    $this->m_session->destroy_session($this->m_std, $this->m_database);
                } else {
                    // Update time
                    // Don't update if controller is connection
                    // A connection to this controller is always established,
                    // even if the session is expired, but the site is still loaded
                    if ($controller !== 'connection') {
                        $time = time();
                        $this->m_session->setTime($time);
                    }
                }
            } else {
                if ($this->m_std->IsXHttpRequest()) {
                    echo 'false';
                } else {
                    header("Location: /asphaleia/auth/login");
                }
                die();
            }
        }

        public function model($model, $id = Null) {
            $file = '../app/models/' . $model . '.php';
            if (file_exists($file)) {
                require_once $file;
                // If is given, create a model with data
                if ($id != Null) {
                    return new $model($this->m_database, $id);
                } else {
                    return new $model();
                }
            } else {
                return false;
            }
        }

        public function view($view, $data = []) {
            $file = '../app/views/' . $view . '.php';
            if (file_exists($file)) {
                require_once $file;
            } else {
                echo 'File ' . $file . ' not found!';
            }
        }
    }

?>