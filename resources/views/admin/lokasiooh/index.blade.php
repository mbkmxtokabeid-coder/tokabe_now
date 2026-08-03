@extends ('admin.template')
@section('content')
  
@if (session('success') || session('update'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: {!! json_encode(session('success') ?? session('update')) !!},
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
                                                <h3 class="m-b-10">Tokabe Billboard List</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/admin">
                                                        <i class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a
                                                        href="{{ route('wilayah-list-ooh') }}">Billboard List</a></li>
                                                <li class="breadcrumb-item"><a href="#!">{{ $lokasiooh->first()?->wilayah ?? $wilayah }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                </div>
                            </div>
                            <div class="container mt-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4>OOH Billboard List</h4>
                                                <a href="{{ route('create-OOH') }}" class="btn btn-primary">Add New OOH Billboard</a>
                                            </div>
                                            <div class="card-body">
                                                <div class="dt-responsive table-responsive">

                                                    <table id="simpletable"
                                                        class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Location Description</th>
                                                                <th>Region</th>
                                                                <th>Provinsi</th>
                                                                <th>Status</th>
                                                                <th>Availability</th>
                                                                <th>Image</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($lokasiooh as $item)
                                                                @php
                                                                    $namaDisplay = is_array($item->nama) 
                                                                        ? ($item->nama['id'] ?? $item->nama['en'] ?? '') 
                                                                        : ($item->nama ?: $item->getRawOriginal('nama'));
                                                                    $descDisplay = is_array($item->deskripsi_lokasi) 
                                                                        ? ($item->deskripsi_lokasi['id'] ?? $item->deskripsi_lokasi['en'] ?? '') 
                                                                        : ($item->deskripsi_lokasi ?: $item->getRawOriginal('deskripsi_lokasi'));
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td
                                                                        style="white-space: normal !important; word-wrap: break-word; min-width: 150px; max-width: 250px;">
                                                                        {{ \Illuminate\Support\Str::limit($namaDisplay, 50, '...') }}
                                                                    </td>
                                                                    <td
                                                                        style="white-space: normal !important; word-wrap: break-word; min-width: 150px; max-width: 250px;">
                                                                        {{ \Illuminate\Support\Str::limit($descDisplay, 100, '...') }}
                                                                    </td>
                                                                    <td
                                                                        style="white-space: normal !important; word-wrap: break-word; min-width: 100px; max-width: 150px;">
                                                                        {{ $item->wilayah }}
                                                                    </td>
                                                                    <td
                                                                        style="white-space: normal !important; word-wrap: break-word; min-width: 100px; max-width: 150px;">
                                                                        {{ $item->provinsi }}
                                                                    </td>
                                                                    <td
                                                                        style="white-space: normal !important; word-wrap: break-word; max-width: 100px;">
                                                                        {{ $item->status }}
                                                                    </td>
                                                                    <td
                                                                        style="white-space: normal !important; word-wrap: break-word; max-width: 100px;">
                                                                        @if(($item->availability ?? 'Available') === 'Available')
                                                                            <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 0.85em; display: inline-block;">Available</span>
                                                                        @else
                                                                            <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 0.85em; display: inline-block;">Not Available</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->gambar)
                                                                            <img src="{{ \Illuminate\Support\Str::startsWith($item->gambar, 'http') ? $item->gambar : asset('storage/image_lokasiooh/' . $item->gambar) }}"
                                                                                alt="{{ $namaDisplay }}"
                                                                                style="max-width: 150px; max-height: 150px;">
                                                                        @else
                                                                            <span>No Image</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a class="btn drp-icon btn-outline-primary"
                                                                            href="{{ route('edit-OOH', $item->id) }}" type="button"><i
                                                                                class="feather icon-edit"></i></a>
                                                                        <a class="btn drp-icon btn-outline-danger"
                                                                            type="button" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $item->id }}"><i
                                                                                    class="feather icon-trash"></i></a>
                                                                        <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}"
                                                                            tabindex="-1"
                                                                            aria-labelledby="exampleModalLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Confirm
                                                                                            Delete
                                                                                        </h5>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        Are you sure to delete this OOH Billboard?
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                                        <form action="{{ route('delete-OOH', $item->id) }}" method="POST">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit"
                                                                                                class="btn btn-danger">Delete</button>
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
    </section>
@endsection
