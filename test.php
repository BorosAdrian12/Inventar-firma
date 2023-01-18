<?php
require('./Database.php');
Database::getConnection();

// require('./model/getDataManager.php');


// var_dump(Database::existingUser("boros_adrian"));
// Database::addUser("boros_adrian","adi@gmail.com","adi","adi");


// require('./autoloader.php');
// $x = new ApiController("");
// $data=$x->getItemTypeList(0);
// var_dump($data);
// $x=new getDataManager();
// $y=$x->getAllDeposit();
// json_encode($y);
// print_r($y);
// print_r($x->getAllUsers());
// print_r($x->getAllType());



// $x=Database::runQuery("select id from productLocation where deposit_id = 1;");
// print_r($x);

function addItem($name,$series,$typeid,$placeType,$idplace){

  
   $arr=["deposit"=>"deposit_id","user"=>"user_id"];
   //verify if item allready exists
   echo"sunt in functie\n";
   if(key_exists($placeType,$arr)){
      echo"sunt in if\n";
      //cauta daca mai exista un produs cu aceeasi serie
      $searchSeries=Database::runQuery("select series from item where series ='$series'");
      print_r(count($searchSeries));
      print_r($searchSeries);
      if(count($searchSeries)!==0){
         return;//this product allready exists
      }
      echo"nu exista alta serie\n";
      //cauta daca exista un loc pentru el
      $idProductPlace=Database::runQuery("select id from productLocation where ".$arr[$placeType]." = $idplace limit 1");
      print_r(count($idProductPlace));
      if(count($idProductPlace)==0){//it may pop if i have to identical place
         //daca nu creaza unu
         $idProductPlace["id"][0]=Database::addProductPlace($placeType,$idplace);
         print_r($idProductPlace["id"][0]);
      }
      Database::addItemTest($name,$series,$typeid,$idProductPlace["id"][0]);
      echo"a adaugat datele \n";
      
   }
   echo"gata functia\n";
}

addItem("dsadsda","aedqderie",1,"user",3);