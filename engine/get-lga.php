<?php

declare(strict_types=1);

require 'connection.php';

header('Content-Type: text/html; charset=utf-8');

$sql = "SELECT * FROM states_in_nigeria";

if (isset($_POST['location'])) {
    $location = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');
    $location = mysqli_real_escape_string($con, $location);
    $sql .= " WHERE state = '$location'";
}

$result = mysqli_query($con, $sql);

if (!$result) {
    echo "<select name='lga' id='lga' class='lga address_details'>";
    echo "<option value=''>Error fetching LGAs</option>";
    echo "</select><br>";
    exit;
}

echo "<select name='lga' id='lga' class='lga address_details'>";
while ($row = mysqli_fetch_assoc($result)) {
    $lga = htmlspecialchars($row['lga'], ENT_QUOTES, 'UTF-8');
    echo "<option value='$lga'>$lga</option>";
}
echo "</select><br>";
