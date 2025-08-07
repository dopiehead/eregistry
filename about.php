<?php include("engine/checkSession.php") ?>
<html lang="en">
<head>
     <?php @include("components/links.php") ?>
     <link rel="stylesheet" href="assets/css/about.css">
     <title>About</title>
</head>
<body>
<?php @include 'components/navbar.php' ?> 
   
<div class="container my-5">
    <div class="about-section">
        <h2 class="mb-3 text-center text-danger">About eRegistry</h2>
        <p><span class="highlight">eRegistry</span> is a modern, secure, and user-friendly digital platform designed to help individuals and businesses register valuable items using unique serial numbers. Whether it's electronics, jewelry, important documents, appliances, vehicles, or any other personal or commercial asset, <span class="highlight">eRegistry</span> provides a centralized system for recording ownership details, ensuring you have proof in case of loss, theft, or recovery needs.</p>

        <p>At the heart of <span class="highlight">eRegistry</span> is a simple but powerful idea: every item of value comes with a unique identifier—such as a serial number, IMEI, chassis number, or custom code. By registering these identifiers with supporting details, owners create a digital trail of proof that links them to their property.</p>

        <p>In a world where lost or stolen items are difficult to trace, <span class="highlight">eRegistry</span> serves as a digital safeguard. When an item goes missing, users can quickly flag it as “lost” or “stolen,” making it easier for others—buyers, resellers, security agents, or good Samaritans—to verify rightful ownership via the eRegistry lookup.</p>

        <p>The platform is especially helpful for businesses managing inventory, individuals protecting personal assets, or service centers verifying item ownership before repairs or recycling. Users can upload product images, receipts, warranties, and more to create a full record.</p>

        <p><strong>Security</strong> is a top priority. All data is encrypted, and only non-sensitive information is searchable. Ownership remains private unless flagged as lost/stolen.</p>

        <p><span class="highlight">eRegistry</span> is more than a loss-prevention tool—it builds a transparent, trustworthy ecosystem. Secondhand buyers can verify product history. Law enforcement can confirm ownership. Even lost IDs and documents can be verified and reported.</p>

        <div class="text-center mt-4">
            <a href="/getstarted" class="btn btn-primary btn-lg rounded-pill px-4">Start Registering Now</a>
        </div>
    </div>
</div>
    <?php @include 'components/footer.php' ?>   
</body>
</html>