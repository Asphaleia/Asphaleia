<?php
class Auth extends Controller {
    public function login() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            // Create pw hash
            $pwhash = hash('sha256', $_POST['password']);

            // Save username and hash in session var
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $pwhash;

            // Write username and hash to session object
            $this->m_session->setUsername($_POST['username']);
            $this->m_session->setPassword($pwhash);
            $login_time = time();
            $this->m_session->setTime($login_time);

            if($this->m_session->check_password()) {
                // check here if session with user $_POST['username'] has already started
                $data = $this->m_database->get_sessions_by_username($_POST['username']);

                if (empty($data)) {
                    // redirect to dashboard page
                    header("Location: /asphaleia/dashboard");

                    // add session data to database
                    $this->m_database->add_session(session_id(), $_POST['username'], $login_time, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
                } else {
                    // todo: add override option
                    $this->view('v_message', 'User ' . $_POST['username'] . ' is already logged in from ' . $data['source_ip']);
                }
                die();
            } else {
                $this->view('v_message', 'Wrong username or password!');
                header( "refresh:2;url=/asphaleia/auth/login" );
                die();
            }
        } else {
            $this->view('v_header', "login");
            $this->view('v_signin');
        }
    }

    public function logout(){
        if (!empty($_SESSION['username']) && !empty($_SESSION['password'])) {
            $this->m_session->setUsername($_SESSION['username']);
            $this->m_session->setPassword($_SESSION['password']);
            if ($this->m_session->check_password()) {
                $this->m_session->destroy_session($this->m_std, $this->m_database);
            }
        } else {
            header("Location: /asphaleia/auth/login");
            die();
        }
    }
}
?>