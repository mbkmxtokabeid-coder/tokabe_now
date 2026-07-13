@extends('admin.template')
@section('content')

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        {{-- HEADER --}}
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Add Portofolio</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="/admin"><i class="feather icon-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('portofolio.index') }}">Portofolio List</a>
                                            </li>
                                            <li class="breadcrumb-item">Add Portofolio</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CARD --}}
                        <div class="card">
                            <div class="card-header">
                                <h5>Create New Portofolio</h5>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('portofolio.store') }}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf

                                    {{-- JUDUL --}}
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Judul (Indonesia)</label>
                                            <input type="text"
                                                   name="judul_id"
                                                   class="form-control"
                                                   value="{{ old('judul_id') }}"
                                                   required>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Judul (English)</label>
                                            <input type="text"
                                                   name="judul_en"
                                                   class="form-control"
                                                   value="{{ old('judul_en') }}">
                                        </div>
                                    </div>

                                    {{-- KATEGORI (DINAMIS DARI DATABASE) --}}
                                    <div class="form-group mb-3">
                                        <label>Kategori</label>
                                        <select name="kategori" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            
                                            {{-- Looping Data Kategori --}}
                                            @foreach ($kategoris as $item)
                                                <option value="{{ $item->id }}" {{ old('kategori') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_kategori }}
                                                </option>
                                            @endforeach
                                            
                                        </select>
                                    </div>

                                    {{-- KLIEN --}}
                                    <div class="form-group mb-3">
                                        <label>Klien</label>
                                        <input type="text"
                                               name="klien"
                                               class="form-control"
                                               value="{{ old('klien') }}">
                                    </div>

                                    {{-- TANGGAL --}}
                                    <div class="form-group mb-3">
                                        <label>Tanggal</label>
                                        <input type="date"
                                               name="tanggal"
                                               class="form-control"
                                               value="{{ old('tanggal') }}">
                                    </div>

                                    {{-- LOKASI --}}
                                    <div class="form-group mb-3">
                                        <label>Lokasi</label>
                                        <input type="text"
                                               name="lokasi"
                                               class="form-control"
                                               value="{{ old('lokasi') }}">
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Deskripsi (Indonesia)</label>
                                            <textarea name="deskripsi_id"
                                                      class="form-control"
                                                      rows="4">{{ old('deskripsi_id') }}</textarea>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Deskripsi (English)</label>
                                            <textarea name="deskripsi_en"
                                                      class="form-control"
                                                      rows="4">{{ old('deskripsi_en') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- IMAGES DINAMIS --}}
                                    <div class="form-group mb-3">
                                        <label>Upload Images <span class="text-danger">*</span></label>
                                        <small class="text-muted d-block mb-3">
                                            Bebas upload foto (tidak ada batas jumlah). Ukuran rekomendasi: <strong>1200 × 1200 px</strong>.
                                            Klik kotak tambah di bawah ini untuk mengupload gambar.
                                        </small>

                                        {{-- Wrapper untuk menampung input-input gambar (Horizontal Layout) --}}
                                        <div id="image-inputs-wrapper" class="d-flex flex-wrap gap-3 mt-2">
                                            <!-- Kotak input gambar akan di-generate via Javascript di sini -->
                                        </div>
                                    </div>

                                    {{-- VIDEO DINAMIS --}}
                                    <div class="form-group mb-4 mt-4">
                                        <label>YouTube Links (Opsional)</label>
                                        <small class="text-muted d-block mb-3">
                                            Masukkan URL YouTube dan unggah custom thumbnail untuk setiap video.
                                        </small>

                                        {{-- YOUTUBE LINKS --}}
                                        <div class="mt-3 border p-3 rounded bg-light">
                                            <label class="font-weight-bold mb-2">YouTube Links</label>
                                            <div id="youtube-links-wrapper">
                                                <div class="input-group mb-2 youtube-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                                                    </div>
                                                    <input type="url" name="youtube_urls[]" class="form-control" placeholder="Masukkan Link YouTube (Contoh: https://www.youtube.com/watch?v=...)">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Thumbnail</span>
                                                    </div>
                                                    <input type="file" name="youtube_thumbnails[]" class="form-control p-1" accept="image/*">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success add-youtube-btn" type="button">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ACTION --}}
                                    <div class="mt-4 border-top pt-4">
                                        <button type="submit" class="btn btn-primary">
                                            Save
                                        </button>
                                        <a href="{{ route('portofolio.index') }}"
                                           class="btn btn-secondary">
                                            Back
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SCRIPT PREVIEW --}}
<script>
// ==========================================
// --- SCRIPT DYNAMIC IMAGE INPUT & PREVIEW
// ==========================================
const imageWrapper = document.getElementById('image-inputs-wrapper');

function createEmptyImageBox() {
    const box = document.createElement('div');
    // Styling kotak: ukuran tetap, abu-abu, flexbox tengah
    box.className = 'image-upload-box position-relative d-flex justify-content-center align-items-center border rounded bg-light mr-3 mb-3';
    box.style.width = '150px';
    box.style.height = '150px';
    box.style.overflow = 'hidden';
    
    box.innerHTML = `
        <div class="plus-icon-container text-muted d-flex flex-column align-items-center" style="pointer-events: none;">
            <span style="font-size: 2.5rem; line-height: 1;">+</span>
            <span style="font-size: 0.8rem;">Gambar</span>
        </div>
        
        <!-- Input file tembus pandang (opacity 0) menutupi kotak -->
        <input type="file" name="images[]" class="image-input position-absolute w-100 h-100" accept="image/*" style="opacity: 0; cursor: pointer; top: 0; left: 0; z-index: 2;">
        
        <!-- Wadah Preview per Gambar (Tersembunyi Awalnya) -->
        <div class="preview-container position-absolute w-100 h-100 d-none" style="top: 0; left: 0; z-index: 3;">
            <img class="w-100 h-100" style="object-fit: cover; background-color: #fff;">
            
            <!-- Tombol Silang (X) Melayang -->
            <button type="button" class="btn btn-danger position-absolute remove-image-btn" style="top: 5px; right: 5px; padding: 2px 7px; z-index: 10; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.5); font-weight: bold; line-height: 1;">&times;</button>
        </div>
    `;
    
    imageWrapper.appendChild(box);
}

// Inisialisasi: Buat 1 kotak kosong gambar pertama kali
createEmptyImageBox();

// Event Delegation Gambar (Ganti File)
imageWrapper.addEventListener('change', function(e) {
    if (e.target.classList.contains('image-input')) {
        const file = e.target.files[0];
        const box = e.target.closest('.image-upload-box');
        
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => {
                const previewContainer = box.querySelector('.preview-container');
                const imgElement = box.querySelector('img');
                
                imgElement.src = ev.target.result;
                previewContainer.classList.remove('d-none');
                e.target.style.pointerEvents = 'none';

                // Cek apakah ini adalah kotak terakhir
                const allBoxes = imageWrapper.querySelectorAll('.image-upload-box');
                const lastBox = allBoxes[allBoxes.length - 1];
                if (box === lastBox) {
                    createEmptyImageBox();
                }
            };
            reader.readAsDataURL(file);
        } else if (file) {
            alert('Format file tidak didukung. Harap upload file gambar.');
            e.target.value = ''; 
        }
    }
});

// Event Delegation Gambar (Hapus Kotak)
imageWrapper.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-image-btn')) {
        const box = e.target.closest('.image-upload-box');
        box.remove(); 
        
        const allBoxes = imageWrapper.querySelectorAll('.image-upload-box');
        if (allBoxes.length === 0) {
            createEmptyImageBox();
        } else {
            const lastBox = allBoxes[allBoxes.length - 1];
            const lastInput = lastBox.querySelector('.image-input');
            if (lastInput.files && lastInput.files.length > 0) {
                createEmptyImageBox();
            }
        }
    }
});



// ==========================================
// --- SCRIPT DYNAMIC YOUTUBE INPUT ---
// ==========================================
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-youtube-btn')) {
        const wrapper = document.getElementById('youtube-links-wrapper');
        const newGroup = document.createElement('div');
        newGroup.className = 'input-group mb-2 youtube-input-group';
        newGroup.innerHTML = `
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
            </div>
            <input type="url" name="youtube_urls[]" class="form-control" placeholder="Masukkan Link YouTube (Contoh: https://www.youtube.com/watch?v=...)">
            <div class="input-group-prepend">
                <span class="input-group-text">Thumbnail</span>
            </div>
            <input type="file" name="youtube_thumbnails[]" class="form-control p-1" accept="image/*">
            <div class="input-group-append">
                <button class="btn btn-danger remove-youtube-btn" type="button">-</button>
            </div>
        `;
        wrapper.appendChild(newGroup);
    } else if (e.target.classList.contains('remove-youtube-btn')) {
        e.target.closest('.youtube-input-group').remove();
    }
});
</script>

@endsection