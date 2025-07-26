<html lang="en">
<head>
     <?php @include("components/links.php") ?>
     <link rel="stylesheet" href="assets/css/forms.css">
     <title>About</title>
</head>
<body class='bg-light'>
<?php @include 'components/navbar.php' ?>  
<div class="container my-5 d-flex justify-content-center ">
    <div class='px-2 py-3  rounded bg-white shadow-lg'>
        <form action="">
            <div>
             <label for="name" class='mb-2'> 
                 <span class='fw-bold'> Full Name</span> 
                 <span class='text-danger fs-6'>**</span>
             </label> 
             <input type="text" class='form-control'>
             <div class='mt-4'>
                <button class='btn'><span id='submit-note' class='submit-note rounded rounded-pill'>Submit</span></button>
             </div>
            </div>
        </form>
    </div>
</div>
    <?php @include 'components/footer.php' ?>   
</body>
</html>