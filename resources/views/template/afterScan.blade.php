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
        @if ($history && $history->image_path)
            <img class="camera-preview" 
                 src="{{ asset('storage/' . $history->image_path) }}"
                 alt="Analyzed face with detection results"
                 style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div class="title">No analysis results available.</div>
        @endif
    </div>
    


        <div style="position: relative; width: max-content; margin: 0 auto; margin-bottom: -100px">
            <button id="btnstartAnalyzeBtn" class="btn-drop" aria-haspopup="true" aria-expanded="false">
                Start Analyze
            </button>
            <form id="scanForm" method="POST" action="{{ route('scan.upload') }}" enctype="multipart/form-data">
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


                        <button type="button" id="removePreviewBtn" style="display:none;margin: 25px">Hapus
                            Pratinjau</button>

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

        @if (session('message'))
            <div class="alert alert-success" style="text-align: center">
                {{ session('message') }}
            </div>
        @endif

        <section class="recommendation" id="recommendationSection"
            aria-label="Analysis results and recommended products">



        @if ($history)
                <div class="title">Analysis Results: {{ $history->skin_type }} - {{ $history->skin_condition }}</div>
            @else
                <div class="title">No analysis results available.</div>
            @endif            <p>Recommended Products</p>

            @foreach ($recommendedProducts as $product)
                <a href="{{ $product->recommendation_links }}">
                    <div class="product-item" tabindex="0" role="button"
                        aria-label="{{ $product->product_name }} from {{ $product->product_category }}, {{ $product->product_description }}">
                        <img src="{{asset($product->product_image)}}" class="product-icon" alt="" srcset="">
                        <div class="product-info">
                            <h4>{{ $product->product_name }}</h4>
                            <div class="brand">{{ $product->product_category }}</div>
                            <div class="price">Rp. {{ number_format($product->product_price, 0, ',', '.') }}</div>
                            <div class="desc">{{ $product->product_description }}</div>
                        </div>
                        <div class="product-arrow">&#8594;</div>
                    </div>
                </a>
            @endforeach

            @if (empty($recommendedProducts))
                <p>No recommendations available at this time.</p>
            @endif
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
