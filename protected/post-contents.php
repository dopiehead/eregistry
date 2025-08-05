<?php include("contents/permission.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add new content</title>
    <?php @include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/contents.css">
    <link rel="stylesheet" href="../assets/css/protected/post-contents.css">
</head>
<body>
    <!-- Sidebar -->
    <?php @include("components/sidebar.php") ?>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php @include("components/topbar.php") ?>

        <div class="container-fluid">
            <div class="form-container">

                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-arrow-left me-3 text-muted"></i>
                    <h4 class="mb-0">Add New Registration</h4>
                </div>

                <!-- ✅ START FORM -->
                <form id="submit-registry" enctype="multipart/form-data">

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <!-- Description Section -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="section-title">Description</h5>

                                <div class="mb-3">
                                    <label class="form-label">Registry type</label>

                                    <?php
                                    $categories = [
                                        'vehicle', 'property', 'death', 'birth', 'court',
                                        'divorce', 'marriage', 'job', 'tenants', 'police',
                                        'mortuary', 'burial'
                                    ];
                                    ?>

                                    <select class="form-control text-capitalize" name="category">
                                        <option value="">Select category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= htmlspecialchars($category) ?>">
                                                <?= htmlspecialchars(ucfirst($category)) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <label class='mt-3'>Others<span> (Please specify*)</span></label>
                                    <input type="text" name='other_category' class='form-control'>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Registry name</label>
                                    <input type="text" class="form-control" name="registry_name" placeholder="..Enter registration name">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Registration Description</label>
                                    <div class="text-editor-toolbar">
                                        <?php 
                                        $buttons = ['fa-bold','fa-italic','fa-underline','fa-list-ul','fa-list-ol'];
                                        foreach ($buttons as $button) { ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1">
                                                <i class="fas <?= htmlspecialchars($button) ?>"></i>
                                            </button>
                                        <?php } ?>
                                    </div>
                                    <textarea class="form-control text-editor" name="registry_description" rows="8" placeholder="... Write details about registration name"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Quotes Section -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="section-title">Daily Quotes</h5>
                                <div class="mb-3">
                                    <textarea class="form-control" name="quotes" id="quotes" placeholder="...Write quote"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Image/File Upload Section -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="section-title mb-0">Add Images / Files</h5>
                                    <i class="fas fa-info-circle text-muted"></i>
                                </div>

                                <div id='drop-area' class="image-upload-area">
                                    <div class="image-upload-icon">
                                        <i class="fas fa-camera text-muted"></i>
                                    </div>
                                    <p class="text-muted mb-2">Click to upload or</p>
                                    <p class="text-muted small">Drag file here</p>
                                    <input type="file" id="fileElem" name="files[]" multiple accept=".pdf, .doc, .docx, image/*" style="display:none" />
                                    <button type="button" class='border-0 bg-secondary text-white' onclick="document.getElementById('fileElem').click()"> 
                                        <i class='fas fa-file'></i> Browse
                                    </button>
                                </div>

                                <div class="product-images">
                                    <div class="position-relative">
                                        <div class='preview' id="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="reset" id='discard' class="btn btn-outline-secondary flex-fill">Discard</button>
                            <button type="submit" class="btn btn-primary">Add Registry</button>
                        </div>
                    </div>
                </div>

                </form> <!-- ✅ END FORM -->

            </div>
        </div>
    </div>

    <script src="../assets/js/post-contents.js"></script>
</body>
</html> 
