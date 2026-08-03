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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h3 class="m-b-10">OOH Billboard in Tokabe</h3>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('wilayah-list-ooh') }}">OOH Billboard list</a></li>
                                            <li class="breadcrumb-item"><a href="#!">Edit OOH Billboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit OOH Billboard</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('update-OOH', $lokasiooh->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                
                                                <div class="col-md-12 mb-4">
                                                    <label class="form-label font-weight-bold">Informasi OOH (Multibahasa)</label>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Field</th>
                                                                <th>English (EN)</th>
                                                                <th>Indonesia (ID)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Nama OOH / OOH Name</strong></td>
                                                                <td>
                                                                    <input type="text" name="nama_en" class="form-control" value="{{ old('nama_en', is_array($lokasiooh->nama) ? ($lokasiooh->nama['en'] ?? '') : $lokasiooh->nama) }}">
                                                                    @error('nama_en') <div class="text-danger small">{{ $message }}</div> @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="nama_id" class="form-control" value="{{ old('nama_id', is_array($lokasiooh->nama) ? ($lokasiooh->nama['id'] ?? '') : $lokasiooh->nama) }}">
                                                                    @error('nama_id') <div class="text-danger small">{{ $message }}</div> @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Deskripsi / Description</strong></td>
                                                                <td>
                                                                    <textarea class="form-control" name="deskripsi_lokasi_en" rows="4">{{ old('deskripsi_lokasi_en', is_array($lokasiooh->deskripsi_lokasi) ? ($lokasiooh->deskripsi_lokasi['en'] ?? '') : $lokasiooh->deskripsi_lokasi) }}</textarea>
                                                                    @error('deskripsi_lokasi_en') <div class="text-danger small">{{ $message }}</div> @enderror
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control" name="deskripsi_lokasi_id" rows="4">{{ old('deskripsi_lokasi_id', is_array($lokasiooh->deskripsi_lokasi) ? ($lokasiooh->deskripsi_lokasi['id'] ?? '') : $lokasiooh->deskripsi_lokasi) }}</textarea>
                                                                    @error('deskripsi_lokasi_id') <div class="text-danger small">{{ $message }}</div> @enderror
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-lg-12"><hr></div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Region (City/District)</label>
                                                    <input type="text" name="wilayah" class="form-control" value="{{ old('wilayah', $lokasiooh->wilayah) }}">
                                                    @error('wilayah') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Coordinate</label>
                                                    <input type="text" name="koordinat" class="form-control" value="{{ old('koordinat', $lokasiooh->koordinat) }}">
                                                    @error('koordinat') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Province</label>
                                                    <select name="provinsi" class="form-control">
                                                        <option value="">-- Pilih Provinsi --</option>
                                                        @foreach(['Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau', 'Jambi', 'Sumatera Selatan', 'Bengkulu', 'Bangka Belitung', 'Lampung'] as $prov)
                                                            <option value="{{ $prov }}" {{ old('provinsi', $lokasiooh->provinsi) == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('provinsi') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Media</label>
                                                    <input type="text" name="media" class="form-control" value="{{ old('media', $lokasiooh->media) }}">
                                                    @error('media') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">OOH Size</label>
                                                    <input type="text" name="size" class="form-control" value="{{ old('size', $lokasiooh->size) }}">
                                                    @error('size') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">OOH Type</label>
                                                    <input type="text" name="type" class="form-control" value="{{ old('type', $lokasiooh->type) }}">
                                                    @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-4 mb-3">
                                                    <label class="form-label">Motorcycle Traffic</label>
                                                    <input type="text" name="motor" class="form-control" value="{{ old('motor', $lokasiooh->motor) }}">
                                                    @error('motor') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label class="form-label">Car Traffic</label>
                                                    <input type="text" name="mobil" class="form-control" value="{{ old('mobil', $lokasiooh->mobil) }}">
                                                    @error('mobil') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label class="form-label">Lighting</label>
                                                    <input type="text" name="lighting" class="form-control" value="{{ old('lighting', $lokasiooh->lighting) }}">
                                                    @error('lighting') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-control" name="status" id="oohStatusSelect">
                                                        <option value="Aktif" {{ old('status', $lokasiooh->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Tidak aktif" {{ old('status', $lokasiooh->status) == 'Tidak aktif' ? 'selected' : '' }}>Tidak aktif</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Availability</label>
                                                    <select class="form-control" name="availability" id="oohAvailabilitySelect">
                                                        <option value="Available" {{ old('availability', $lokasiooh->availability) == 'Available' ? 'selected' : '' }}>Available</option>
                                                        <option value="Not Available" {{ old('availability', $lokasiooh->availability) == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                                                    </select>
                                                    @error('availability') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Ganti Gambar (Kosongkan jika tidak ingin ganti)</label>
                                                    <input type="file" name="gambar" class="form-control" id="gambarInput" accept="image/*">
                                                    @error('gambar') <div class="text-danger small">{{ $message }}</div> @enderror
                                                    
                                                    @if($lokasiooh->gambar)
                                                        <div class="mt-2">
                                                            <small class="d-block mb-1">Gambar saat ini:</small>
                                                            <img id="gambarPreview" src="{{ asset('storage/image_lokasiooh/' . $lokasiooh->gambar) }}" alt="Preview" style="max-height: 150px; border-radius: 10px;">
                                                        </div>
                                                    @else
                                                        <div class="mt-2">
                                                            <img id="gambarPreview" src="#" alt="Preview" style="max-height: 150px; display: none; border-radius: 10px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-4 mb-3">
                                                <button class="btn btn-warning text-dark font-weight-bold" type="submit">Update Data</button>
                                                <a href="{{ route('lokasi-list-ooh', $lokasiooh->wilayah) }}" class="btn btn-secondary">Batal</a>
                                            </div>
                                        </form>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const statusSelect = document.getElementById('oohStatusSelect');
                                                const availabilitySelect = document.getElementById('oohAvailabilitySelect');
                                                
                                                function checkAvailability() {
                                                    if (availabilitySelect.value === 'Not Available') {
                                                        statusSelect.value = 'Tidak aktif';
                                                        Array.from(statusSelect.options).forEach(opt => {
                                                            if (opt.value === 'Aktif') opt.disabled = true;
                                                        });
                                                    } else {
                                                        Array.from(statusSelect.options).forEach(opt => {
                                                            if (opt.value === 'Aktif') opt.disabled = false;
                                                        });
                                                    }
                                                }
                                                
                                                availabilitySelect.addEventListener('change', checkAvailability);
                                                checkAvailability();
                                            });
                                        </script>
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
    // Script untuk preview gambar pas pilih file baru
    document.getElementById('gambarInput').addEventListener('change', function (event) {
        const [file] = event.target.files;
        const preview = document.getElementById('gambarPreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>
@endsection