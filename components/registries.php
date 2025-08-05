<div class="container py-5">
  <div class="row justify-content-center g-4">

    <?php
    $registries = [
        ['image' => 'assets/img/registry/bank-registry.png', 'name' => 'Bank Registry', 'slug' => 'bank.php'], ['image' => 'assets/img/registry/car-registry.png', 'name' => 'Car Registry', 'slug' => 'car.php'],
        ['image' => 'assets/img/registry/child-registry.png', 'name' => 'Child Registry', 'slug' => 'child.php'], ['image' => 'assets/img/registry/land-registry.png', 'name' => 'Land Registry', 'slug' => 'land.php'],
        ['image' => 'assets/img/registry/property-registry.png', 'name' => 'Property Registry', 'slug' => 'property.php'],  ['image' => 'assets/img/registry/wedding-registry.png', 'name' => 'Wedding Registry', 'slug' => 'wedding.php'], ['image' => 'assets/img/registry/will-registry.png', 'name' => 'Will Registry', 'slug' => 'will.php'],
      
        // Additional Registries with Placeholder Images
        ['image' => 'assets/img/registry/death.jpeg', 'name' => 'Death', 'slug' => 'death.php'], ['image' => 'assets/img/registry/birth.jpg', 'name' => 'Birth', 'slug' => 'birth.php'],
        ['image' => 'assets/img/registry/court.jpeg', 'name' => 'Court', 'slug' => 'court.php'],  ['image' => 'assets/img/registry/divorce.webp', 'name' => 'Divorce', 'slug' => 'divorce.php'],
        ['image' => 'assets/img/registry/job.jpg', 'name' => 'Job', 'slug' => 'job.php'], ['image' => 'assets/img/registry/tenants.jpg', 'name' => 'Tenants', 'slug' => 'tenants.php'], ['image' => 'assets/img/registry/police.jpg', 'name' => 'Police', 'slug' => 'police.php'],
        ['image' => 'assets/img/registry/mortuary.jpg', 'name' => 'Mortuary', 'slug' => 'mortuary.php'], ['image' => 'assets/img/registry/burial.jpg', 'name' => 'Burial', 'slug' => 'burial.php']
      ];
      

    foreach ($registries as $index => $registry) {
      $name = htmlspecialchars($registry['name']);
      $image = htmlspecialchars($registry['image']);
      $slug = htmlspecialchars($registry['slug']);
      $extraClass = $index > 7 ? 'd-none more-item' : ''; // hide items after 8

      echo "
        <div class='col-6 col-md-4 col-lg-3 registry-item {$extraClass}'>
          <a href='{$slug}' class='text-decoration-none'>
            <div class='position-relative rounded overflow-hidden shadow-sm transition-hover'>
              <img src='{$image}' alt='{$name}' loading='lazy' class='img-fluid w-100' style='height:150px; object-fit:cover;'>
              <div class='position-absolute top-50 start-50 translate-middle text-white text-center fw-semibold fs-6 px-2'>
                {$name}
              </div>
              <div class='position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50'></div>
            </div>
          </a>
        </div>
      ";
    }
    ?>
    
  </div>

  <!-- See More Button -->
  <div class="text-center mt-4">
    <button class="btn btn-outline-danger rounded-pill px-4" id="seeMoreBtn">See More</button>
  </div>
</div>

<script>
document.getElementById("seeMoreBtn").addEventListener("click", function () {
  const hiddenItems = document.querySelectorAll(".more-item");
  const isHidden = hiddenItems[0].classList.contains("d-none");

  hiddenItems.forEach(function (el) {
    el.classList.toggle("d-none");
  });

  // Toggle button text
  this.textContent = isHidden ? "See Less" : "See More";
});
</script>



