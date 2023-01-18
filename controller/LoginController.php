<?php

class LoginController extends Controller{
    public function __construct($path)
    {
        parent::__construct($path);
    }
    public function test(){
        echo "test";
    }
    public function process(array $path=null)
    {   
        if($path==null){
            $path = $this->path;
        }
        
        if (isset($path[1])&&method_exists($this::class, $path[1]))
            $this->{$path[1]}();
        else
            $this->logIn();
    }
    public function logIn(){
        include($_SERVER['DOCUMENT_ROOT']."/static/php/loginPage.php");
    }
    public function logoutUser(){
        session_destroy();
        header("Location: https://".$_SERVER['SERVER_NAME']);
        return;
    }
    public function createAccount(){
        include($_SERVER['DOCUMENT_ROOT']."/static/php/createAccountPage.php");
    }
    public function confirmLogIn(){
        $manager=new LoginManager();
        if(!isset($_POST["username"])||!isset($_POST["password"])){
            echo "no login information";
            return;
        }
        $manager->logUser($_POST["username"],$_POST["password"]);
        
        Log::addToLog($_POST["username"],"s-a logat");
    }
    public function confirmCreateAccount(){
        $manager=new LoginManager();
        if(!isset($_POST["username"])||!isset($_POST["password"])){
            echo "no login information";
            return;
        }
        $manager->createAccount($_POST["username"],$_POST["password"],$_POST["repassword"],$_POST["email"]);
    }
}