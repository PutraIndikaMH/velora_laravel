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
                      <button type="button" id="removePreviewBtn" class="remove-preview-btn"
                          style="display:none;">✕</button>
                  </div>
              </div>


          </form>
      </div>
