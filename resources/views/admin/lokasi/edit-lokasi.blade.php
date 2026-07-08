@extends('admin.template')

@section('content')
<style>
    form {
        max-width: 100%;
        margin: auto;
        padding: 10px;
        border-radius: 7px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
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
                        @if(session('success'))
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
                                            <h3 class="m-b-10">Edit Tokabe Location List</h3>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="">Location list</a></li>
                                            <li class="breadcrumb-item"><a href="">Edit Location</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('lokasi.update', $lokasis->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')

                                            <div class="lead font-weight-bold text-dark text-uppercase mb-3">Update Lokasi!</div>
                                            <p>Lokasi yang mau di-update: {{ is_array($lokasis->nama) ? ($lokasis->nama['id'] ?? '') : $lokasis->nama }}</p>

                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <label class="form-label">Informasi Lokasi (Multibahasa)</label>
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
                                                                <td><strong>Nama Lokasi / Location Name</strong></td>
                                                                <td>
                                                                    <input type="text" name="nama_en" class="form-control" id="nama_en" placeholder="Location Name (EN)" value="{{ old('nama_en', is_array($lokasis->nama) ? ($lokasis->nama['en'] ?? '') : $lokasis->nama) }}">
                                                                    @error('nama_en') <div class="text-danger">{{ $message }}</div> @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="nama_id" class="form-control" id="nama_id" placeholder="Nama Lokasi (ID)" value="{{ old('nama_id', is_array($lokasis->nama) ? ($lokasis->nama['id'] ?? '') : $lokasis->nama) }}">
                                                                    @error('nama_id') <div class="text-danger">{{ $message }}</div> @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Deskripsi / Description</strong></td>
                                                                <td>
                                                                    <textarea class="form-control" name="deskripsi_lokasi_en" id="deskripsi_lokasi_en" rows="3" placeholder="Description (EN)">{{ old('deskripsi_lokasi_en', is_array($lokasis->deskripsi_lokasi) ? ($lokasis->deskripsi_lokasi['en'] ?? '') : $lokasis->deskripsi_lokasi) }}</textarea>
                                                                    @error('deskripsi_lokasi_en') <div class="text-danger">{{ $message }}</div> @enderror
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control" name="deskripsi_lokasi_id" id="deskripsi_lokasi_id" rows="3" placeholder="Deskripsi (ID)">{{ old('deskripsi_lokasi_id', is_array($lokasis->deskripsi_lokasi) ? ($lokasis->deskripsi_lokasi['id'] ?? '') : $lokasis->deskripsi_lokasi) }}</textarea>
                                                                    @error('deskripsi_lokasi_id') <div class="text-danger">{{ $message }}</div> @enderror
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Left Column -->
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label>Tagline</label>
                                                        <input type="text" name="tagline" value="{{ old('tagline', $lokasis->tagline) }}" class="form-control">
                                                        @error('tagline') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>



                                                    <div class="form-group">
                                                        <label>Koordinat</label>
                                                        <input type="text" name="koordinat" value="{{ old('koordinat', $lokasis->koordinat) }}" class="form-control">
                                                        @error('koordinat') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                    <label>Provinsi</label>
                                                    <select name="provinsi" class="form-control">
                                                        <option value="">-- Pilih Provinsi --</option>
                                                        <option value="Aceh" {{ old('provinsi', $lokasis->provinsi) == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                                                        <option value="Sumatera Selatan" {{ old('provinsi', $lokasis->provinsi) == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                                                        <option value="Sumatera Utara" {{ old('provinsi', $lokasis->provinsi) == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                                                        <option value="Riau" {{ old('provinsi', $lokasis->provinsi) == 'Riau' ? 'selected' : '' }}>Riau</option>
                                                        <option value="Sumatra Barat" {{ old('provinsi', $lokasis->provinsi) == 'Sumatra Barat' ? 'selected' : '' }}>Sumatra Barat</option>
                                                        <option value="Kepulauan Riau" {{ old('provinsi', $lokasis->provinsi) == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                                                        <option value="Jambi" {{ old('provinsi', $lokasis->provinsi) == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                                                        <option value="Bengkulu" {{ old('provinsi', $lokasis->provinsi) == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                                                        <option value="Bangka Belitung" {{ old('provinsi', $lokasis->provinsi) == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                                                        <option value="Lampung" {{ old('provinsi', $lokasis->provinsi) == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                                                    </select>
                                                    @error('provinsi')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                    <div class="form-group">
                                                        <label>Media</label>
                                                        <input type="text" name="media" value="{{ old('media', $lokasis->media) }}" class="form-control">
                                                        @error('media') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Size</label>
                                                        <input type="text" name="size" value="{{ old('size', $lokasis->size) }}" class="form-control">
                                                        @error('size') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Type</label>
                                                        <input type="text" name="type" value="{{ old('type', $lokasis->type) }}" class="form-control">
                                                        @error('type') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Motor</label>
                                                        <input type="text" name="motor" value="{{ old('motor', $lokasis->motor) }}" class="form-control">
                                                        @error('motor') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>

                                                <!-- Right Column -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Mobil</label>
                                                        <input type="text" name="mobil" value="{{ old('mobil', $lokasis->mobil) }}" class="form-control">
                                                        @error('mobil') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Duration</label>
                                                        <input type="text" name="duration" value="{{ old('duration', $lokasis->duration) }}" class="form-control">
                                                        @error('duration') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Hour</label>
                                                        <input type="text" name="hour" value="{{ old('hour', $lokasis->hour) }}" class="form-control">
                                                        @error('hour') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Spot</label>
                                                        <input type="text" name="spot" value="{{ old('spot', $lokasis->spot) }}" class="form-control">
                                                        @error('spot') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Brand</label>
                                                        <input type="text" name="brand" value="{{ old('brand', $lokasis->brand) }}" class="form-control">
                                                        @error('brand') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Display</label>
                                                        <input type="text" name="display" value="{{ old('display', $lokasis->display) }}" class="form-control">
                                                        @error('display') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Location Picture</label><br>
                                                      
                                                        <input type="file" name="gambar" class="form-control" id="gambar" onchange="previewImage()">
                                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                                                        @error('gambar') 
                                                        <div class="text-danger">{{ $message }}</div> 
                                                        @enderror
                                                        <div class="mb-2">
                                                        @if ($lokasis->gambar)
                                                        <img id="img-preview" class="img-preview img-fluid"
                                                            style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                            src="{{ asset('storage/image_lokasi/' . $lokasis->gambar) }}"
                                                            alt="Preview Gambar">
                                                        @else
                                                        <img id="img-preview" class="img-preview img-fluid"
                                                            style="width: 150px; height: 150px; object-fit: contain; overflow: hidden;"
                                                            src="" alt="Preview Gambar" style="display: none;">
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label class="form-label"
                                                            for="exampleFormControlSelect1">Status</label>
                                                        <select class="form-control" name="status" id="exampleFormControlSelect1">
                                                            <option value="">Select status</option>
                                                            <option value="Aktif" {{ old('status', $lokasis->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="Tidak aktif" {{ old('status', $lokasis->status) == 'Tidak aktif' ? 'selected' : '' }}>Tidak aktif</option>
                                                        </select>
                                                        @error('status')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-6 mt-3 mt-lg-0">
                                                        <label class="form-label"
                                                            for="availabilitySelect">Availability</label>
                                                        <select class="form-control" name="availability" id="availabilitySelect">
                                                            <option value="Available" {{ old('availability', $lokasis->availability) == 'Available' ? 'selected' : '' }}>Available</option>
                                                            <option value="Not Available" {{ old('availability', $lokasis->availability) == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                                                        </select>
                                                        @error('availability')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-success">Update</button>
                                                <a href="/admin/lokasi-list" class="btn btn-danger">Cancel</a>
                                            </div>
                                        </form>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const statusSelect = document.getElementById('exampleFormControlSelect1');
                                                const availabilitySelect = document.getElementById('availabilitySelect');
                                                
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
                                    </div> <!-- card-body -->
                                </div> <!-- card -->
                            </div> <!-- col-lg-12 -->
                        </div> <!-- row -->
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
                const oldImage = "{{ asset('storage/image_lokasi/' . $lokasis->gambar) }}";
                imgPreview.style.display = 'block';
                imgPreview.src = oldImage;
            }
        }
    </script>
@endsection
