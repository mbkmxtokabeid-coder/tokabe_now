@extends ('admin.template')
@section('content')

    <!-- CSRF Token Meta Tag (Wajib untuk AJAX) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif
    
    @if (session('update'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Hero has been successfully updated',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @if (session('delete'))
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Hero has been successfully deleted',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif
    

    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ breadcrumb ] start -->
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h3 class="m-b-10">Tokabe Hero List</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/admin">
                                                        <i class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="#!">Heroes List</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="container mt-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4>Heroes List</h4>
                                                <a href="{{ route('hero-add') }}" class="btn btn-primary">Add New Heroes</a>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted"><i class="feather icon-info"></i> <i>Drag (tahan dan geser) ikon <i class="feather icon-move"></i> untuk mengatur urutan hero.</i></p>
                                                <div class="dt-responsive table-responsive">

                                                    <table id="simpletable"
                                                        class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 50px;">Order</th>
                                                                <th>ID</th>
                                                                <th>Title</th>
                                                                <th>Description</th>
                                                                <th>Image</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <!-- Tambahkan ID 'sortable-heroes' untuk JS -->
                                                        <tbody id="sortable-heroes">
                                                            @foreach ($heroes as $item)
                                                                <!-- Tambahkan data-id agar JS tau ID hero yang digeser -->
                                                                <tr data-id="{{ $item->id }}">
                                                                    <!-- Tombol/Icon Drag -->
                                                                    <td class="text-center align-middle drag-handle" style="cursor: grab;">
                                                                        <i class="feather icon-move" style="font-size: 20px; color: #6c757d;"></i>
                                                                    </td>
                                                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                                                    <td class="align-middle text-wrap text-break" style="max-width: 300px;">
                                                                    <!-- <td class="align-middle"
                                                                        style="white-space: normal; word-wrap: break-word; max-width: 300px;"> -->
                                                                        @php
                                                                            $judul = is_array($item->judul) ? ($item->judul[app()->getLocale()] ?? $item->judul['id'] ?? $item->judul['en'] ?? '') : $item->judul;
                                                                            $deskripsi = is_array($item->deskripsi) ? ($item->deskripsi[app()->getLocale()] ?? $item->deskripsi['id'] ?? $item->deskripsi['en'] ?? '') : $item->deskripsi;
                                                                        @endphp
                                                                        {!! \Illuminate\Support\Str::limit($judul, 50, '...') !!}
                                                                    </td>
                                                                    <td class="align-middle text-wrap text-break" style="max-width: 300px;">
                                                                    <!-- <td class="align-middle"
                                                                        style="white-space: normal; word-wrap: break-word; max-width: 300px;"> -->
                                                                        {{ \Illuminate\Support\Str::limit($deskripsi, 50, '...') }}
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        @if ($item->gambar)
                                                                            <img src="{{ \Illuminate\Support\Str::startsWith($item->gambar, 'http') ? $item->gambar : asset('storage/image_hero/' . $item->gambar) }}"
                                                                                alt="{{ $item->nama }}"
                                                                                style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                                                                        @else
                                                                            <span class="badge bg-secondary">No Image</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <a class="btn drp-icon btn-outline-primary"
                                                                            href="{{ route('hero-edit', $item->id) }}" type="button"><i
                                                                                class="feather icon-edit"></i></a>
                                                                        <a class="btn drp-icon btn-outline-danger"
                                                                            type="button" data-bs-toggle="modal"
                                                                            data-bs-target="#confirmDeleteModal-{{ $item->id }}"><i
                                                                                class="feather icon-trash"></i></a>
                                                                        
                                                                        <!-- Modal Delete -->
                                                                        <div class="modal fade"
                                                                            id="confirmDeleteModal-{{ $item->id }}"
                                                                            tabindex="-1"
                                                                            aria-labelledby="exampleModalLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        Are you sure to delete this Hero?
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                        <form action="{{ route('hero-delete', $item->id) }}" method="POST">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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

    <!-- Library SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.getElementById('sortable-heroes');
            
            // Inisialisasi fitur Drag and Drop
            new Sortable(tableBody, {
                handle: '.drag-handle', // Area yang bisa ditarik
                animation: 150, // Animasi saat geser (ms)
                ghostClass: 'bg-light', // Class saat item ditahan
                onEnd: function (evt) {
                    // Kumpulkan ID berdasarkan urutan terbaru
                    let order = [];
                    document.querySelectorAll('#sortable-heroes tr').forEach(function (row) {
                        order.push(row.getAttribute('data-id'));
                    });

                    // Kirim urutan ke Backend via AJAX
                    fetch('{{ route("hero-reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Munculkan notifikasi sukses (bisa dihapus jika tidak perlu)
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Urutan berhasil disimpan!'
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>

    <!-- [TAMBAHAN BARU] Matikan Auto-Sorting DataTables -->
    <script>
        $(document).ready(function() {
            // Jeda 500ms agar script bawaan template dieksekusi duluan, baru kita timpa
            setTimeout(function() {
                if ($.fn.DataTable.isDataTable('#simpletable')) {
                    $('#simpletable').DataTable().destroy(); // Hancurkan DataTables lama
                }
                
                // Inisialisasi ulang DataTables tanpa fitur auto ordering
                $('#simpletable').DataTable({
                    "ordering": false, 
                    "info": true,
                    "paging": true
                });
            }, 500);
        });
    </script>
@endsection