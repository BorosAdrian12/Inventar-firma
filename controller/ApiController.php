<?php
class ApiController extends Controller{
    public static $pageSize=10;
    public function __construct($path)
    {
        parent::__construct($path);
    }
    public function process(array $path=null)
    {
        if($path==null){
            $path = $this->path;
        }
        if (method_exists($this::class, $path[1]))
            $this->{$path[1]}();
        //aici trebuie sa execute api
    }
    public function test(){
        echo "<br> acesta este un mesaj din apiController , din functia test<br>".$this->path[2];
    }
    public function returnData(){
        echo "<br> data<br>";
    }
    public function getItemTypeList(){
        if(!isset($_GET["page"]) || $_GET["page"]=="" || !is_numeric($_GET["page"]))
        return null;

        $page=intval($_GET["page"]);
        $manager=new getDataManager();
        
        $pageData=$manager->getIntervalItemType($page * self::$pageSize,self::$pageSize );
        header('Content-Type: application/json');
        echo json_encode($pageData);

        return $pageData;
    }
    public function addItemType(){
        // if(!isset($_POST["itemType"])||!isset($_POST["count"]))
        // return;
        // if($_POST["itemType"]=="")
        // return;
        $manager=new putDataManager();
        $manager->addItemType($_POST["itemType"],$_POST["count"]);
    }
    public function getAllDeposit(){
        $manager=new getDataManager();
        $data=$manager->gettAllDeposit();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getAllItemFromDeposit(){
        //adauga in log
        if(!isset($_GET["id"]) || $_GET["id"]=="" || !is_numeric($_GET["id"]))
        return null;
        $manager=new getDataManager();
        $data=$manager->getItemsFromDeposit($_GET["id"]);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getItemWithTypeWithId(){
        if(!isset($_GET["id"]) || $_GET["id"]=="" || !is_numeric($_GET["id"]))
        return null;
        $manager=new getDataManager();
        $data=$manager->getItemWithTypeWithId($_GET["id"]);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getAlltype(){
        $manager=new getDataManager();
        $data=$manager->getAllType();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getAllusers(){
        $manager=new getDataManager();
        $data=$manager->getAllUsers();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getAlldepositName(){
        $manager=new getDataManager();
        $data=$manager->getAllDeposit();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function addItem(){
        header('Content-Type: application/json');
        $_POST=json_decode(file_get_contents('php://input'),true);
        if(!isset($_POST["name"],$_POST["series"],$_POST["type"],$_POST["locationType"],$_POST["selectedPlace"])){
            //set 200 code
            echo json_encode(["stat"=>"nu"]);
            return;}
        //$arr=[$_POST["name"],$_POST["series"],$_POST["type"],$_POST["locationType"],$_POST["selectedPlace"]];
        //$_SESSION["data"];
        $manager=new putDataManager();
        $x=$manager->addItem($_POST["name"],$_POST["series"],$_POST["type"],$_POST["locationType"],$_POST["selectedPlace"]);
        header('Content-Type: application/json');
        if(isset($x['status'])){
            echo json_encode($x);
            return;
        }
        
        echo json_encode(["status"=>"ok"]);
        Log::addToLog($_SESSION["userData"]["username"],"adauga item","serie".$_POST['series']);
    }
    public function deleteObject(){
        header('Content-Type: application/json');
        $p=json_decode(file_get_contents('php://input'),true);
        if(!isset($p['id'],$p['nameObject'])){
        echo json_encode(["stat"=>"nu"]);
            return;}
        $manager=new putDataManager();
        $x=$manager->deleteObject($p['nameObject'],$p['id']);
        $p['status']=$x;
        
        // $p=["status"=>"test"];
        echo json_encode($p);
        return;
    }
    public function getLogs(){
        $manager=new getDataManager();
        $data=$manager->getLogs(0);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function modifyItem(){

    }
    public function searchItem(){
        header('Content-Type: application/json');
        if(!isset($_GET['search'])){
            return;
        }
        $manager=new getDataManager();
        $data=$manager->searchData($_GET['search']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function searchDeposits(){
        header('Content-Type: application/json');
        if(!isset($_GET['search'])){
            return;
        }
        $manager=new getDataManager();
        $data=$manager->searchDeposits($_GET['search']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function getItem(){
        header('Content-Type: application/json');
        if(!isset($_GET['id'])){
            return null;
        }
        $manager=new getDataManager();
        $data=$manager->getItem($_GET['id']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getItemInfo(){
        header('Content-Type: application/json');
        if(!isset($_GET['id'])){
            return null;
        }
        $manager=new getDataManager();
        $data=$manager->getIteminfo($_GET['id']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function modifyItemLocation(){
        header('Content-Type: application/json');
        $p=json_decode(file_get_contents('php://input'),true);
        if(!isset($p["locationType"],$p["idItem"],$p["idPlace"])){
            return;
        }
        if(!is_numeric($p["idItem"])||!is_numeric($p["idPlace"])){
            return;
        }
        // var_dump($p);
        // echo "da";
        $manager=new putDataManager();
        $manager->modifyLocationItem($p["idItem"],$p["locationType"],$p["idPlace"]);
    }
    public function getAllItemFromUser(){
        header('Content-Type: application/json');
        if(!isset($_GET["id"])||!is_numeric($_GET["id"])){
            return;
        }
        $manager=new getDataManager();
        $data=$manager->getAllItemFromUser($_GET['id']);
       
        echo json_encode($data);
    }
}
