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

<label class='mt-3' for="">Others<span> (Please specify*)</span></label>
<input type="text" name='category' class='form-control'>

                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Registry name</label>
                                <input type="text" class="form-control" placeholder="..Enter registration name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Registration Description</label>
                                <div class="text-editor-toolbar">
                  
                                    <?php $buttons = [ 'fa-bold','fa-italic','fa-underline','fa-list-ul','fa-list-ol' ];
                                     foreach ($buttons as $button) { ?>
                                         <button type="button" class="btn btn-sm btn-outline-secondary me-1"><i class="fas <?= htmlspecialchars($button) ?>"></i></button>
                                    <?php }
                                     ?>
      
                                </div>
                                <textarea class="form-control text-editor" rows="8" placeholder="... Write details about registration name">[Additional text content from image]</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Category Section -->
                   <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="section-title">Daily Quotes</h5>
                            
                            <div class="mb-3">
                
                            
                                    <textarea class="form-select" name="quotes" id="quotes" placeholder="...Write quote"></textarea>
                              
                            </div>
                           
                        </div>
                    </div>

                    <!-- Inventory Section -->
                    <!-- <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="section-title">Inventory</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" value="1020">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">SKU/Barcode</label>
                                    <input type="text" class="form-control" value="UPC-PR-PB-DR">
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Product Images Section -->
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
                                <input type="file" id="fileElem" name="file" multiple accept=".pdf, .doc, .docx, image/*" style="display:none" />
                                <button class='border-0 bg-secondary text-white' onclick="document.getElementById('fileElem').click()"> <i class='fas fa-file'></i> Browse</button>
                                
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
                        <button class="btn btn-outline-secondary flex-fill">Discard</button>
                        
                        <button class="btn btn-primary">Add Registry</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


<script>
const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('fileElem');

// Prevent default behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
  dropArea.addEventListener(eventName, (e) => e.preventDefault(), false);
});

// Highlight on drag
['dragenter', 'dragover'].forEach(eventName => {
  dropArea.classList.add('highlight');
});
['dragleave', 'drop'].forEach(eventName => {
  dropArea.classList.remove('highlight');
});

// Handle file drop
dropArea.addEventListener('drop', (e) => {
  const files = e.dataTransfer.files;
  handleFiles(files);
});

// Handle file input change
fileInput.addEventListener('change', () => {
  handleFiles(fileInput.files);
});

// Main handler
function handleFiles(files) {
  const preview = document.getElementById('preview');
  preview.innerHTML = ""; // Clear previous previews

  const formData = new FormData();

  Array.from(files).forEach((file, index) => {
    const fileName = file.name;
    const fileType = file.type;
    const fileExt = fileName.split('.').pop().toLowerCase();

    formData.append('files[]', file);

    const fileBox = document.createElement("div");
    fileBox.style.marginBottom = "15px";

    if (fileType.startsWith("image/")) {
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      img.style.maxWidth = "200px";
      img.style.borderRadius = "6px";
      fileBox.appendChild(img);
    } else if (fileType === "application/pdf") {
      const embed = document.createElement("embed");
      embed.src = URL.createObjectURL(file);
      embed.type = "application/pdf";
      embed.width = "100%";
      embed.height = "400px";
      fileBox.appendChild(embed);
    } else if (fileExt === "doc" || fileExt === "docx") {
      const icon = document.createElement("div");
      icon.innerHTML = `<strong>📄 ${fileName}</strong>`;
      icon.style.padding = "10px";
      icon.style.background = "#f0f0f0";
      icon.style.border = "1px solid #ccc";
      icon.style.borderRadius = "4px";
      fileBox.appendChild(icon);
    } else {
      fileBox.innerHTML = `<strong>Unsupported file: ${fileName}</strong>`;
    }

    preview.appendChild(fileBox);
  });

  // Upload to server
  fetch("upload.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(data => console.log("Server response:", data))
  .catch(err => console.error("Upload error:", err));
}
</script>

</body>
</html>