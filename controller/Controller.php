<?php

abstract class Controller
{
    protected $path;
    protected $view;
    protected $function;
    // protected $data = array();
    // protected $view = "";
	// protected $head = array('title' => '', 'description' => '');
    // public function renderView()
    // {
    //     if ($this->view)
    //     {
    //         extract($this->data);
    //         require("views/" . $this->view . ".phtml");
    //     }
    // }
    // public function redirect($url)
	// {
	// 	header("Location: /$url");
	// 	header("Connection: close");
    //     exit;
	// }
    public function __construct($path)
    {
        $this->path = $path;
    }
    protected function renderView($view=null){
        if($view==null){
            $view = $this->view;
        }
    }
    abstract function process(array $path=null);

}
