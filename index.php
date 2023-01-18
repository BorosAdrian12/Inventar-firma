<!-- <?php
session_start();
include("./autoloader.php");
include_once("./Util.php");
include("./Log.php");
$path = Util::parseUrl($_SERVER['REQUEST_URI']);
$controllerType = [
    "api"=>"ApiController",
    "static"=>"StaticController",
    "default"=>"DefaultController",
    "login"=>"LoginController"
];
$controller;

/**
 * add verifi token life
 */

// if(!(isset($_SESSION["isLog"]))||$_SESSION["isLog"]==FALSE){
//     // $path=["login"];
//     if($_SERVER['REQUEST_URI']!=="/login")
//         header("Location: https://".$_SERVER['SERVER_NAME']."/login");
//     // echo " in if index :".$_SESSION["isLog"];
// }

// else{
//     header("Location: https://".$_SERVER['SERVER_NAME']."/login");
// }
// var_dump($controllerType);
if(array_key_exists($path[0],$controllerType)){
    $controller=new $controllerType[$path[0]]($path);
}else{
    $controller = new $controllerType['default']($path);
    if(isset($_SESSION["isLog"])){
        echo "<script>dataUser =".json_encode($_SESSION['userData']).";</script>";
    }
}
$controller->process();
// echo "<br> aici este index , ce a fost inainte a fost randat de pe site ";
// var_dump($path); 
// var_dump($_SESSION["isLog"]);
//         echo "<br>";
// if(isset($_GET["data"]))
//     echo"<br>".$_GET["data"];
// $controller->renderView();
// asta ar trebuii sa fie in proccess pentru ca la unele nu ar trebuii sa ruleze -->
