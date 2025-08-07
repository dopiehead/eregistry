<!-- Search Category -->
<div class="container mt-5 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-6 d-flex gap-2 border border-muted rounded px-3 py-2">
            <input type="text" class="form-control border-0 shadow-none" placeholder="Search category...">
            <button class="btn btn-danger">Search</button>
        </div>
    </div>
</div>

<!-- Category Section -->
<div class="container mb-5">
    <div class="row g-4 justify-content-center">
        <?php 
        $categories = [
            ['category_name' => 'Vehicle', 'slug' => 'vehicle'], ['category_name' => 'Property', 'slug' => 'property'], 
            ['category_name' => 'Death', 'slug' => 'death'], ['category_name' => 'Birth', 'slug' => 'birth'], 
            ['category_name' => 'Court', 'slug' => 'court'], ['category_name' => 'Divorce', 'slug' => 'divorce'],  
            ['category_name' => 'Marriage', 'slug' => 'marriage'], ['category_name' => 'Job', 'slug' => 'job'],   
            ['category_name' => 'Tenants', 'slug' => 'tenants'], ['category_name' => 'Police', 'slug' => 'police'],   
            ['category_name' => 'Mortuary', 'slug' => 'mortuary'], ['category_name' => 'Burial', 'slug' => 'burial']
        ];
        foreach ($categories as $category) {
            $category_name = $category['category_name'];
            $slug = $category['slug'];
            echo "
            <div class='col-6 col-sm-4 col-md-3 col-lg-2'>
                <div class='category-box text-center'>
                    <a class='text-decoration-none' href='getstarted?detail=post-contents'><span>{$category_name}</span></a>
                </div>
            </div>";
        }
        ?>
    </div>
</div>
