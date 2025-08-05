<?php include("engine/checkSession.php") ?>
<html lang="en">
<head>
     <?php @include("components/links.php") ?>
     <link rel="stylesheet" href="assets/css/faq.css">
    <title>FAQ</title>
</head>
<body>
<?php @include 'components/navbar.php' ?>  

    <div class='faq-home'>

    <div class="faq-container">
        <div class="faq-header">
            <h1 class="faq-title">Frequently asked questions</h1>
            <p class="faq-subtitle">These are the most commonly asked questions about Untitled UI.</p>
            <p class="faq-subtitle">Can't find what you're looking for? <a href="#" class="faq-link">Chat to our friendly team!</a></p>
        </div>

        <div class="filter-tabs">
            <div class="filter-tab active" data-category="all">General</div>
            <div class="filter-tab" data-category="pricing">Pricing</div>
            <div class="filter-tab" data-category="dashboard">Dashboard</div>
            <div class="filter-tab" data-category="api">API</div>
        </div>

        <div class="faq-list">
           <?php
$faqs = [
    [
        'category' => 'general',  'icon' => '😊',   'question' => 'Is there a free trial available?',  'answer' => 'Yes, you can try us for free for 30 days. If you want, we\'ll provide you with a free 30-minute onboarding call to get you up and running. <a href="#" class="faq-link-text">Book a call here.</a>' 
     ],
    [
        'category' => 'pricing',   'icon' => '📋',    'question' => 'Can I change my plan later?',  'answer' => 'Of course! You can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle. Contact our support team if you need assistance with plan changes.'
    ],
    [
        'category' => 'general',   'icon' => '📄',  'question' => 'What is your cancellation policy?', 'answer' => 'You can cancel your subscription at any time. Your cancellation will take effect at the end of your current billing period. You\'ll retain access to all features until then, and we\'ll send you a confirmation email.'
    ],
    [
        'category' => 'dashboard', 'icon' => '👥',  'question' => 'Can other info be added to an invoice?','answer' => 'Yes, you can customize your invoices with additional information such as purchase order numbers, tax IDs, custom billing addresses, and company-specific details through your account settings.'
    ],
    [
        'category' => 'pricing', 'icon' => '💳',  'question' => 'How does billing work?', 'answer' => 'We bill monthly or annually depending on your chosen plan. Billing occurs automatically on the same date each month/year. You\'ll receive an invoice via email, and payments are processed securely through our payment partners.'
    ],
    [
        'category' => 'general', 'icon' => '✉️',  'question' => 'How do I change my account email?', 'answer' => 'You can change your account email in your profile settings. Go to Account Settings > Profile > Email Address. You\'ll need to verify the new email address before the change takes effect.'
    ],
    [
        'category' => 'api',   'icon' => '❓',  'question' => 'How does support work?',  'answer' => 'We offer 24/7 support through multiple channels including live chat, email, and phone. Premium customers get priority support with faster response times and dedicated account managers.'
    ],
    [
        'category' => 'dashboard',  'icon' => '📚',  'question' => 'Do you provide tutorials?',  'answer' => 'Yes! We have an extensive library of video tutorials, written guides, and interactive walkthroughs. You can access them in our Help Center or through the tutorials section in your dashboard.'
    ],
      ];
?>

<?php foreach ($faqs as $faq): ?>
<div class="faq-item" data-category="<?= htmlspecialchars($faq['category']) ?>">
    <div class="faq-question">
        <div class="faq-icon"><?=  htmlspecialchars($faq['icon']) ?></div>
        <div class="faq-question-text"><?= htmlspecialchars($faq['question']) ?></div>
        <div class="expand-icon">+</div>
    </div>
    <div class="faq-answer">
        <div class="faq-answer-text">
            <?= htmlspecialchars($faq['answer']) ?>
        </div>
    </div>
</div>
<?php endforeach; ?>

        </div>
    </div>

    <!-- <button class="chat-button" onclick="openChat()">💬</button> -->
</div>
</div>
    <?php @include 'components/footer.php' ?>
    <script src='assets/js/faq.js'></script>
</body>
</html>