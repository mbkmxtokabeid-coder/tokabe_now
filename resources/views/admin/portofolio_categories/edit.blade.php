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
                                            <h3 class="m-b-10">Edit Kategori Portofolio</h3>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="/admin"><i class="feather icon-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('portofolio_categories.index') }}">Daftar Kategori</a>
                                            </li>
                                            <li class="breadcrumb-item active">Edit Kategori</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FORM -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit Kategori</h4>
                                    </div>

                                    <div class="card-body">

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form action="{{ route('portofolio_categories.update', $category->id) }}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            {{-- Gambar --}}
                                            <div class="form-group mb-3">
                                                <label>Gambar Kategori</label><br>

                                                @if ($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                         width="120"
                                                         class="rounded mb-2">
                                                @endif

                                                <input type="file"
                                                       name="image"
                                                       class="form-control crop-image-input"
                                                       accept="image/*"
                                                       data-aspect-ratio="4/3">
                                            </div>

                                            {{-- Nama --}}
                                            @php
                                                $namaArray = json_decode($category->nama_kategori, true);
                                                $nama_id = is_array($namaArray) ? ($namaArray['id'] ?? $category->nama_kategori) : $category->nama_kategori;
                                                $nama_en = is_array($namaArray) ? ($namaArray['en'] ?? '') : '';
                                            @endphp
                                            <div class="form-group mb-3">
                                                <label>Nama Kategori (Indonesia)</label>
                                                <input type="text"
                                                       name="nama_kategori_id"
                                                       class="form-control mb-2"
                                                       value="{{ old('nama_kategori_id', $nama_id) }}"
                                                       required>
                                                       
                                                <label>Nama Kategori (English)</label>
                                                <input type="text"
                                                       name="nama_kategori_en"
                                                       class="form-control"
                                                       value="{{ old('nama_kategori_en', $nama_en) }}">
                                            </div>

                                            {{-- Action --}}
                                            <button type="submit" class="btn btn-primary">
                                                Update Kategori
                                            </button>
                                            <a href="{{ route('portofolio_categories.index') }}"
                                               class="btn btn-secondary">
                                                Cancel
                                            </a>

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
@endsection
