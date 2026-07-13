@extends ('admin.template')
@section('content')

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'success',
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
                title: 'Service has been successfully updated',
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
                title: 'Service has been successfully deleted',
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
                                                <h3 class="m-b-10">Tokabe Services List</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/admin">
                                                        <i class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="{{route('service-list')}}">Services List</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Services List</h4>
                                            <a href="/admin/service/create" class="btn btn-primary">Add New Service</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive table-responsive">
                                                <table id="simpletable" class="table table-striped table-bordered w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @foreach ($services as $item )
                                                            <tr>
                                                                <td>{{$loop->iteration }}</td>
                                                                <td style="white-space: normal !important; word-wrap: break-word; min-width: 150px; max-width: 200px;">
                                                                    {{ is_array($item->judul) ? ($item->judul['id'] ?? '') : $item->judul }}
                                                                </td>
                                                                <td style="white-space: normal !important; word-wrap: break-word; min-width: 200px; max-width: 300px;">
                                                                    @php
                                                                        $descText = is_array($item->deskripsi) ? ($item->deskripsi['id'] ?? '') : $item->deskripsi;
                                                                    @endphp
                                                                    {!! \Illuminate\Support\Str::limit(strip_tags($descText), 150, '...') !!}
                                                                </td>
                                                                <td style="min-width: 80px;">@if($item->gambar)
                                                                        <img src="{{ asset('storage/image_service/' . $item->gambar) }}" alt="{{ is_array($item->judul) ? ($item->judul['id'] ?? '') : $item->judul }}" class="rounded border" style="width: 120px; height: 80px; object-fit: cover;">
                                                                    @else
                                                                        <span class="text-muted">No Image</span>
                                                                    @endif</td>
                                                               
                                                                <td style="white-space: nowrap; width: 1%; text-align: center;">
                                                                    <a class="btn drp-icon btn-outline-primary"
                                                                        href="/admin/service/edit/{{ $item->id }}"
                                                                        type="button"><i class="feather icon-edit"></i></a>
                                                                    <a class="btn drp-icon btn-outline-danger"
                                                                        href="#" 
                                                                        type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#confirmDeleteModal-{{ $item->id }}">
                                                                        <i class="feather icon-trash"></i>
                                                                    </a>

                                                                    <div class="modal fade"
                                                                        id="confirmDeleteModal-{{ $item->id }}"
                                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                        aria-hidden="true" style="text-align: left; white-space: normal;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Confirm Delete
                                                                                    </h5>
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Are you sure to delete this Service?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                                    <form
                                                                                        action="{{ route('admin.service-list.destroy', $item->id) }}"
                                                                                        method="POST">
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

                            @endsection


