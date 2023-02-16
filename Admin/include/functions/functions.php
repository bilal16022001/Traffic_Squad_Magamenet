<?php
/*
    this function her role checkItem is found in dtabase ?
*/
function checkitem($filed,$nameTable,$where=null,$condition1=null){
   global $con;

   $stmt = $con->prepare("SELECT $filed FROM $nameTable $where $condition1");
   $stmt->execute();
   $count = $stmt->rowCount();
   return $count;

}

/*
   this function her role get anything in dtabase ?
   function v3.0
*/

function getdb($filed,$table,$where=null,$condition=null){
   global $con;

   $stmt = $con->prepare("SELECT $filed FROM $table $where $condition");
   $stmt->execute();
   $data = $stmt->fetchAll();
   return $data;
}
/*
   function v2.0
*/

 function deleteItem($nameTable,$condition){
    global $con;
    $stmt = $con->prepare("DELETE FROM  $nameTable $condition");
    $stmt->execute();
    $count = $stmt->rowCount();
    return $count;
 }

 /*
 
 */

 function CountItem($item,$nameTable,$condition=null){
       global $con;
       $stmt = $con->prepare("SELECT COUNT($item) FROM $nameTable $condition");
       $stmt->execute();
       return $stmt->fetchColumn();
 }



/*
  this function does every page his title
*/

function getTitle(){
   global $title;
     if(isset($title)){
         echo $title;
     }else{
        echo "default";
     }
}

?>