function previewFile() {
  const preview = document.getElementById('preview');
  const fileName = document.getElementById('file-name');
  const file = document.getElementById('media').files[0];
  const reader = new FileReader();

  fileName.textContent = file ? file.name : '';

  reader.addEventListener("load", function () {
      if (file.type.startsWith('image/')) {
          preview.innerHTML = `<img src="${reader.result}" alt="Preview" class="w-full h-auto rounded-lg"/>`;
      } else if (file.type.startsWith('video/')) {
          preview.innerHTML = `<video controls class="w-full h-auto rounded-lg"><source src="${reader.result}" type="${file.type}">Your browser does not support the video tag.</video>`;
      } else {
          preview.innerHTML = `<p class="text-gray-600">File preview not available</p>`;
      }
  }, false);

  if (file) {
      reader.readAsDataURL(file);
  }
}