<?php include("engine/checkSession.php") ?>
<html lang="en">
<head>
<?php @include("components/links.php") ?>
<?php 
$links = ['assets/css/categories.css','assets/css/navbar.css','assets/css/footer.css']; 
foreach ($links as $link) {
    echo "<link rel='stylesheet' href='{$link}'>";
}
?>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="assets/css/navbar.css">
    
    <title>Categories</title>
</head>
<body>
    <?php include("components/navbar.php") ?>

<div style='margin-top:150px;' class="container mb-5">
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
<?php include("components/footer.php") ?>
</body>
</html>