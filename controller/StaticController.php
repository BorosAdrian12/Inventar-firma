<?php
class StaticController extends Controller{
    protected $ContentType=[
        "css"=>"text/css",
        "javascript"=>"text/javascript",
        "html"=>"text/html"
    ];
    public function __construct($path)
    {
        parent::__construct($path);
    }
    public function process(array $path=null)
    {
        //cred ca nici nu trebuie sa faci magaria asta 
        //aparent nu ii chiar asa de rau , face ce imi trebuie 
        if($path==null){
            $path = $this->path;
        }
        // echo "<br>".$_SERVER['DOCUMENT_ROOT']."<br>";
        // print_r($path);
        // var_dump($path);
        //aici trebuie sa execute api
        if($path[1]=="php")//nu il las ca nu stiu ce o sa se intample 
            return;
        $path[0]="static";
        $pathString=implode("/",$path);
        // echo $pathString;
        if (isset($path[2]) && $path[2] != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/static/' . $path[1] . '/' . $path[2])) {
            // if (file_exists($_SERVER['DOCUMENT_ROOT'].'/static/html/test.html'))
            if(array_key_exists($path[1],$this->ContentType)){
                $header='Content-Type: '.$this->ContentType[$path[1]].'';
                header($header);
            }
                
            require($_SERVER['DOCUMENT_ROOT'] . '/static/' . $path[1] . '/' . $path[2]);
        }
        else {
            // var_dump($path);
        }
    }
}