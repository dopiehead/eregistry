

<div class="top-bar">
            <div>
                <h1 style="margin: 0; font-size: 24px; font-weight: 600; color: #1f2937;">Hello, <?= htmlspecialchars($name) ?></h1>
                <p style="margin: 0; color: #6b7280; font-size: 14px;">Track team progress here. You almost reach a goal!</p>
            </div>
            <div class="user-profile">
                <span style="color: #6b7280; font-size: 14px;"><?= htmlspecialchars (date("Y-m-d")) ?></span>
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar"></i>
                    </button>
                </div>
                <img src="https://images.unsplash.com/photo-1494790108755-2616b2c05036?w=40&h=40&fit=crop&crop=face" alt="<?= htmlspecialchars($name) ?>" class="user-avatar">
                <div>
                    <div style="font-weight: 600; font-size: 14px;"><?= htmlspecialchars($name) ?></div>
                    <div style="color: #6b7280; font-size: 12px;">@<?= htmlspecialchars($name) ?></div>
                </div>
                <div class="dropdown">
                    <a href='tel:+2347033506332' class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-phone"></i>
                    </a>
                </div>
                <!-- <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-video"></i>
                    </button>
                </div> -->
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
            </div>
        </div>