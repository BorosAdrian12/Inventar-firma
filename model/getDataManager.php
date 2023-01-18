<?php
// require($_SERVER['DOCUMENT_ROOT']."/Database.php");
require($_SERVER['DOCUMENT_ROOT']."/Database.php");
// require('C:\xampp\htdocs/Database.php');

//here will bee all request from api to retrieve information from database 
Database::getConnection();

/**
 * 1) i can use selectFromTable() alot but then i need to pass sql 
 * condition and i don't know if is a good way to do it 
 */

class getDataManager{
   // o sa trebuiasca sa existe si returnare pe bucati
   public function getIntervalItemType($from,$to){
      $data=Database::selectFromTable("item_type","chunk",[$from,$to]);
      // var_dump($data);
      // $data=json_encode($data);
      return $data;
   }
   public function gettAllDeposit(){
      $data=Database::selectView("deposit");
      return $data;
   }
   public function getItemsFromDeposit($id){
      $data=Database::selectView("returnItemWithLocation","idDep=$id");
      return $data;
   }
   public function getItemWithTypeWithId($typeId){
      $data=Database::selectView("returnitemWithType","idType=$typeId");
      $data1=Database::selectView("returnItemWithTypeBaseUser","idType=$typeId");
      if($data==null)
         $data=['id'=>[],'series'=>[],'name'=>[],'data'=>[]];
      if($data1==null)
         $data1=['id'=>[],'series'=>[],'name'=>[],'data'=>[]];
      $data2=['id'=>null,'series'=>null,'name'=>null,'data'=>null];
      $data2['id']=array_merge($data['id'],$data1['id']);
      $data2['series']=array_merge($data['series'],$data1['series']);
      $data2['name']=array_merge($data['name'],$data1['name']);
      $data2['data']=array_merge($data['data'],$data1['data']);
      //nu ia si itemele de la utilizatori
      return $data2;
   }
   public function searchForItemBySeries($toFind){
      $data=Database::searchProduct("serie",$toFind);
      return $data;
   }
   public function searchForItemByName($toFind){
      $data=Database::searchProduct("Name",$toFind);
      return $data;
   }
   public function getAllUsers(){
      $data=Database::runQuery("select idUser as id,username as name from users");
      return $data;
   }
   public function getAllType(){
      $data=Database::runQuery("select id,name from item_type");
      return $data;
   }
   public function getAllDeposit(){
      $data=Database::runQuery("select id,name from deposit");
      return $data;
   }
   public function getLogs($page){
      $data=Database::runQuery("select * from log order by id desc");
      return $data;
   }
   public function getItem($id){
      $data=Database::runQuery("select * from querySearch_view where id=$id");
      return $data;
   }
   public function getIteminfo($id){
      $data=Database::runQuery("select * from returnfulldataItem_view where id=$id");
      return $data;
   }
   public function searchData($searchstring){
      $data=Database::selectView("querySearch","name like '%$searchstring%' limit 5");
      return $data;
   }
   
   public function getAllItemFromUser($id){
      // var_dump($id);
      $data=Database::runQuery("select id from productLocation where user_id=$id");
      // var_dump($data);
      $data=$data["id"][0];
      $data=Database::runQuery("select id, name,series from item where location_id = $data");
      return $data;
   }
   public function searchDeposits($searchstring){
      $data=Database::selectView("depositSearch","name like '%$searchstring%' limit 5");
      // $data=Database::runQuery("select * from deposit where name like '%$searchstring%' limit 5");
      return $data;
   }
}