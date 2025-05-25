  <script>
      // Dropdown profil toggle
      // sudah di simpan di tempalte nav

      // Dropdown Start Analyze button
      const startBtn = document.getElementById('btnstartAnalyzeBtn');
      const analyzeDropdown = document.getElementById('analyzeDropdown');

      startBtn.addEventListener('click', () => {
          analyzeDropdown.classList.toggle('show');
          // Aria attribute for accessibility
          const expanded = startBtn.getAttribute('aria-expanded') === 'true';
          startBtn.setAttribute('aria-expanded', !expanded);
      });

      // Close dropdown if click outside for analyze dropdown
      window.addEventListener('click', e => {
          if (!startBtn.contains(e.target) && !analyzeDropdown.contains(e.target)) {
              analyzeDropdown.classList.remove('show');
              startBtn.setAttribute('aria-expanded', false);
          }
      });


      document.addEventListener('DOMContentLoaded', function() {
          // Ambil referensi elemen-elemen penting
          const video = document.getElementById('video');
          const previewImage = document.getElementById('previewImage');
          const startCameraBtn = document.getElementById('startCamera');
          const capturePhotoBtn = document.getElementById('capturePhoto');
          const cameraOption = document.getElementById('cameraOption');
          const galleryOption = document.getElementById('galleryOption');
          const inputGallery = document.getElementById('inputGallery');
          const removePreviewBtn = document.getElementById('removePreviewBtn');
          const startAnalyzeBtn = document.getElementById('startAnalyzeBtn');
          const cameraIcon = document.querySelector('.camera-icon');
          const scanForm = document.getElementById('scanForm');


          // Fungsi untuk mereset semua state
          function resetStates() {
              // Hentikan stream video jika aktif
              if (video.srcObject) {
                  const tracks = video.srcObject.getTracks();
                  tracks.forEach(track => track.stop());
              }

              // Reset tampilan video dan preview
              video.style.display = 'none';
              previewImage.style.display = 'none';
              previewImage.src = '';
              removePreviewBtn.style.display = 'none';
              cameraIcon.style.display = 'block';

              // Reset tombol-tombol
              startCameraBtn.style.display = 'block';
              capturePhotoBtn.style.display = 'none';

              // Reset input file
              inputGallery.value = '';

              // Nonaktifkan tombol analisis
              startAnalyzeBtn.disabled = true;

              // Nonaktifkan pilihan radio
              cameraOption.checked = false;
              galleryOption.checked = false;
          }
          // Fungsi memulai kamera
          function startCamera() {
              // Konfigurasi constraint kamera
              const constraints = {
                  video: {
                      width: {
                          ideal: 300
                      },
                      height: {
                          ideal: 300
                      },
                      facingMode: 'user'
                  }
              };

              // Minta akses kamera
              navigator.mediaDevices.getUserMedia(constraints)
                  .then(function(stream) {
                      video.srcObject = stream;
                      video.play();

                      // Sembunyikan ikon kamera, tampilkan video
                      cameraIcon.style.display = 'none';
                      video.style.display = 'block';
                      previewImage.style.display = 'none';

                      // Update tampilan tombol
                      startCameraBtn.style.display = 'none';
                      capturePhotoBtn.style.display = 'block';
                      removePreviewBtn.style.display = 'none';

                      // Nonaktifkan tombol analisis
                      startAnalyzeBtn.disabled = true;

                      // Pastikan opsi kamera dipilih
                      cameraOption.checked = true;
                      galleryOption.checked = false;
                  })
                  .catch(function(err) {
                      console.error("Kesalahan kamera: ", err);
                      alert("Gagal mengakses kamera: " + err.message);
                  });
          }

          // Fungsi untuk menangkap foto
          function capturePhoto() {
              // Periksa apakah video siap
              if (video.videoWidth === 0 || video.videoHeight === 0) {
                  alert("Kamera belum siap. Silakan coba lagi.");
                  return;
              }

              // Buat kanvas untuk menangkap foto
              const canvas = document.createElement('canvas');
              canvas.width = video.videoWidth;
              canvas.height = video.videoHeight;
              const context = canvas.getContext('2d');
              context.drawImage(video, 0, 0, canvas.width, canvas.height);

              // Ambil URL data gambar (pratinjau)
              const imageDataURL = canvas.toDataURL('image/png');
              previewImage.src = imageDataURL;

              // Hentikan stream video
              const tracks = video.srcObject.getTracks();
              tracks.forEach(track => track.stop());

              // Update tampilan
              video.style.display = 'none';
              previewImage.style.display = 'block';
              cameraIcon.style.display = 'none';
              capturePhotoBtn.style.display = 'none';
              removePreviewBtn.style.display = 'block';
              startCameraBtn.style.display = 'block';

              // Siapkan file untuk diunggah
              canvas.toBlob(function(blob) {
                  const file = new File([blob], 'captured_image.png', {
                      type: 'image/png'
                  });

                  // Hapus input tersembunyi sebelumnya jika ada
                  const inputExisting = scanForm.querySelector('input[name="image"]');
                  if (inputExisting) {
                      inputExisting.remove();
                  }

                  // Buat input gambar baru
                  const hiddenInput = document.createElement('input');
                  hiddenInput.type = 'file';
                  hiddenInput.name = 'image'; // Pastikan tetap 'image'
                  hiddenInput.style.display = 'none';

                  // Tambahkan file ke input
                  const dataTransfer = new DataTransfer();
                  dataTransfer.items.add(file);
                  hiddenInput.files = dataTransfer.files;

                  // Tambahkan ke form
                  scanForm.appendChild(hiddenInput);

                  // Aktifkan tombol analisis
                  startAnalyzeBtn.disabled = false; // Pastikan tombol diaktifkan di sini
              }, 'image/png');
          }
          // Fungsi untuk menangani perubahan pilihan unggah
          function handleUploadTypeChange() {
              resetStates();

              if (cameraOption.checked) {
                  // Jika opsi kamera dipilih
                  startCameraBtn.style.display = 'block';
                  cameraIcon.style.display = 'block';
              } else if (galleryOption.checked) {
                  // Jika opsi galeri dipilih
                  inputGallery.click();
              }
          }


          // Tambahkan event listener untuk radio button
          cameraOption.addEventListener('change', handleUploadTypeChange);
          galleryOption.addEventListener('change', handleUploadTypeChange);
          // Tambahkan event listener untuk tombol
          startCameraBtn.addEventListener('click', startCamera);
          capturePhotoBtn.addEventListener('click', capturePhoto);

          // Pratinjau gambar dari galeri
          inputGallery.addEventListener('change', function(e) {
              const file = e.target.files[0];
              if (file) {
                  const reader = new FileReader();
                  reader.onload = function(event) {
                      // Tampilkan pratinjau
                      previewImage.src = event.target.result;
                      previewImage.style.display = 'block';
                      cameraIcon.style.display = 'none';
                      removePreviewBtn.style.display = 'block';
                      startAnalyzeBtn.disabled = false;

                      // Pastikan opsi galeri dipilih
                      galleryOption.checked = true;
                      cameraOption.checked = false;

                      // Sembunyikan kontrol kamera
                      startCameraBtn.style.display = 'none';
                      capturePhotoBtn.style.display = 'none';

                      // Siapkan file untuk diunggah
                      const hiddenInput = document.createElement('input');
                      hiddenInput.type = 'file';
                      hiddenInput.name = 'uploadedImage';
                      hiddenInput.style.display = 'none';

                      // Tambahkan file ke input
                      const dataTransfer = new DataTransfer();
                      dataTransfer.items.add(file);
                      hiddenInput.files = dataTransfer.files;

                      // Hapus input tersembunyi sebelumnya jika ada
                      const inputExisting = scanForm.querySelector('input[name="uploadedImage"]');
                      if (inputExisting) {
                          inputExisting.remove();
                      }

                      // Tambahkan ke form
                      scanForm.appendChild(hiddenInput);
                  }
                  reader.readAsDataURL(file);
              }
          });
          // Tombol untuk memilih gambar dari galeri
          galleryOption.addEventListener('click', function() {
              inputGallery.click();
          });
          // Tombol hapus pratinjau
          removePreviewBtn.addEventListener('click', function() {
              resetStates();

              inputGallery.value = '';

              // Hapus input tersembunyi jika ada
              const hiddenInput = scanForm.querySelector('input[name="uploadedImage"]');
              if (hiddenInput) {
                  hiddenInput.remove();
              }
          });

          // Tombol mulai analisis
          startAnalyzeBtn.addEventListener('click', function() {
              const imageInput = document.querySelector('input[name="image"]'); // Mencari input 'image'
              const previewImage = document.getElementById('previewImage');

              // Validasi input gambar
              if (!imageInput || !imageInput.files.length) {
                  alert('Silakan pilih gambar terlebih dahulu');
                  return;
              }

              // Kirim FormData
              scanForm.submit(); // Mengirim form
          });

          function sendImageToServer(formData) {
              // Tambahkan indikator loading
              const startAnalyzeBtn = document.getElementById('startAnalyzeBtn');
              startAnalyzeBtn.disabled = true;
              startAnalyzeBtn.textContent = 'Sedang Menganalisis...';

              fetch('{{ route('scan.upload') }}', {
                      method: 'POST',
                      body: formData,
                      headers: {
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                      }
                  })
                  .then(response => {
                      // Cek status respons
                      if (!response.ok) {
                          return response.text().then(errorData => {
                              throw new Error(errorData || 'Gagal mengunggah gambar');
                          });
                      }
                      return response.json(); // Selalu kembalikan JSON untuk permintaan sukses
                  })
                  .then(data => {
                      startAnalyzeBtn.disabled = false;
                      startAnalyzeBtn.textContent = 'Start Analyze';

                      if (data.success) {
                          // Update tampilan rekomendasi produk
                          const recommendationSection = document.getElementById('recommendationSection');
                          const skinTypeResult = document.getElementById('skinTypeResult');
                          const productRecommendations = document.getElementById('productRecommendations');

                          skinTypeResult.textContent = `Hasil Analisis: Kulit ${data.skin_type}`;
                          productRecommendations.innerHTML = '';

                          data.recommended_products.forEach(product => {
                              const productItem = document.createElement('div');
                              productItem.classList.add('product-item');
                              productItem.innerHTML = `
                                <div class="product-info">
                                    <h4>${product.nama}</h4>
                                    <div class="brand">${product.brand}</div>
                                    <div class="price">Rp. ${product.harga.toLocaleString('id-ID')}</div>
                                    <div class="desc">${product.deskripsi}</div>
                                </div>
                            `;
                              productRecommendations.appendChild(productItem);
                          });

                          recommendationSection.style.display = 'block';
                      } else {
                          throw new Error(data.message || 'Gagal melakukan analisis');
                      }
                  })
                  .catch(error => {
                      startAnalyzeBtn.disabled = false;
                      startAnalyzeBtn.textContent = 'Start Analyze';
                      console.error('Kesalahan:', error);
                      alert(error.message || 'Terjadi kesalahan saat mengunggah');
                  });
          }
          // Tambahkan event listener untuk radio button
          document.getElementById('galleryOption').addEventListener('change', function() {
              if (this.checked) {
                  document.getElementById('inputGallery').click();
              }
          });

          // Event listener untuk input file
          document.getElementById('inputGallery').addEventListener('change', function(e) {
              const file = e.target.files[0];
              if (file) {
                  const reader = new FileReader();
                  reader.onload = function(event) {
                      const previewImage = document.getElementById('previewImage');
                      previewImage.src = event.target.result;
                      previewImage.style.display = 'block';

                      // Aktifkan tombol Start Analyze
                      document.getElementById('startAnalyzeBtn').disabled = false;

                      // Pastikan radio button gallery terpilih
                      document.getElementById('galleryOption').checked = true;
                  }
                  reader.readAsDataURL(file);
              }
          });

          function displayRecommendations(data) {
              const recommendationSection = document.getElementById('recommendationSection');
              const skinTypeResult = document.getElementById('skinTypeResult');
              const productRecommendations = document.getElementById('productRecommendations');

              // Tampilkan tipe kulit
              skinTypeResult.textContent = `Analysis Results: ${data.skin_type} Skin`;

              // Bersihkan rekomendasi produk sebelumnya
              productRecommendations.innerHTML = '';

              // Tampilkan produk yang direkomendasikan
              data.recommended_products.forEach(product => {
                  const productItem = document.createElement('div');
                  productItem.classList.add('product-item');
                  productItem.innerHTML = `
                    <svg class="product-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M9 2v2h6V2H9zM17 4h-2v16h2V4zm-8 0h-2v16h2V4zM5 5H3v15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5h-2v12H5V5z" />
                    </svg>
                    <div class="product-info">
                        <h4>${product.nama}</h4>
                        <div class="brand">${product.brand}</div>
                        <div class="price">Rp. ${product.harga.toLocaleString('id-ID')}</div>
                        <div class="desc">${product.deskripsi}</div>
                    </div>
                    <div class="product-arrow">&#8594;</div>
                `;
                  productRecommendations.appendChild(productItem);
              });

              // Tampilkan bagian rekomendasi
              recommendationSection.style.display = 'block';
          }
      });
  </script>
