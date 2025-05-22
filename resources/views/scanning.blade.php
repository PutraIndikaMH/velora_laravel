<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scanning</title>

</head>

<body>
    <nav>
        <div class="logo">VELORA</div>
        <ul>
            <li><a href="{{route('home')}}">Home</a></li>
            <li class="active"><a href="{{route('scanning')}}">Scanning</a></li>
            <li><a href="{{route('services')}}">Services</a></li>
            <li><a href="{{route('about')}}">About Us</a></li>
            <li class="dropdown">
                <button class="dropdown-button" id="profile-button">Profil</button>
                <div class="dropdown-content" id="profile-menu">
                    <a href="{{route('history')}}">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 5.5A6.5 6.5 0 1 0 18.5 12 6.508 6.508 0 0 0 12 5.5zM12 15a9 9 0 0 1-8.66-6.11l-1.85 1.15A11.986 11.986 0 0 0 12 17a11.986 11.986 0 0 0 10.51-5.96l-1.85-1.15A9 9 0 0 1 12 15zm0 4a1 1 0 1 0 1 1 1 1 0 0 0-1-1z" />
                        </svg>
                        History
                    </a>
                    <a href="#">
                        <svg viewBox="0 0 24 24">
                            <path d="M7 10v4h10v-4H7zm-4 8h18v2H3v-2zM3 4h18v2H3V4zm0 6h18v2H3v-2z" />
                        </svg>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <main id="scanning-page">
        <div class="scan-box" aria-label="Face scanning area">
           <div class="camera-preview">
                <svg class="camera-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M20 5h-3.17l-1.83-2H9L7.17 5H4a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zM12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path>
                </svg>
                <video id="video" width="300" height="300" autoplay playsinline style="display:none;"></video>
                <img id="previewImage" style="display:none; width: 100%; height: 100%; object-fit: cover;">
                <button id="removePreviewBtn" class="remove-preview-btn" style="display:none;">✕</button>
            </div>
        </div>

        <div class="upload-container">
            <form id="scanForm" enctype="multipart/form-data">
                @csrf
                <div class="upload-header">
                    <h2>Upload Gambar</h2>
                    <p>Silakan pilih gambar wajah Anda untuk analisis kulit.</p>
                </div>
                <div class="upload-options">
                    <label class="upload-option">
                        <input type="radio" name="uploadType" value="gallery" id="galleryOption">
                        Choose from library
                    </label>

                    <label class="upload-option">
                        <input type="radio" name="uploadType" value="camera" id="cameraOption">
                        Take selfie
                    </label>
                </div>

                <input type="file" name="image" id="inputGallery" accept="image/*" style="display:none;">

                 <div class="preview-container">
                        <div class="preview-wrapper">
                            <img id="previewImage" src="" class="preview-image">
                            <button type="button" id="removePreviewBtn" class="remove-preview-btn" style="display:none;">✕</button>
                        </div>
                    </div>

                <div class="camera-controls">
                    <button type="button" id="startCamera" style="display:none;">Start Camera</button>
                    <button type="button" id="capturePhoto" style="display:none;">Capture Photo</button>
                    <button type="button" id="removePreviewBtn" style="display:none;">Hapus Pratinjau</button>
                </div>

                <div class="analyze-controls" style="text-align: center; margin-top: 15px;">
                    <button type="button" id="startAnalyzeBtn" class="analyze-btn" disabled>
                        Start Analyze
                    </button>
                </div>
            </form>
        </div>




        <section class="recommendation" id="recommendationSection" aria-label="Analysis results and recommended products">
            <div class="title" id="recommendationSection">Analysis Results </div>

            <p>Recommended Products</p>
            <div id="productRecommendations">
                <!-- Produk akan dimasukkan secara dinamis via JavaScript -->
            </div>

           <!-- <div class="product-item" tabindex="0" role="button"
                aria-label="Hydrating Cleanser from CleanCare, gentle daily cleanser for dry skin">
                <svg class="product-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M9 2v2h6V2H9zM17 4h-2v16h2V4zm-8 0h-2v16h2V4zM5 5H3v15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5h-2v12H5V5z" />
                </svg>
                <div class="product-info">
                    <h4>Hydrating Cleanser</h4>
                    <div class="brand">CleanCare</div>
                    <div class="price">Rp. xxx.xxx</div>
                    <div class="desc">Gentle daily cleanser for dry skin</div>
                </div>
                <div class="product-arrow">&#8594;</div>
            </div>-->

            <!--<div class="product-item" tabindex="0" role="button"
               aria-label="Moisture Boost Serum from DermaCare, intensive hydrating serum with hyaluronic acid">
                <svg class="product-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M9 2v2h6V2H9zM17 4h-2v16h2V4zm-8 0h-2v16h2V4zM5 5H3v15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5h-2v12H5V5z" />
                </svg>
                <div class="product-info">
                    <h4>Moisture Boost Serum</h4>
                    <div class="brand">DermaCare</div>
                    <div class="price">Rp. xxx.xxx</div>
                    <div class="desc">Intensive hydrating serum with hyaluronic acid</div>
                </div>
                <div class="product-arrow">&#8594;</div>
            </div>

            <div class="product-item" tabindex="0" role="button"
                aria-label="Barrier Repair Cream from SkinHealth, rich moisturizer for dry skin repair">
                <svg class="product-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M17 2H7a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM7 20V4h10v16H7z" />
                </svg>
                <div class="product-info">
                    <h4>Barrier Repair Cream</h4>
                    <div class="brand">SkinHealth</div>
                    <div class="price">Rp. xxx.xxx</div>
                    <div class="desc">Rich moisturizer for dry skin repair</div>
                </div>
                <div class="product-arrow">&#8594;</div>
            </div>-->
        </section>

        <section class="chat-section" aria-label="Consultation chat bot">
            <p>Apakah anda memerlukan konsultasi lebih lanjut? Klik Chat bot dibawah ini</p>
            <a href="{{route('services')}}" class="chat-btn" aria-label="Chat Bot Button">Chat Bot</a>
            <div class="chat-feedback" aria-live="polite" aria-atomic="true">
                Kami ingin mendengar dari Anda! Klik tombol di samping ini untuk memberikan saran
               <a href="{{route('about')}}"> <img src="icons/feedback-svgrepo-com.svg" alt="Feedback Icon" class="feedback-icon" />  </a>
            </div>
        </section>


        <script>
            // Dropdown profil toggle
            const profileBtn = document.getElementById('profile-button');
            const profileMenu = document.getElementById('profile-menu');
            const dropdownLi = profileBtn.parentElement;

            profileBtn.addEventListener('click', () => {
                dropdownLi.classList.toggle('show');
            });

            // Close dropdown if click outside
            window.addEventListener('click', e => {
                if (!dropdownLi.contains(e.target)) {
                    dropdownLi.classList.remove('show');
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
                width: { ideal: 300 },
                height: { ideal: 300 },
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

        // Ambil URL data gambar
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

        // Aktifkan tombol analisis
        startAnalyzeBtn.disabled = false;

        // Siapkan file untuk diunggah
        canvas.toBlob(function(blob) {
            const file = new File([blob], 'foto_tersimpan.png', { type: 'image/png' });

            // Hapus input tersembunyi sebelumnya jika ada
            const inputExisting = scanForm.querySelector('input[name="capturedImage"]');
            if (inputExisting) {
                inputExisting.remove();
            }

            // Buat input tersembunyi baru
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'file';
            hiddenInput.name = 'capturedImage';
            hiddenInput.style.display = 'none';

            // Tambahkan file ke input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            hiddenInput.files = dataTransfer.files;

            // Tambahkan ke form
            scanForm.appendChild(hiddenInput);

            // Pastikan opsi kamera dipilih
            cameraOption.checked = true;
            galleryOption.checked = false;
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
   document.getElementById('startAnalyzeBtn').addEventListener('click', function() {
    const imageInput = document.getElementById('inputGallery');
    const previewImage = document.getElementById('previewImage');

    // Validasi input gambar
    if (!imageInput.files.length && !previewImage.src) {
        alert('Silakan pilih gambar terlebih dahulu');
        return;
    }

    // Buat FormData
    const formData = new FormData();

    // Tambahkan gambar dari input file atau convert preview image
    if (imageInput.files.length) {
        formData.append('image', imageInput.files[0]);
    } else if (previewImage.src) {
        // Konversi data URL ke blob
        fetch(previewImage.src)
        .then(res => res.blob())
        .then(blob => {
            // Buat File dari blob
            const file = new File([blob], 'captured_image.png', { type: 'image/png' });
            formData.append('image', file);

            // Lakukan upload
            sendImageToServer(formData);
        });
        return;
    }

    // Lakukan upload langsung jika dari input file
    sendImageToServer(formData);
});

     function sendImageToServer(formData) {
    // Tambahkan indikator loading
    const startAnalyzeBtn = document.getElementById('startAnalyzeBtn');
    startAnalyzeBtn.disabled = true;
    startAnalyzeBtn.textContent = 'Sedang Menganalisis...';

    fetch('{{ route("scan.upload") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        // Cek status response
        if (!response.ok) {
            // Tangkap pesan error dari server
            return response.json().then(errorData => {
                throw new Error(errorData.message || 'Gagal mengunggah gambar');
            });
        }
        return response.json();
    })
    .then(data => {
        // Kembalikan status tombol
        startAnalyzeBtn.disabled = false;
        startAnalyzeBtn.textContent = 'Start Analyze';

        if (data.success) {
            // Tampilkan hasil analisis (sama seperti sebelumnya)
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
        // Kembalikan status tombol
        startAnalyzeBtn.disabled = false;
        startAnalyzeBtn.textContent = 'Start Analyze';

        // Tampilkan pesan error yang jelas
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





            // Dummy actions for analyze options
            //document.getElementById('chooseLib').addEventListener('click', () => {
               // alert('Fitur pilih foto dari perpustakaan akan dikembangkan.');
               // analyzeDropdown.classList.remove('show');
               // startBtn.setAttribute('aria-expanded', false);
           // });
           // document.getElementById('takeSelfie').addEventListener('click', () => {
               // alert('Fitur selfie akan dikembangkan.');
               // analyzeDropdown.classList.remove('show');
               // startBtn.setAttribute('aria-expanded', false);
           //});
        </script>


</body>

</html>
