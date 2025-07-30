<?php 
require("../engine/connection.php");

$getstates = $con->prepare("SELECT DISTINCT state FROM states_in_nigeria ORDER BY state ASC");

$states = [];

if ($getstates->execute()) {
    $result = $getstates->get_result(); // ✅ not get_results()
    while ($row = $result->fetch_assoc()) {
        $states[] = $row['state'];
    }
}
?>
