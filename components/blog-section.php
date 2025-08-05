<section class="blog-section py-5">
    <div class="container">
        <!-- Blog Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="blog-title mb-0 fw-bold">Latest Blogs</h2>
            <a href="#" class="text-decoration-none text-danger fw-semibold">See All</a>
        </div>

        <!-- Blog Cards -->
        <div class="row g-4">
            <?php
            $blogs = [
                [
                    'date' => 'February 28, 2024',
                    'author' => 'Admin',
                    'title' => 'How to Safeguard Your Property Digitally',
                    'image' => 'assets/img/blog/blog1.avif',
                    'link' => '#'
                ],
                [
                    'date' => 'February 28, 2024',
                    'author' => 'Admin',
                    'title' => 'Top 5 Registry Services You Should Know',
                    'image' => 'assets/img/blog/blog2.jpeg',
                    'link' => '#'
                ],
                [
                    'date' => 'February 28, 2024',
                    'author' => 'Admin',
                    'title' => 'Why You Should Register a Will Early',
                    'image' => 'assets/img/blog/blog3.jpg',
                    'link' => '#'
                ]
            ];

            foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card border shadow-sm rounded overflow-hidden h-100">
                        <div class="blog-image" style="
                            background-image: url('<?= htmlspecialchars($blog['image']) ?>');
                            background-size: cover;
                            background-position: center;
                            height: 200px;
                        " loading="lazy"></div>
                        <div class="p-3 blog-content d-flex flex-column justify-content-between h-100">
                            <div>
                                <div class="blog-meta d-flex justify-content-between text-muted mb-2">
                                    <small><i class="far fa-calendar-alt me-1"></i><?= htmlspecialchars($blog['date']) ?></small>
                                    <small><i class="far fa-user me-1"></i><?= strtoupper(htmlspecialchars($blog['author'])) ?></small>
                                </div>
                                <h5 class="fw-semibold mb-3"><?= htmlspecialchars($blog['title']) ?></h5>
                            </div>
                            <a href="<?= htmlspecialchars($blog['link']) ?>" class="text-danger text-decoration-none mt-auto fw-medium">
                                Read More <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
