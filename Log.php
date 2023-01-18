<?php

class Log{

   public static function addToLog($username,$action,$data=''){
      
      Database::runQueryRaw("insert into log(whoDidIt,action,data) values('$username','$action','$data');");
   }
}