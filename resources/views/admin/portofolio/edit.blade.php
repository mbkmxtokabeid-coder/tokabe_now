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
                                            <h5 class="m-b-10">Edit Portofolio</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="/admin"><i class="feather icon-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('portofolio.index') }}">Portofolio List</a>
                                            </li>
                                            <li class="breadcrumb-item">Edit Portofolio</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CARD --}}
                        <div class="card">
                            <div class="card-header">
                                <h5>Update Portofolio: {{ $portofolio->judul }}</h5>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('portofolio.update', $portofolio->id) }}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- JUDUL --}}
                                    @php
                                        $judulArray = json_decode($portofolio->judul, true);
                                        $judul_id = is_array($judulArray) ? ($judulArray['id'] ?? $portofolio->judul) : $portofolio->judul;
                                        $judul_en = is_array($judulArray) ? ($judulArray['en'] ?? '') : '';
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Judul (Indonesia)</label>
                                            <input type="text"
                                                   name="judul_id"
                                                   class="form-control"
                                                   value="{{ old('judul_id', $judul_id) }}"
                                                   required>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Judul (English)</label>
                                            <input type="text"
                                                   name="judul_en"
                                                   class="form-control"
                                                   value="{{ old('judul_en', $judul_en) }}">
                                        </div>
                                    </div>

                                    {{-- KATEGORI --}}
                                    <div class="form-group mb-3">
                                        <label>Kategori</label>
                                        <select name="kategori" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategoris as $item)
                                                <option value="{{ $item->id }}" {{ old('kategori', $portofolio->kategori) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- KLIEN --}}
                                    <div class="form-group mb-3">
                                        <label>Klien</label>
                                        <input type="text" name="klien" class="form-control" value="{{ old('klien', $portofolio->klien) }}">
                                    </div>

                                    {{-- TANGGAL --}}
                                    <div class="form-group mb-3">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $portofolio->tanggal) }}">
                                    </div>

                                    {{-- LOKASI --}}
                                    <div class="form-group mb-3">
                                        <label>Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $portofolio->lokasi) }}">
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    @php
                                        $deskripsiArray = json_decode($portofolio->deskripsi, true);
                                        $deskripsi_id = is_array($deskripsiArray) ? ($deskripsiArray['id'] ?? $portofolio->deskripsi) : $portofolio->deskripsi;
                                        $deskripsi_en = is_array($deskripsiArray) ? ($deskripsiArray['en'] ?? '') : '';
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Deskripsi (Indonesia)</label>
                                            <textarea name="deskripsi_id"
                                                      class="form-control"
                                                      rows="4">{{ old('deskripsi_id', $deskripsi_id) }}</textarea>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label>Deskripsi (English)</label>
                                            <textarea name="deskripsi_en"
                                                      class="form-control"
                                                      rows="4">{{ old('deskripsi_en', $deskripsi_en) }}</textarea>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    {{-- IMAGES DINAMIS --}}
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Portofolio Images</label>
                                        <small class="text-muted d-block mb-3">Klik ikon "X" untuk menghapus foto lama, atau klik kotak "+" di paling kanan untuk menambah foto baru.</small>
                                        
                                        <div id="image-inputs-wrapper" class="d-flex flex-wrap gap-3">
                                            {{-- Menampilkan Gambar yang Sudah Ada --}}
                                            @foreach($portofolio->images as $img)
                                                <div class="image-upload-box position-relative d-flex justify-content-center align-items-center border rounded bg-light mr-3 mb-3" style="width: 150px; height: 150px; overflow: hidden;">
                                                    <img src="{{ asset('storage/' . $img->image) }}" class="w-100 h-100" style="object-fit: cover;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute delete-old-media" 
                                                            data-id="{{ $img->id }}" data-type="image"
                                                            style="top: 5px; right: 5px; border-radius: 50%; padding: 2px 7px;">&times;</button>
                                                </div>
                                            @endforeach
                                            <!-- Kotak "+" akan muncul di sini via JS -->
                                        </div>
                                        {{-- Wadah untuk menampung ID gambar yang akan dihapus --}}
                                        <div id="delete-images-container"></div>
                                    </div>

                                    {{-- VIDEOS DINAMIS --}}
                                    <div class="form-group mb-4 mt-4">
                                        <label class="font-weight-bold">Portofolio Videos (MP4)</label>
                                        <small class="text-muted d-block mb-3">Klik ikon "X" untuk menghapus video lama, atau klik kotak "+" di paling kanan untuk menambah video baru.</small>

                                        <div id="video-inputs-wrapper" class="d-flex flex-wrap gap-3">
                                            {{-- Menampilkan Video yang Sudah Ada --}}
                                            @foreach($portofolio->videos as $vid)
                                                <div class="video-upload-box position-relative d-flex justify-content-center align-items-center border rounded bg-dark mr-3 mb-3" style="width: 150px; height: 150px; overflow: hidden;">
                                                    <video src="{{ asset('storage/' . ($vid->video_path ?? $vid->video)) }}" class="w-100 h-100" style="object-fit: cover;"></video>
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute delete-old-media" 
                                                            data-id="{{ $vid->id }}" data-type="video"
                                                            style="top: 5px; right: 5px; border-radius: 50%; padding: 2px 7px; z-index:10;">&times;</button>
                                                </div>
                                            @endforeach
                                            <!-- Kotak "+" akan muncul di sini via JS -->
                                        </div>
                                        {{-- Wadah untuk menampung ID video yang akan dihapus --}}
                                        <div id="delete-videos-container"></div>
                                    </div>

                                    {{-- ACTION --}}
                                    <div class="mt-5 border-top pt-4">
                                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                        <a href="{{ route('portofolio.index') }}" class="btn btn-secondary">Cancel</a>
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

<script>
// ==========================================
// --- LOGIKA HAPUS MEDIA LAMA ---
// ==========================================
document.querySelectorAll('.delete-old-media').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const type = this.getAttribute('data-type');
        const containerId = type === 'image' ? 'delete-images-container' : 'delete-videos-container';
        const inputName = type === 'image' ? 'delete_images[]' : 'delete_videos[]';

        // Buat hidden input untuk dikirim ke controller
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = inputName;
        input.value = id;
        document.getElementById(containerId).appendChild(input);

        // Hilangkan kotak dari tampilan
        this.closest(type === 'image' ? '.image-upload-box' : '.video-upload-box').remove();
    });
});

// ==========================================
// --- SCRIPT DYNAMIC IMAGE INPUT (SAMAKAN DENGAN CREATE)
// ==========================================
const imageWrapper = document.getElementById('image-inputs-wrapper');

function createEmptyImageBox() {
    const box = document.createElement('div');
    box.className = 'image-upload-box position-relative d-flex justify-content-center align-items-center border rounded bg-light mr-3 mb-3';
    box.style.width = '150px';
    box.style.height = '150px';
    box.style.overflow = 'hidden';
    
    box.innerHTML = `
        <div class="plus-icon-container text-muted d-flex flex-column align-items-center" style="pointer-events: none;">
            <span style="font-size: 2.5rem; line-height: 1;">+</span>
            <span style="font-size: 0.8rem;">Gambar</span>
        </div>
        <input type="file" name="images[]" class="image-input position-absolute w-100 h-100" accept="image/*" style="opacity: 0; cursor: pointer; top: 0; left: 0; z-index: 2;">
        <div class="preview-container position-absolute w-100 h-100 d-none" style="top: 0; left: 0; z-index: 3;">
            <img class="w-100 h-100" style="object-fit: cover; background-color: #fff;">
            <button type="button" class="btn btn-danger position-absolute remove-image-btn" style="top: 5px; right: 5px; padding: 2px 7px; z-index: 10; border-radius: 50%;">&times;</button>
        </div>
    `;
    imageWrapper.appendChild(box);
}

createEmptyImageBox();

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

                const allBoxes = imageWrapper.querySelectorAll('.image-upload-box');
                const lastBox = allBoxes[allBoxes.length - 1];
                if (box === lastBox) createEmptyImageBox();
            };
            reader.readAsDataURL(file);
        }
    }
});

imageWrapper.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-image-btn')) {
        e.target.closest('.image-upload-box').remove();
        const allBoxes = imageWrapper.querySelectorAll('.image-upload-box');
        if (allBoxes.length === 0 || Array.from(allBoxes).every(b => b.querySelector('.image-input').files.length > 0)) {
            createEmptyImageBox();
        }
    }
});

// ==========================================
// --- SCRIPT DYNAMIC VIDEO INPUT (SAMAKAN DENGAN CREATE)
// ==========================================
const videoWrapper = document.getElementById('video-inputs-wrapper');

function createEmptyVideoBox() {
    const box = document.createElement('div');
    box.className = 'video-upload-box position-relative d-flex justify-content-center align-items-center border rounded bg-light mr-3 mb-3';
    box.style.width = '150px';
    box.style.height = '150px';
    box.style.overflow = 'hidden';
    
    box.innerHTML = `
        <div class="plus-icon-container text-muted d-flex flex-column align-items-center" style="pointer-events: none;">
            <span style="font-size: 2.5rem; line-height: 1;">+</span>
            <span style="font-size: 0.8rem;">Video</span>
        </div>
        <input type="file" name="videos[]" class="video-input position-absolute w-100 h-100" accept="video/mp4" style="opacity: 0; cursor: pointer; top: 0; left: 0; z-index: 2;">
        <div class="preview-container position-absolute w-100 h-100 d-none" style="top: 0; left: 0; z-index: 3;">
            <video class="w-100 h-100" style="object-fit: cover; background-color: #000;" controls></video>
            <button type="button" class="btn btn-danger position-absolute remove-video-btn" style="top: 5px; right: 5px; padding: 2px 7px; z-index: 10; border-radius: 50%;">&times;</button>
        </div>
    `;
    videoWrapper.appendChild(box);
}

createEmptyVideoBox();

videoWrapper.addEventListener('change', function(e) {
    if (e.target.classList.contains('video-input')) {
        const file = e.target.files[0];
        const box = e.target.closest('.video-upload-box');
        if (file && file.type === 'video/mp4') {
            const videoURL = URL.createObjectURL(file);
            const previewContainer = box.querySelector('.preview-container');
            const videoElement = box.querySelector('video');
            videoElement.src = videoURL;
            previewContainer.classList.remove('d-none');
            e.target.style.pointerEvents = 'none';

            const allBoxes = videoWrapper.querySelectorAll('.video-upload-box');
            const lastBox = allBoxes[allBoxes.length - 1];
            if (box === lastBox) createEmptyVideoBox();
        }
    }
});

videoWrapper.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-video-btn')) {
        e.target.closest('.video-upload-box').remove();
        const allBoxes = videoWrapper.querySelectorAll('.video-upload-box');
        if (allBoxes.length === 0 || Array.from(allBoxes).every(b => b.querySelector('.video-input').files.length > 0)) {
            createEmptyVideoBox();
        }
    }
});
</script>

@endsection