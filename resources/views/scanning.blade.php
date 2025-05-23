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
    @include('template.nav')

    <main id="scanning-page">
        <div class="scan-box" aria-label="Face scanning area">
            <div class="camera-preview">
                <svg class="camera-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M20 5h-3.17l-1.83-2H9L7.17 5H4a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zM12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10z">
                    </path>
                </svg>
                <video id="video" width="300" height="300" autoplay playsinline style="display:none;"></video>
                <img id="previewImage" style="display:none; width: 100%; height: 100%; object-fit: cover;">
                <button id="removePreviewBtn" class="remove-preview-btn" style="display:none;">✕</button>
            </div>
        </div>


        <div style="position: relative; width: max-content; margin: 0 auto;">
            <button id="btnstartAnalyzeBtn" class="btn-drop" aria-haspopup="true" aria-expanded="false">
                Start Analyze
            </button>
            <form id="scanForm" enctype="multipart/form-data">
                @csrf
                <div id="analyzeDropdown" class="dropdown-menu" role="menu" aria-label="Analyze options">
                    <div tabindex="0" role="menuitem" id="chooseLib">
                        <label class="upload-option">
                            <input type="radio" name="uploadType" value="gallery" id="galleryOption">
                            Choose from library
                        </label>
                    </div>
                    <div tabindex="0" role="menuitem" id="takeSelfie">
                        <label class="upload-option">
                            <input type="radio" name="uploadType" value="camera" id="cameraOption">
                            Take selfie
                        </label>
                        <button type="button" id="startCamera" style="display:none; margin: 25px">Start Camera</button>

                        <button type="button" id="capturePhoto" style="display:none;margin: 25px">Capture
                            Photo</button>


                        <button type="button" id="removePreviewBtn" style="display:none;margin: 25px">Hapus Pratinjau</button>

                        <div class="analyze-controls" style="text-align: center; margin-top: 15px;">
                            <button type="button" id="startAnalyzeBtn" class="analyze-btn" disabled>
                                Start Analyze
                            </button>
                        </div>
                    </div>
                </div>
                <div class="camera-controls">

                </div>

                <input type="file" name="image" id="inputGallery" accept="image/*" style="display:none;">

                <div class="preview-container">
                    <div class="preview-wrapper">
                        <img id="previewImage" src="" class="preview-image">
                        <button type="button" id="removePreviewBtn" class="remove-preview-btn"
                            style="display:none;">✕</button>
                    </div>
                </div>
            </form>
        </div>



        <section class="recommendation" id="recommendationSection"
            aria-label="Analysis results and recommended products">
            <div class="title" id="recommendationSection">Analysis Results </div>

            <p>Recommended Products</p>
            <div id="productRecommendations">
                <!-- Produk akan dimasukkan secara dinamis via JavaScript -->
            </div>

            <div class="product-item" tabindex="0" role="button"
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
            </div>

            <div class="product-item" tabindex="0" role="button"
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
            </div>
        </section>

        <section class="chat-section" aria-label="Consultation chat bot">
            <p>Apakah anda memerlukan konsultasi lebih lanjut? Klik Chat bot dibawah ini</p>
            <a href="{{ route('services') }}" class="chat-btn" aria-label="Chat Bot Button">Chat Bot</a>
            <div class="chat-feedback" aria-live="polite" aria-atomic="true">
                Kami ingin mendengar dari Anda! Klik tombol di samping ini untuk memberikan saran
                <a href="{{ route('about') }}#about-care-contact">
                    <img src="icons/feedback-svgrepo-com.svg" alt="Feedback Icon" class="feedback-icon" />
                </a>
            </div>
        </section>


        @include('template.scriptScan')


</body>

</html>
