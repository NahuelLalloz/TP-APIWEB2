<?php
require_once 'app/views/loginview.php';
require_once '../api/app/models/loginmodel.php';

class LoginController
{

    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new LoginModel();
        $this->view = new LoginView();
    }

    public function showLogin()
    {

        $this->view->showLogin();
    }

    public function checkLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            die;
        }


        $user = $this->model->getUserByUsername($username);


        if ($user && password_verify($password, $user->password)) {
            session_start();
            $_SESSION['USER_ID'] = $user->id;
            $_SESSION['USER_NAME'] = $user->username;
            $_SESSION['logged'] = true;

            header("Location: " . BASE_URL . "home");
            die;
        } else {
            $this->view->showLogin('Usuario o contraseña incorrectos');
            die;
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL . "home");
    }
}
