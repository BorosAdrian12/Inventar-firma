<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database.php");
Database::getConnection();
class LoginManager {
   

   public function __constructor(){
      
   }
   public function logUser($username,$password){
      //pana acum merge dar trebuie sa mai adaugi si remember me
      $userData=Database::loginUser($username,$password);
      if($userData==false){
         echo "invalid credential";
         return;
      }
      $_SESSION["isLog"]=true;
      $_SESSION["userData"]=$userData;
      header('Location: https://'.$_SERVER['SERVER_NAME']);
      return;
   }
   public function createAccount($username,$password,$repassword,$email){
      //check data
      if($password!==$repassword){
         return;
      }
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
         return;
      }
      if(preg_match($email,'/;/') || preg_match($username,'/;/') || preg_match($password,'/;/')){
         return;
      }
      if(Database::existingUser($username)){
         echo "exista acest user";
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         return;
      }
      Database::addUser($username,$email,$password,$repassword);
      header('Location: https://'.$_SERVER['SERVER_NAME'].'/login/');
   }
   
}