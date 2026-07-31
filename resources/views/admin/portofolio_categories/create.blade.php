@extends('admin.template')

@section('content')
<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <!-- HEADER -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h3 class="m-b-10">Tambah Kategori Portofolio</h3>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="/admin"><i class="feather icon-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('portofolio_categories.index') }}">Daftar Kategori Portofolio</a>
                                            </li>
                                            <li class="breadcrumb-item active">Tambah Baru</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FORM -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah Kategori Portofolio</h4>
                                    </div>

                                    <div class="card-body">
                                        <form action="{{ route('portofolio_categories.store') }}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            {{-- NAMA KATEGORI --}}
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label>Nama Kategori (Indonesia)</label>
                                                    <input type="text"
                                                           name="nama_kategori_id"
                                                           class="form-control"
                                                           value="{{ old('nama_kategori_id') }}"
                                                           required>
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label>Nama Kategori (English)</label>
                                                    <input type="text"
                                                           name="nama_kategori_en"
                                                           class="form-control"
                                                           value="{{ old('nama_kategori_en') }}">
                                                </div>
                                            </div>

                                            {{-- GAMBAR KATEGORI --}}
                                            <div class="form-group mt-3">
                                                <label>Gambar Kategori</label>
                                                <input type="file"
                                                       name="image"
                                                       class="form-control crop-image-input"
                                                       id="imageInput"
                                                       accept="image/*"
                                                       data-aspect-ratio="4/3"
                                                       data-preview="#previewImage">

                                                <small class="text-muted">
                                                    1 gambar akan digunakan untuk semua kategori yang ditambahkan
                                                </small>

                                                {{-- PREVIEW --}}
                                                <div class="mt-3">
                                                    <img id="previewImage"
                                                         src=""
                                                         style="display:none; width:120px; border-radius:10px;">
                                                </div>
                                            </div>

                                            {{-- ACTION --}}
                                            <div class="mt-4">
                                                <button class="btn btn-primary" type="submit">Simpan</button>
                                                <a href="{{ route('portofolio_categories.index') }}"
                                                   class="btn btn-danger">Batal</a>
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

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function() {



    // preview gambar
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('previewImage');
        const file = e.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });

});
</script>
@endsection
