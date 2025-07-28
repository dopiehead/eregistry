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

        <!-- Performance Chart -->
        <div class="content-section" style="margin-right: 350px;">
            <div class="section-header">
                <h3 class="section-title">Performance</h3>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        01-07 May
                    </button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="performanceChart" class="chart-canvas"></canvas>
            </div>
        </div>

        <!-- Current Tasks -->
        <div class="content-section" style="margin-right: 350px;">
            <div class="section-header">
                <div>
                    <h3 class="section-title">Current Tasks</h3>
                    <span style="color: #6b7280; font-size: 14px;">Done 30%</span>
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

    <!-- Activity Sidebar -->
    <div class="activity-section">
        <h4 style="margin-bottom: 24px; font-size: 16px; font-weight: 600;">Activity</h4>
        
        <div class="activity-item">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=32&h=32&fit=crop&crop=face" alt="Floyd Miles" class="activity-avatar">
            <div class="activity-content">
                <div class="activity-name">Floyd Miles</div>
                <div class="activity-action">Commented on Start Project</div>
                <div style="background: #f3f4f6; padding: 8px; border-radius: 6px; font-size: 13px; margin: 8px 0;">
                    Hi! Next week we'll start a new project. I'll tell you all the details later
                </div>
                <div class="activity-time">10:15 AM</div>
            </div>
        </div>

        <div class="activity-item">
            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=32&h=32&fit=crop&crop=face" alt="Guy Hawkins" class="activity-avatar">
            <div class="activity-content">
                <div class="activity-name">Guy Hawkins</div>
                <div class="activity-action">Added a file to ThreeProject</div>
                <div class="activity-time">10:15 AM</div>
            </div>
        </div>

        <div class="activity-item">
            <div class="activity-avatar" style="background: #1f2937; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600;">
                H
            </div>
            <div class="activity-content">
                <div class="activity-name">Homepage.fig</div>
                <div class="activity-action">23.4 MB</div>
                <div class="activity-time">10:15 AM</div>
            </div>
        </div>

        <div class="activity-item">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=32&h=32&fit=crop&crop=face" alt="Kristin Watson" class="activity-avatar">
            <div class="activity-content">
                <div class="activity-name">Kristin Watson</div>
                <div class="activity-action">Commented on ThreeProject</div>
                <div class="activity-time">10:15 AM</div>
            </div>
        </div>
    </div>

    <!-- Message Input -->
    <div class="message-input">
        <i class="fas fa-paperclip" style="color: #6b7280;"></i>
        <input type="text" placeholder="Write a message">
        <i class="fas fa-microphone" style="color: #6b7280;"></i>
        <i class="fas fa-paper-plane" style="color: #6b7280;"></i>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Performance Chart
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['01', '02', '03', '04', '05', '06', '07'],
                datasets: [
                    {
                        label: 'This Month',
                        data: [6, 4, 7, 3, 8, 5, 6],
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#667eea',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Last Month',
                        data: [5, 3, 6, 4, 7, 4, 5],
                        borderColor: '#e2e8f0',
                        backgroundColor: 'rgba(226, 232, 240, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#e2e8f0',
                        pointBorderColor: '#e2e8f0',
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                const date = context[0].label;
                                return `0${date} May 2023`;
                            },
                            label: function(context) {
                                return `${context.parsed.y}h`;
                            },
                            afterLabel: function(context) {
                                if (context.datasetIndex === 0) {
                                    return `Last month: ${context.chart.data.datasets[1].data[context.dataIndex]}h`;
                                }
                                return '';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 12,
                        ticks: {
                            stepSize: 2,
                            color: '#9ca3af',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return value + 'h';
                            }
                        },
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        border: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    point: {
                        hoverBorderWidth: 3
                    }
                }
            }
        });
    </script>
</body>
</html>

