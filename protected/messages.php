<?php include("contents/permission.php") ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages</title>
    <?php include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/messages.css">
</head>
<body>
    <!-- Sidebar -->
    <?php @include("components/sidebar.php") ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php @include("components/topbar.php") ?>

        <div class='px-3' id="label">
            <?php
            $limit = 2;
            $getQuery = "SELECT * FROM messages WHERE receiver_email = '$email' AND is_receiver_deleted = 0 GROUP BY sender_email";
            $result = mysqli_query($conn, $getQuery);
            $total_rows = $result->num_rows;
            $total_pages = ceil($total_rows / $limit);
            
            $page_number = $_GET['page'] ?? 1;
            $initial_page = ($page_number - 1) * $limit;

            $inbox = "SELECT * FROM (
                        SELECT * FROM messages 
                        WHERE receiver_email = '$email' 
                          AND is_receiver_deleted = 0 
                        ORDER BY has_read ASC 
                        LIMIT 18446744073709551615
                      ) AS sub 
                      GROUP BY sender_email 
                      LIMIT $initial_page, $limit";

            $in = mysqli_query($conn, $inbox);
            $datafound = $in->num_rows;
            ?>

            <table style='width:100%'>
                <thead>
                    <tr>
                        <th id="inbox">Inbox(<?= htmlspecialchars($datafound) ?>)</th>
                        <th><a href="" id="refresh">Refresh</a></th>
                        <th><a class="mark">Mark as Read</a></th>
                    </tr>
                </thead>
            </table>
            <br><br><br>

            <?php
            echo "<table style='width:100%'>
                    <thead>
                    <tr style='background-color:rgba(192,192,192,0.1);'>
                        <td id='td-action'>Action</td>
                        <td id='td-from'>From</td>
                        <td id='td-subject'>Subject</td>
                        <td id='td-date'>Date</td>
                    </tr>
                    </thead>
                    <tbody>";

            while ($row = mysqli_fetch_array($in)) {
                echo "<tr id='{$row['id']}' class='border_bottom'>";
                echo "<td id='delete' style='text-align: center;'>
                        <a style='color:red;' class='remove' id='{$row['sender_email']}'><i class='fa fa-trash'></i></a>
                      </td>";

                $user_name = $row['sender_email'];
                $subject = $row['subject'];

                $getUsercount = mysqli_query($conn, "SELECT * FROM messages WHERE sender_email = '$user_name' AND receiver_email = '$you' AND is_receiver_deleted = 0 AND has_read = 0");
                $countgetuser = $getUsercount->num_rows > 0 ? "<span class='numbering'>({$getUsercount->num_rows})</span> " : "";

                echo "<td id='from' style='text-align: center;'><a href='chat.php?user_name=" . urlencode($user_name) . "'>" . substr($user_name, 0, 4) . "</a></td>";

                $messageStyle = $row['has_read'] == 0 ? "font-weight:bold; font-size:14px;" : "font-weight:normal; font-size:13px;";
                echo "<td id='message' style='text-align: center; {$messageStyle}'>
                        <a href='chat.php?user_name=" . urlencode($user_name) . "' class='reply' style='{$messageStyle}'>
                        {$countgetuser}{$subject}</a>
                      </td>";

                echo "<td id='date' style='text-align: center;'>{$row['date']}<br></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            ?>
        </div>

        <?php 
        if ($page_number > 1) {
            echo '<a href="messages.php?page=' . ($page_number - 1) . '">Prev</a> ';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            $activeClass = $i == $page_number ? 'class="active"' : '';
            echo '<a ' . $activeClass . ' href="messages.php?page=' . $i . '">' . $i . '</a> ';
        }

        if ($page_number < $total_pages) {
            echo '<a href="messages.php?page=' . ($page_number + 1) . '">Next</a>';
        }
        ?>
    </div>
    <script src="../assets/js/messages.js"></script>
</body>
</html>
