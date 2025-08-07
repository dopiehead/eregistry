<?php


$searchedby = (int) $auth->getUserId();   // ID of the user performing the search
$targetId   = isset($u_id) ? (int)$u_id : 0; // ID of the profile being viewed

if ($searchedby > 0 && $targetId > 0) {

    // Avoid logging when a user views their own profile
    if ($searchedby !== $targetId) {

        $now = date('Y-m-d H:i:s'); // current timestamp

        // 1) Log the search event
        //    Use correct types: searched_by (int), searching (int), date (string)
        $getsearchinfo = $conn->prepare(
            "INSERT INTO search_info (searched_by, searching, date) VALUES (?, ?, ?)"
        );

        if ($getsearchinfo) {
            $getsearchinfo->bind_param("iis", $searchedby, $targetId, $now);

            if ($getsearchinfo->execute()) {

                // 2) Fetch the searcher's display name
                //    FIX: add '=' in WHERE clause; bind as int
                $getprofile = $conn->prepare(
                    "SELECT name FROM user_profile WHERE id = ? LIMIT 1"
                );

                if ($getprofile) {
                    $getprofile->bind_param("i", $searchedby);

                    if ($getprofile->execute()) {
                        // Prefer bind_result()/fetch() to avoid mysqlnd dependency
                        $getprofile->bind_result($searcherName);
                        $hasRow = $getprofile->fetch();
                        $getprofile->close();

                        if ($hasRow) {
                            // 3) Notify the profile owner
                            //    sender_id: assuming it's a string "admin". If INT, change type + value accordingly.
                            $admin    = 'admin';
                            $message  = $searcherName . ' just checked your profile';
                            $pending  = 0;
                            $now2     = date('Y-m-d H:i:s'); // separate var for clarity

                            $insSql = "INSERT INTO user_notifications (sender_id, message, recipient_id, pending, date)
                                       VALUES (?, ?, ?, ?, ?)";
                            $ins = $conn->prepare($insSql);

                            if ($ins) {
                                // Types: s (sender_id), s (message), i (recipient_id), i (pending), s (date)
                                $ins->bind_param('ssiss', $admin, $message, $targetId, $pending, $now2);
                                $ins->execute(); // Notification failures are non-fatal here
                                $ins->close();
                            } else {
                                // Optional: log prepare error for notifications
                                error_log("Notifications prepare failed: " . $conn->error);
                            }
                        }
                    } else {
                        // Optional: log execute error for getprofile
                        error_log("Get profile execute failed: " . $getprofile->error);
                        $getprofile->close();
                    }
                } else {
                    // Optional: log prepare error for getprofile
                    error_log("Get profile prepare failed: " . $conn->error);
                }
            } else {
                // Optional: log execute error for search_info insert
                error_log("Search info execute failed: " . $getsearchinfo->error);
            }

            $getsearchinfo->close();
        } else {
            // Prepare failed for search_info insert
            error_log("Search info prepare failed: " . $conn->error);
        }
    }
}
