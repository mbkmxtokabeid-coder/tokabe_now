@extends('admin.template')
@section('content')
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
                                        @php
                                            $sTitle = is_array($detail->serviceCategory->service->judul) ? ($detail->serviceCategory->service->judul['id'] ?? $detail->serviceCategory->service->judul['en'] ?? '') : ($detail->serviceCategory->service->judul ?? '');
                                            $pageTitle = $sTitle ? "Edit Detail Service: {$sTitle}" : 'Edit Detail Service';
                                        @endphp
                                        <div class="page-header-title">
                                            <h3 class="m-b-10">{{ $pageTitle }}</h3>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('service-details.index') }}?service_id={{ $detail->serviceCategory->service_id }}">Detail Service List</a></li>
                                            <li class="breadcrumb-item"><a href="#">Edit Detail</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ $pageTitle }}</h5>
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
                                        <form action="{{ route('service-details.update', $detail->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <input type="hidden" name="service_id" value="{{ $detail->serviceCategory->service_id }}">
                                            
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-3">
                                                    <label for="service_category_id">Kategori (Pilih Kategori)</label>
                                                    <select name="service_category_id" id="service_category_id" class="form-control" required>
                                                        <option value="">-- Pilih Kategori --</option>
                                                        @foreach($categories as $cat)
                                                            @php
                                                                $catNama = is_array($cat->nama) ? ($cat->nama['id'] ?? $cat->nama['en'] ?? 'Unknown') : ($cat->nama ?: 'Unknown');
                                                            @endphp
                                                            <option value="{{ $cat->id }}" {{ $detail->service_category_id == $cat->id ? 'selected' : '' }}>{{ $catNama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 form-group mb-3">
                                                    <label for="tipe_card">Tipe Card</label>
                                                    <select name="tipe_card" id="tipe_card" class="form-control" required>
                                                        <option value="main" {{ $detail->tipe_card == 'main' ? 'selected' : '' }}>Card Utama (Penjelasan Kategori)</option>
                                                        <option value="sub" {{ $detail->tipe_card == 'sub' ? 'selected' : '' }}>Card Kecil (Bagian Bawah)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Judul - ID</label>
                                                    <input type="text" class="form-control" name="judul_id" required value="{{ is_array($detail->judul) ? ($detail->judul['id'] ?? '') : '' }}">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Judul - EN</label>
                                                    <input type="text" class="form-control" name="judul_en" required value="{{ is_array($detail->judul) ? ($detail->judul['en'] ?? '') : '' }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Deskripsi - ID</label>
                                                    <textarea class="form-control" name="deskripsi_id" rows="4" required>{{ is_array($detail->deskripsi) ? ($detail->deskripsi['id'] ?? '') : '' }}</textarea>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Deskripsi - EN</label>
                                                    <textarea class="form-control" name="deskripsi_en" rows="4" required>{{ is_array($detail->deskripsi) ? ($detail->deskripsi['en'] ?? '') : '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label>Image / Gambar</label>
                                                @if($detail->gambar)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/service_details/' . $detail->gambar) }}" style="max-height: 150px; border-radius: 8px;">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control crop-image-input" name="gambar" accept="image/*" data-aspect-ratio="16/9">
                                                <small class="text-muted">Leave blank if you don't want to change the image.</small>
                                            </div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Update Detail Service</button>
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
@endsection
