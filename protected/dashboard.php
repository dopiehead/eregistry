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
        <div class="content-section" style="margin-right: 350px;">
            <div class="section-header">
                <div>
                    <h3 class="section-title">Current Contents</h3>
                    <span style="color: #6b7280; font-size: 14px;">Wedding Registry</span>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Week
                    </button>
                </div>
            </div>
            <div class="tasks-section">
                <div class="task-item">
                    <div class="task-icon review">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="task-content">
                        <div class="task-title">Product Review for UIR Market</div>
                        <span class="task-status in-progress">In progress</span>
                    </div>
                    <div class="task-time">4h</div>
                    <i class="fas fa-ellipsis-h" style="color: #6b7280;"></i>
                </div>
                <div class="task-item">
                    <div class="task-icon research">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="task-content">
                        <div class="task-title">UX Research for Product</div>
                        <span class="task-status on-hold">On hold</span>
                    </div>
                    <div class="task-time">8h</div>
                    <i class="fas fa-ellipsis-h" style="color: #6b7280;"></i>
                </div>
                <div class="task-item">
                    <div class="task-icon design">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="task-content">
                        <div class="task-title">App design and development</div>
                        <span class="task-status done">Done</span>
                    </div>
                    <div class="task-time">32h</div>
                    <i class="fas fa-ellipsis-h" style="color: #6b7280;"></i>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
   
</body>
</html>

