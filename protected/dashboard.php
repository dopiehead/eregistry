<?php
include("contents/permission.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php include("components/links.php"); ?>
    <link rel="stylesheet" href="../assets/css/protected/dashboard.css">
</head>
<body>
    <!-- Sidebar -->
    <?php @include("components/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php @include("components/topbar.php"); ?>

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

       <!-- Current Tasks and Bank Details -->
<div class="content container-fluid mt-4">

<!-- Current Tasks Table -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-bold">
        Next of Kin Details
    </div>
    <div class="card-body p-0">
        <div style="max-height: 300px; overflow-y: auto;">
            <table class="table table-hover mb-0">
                <thead class="table-light">
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
                    $getkin->bind_param("s", $email);
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
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-success btn-sm">Activate</button>
                                        <button class="btn btn-outline-danger btn-sm">Remove</button>
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
</div>

<!-- Bank Details Section -->
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white fw-bold">
        Bank Details
    </div>
    <div class="card-body">
    <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Bank Name</th>
                        <th>Bank account no</th>
                        <th>Bank balance</th>
                        <th>Account type</th>
                        <th>Bank details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = $auth->getConnection();
                    $user_id = $auth->getUserId();
                    $getkin = $conn->prepare("SELECT * FROM bank_details WHERE u_id = ?");
                    $getkin->bind_param("s", $user_id);
                    if ($getkin->execute()) {
                        $kinResults = $getkin->get_result();
                        while ($dataFound = $kinResults->fetch_assoc()) {
                                $bId = $dataFound['id'];
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($dataFound['bank_name']) ?></td>
                                <td><?= htmlspecialchars($dataFound['bank_account']) ?></td>
                                <td><?= htmlspecialchars($dataFound['bank_account']) ?></td>
                                <td><?= htmlspecialchars($dataFound['account_type']) ?></td>
                                <td><?= htmlspecialchars($dataFound['account_details']) ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href='functions/edit-bank.php?id=<?= urlencode($bId) ?>' class="btn btn-outline-success btn-sm"> <i class='fa fa-edit'></i> Edit</a>
                                        <a href='functions/delete-bank.php?id=<?= urlencode($bId) ?>' class="btn btn-outline-danger btn-sm"> <i class='fa fa-trash'></i> Remove</a>
                                    </div>
                                </td>
                              
                            </tr>
                            <?php
                        }
                    }

                    else{
                        echo '<p class="text-muted">No bank details available yet.</p>';
                    }
                    ?>
                </tbody>
            </table>
    </div>
</div>

</div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
