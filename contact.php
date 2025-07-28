<?php include("engine/checkSession.php") ?>
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
                            <div class="row g-3">
                                <?php
                                $fields = [
                                    [
                                        "label" => "First name*",  "type" => "text", "id" => "firstName", "name" => "firstName",
                                        "placeholder" => "Enter your first name", "required" => true, "col" => "col-md-6"
                                    ],
                                    [
                                        "label" => "Last name",  "type" => "text", "id" => "lastName",
                                        "name" => "lastName", "placeholder" => "Enter your last name", "required" => false, "col" => "col-md-6"
                                    ],
                                    [
                                        "label" => "Email*", "type" => "email",  "id" => "email",
                                        "name" => "email", "placeholder" => "Enter your email address", "required" => true, "col" => "col-12"
                                    ],

                                    [
                                        "label" => "Subject*", "type" => "text",  "id" => "subject",
                                        "name" => "subject", "placeholder" => "Enter message heading", "required" => true, "col" => "col-12"
                                    ],
                                    [
                                        "label" => "What can we help you with?*",  "type" => "textarea", "id" => "message",
                                        "name" => "message",  "placeholder" => "Tell us about your inquiry...",  "required" => true,  "col" => "col-12"
                                    ]
                                ];

                                foreach ($fields as $field): ?>
                                    <div class="<?= $field['col'] ?>">
                                        <div class="form-group">
                                            <label for="<?= $field['id'] ?>" class="form-label"><?= $field['label'] ?></label>
                                            <?php if ($field['type'] === 'textarea'): ?>
                                                <textarea
                                                    class="form-control"
                                                    id="<?= $field['id'] ?>"
                                                    name="<?= $field['name'] ?>"
                                                    placeholder="<?= $field['placeholder'] ?>"
                                                    <?= $field['required'] ? 'required' : '' ?>
                                                ></textarea>
                                            <?php else: ?>
                                                <input
                                                    type="<?= $field['type'] ?>"
                                                    class="form-control"
                                                    id="<?= $field['id'] ?>"
                                                    name="<?= $field['name'] ?>"
                                                    placeholder="<?= $field['placeholder'] ?>"
                                                    <?= $field['required'] ? 'required' : '' ?>
                                                />
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <span id="responseMessage"></span>
                            <!-- Submit Button -->
                            <button type="submit" class="submit-btn mt-3">
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
<script src="assets/js/contact.js"></script>
<?php @include 'components/footer.php' ?>   
</body>
</html>
