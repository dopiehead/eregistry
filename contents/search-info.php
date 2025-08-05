<?php 
$searchedby = $auth->getUserId();
if (!empty($searchedby) && !empty($u_id)) {
     if($searchedby !== $u_id){
     $date = date('Y-m-d H:i:s'); // current date/time
     $getsearchinfo = $conn->prepare("INSERT INTO search_info (searched_by, searching, date) VALUES (?, ?, ?)");    
     if ($getsearchinfo) {
         $getsearchinfo->bind_param("sss", $searchedby, $u_id, $date);
         $getsearchinfo->execute();
         $getsearchinfo->close();
     } else {
         error_log("Prepare failed: " . $conn->error);
     }
 }

}