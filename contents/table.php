<?php
  $getuserPersonality = $conn->prepare("SELECT * FROM $table WHERE u_id = ? $order $limit $number");
  $getuserPersonality->bind_param("i",$u_id);
  if($getuserPersonality->execute()){
     $result = $getuserPersonality->get_result();
     while($datafound = $result->fetch_assoc()){
     extract($datafound);
  }

}