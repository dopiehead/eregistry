
    <section class="videos-section">
        <div class="container">
            <!-- Videos Header -->
            <div class="videos-header">
                <h2 class="videos-title">Short Videos</h2>
                <a href="#" class="see-all-link">See All</a>
            </div>
            
            <!-- Videos Grid -->
            <div class="row g-3">
                <!-- Video Card 1 -->
                <?php
$videos = [
    ['thumbnail_class' => 'video-1', 'likes' => 203, 'views' => '5,345'],
    ['thumbnail_class' => 'video-2', 'likes' => 150, 'views' => '3,210'],
    ['thumbnail_class' => 'video-3', 'likes' => 98,  'views' => '2,840'],
    ['thumbnail_class' => 'video-4', 'likes' => 76,  'views' => '1,904'],
    ['thumbnail_class' => 'video-5', 'likes' => 305, 'views' => '6,200'],
    // Add more as needed...
];
?>
<div class="row">
<?php foreach ($videos as $video): ?>
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
        <div class="video-card">
            <div class="video-thumbnail <?= htmlspecialchars($video['thumbnail_class']) ?>">
                <div class="play-button"></div>
                <div class="video-stats">
                    <div class="likes">
                        <i class="fas fa-heart heart-icon"></i>
                        <span><?= htmlspecialchars($video['likes']) ?></span>
                    </div>
                    <div class="views"><?= htmlspecialchars($video['views']) ?> views</div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>


            </div>
        </div>
    </section>
