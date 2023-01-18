<?php
require('./Database.php');
require('./Log.php');
Database::getConnection();
class scriptUpdateCountdb{
   public function updateDepositsCount(){
      // $allDepositinUse=Database::runQuery("select id,deposit_id from productLocation where deposit_id is not null;");
      // $list=array();
      // for($i=0;$i<count($allDepositinUse['id']);$i++){
      //    $count=Database::runQuery("select count(id) from item where location_id=".$allDepositinUse['id'][$i].";");
      //    $count=$count['count(id)'][0];
      //    echo $allDepositinUse['deposit_id'][$i]." are ".$count."\n";
      //    Database::runQuery("update deposit set count=$count where id=".$allDepositinUse['deposit_id'][$i].";");
      // }
      
      // return ;
   }

}
// $x = new scriptUpdateCountdb();
// $x->updateDepositsCount();
// $data=Database::selectFromTable("item_type","chunk",[11,10]);
// var_dump($data);
Database::updateCountDeposits();
Database::updateCountItemType();
// $data=Database::runQuery("select * from log");
// var_dump($data);

