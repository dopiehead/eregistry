<div class="container mt-5">
  <div class="row g-4">
    <?php
    $cards = [
      [
        'title' => 'Post Your Property',
        'text' => 'Lorem ipsum dolor sit amet consectetur. Et sed ut non dignissim. Rhoncus tellus tellus vitae lorem mauris faucibus felis id.',
        'btns' => [
          ['label' => 'Post your Property', 'class' => 'btn-custom', 'href' => '#']
        ],
        'image_url' => 'assets/img/request/building.jpg',
        'card_class' => 'purple-card'
      ],
      [
        'title' => 'Make a Request',
        'text' => 'Lorem ipsum dolor sit amet consectetur. Et sed ut non dignissim. Rhoncus tellus tellus vitae lorem mauris faucibus felis id.',
        'btns' => [
          ['label' => 'Request', 'class' => 'btn-outline-custom', 'href' => '#'],
          ['label' => 'View Requests', 'class' => 'btn-filled-custom', 'href' => '#']
        ],
        'image_url' => 'assets/img/request/landline.jpg',
        'card_class' => 'dark-card',
        'badge' => '250'
      ]
    ];
    foreach ($cards as $card): ?>
      <div class="col-md-6">
        <div class="property-card <?= $card['card_class'] ?>">
          <div class="row h-100 g-0">
            <div class="col-12 col-sm-7">
              <div class="card-content">
                <h3 class="card-title"><?= htmlspecialchars($card['title']) ?></h3>
                <?php if (!empty($card['text'])): ?>
                  <p class="card-text"><?= htmlspecialchars($card['text']) ?></p>
                <?php endif; ?>
                <div>
                  <?php foreach ($card['btns'] as $btn): ?>
                    <a href="<?= $btn['href'] ?>" class="<?= $btn['class'] ?>"><?= htmlspecialchars($btn['label']) ?></a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-5 p-0">
              <div class="card-image" style="background-image: url('<?= $card['image_url'] ?>');">
                <?php if (!empty($card['badge'])): ?>
                  <div class="notification-badge"><?= $card['badge'] ?></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Land Verification Row -->
  <div class="row g-4 mt-4">
    <div class="col-md-12">
      <div class="property-card purple-card">
        <div class="row h-100 g-0">
          <div class="col-12 col-sm-7">
            <div class="card-content w-50">
              <h3 class="card-title">Land Verification, Regularization on E-Property</h3>
              <a href="#" class="btn-custom mt-3">Read More</a>
            </div>
          </div>
          <div class="col-12 col-sm-5 p-0">
            <div class="card-image" style="background-image: url('assets/img/request/landline.jpg');"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
