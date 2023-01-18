<?php
function autoloadFunction($class)
{
    // echo $class . "\n";
    // Ends with a string "Controller"?
    if($class=="Log"){
        require("Log.php");
    }
    else if (preg_match('/Controller$/', $class))
        require("controller/" . $class . ".php");
    else if (preg_match('/Manager$/', $class))
        require("model/" . $class . ".php");
}
spl_autoload_register("autoloadFunction");