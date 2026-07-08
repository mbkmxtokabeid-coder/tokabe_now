@extends('admin.template')

@section('content')
    <style>
        form {
            max-width: 100%;
            margin: auto;
            padding: 10px;
            border-radius: 7px;
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
                                                <h3 class="m-b-10">Tokabe Location List</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/admin"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="">Location list</a></li>
                                                <li class="breadcrumb-item"><a href="">Add New Location</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Add New Location</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="/admin/lokasi/create-lokasi" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
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
                                                                        <input type="text" name="nama_en" class="form-control" id="nama_en" placeholder="Location Name (EN)">
                                                                        @error('nama_en') <div class="text-danger">{{ $message }}</div> @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="nama_id" class="form-control" id="nama_id" placeholder="Nama Lokasi (ID)">
                                                                        @error('nama_id') <div class="text-danger">{{ $message }}</div> @enderror
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Deskripsi / Description</strong></td>
                                                                    <td>
                                                                        <textarea class="form-control" name="deskripsi_lokasi_en" id="deskripsi_lokasi_en" rows="3" placeholder="Description (EN)"></textarea>
                                                                        @error('deskripsi_lokasi_en') <div class="text-danger">{{ $message }}</div> @enderror
                                                                    </td>
                                                                    <td>
                                                                        <textarea class="form-control" name="deskripsi_lokasi_id" id="deskripsi_lokasi_id" rows="3" placeholder="Deskripsi (ID)"></textarea>
                                                                        @error('deskripsi_lokasi_id') <div class="text-danger">{{ $message }}</div> @enderror
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    {{-- Left Column --}}
                                                    <div class="col-md-6">
                                                        @foreach ([
            'tagline' => 'Tagline',
        ] as $field => $label)
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ $label }}</label>
                                                                <input type="text" name="{{ $field }}"
                                                                    class="form-control" id="{{ $field }}"
                                                                    placeholder="Fill in the {{ strtolower($label) }} here">
                                                                @error($field)
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        @endforeach



                                                        @foreach ([
                                                            'koordinat' => 'Koordinat',
                                                              'provinsi' => 'provinsi',
                                                            'media' => 'Media',
                                                            'size' => 'Size',
                                                            'type' => 'Type',
                                                            'motor' => 'Motor',
                                                        ] as $field => $label)
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ $label }}</label>
                                                                <input type="text" name="{{ $field }}"
                                                                    class="form-control" id="{{ $field }}"
                                                                    placeholder="Fill in the {{ strtolower($label) }} here">
                                                                @error($field)
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                   



                                                    {{-- Right Column --}}
                                                    <div class="col-md-6">
                                                        @foreach ([
                                                        'mobil' => 'Mobil',
                                                        'duration' => 'Duration',
                                                        'hour' => 'Hour',
                                                        'spot' => 'Spot',
                                                        'brand' => 'Brand',
                                                        'display' => 'Display',
                                                    ] as $field => $label)
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ $label }}</label>
                                                                <input type="text" name="{{ $field }}"
                                                                    class="form-control" id="{{ $field }}"
                                                                    placeholder="Fill in the {{ strtolower($label) }} here">
                                                                @error($field)
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                        
                                                        <div class="mb-3">
                                                    <label class="form-label">Provinsi</label>
                                                    <select name="provinsi" class="form-control">
                                                        <option value="">-- Pilih Provinsi --</option>
                                                        <option value="Aceh" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                                                        <option value="Sumatera Selatan" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                                                        <option value="Sumatera Utara" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                                                        <option value="Riau" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Riau' ? 'selected' : '' }}>Riau</option>
                                                        <option value="Sumatra Barat" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Sumatra Barat' ? 'selected' : '' }}>Sumatra Barat</option>
                                                        <option value="Kepulauan Riau" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                                                        <option value="Jambi" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                                                        <option value="Bengkulu" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                                                        <option value="Bangka Belitung" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                                                        <option value="Lampung" {{ old('provinsi', $lokasis->provinsi ?? '') == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                                                    </select>
                                                    @error('provinsi')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Location Picture</label>
                                                            <input type="file" name="gambar" class="form-control"  id="gambarInput"
                                                                accept="image/*">
                                                            @error('gambar')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        
                                                         <div class="mt-2">
                                                        <img id="gambarPreview" src="#" alt="Image Preview" style="max-height: 200px; display: none;">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label class="form-label"
                                                            for="exampleFormControlSelect1">Status</label>
                                                        <select class="form-control" name="status"
                                                            id="exampleFormControlSelect1">
                                                            <option value="">Select status</option>
                                                            <option value="Aktif">
                                                                Aktif</option>
                                                            <option value="Tidak aktif">
                                                                Tidak aktif</option>
                                                        </select>
                                                        @error('status')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-6 mt-3 mt-lg-0">
                                                        <label class="form-label"
                                                            for="availabilitySelect">Availability</label>
                                                        <select class="form-control" name="availability"
                                                            id="availabilitySelect">
                                                            <option value="Available">Available</option>
                                                            <option value="Not Available">Not Available</option>
                                                        </select>
                                                        @error('availability')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <button type="submit" class="btn btn-primary"
                                                        title="Submit">Submit</button>
                                                    <a href="/admin/lokasi-list" class="btn btn-danger"
                                                        title="Close">Close</a>
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
    document.getElementById('gambarInput').addEventListener('change', function (event) {
        const input = event.target;
        const preview = document.getElementById('gambarPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });

</script>
@endsection
