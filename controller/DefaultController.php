<?php

class DefaultController extends Controller{
    public function __construct($path)
    {
        parent::__construct($path);
    }
    public function process(array $path=null)
    {
        if($path==null){
            $path = $this->path;
        }
        if(!isset($_SESSION["isLog"])){
            $p="";
            if($path[0]!=="/login"){
                for($i=1;$i<count($path);$i++){
                    $p.=$path[$i]."/";
                }
                header("Location: https://".$_SERVER['SERVER_NAME']."/login/".$p);
            }
        } 

        if(count($path)<= 1 && $path[0]==""){//default return
            $this->app();
            return;
        }
        //aici trebuie sa execute api
        //aici o sa trebuiasca sa preiau cele trei bucati din cod , cel mai probabil o sa fie cu functii
        // if(!(isset($path[1])))//need to be a parameter 
        //     return;
        
        if($path[1]=="component"){
            if(!isset($path[2])||$path[2]=="")
            $this->app();
            else if(method_exists($this::class, $path[2]))
                $this->{$path[2]}();
        }
    }
    public function app(){
        include($_SERVER['DOCUMENT_ROOT']."/static/php/mainPage.php");
    }
    public function getView(){
        if(!isset($_GET["view"]))
            return;
        if(file_exists($_SERVER['DOCUMENT_ROOT']."/view/display".$_GET["view"].".php"))
            include($_SERVER['DOCUMENT_ROOT']."/view/display".$_GET["view"].".php");
    }
    
}