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
                                            $pageTitle = 'Add Detail Service';
                                            if (isset($currentService)) {
                                                $sTitle = is_array($currentService->judul) ? ($currentService->judul['id'] ?? $currentService->judul['en'] ?? '') : ($currentService->judul ?? '');
                                                $pageTitle = $sTitle ? "Add Detail Service: {$sTitle}" : $pageTitle;
                                            }
                                        @endphp
                                        <div class="page-header-title">
                                            <h3 class="m-b-10">{{ $pageTitle }}</h3>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('service-details.index') }}{{ isset($currentService) ? '?service_id='.$currentService->id : '' }}">Detail Service List</a></li>
                                            <li class="breadcrumb-item"><a href="#">Add Detail</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ str_replace('Add', 'Create', $pageTitle) }}</h5>
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
                                        <form action="{{ route('service-details.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            @if(request()->has('service_id'))
                                                <input type="hidden" name="service_id" value="{{ request('service_id') }}">
                                            @else
                                                <div class="alert alert-warning">
                                                    <strong>Warning:</strong> You have not selected a parent service. Please go back and select a service first.
                                                </div>
                                            @endif
                                            <input type="hidden" name="service_id" value="{{ $currentService->id ?? '' }}">
                                            
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-3">
                                                    <label for="service_category_id">Kategori (Pilih Kategori)</label>
                                                    <select name="service_category_id" id="service_category_id" class="form-control" required>
                                                        <option value="">-- Pilih Kategori --</option>
                                                        @foreach($categories as $cat)
                                                            @php
                                                                $catNama = is_array($cat->nama) ? ($cat->nama['id'] ?? $cat->nama['en'] ?? 'Unknown') : ($cat->nama ?: 'Unknown');
                                                            @endphp
                                                            <option value="{{ $cat->id }}">{{ $catNama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 form-group mb-3">
                                                    <label for="tipe_card">Tipe Card</label>
                                                    <select name="tipe_card" id="tipe_card" class="form-control" required>
                                                        <option value="main">Card Utama (Penjelasan Kategori)</option>
                                                        <option value="sub">Card Kecil (Bagian Bawah)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Judul - ID</label>
                                                    <input type="text" class="form-control" name="judul_id" required>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Judul - EN</label>
                                                    <input type="text" class="form-control" name="judul_en" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Deskripsi - ID</label>
                                                    <textarea class="form-control" name="deskripsi_id" rows="4" required></textarea>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Deskripsi - EN</label>
                                                    <textarea class="form-control" name="deskripsi_en" rows="4" required></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label>Image / Gambar</label>
                                                <input type="file" class="form-control crop-image-input" name="gambar" accept="image/*" data-aspect-ratio="16/9">
                                            </div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Save Detail Service</button>
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
