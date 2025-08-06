<?php include("contents/permission.php") ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Dashboard</title>
    <?php include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/dashboard.css">

</head>
<body>
    <!-- Sidebar -->
     <?php @include("components/sidebar.php") ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
       <?php @include("components/topbar.php") ?>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon finished">
                    <i class="fas fa-thumbs-up"></i>
                </div>
                <div>
                    <div class="stat-value">18</div>
                    <div class="stat-label">
                        Finished
                        <span class="stat-change positive">+6 tasks</span>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon tracked">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="stat-value">31h</div>
                    <div class="stat-label">
                        Tracked
                        <span class="stat-change negative">-5 hours</span>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon efficiency">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <div class="stat-value">93%</div>
                    <div class="stat-label">
                        Efficiency
                        <span class="stat-change positive">+12%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Tasks -->
        <div class="content-section w-100" style="margin-right: 350px;">
        

        <div>

        <table class='w-100 border-mute' cellpadding="8" cellspacing="0">
    <thead>
        <tr>
          
            <th>Next of Kin Name</th>
            <th>Address</th>
            <th>Telephone</th>
            <th>Relationship</th>
            <th>PIN</th>
            <th>Status</th>
            <th>Expiry Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conn = $auth->getConnection();
        $user_id = $auth->getUserId();
        $getkin = $conn->prepare("SELECT * FROM next_of_kin WHERE email = ?");
        $getkin->bind_param("s", $email); // "i" for integer
        if ($getkin->execute()) {
            $kinResults = $getkin->get_result();
            while ($dataFound = $kinResults->fetch_assoc()) {
                ?>
                <tr>
                   
                    <td class='text-secondary'><?= htmlspecialchars($dataFound['next_of_kin_name']) ?></td>
                    <td class='text-secondary'><?= htmlspecialchars($dataFound['next_of_kin_address']) ?></td>
                    <td class='text-secondary'><?= htmlspecialchars($dataFound['next_of_kin_telephone']) ?></td>
                    <td class='text-secondary'><?= htmlspecialchars($dataFound['next_of_kin_relationship']) ?></td>
                    <td class='text-secondary'><?= htmlspecialchars($dataFound['pin']) ?></td>
                    <td class='text-secondary'><?= htmlspecialchars($dataFound['status'] ?? 'N/A') ?></td>                    
                    <td class='text-secondary'><?= htmlspecialchars($dataFound['expiry_date']) ?></td>

                    <td> 
                        <div class='d-flex justify-content-center gap-2'>
                             <button class='border border-success text-success rounded rounded-pill'>Activate</button>
                            <button class='border border-danger text-danger rounded rounded-pill'>Remove</button>
                        </div>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>

        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>

