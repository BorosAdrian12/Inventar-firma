<?php

require($_SERVER['DOCUMENT_ROOT']."/Database.php");
// require('C:\xampp\htdocs/Database.php');

Database::getConnection();

class putDataManager{
   public function addItemType($name,$count=0){
      //need to verifi if it's allready existe
      if(is_numeric($count))
         $count=intval($count);
      else
         $count=0;
      
      Database::addItemType($name,$count);
   }
   public function addItem($name,$series,$typeid,$placeType,$idplace){
      $arr=["deposit"=>"deposit_id","user"=>"user_id"];
      //verify if item allready exists
      // echo "$name,$series,$typeid,$placeType,$idplace\n";
      // echo"sunt in addItem\n";
      // var_dump($name,$series,$typeid,$placeType,$idplace);
      if(key_exists($placeType,$arr)){
         
         //cauta daca mai exista un produs cu aceeasi serie
         // echo"sunt in if\n";
         $searchSeries=Database::runQuery("select series from item where series ='$series'");
         // var_dump($searchSeries);
         if($searchSeries==null)
            $searchSeries=[];
         else{
            return ["status"=>"bad"];
         }
         if(count($searchSeries)!==0){
            return;//this product allready exists
         }
         //cauta daca exista un loc pentru el
         $idProductPlace=Database::runQuery("select id from productLocation where ".$arr[$placeType]." = $idplace limit 1");
         try {
            $count=count($idProductPlace);
         } catch (\Throwable $th) {
            $count=0;
         }
         
         if($count==0){//it may pop if i have to identical place
            //daca nu creaza unu
            $idProductPlace["id"][0]=Database::addProductPlace($placeType,$idplace);
         }
         Database::addItem($name,$series,$typeid,$idProductPlace["id"][0]);
            
         
      }
   }
   public function modifyLocationItem($id,$placeType,$idplace){
      $arr=["deposit"=>"deposit_id","user"=>"user_id"];
      if(key_exists($placeType,$arr)){
          $data=Database::runQuery("select id from productLocation where ".$arr[$placeType]."=$idplace;");
          $data=$data["id"][0];
          Database::runQuery("update item set location_id= $data where id=$id");
      }
      
   }
   public function deleteObject($nameobj,$id){
      $extra=[];
      switch ($nameobj) {
         case 'deposit':
            $searchSeries=Database::runQuery("select count from deposit where id = $id");
            // if($searchSeries['count(id)'][0]!==0){
            //    return ["err"=>"mai exista iteme in depozit"];//can't
            // }
            $count=intval($searchSeries['count'][0]);
            
            // $count=0;
            if($count!==0){
                  return ["err"=>"mai exista iteme in depozit"];//can't
               }
            Database::runQuery("delete from deposit where id=$id;");
            
            break;
         case 'itemtype':
            $searchSeries=Database::runQuery("select count from item_type where id = $id");
            $extra["dataextra"]=$searchSeries;
            $count=intval($searchSeries['count'][0]);
            // var_dump($count);
            // var_dump($count!==0);
            if($count!==0){
               $extra["err"]="mai exista iteme de acelas tip ";
               $extra["count"]=$count;
               //return ["err"=>"mai exista iteme de acelas tip"];//can't
               return $extra;
            }
            Database::runQuery("delete from item_type where id=$id;");

            break;
         default:
            # code...
            break;
      }

      return null;
   }
}
