<html lang="en">
<head>
     <?php @include("components/links.php") ?>
     <link rel="stylesheet" href="assets/css/about.css">
     <title>About</title>
</head>
<body>
<?php @include 'components/navbar.php' ?> 
<link rel="stylesheet" href="assets/css/contact.css">
   
<div class="container my-5">
    <div class="contact-section">
        <h2 class="mb-3 text-center text-danger">Contact Us</h2>
</div>
  
     
    <div class="container-fluid">
        <div class="contact-container">
            <div class="row g-0 h-100">
                <!-- Contact Information -->
                <div class="col-lg-5">
                    <div class="contact-content">
                        <h1 class="contact-title">Contact us</h1>
                        <p class="contact-description">
                            We'd love to hear from you. Send us a message and we'll respond as soon as possible. You can also find us on our 
                            <a href="#" class="contact-link">social media</a> 
                            pages if you'd like to contact us there.
                        </p>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="form-section h-100">
                        <form id="contactForm" method="POST" action="#" novalidate>
                            <div class="row">
                                <!-- First Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName" class="form-label">First name*</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name" required>
                                    </div>
                                </div>
                                
                                <!-- Last Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                            </div>
                            
                            <!-- Message -->
                            <div class="form-group">
                                <label for="message" class="form-label">What can we help you with?*</label>
                                <textarea class="form-control" id="message" name="message" placeholder="Tell us about your inquiry..." required></textarea>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" class="submit-btn">
                                <span class="btn-text">Submit</span>
                            </button>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php @include 'components/footer.php' ?>   
</body>
</html>