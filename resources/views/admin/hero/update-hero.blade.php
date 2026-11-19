@extends('admin.template')

@section('content')
    <style>
        form {
            max-width: 100%;
            margin: auto;
            padding: 10px;

            border-radius: 7px;
            size: 15px;
        }

        input[type="text"] {
            width: 100;
            padding: 10px;
            margin: auto;

            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h3 class="m-b-10">Heroes in Tokabe</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/admin"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="{{ route('wilayah-list-ooh') }}">Heroes
                                                        list</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="{{ route('hero') }}">Heroes List</a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Edit Heroes</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Edit Heroes</h4>
                                        </div>
                                        <div class="card-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <form action="{{ route('hero-update', $hero->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Heroes Title (ID):</label>
                                                        <textarea class="form-control" rows="3" name="judul_id"
                                                            placeholder="Judul dalam bahasa Indonesia">{{ old('judul_id', $hero->judul['id'] ?? '') }}</textarea>
                                                        @error('judul_id')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Heroes Title (EN):</label>
                                                        <textarea class="form-control" rows="3" name="judul_en"
                                                            placeholder="Title in English">{{ old('judul_en', $hero->judul['en'] ?? '') }}</textarea>
                                                        @error('judul_en')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Heroes Description (ID):</label>
                                                        <textarea class="form-control" rows="3" name="deskripsi_id"
                                                            placeholder="Deskripsi dalam bahasa Indonesia">{{ old('deskripsi_id', $hero->deskripsi['id'] ?? '') }}</textarea>
                                                        @error('deskripsi_id')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Heroes Description (EN):</label>
                                                        <textarea class="form-control" rows="3" name="deskripsi_en"
                                                            placeholder="Description in English">{{ old('deskripsi_en', $hero->deskripsi['en'] ?? '') }}</textarea>
                                                        @error('deskripsi_en')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <input type="hidden" name="dooh_count" value="0">
                                                        <label class="form-label">Tampilkan Statistik DOOH:</label>
                                                        <div class="form-check form-switch custom-switch-v1 mb-2">
                                                            <input type="checkbox"
                                                                class="form-check-input input-success custom-control-input"
                                                                id="switch-dooh-count" name="dooh_count" value="1"
                                                                {{ old('dooh_count', $hero->dooh_count) > 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label align-text-top"
                                                                for="switch-dooh-count">Tampilkan (otomatis dari database: {{ \App\Models\Lokasi::count() }}+)</label>
                                                        </div>
                                                        @error('dooh_count')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="hidden" name="ooh_count" value="0">
                                                        <label class="form-label">Tampilkan Statistik OOH:</label>
                                                        <div class="form-check form-switch custom-switch-v1 mb-2">
                                                            <input type="checkbox"
                                                                class="form-check-input input-success custom-control-input"
                                                                id="switch-ooh-count" name="ooh_count" value="1"
                                                                {{ old('ooh_count', $hero->ooh_count) > 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label align-text-top"
                                                                for="switch-ooh-count">Tampilkan (otomatis dari database: {{ \App\Models\Lokasiooh::count() }}+)</label>
                                                        </div>
                                                        @error('ooh_count')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- Switch Aktif atau tidak -->
                                                <!-- Hidden field sebagai fallback jika checkbox tidak dicentang -->
                                                <input type="hidden" name="status" value="0">
                                                <label class="form-label">Hero Status:</label>
                                                <div class="form-check form-switch custom-switch-v1 mb-2">
                                                    <input type="checkbox"
                                                        class="form-check-input input-success custom-control-input"
                                                        id="customswitchv2-3" name="status" value="1"
                                                        {{ $hero->status ? 'checked' : '' }}>
                                                    <label class="form-check-label align-text-top"
                                                        for="customswitchv2-3">Aktif</label>
                                                </div>
                                                <div class="form-file mb-3">
                                                    <label class="form-label">Heroes Picture</label>
                                                    <input type="file" name="gambar" id="gambar"
                                                        class="form-control @error('gambar') is-invalid @enderror"
                                                        aria-label="file example" accept="image/*"
                                                        onchange="previewImage()">
                                                    @error('gambar')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    @if ($hero->gambar)
                                                        <img id="img-preview" class="img-preview img-fluid"
                                                            style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                            src="{{ asset('storage/image_hero/' . $hero->gambar) }}"
                                                            alt="Preview Gambar">
                                                    @else
                                                        <img id="img-preview" class="img-preview img-fluid"
                                                            style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                            src="" alt="Preview Gambar" style="display: none;">
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                                    <a href="{{ route('hero') }}" class="btn btn-danger"
                                                        title="btn btn-danger" data-bs-toggle="tooltip">Cancel</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function previewImage() {
            const input = document.querySelector('#gambar');
            const imgPreview = document.querySelector('#img-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imgPreview.style.display = 'block';
                    imgPreview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                // Menampilkan gambar lama jika ada
                const oldImage = "{{ asset('storage/image_hero/' . $hero->gambar) }}";
                imgPreview.style.display = 'block';
                imgPreview.src = oldImage;
            }
        }
    </script>
@endsection
