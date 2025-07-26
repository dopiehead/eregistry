<?php include("engine/checkSession.php") ?>
<html lang="en">
<head>
<?php
 @include("components/links.php");
$links = ['assets/css/hero-section.css','assets/css/categories.css', 'assets/css/navbar.css',
 'assets/css/banner.css', 'assets/css/registries.css', 'assets/css/request.css', 'assets/css/blog-section.css',
'assets/css/video.css', 'assets/css/groups.css', 'assets/css/pride.css'];
foreach ($links as $link) {
echo"<link rel='stylesheet' href='{$link}' >";
}
?>
<title>Home page</title>
</head>
<body> 
   <?php     
    $components = ['components/navbar.php', 'components/hero-section.php', 'components/brands.php', 'components/heading.php', 'components/categories.php',
      'components/banner.php', 'components/about-us.php', 'components/registries.php', 'components/request.php', 'components/blog-section.php', 
      'components/video.php', 'components/groups.php', 'components/pride.php', 'components/footer.php'];
    foreach ($components as $component) {
        @include ($component);
    }
     ?>
</body>
</html>
