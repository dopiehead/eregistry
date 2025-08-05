
// ---- Safe element lookups
const dropArea  = document.getElementById('drop-area');
const fileInput = document.getElementById('fileElem');
const previewEl = document.getElementById('preview');

// Exit early if essentials are missing
if (dropArea && fileInput && previewEl) {
  // ---- Prevent default behaviors on DnD
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, (e) => {
      e.preventDefault();
      e.stopPropagation();
    }, false);
  });

  // ---- Highlight on dragenter/dragover, remove on dragleave/drop
  ['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
  });
  ['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
  });

  // ---- Handle file drop
  dropArea.addEventListener('drop', (e) => {
    const files = e.dataTransfer && e.dataTransfer.files ? e.dataTransfer.files : [];
    handleFiles(files);
  });

  // ---- Handle file input change
  fileInput.addEventListener('change', () => {
    handleFiles(fileInput.files || []);
  });

  // ---- Main handler
  function handleFiles(files) {
    // Clear previous previews
    previewEl.innerHTML = "";

    const formData = new FormData();

    Array.from(files).forEach((file) => {
      const fileName = file.name;
      const fileType = file.type || '';
      const fileExt  = (fileName.split('.').pop() || '').toLowerCase();

      formData.append('files[]', file);

      const fileBox = document.createElement("div");
      fileBox.style.marginBottom = "15px";

      if (fileType.startsWith("image/")) {
        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = "200px";
        img.style.borderRadius = "6px";
        img.onload = () => URL.revokeObjectURL(img.src); // cleanup
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

      previewEl.appendChild(fileBox);
    });

    // ---- Upload to server
    fetch("submit-registry", {
      method: "POST",
      body: formData
    })
    .then(async (res) => {
      // Try parse JSON; if server sends HTML/php errors, show as text
      const text = await res.text();
      try {
        return JSON.parse(text);
      } catch {
        throw new Error(text || "Invalid server response");
      }
    })
    .then((data) => {
      console.log("Server response:", data);
      if (data.success) {
        swal("Success", data.message || "Uploaded successfully", "success");
      } else {
        swal("Error", data.message || "Upload failed", "error");
      }
    })
    .catch((err) => {
      swal("Error", err.message || "Something went wrong!", "error");
    });
  }
}

// ---- Reset / Discard with confirmation (jQuery + SweetAlert)
$(document).on("click", "#discard", function () {
  swal({
    title: "Are you sure?",
    text: "This will reset the entire form and remove uploaded files.",
    icon: "warning",
    buttons: ["Cancel", "Yes, reset it!"],
    dangerMode: true,
  }).then((willReset) => {
    if (willReset) {
      const form = document.getElementById('submit-registry');
      if (form) form.reset();

      const fileEl = document.getElementById('fileElem');
      if (fileEl) fileEl.value = "";

      const preview = document.getElementById('preview');
      if (preview) preview.innerHTML = "";

      const area = document.getElementById('drop-area');
      if (area) area.classList.remove('highlight');

      swal("Reset Successful", "Form and files have been cleared.", "success");
    }
  });
});

