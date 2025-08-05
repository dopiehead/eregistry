<br>
<footer class="bg-dark text-white py-5 mt-5">
  <div class="container">
    <div class="row g-4">
      <!-- About Section -->
      <div class="col-lg-4 col-md-6 col-12">
        <h6 class="text-uppercase fw-bold mb-3">About Eregistry.ng</h6>
        <p class="text-white-50">
          Eregistry.ng platforms offer exclusive deals, discounts, and promotions, including seasonal sales like Black Friday, flash sales, daily deals, and bulk purchase discounts. Use coupons or promo codes at checkout for extra savings.
        </p>
        <a href="about.php" class="btn btn-outline-light btn-sm mt-2">Learn More</a>
      </div>

      <!-- Links Section -->
      <div class="col-lg-4 col-md-6 col-12">
        <h6 class="text-uppercase fw-bold mb-3">Quick Links</h6>
        <ul class="list-unstyled">
        <?php
$footer_links = [
    ['label' => 'Privacy Policy', 'href' => 'privacy.php'], ['label' => 'Terms and Conditions', 'href' => 'terms.php'],['label' => 'FAQs', 'href' => 'faq.php'],  ['label' => 'Contact Us', 'href' => 'contact.php']
];
?>

<ul class="list-unstyled">
  <?php foreach ($footer_links as $link): ?>
    <li class="mb-2">
      <a href="<?= htmlspecialchars($link['href']) ?>" class="text-white-50 text-decoration-none">
        <?= htmlspecialchars($link['label']) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
        </ul>
      </div>

      <!-- Follow Us Section -->
      <div class="col-lg-4 col-12">
        <h6 class="text-uppercase fw-bold mb-3">Follow Us</h6>
        <div class="d-flex gap-3 mb-3">
        <?php
$social_links = [
    ['platform' => 'Facebook', 'icon' => 'facebook-f', 'url' => '#'], ['platform' => 'Instagram', 'icon' => 'instagram', 'url' => '#'], ['platform' => 'LinkedIn', 'icon' => 'linkedin', 'url' => '#'],  ['platform' => 'Twitter', 'icon' => 'twitter', 'url' => '#'],
];
?>

<div class="d-flex gap-3 mb-3">
  <?php foreach ($social_links as $social): ?>
    <a href="<?= htmlspecialchars($social['url']) ?>"
       class="text-white"
       aria-label="<?= htmlspecialchars($social['platform']) ?>">
      <i class="fab fa-<?= htmlspecialchars($social['icon']) ?> fa-lg"></i>
    </a>
  <?php endforeach; ?>
</div>

        </div>
        
        <!-- Newsletter Signup -->
        <h6 class="text-uppercase fw-bold mb-3">Stay Updated</h6>
        <form method="post" class="d-flex gap-2" id="subscribe-form">
          <input name="email" type="email" class="form-control form-control-sm bg-dark border-light text-white" placeholder="Enter your email" required>
          <button type="submit" id="submit-subscribe" class="btn btn-outline-light btn-sm">Subscribe</button>
        </form>
      </div>
    </div>

    <!-- Copyright -->
    <div class="text-center mt-5">
      <p class="text-white-50 mb-0">&copy; 2025 Eregistry.ng. All rights reserved.</p>
    </div>
  </div>
</footer>

<script>
$(document).ready(function () {
  $('#subscribe-form').on('submit', function (e) {
    e.preventDefault();

    const email = $('input[name="email"]').val().trim();

    if (!email) {
      alert("Please enter a valid email address.");
      return;
    }

    $.ajax({
      url: 'engine/handle-subscription', // your backend endpoint
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({ email: email }),
      success: function (response) {
        if (response.status === 'success') {
          swal({
            icon:"success",
            title:"Success",
            text:response.message
          });
          $('#subscribe-form')[0].reset();
        } else {
          swal({
            title:"Notice",
            icon:"warning",
            text:response.message
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Subscription error:", status, error);
        swal("Something went wrong. Please try again.");
      }
    });
  });
});
</script>

