<!-- Bootstrap Navbar Section -->
<nav class="navbar navbar-expand-md bg-white shadow py-3 px-3">
  <div class="container-fluid">
    
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-dark" href="index">LOGO</a>

    <!-- Toggler button for mobile -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

      <!-- Navigation links -->
      <ul class="navbar-nav mx-auto mb-2 mb-md-0 gap-md-4 text-center">
        <?php
        $links = [ 
          ['link' => 'About us', 'slug' => 'about.php'],
          ['link' => 'Forms', 'slug' => 'forms.php'],
          ['link' => 'FAQ', 'slug' => 'faq.php'],
          ['link' => 'Blog', 'slug' => 'blog.php'],
          ['link' => 'Contact us', 'slug' => 'contact.php'],
        ];

        foreach ($links as $item) {
          echo '<li class="nav-item">
                  <a class="nav-link text-dark" href="' . htmlspecialchars($item['slug']) . '">' . htmlspecialchars($item['link']) . '</a>
                </li>';
        }
        ?>
      </ul>

      <!-- Auth buttons -->
      <div class="d-flex flex-column flex-md-row align-items-center gap-2 text-center">
        <a class="btn btn-danger rounded-pill px-4 py-1 w-100 w-md-auto" href="#">Get Started</a>
        <a class="btn btn-outline-danger rounded-pill px-4 py-1 w-100 w-md-auto" href="#">Sign In</a>
      </div>
    </div>
  </div>
</nav>

<!-- Bootstrap CSS (in <head>) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (before </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

