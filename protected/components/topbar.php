
<div class="top-bar">
            <div>
                <h1 style="margin: 0; font-size: 24px; font-weight: 600; color: #1f2937;">Hello, <?= htmlspecialchars($name) ?></h1>
            </div>
            <div class="user-profile">
                <span style="color: #6b7280; font-size: 14px;"><?= htmlspecialchars (date("Y-m-d")) ?></span>
                <?php             
             if (!in_array($extension , $image_extension)) :
                  echo"<div class='text-center user-avatar border border-mute rounded rounded-circle  d-flex justify-content-center align-items-center'><span style='font-size:20px;' class='text-secondary text-uppercase'>".substr($name,0,2)."</span></div>";                  
             else: ?> 
                <?php $image = $image ?? "https://placehold.co/600x400"; ?>
                <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>" class="user-avatar">
           <?php endif ?>
                <div>
                    <div style="font-weight: 600; font-size: 14px;"><?= htmlspecialchars($name) ?></div>
                    <div style="color: #6b7280; font-size: 12px;">@<?= htmlspecialchars($name) ?></div>
                </div>
                <div class="dropdown">
                    <a href='tel:+2347033506332' class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-phone"></i>
                    </a>
                </div>
                <div class="dropdown">
                    <a class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i> (<span class='text-danger'>0</span>)
                    </a>
                </div> 
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
            </div>
        </div>