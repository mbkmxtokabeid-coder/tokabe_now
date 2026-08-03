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


@if (session('delete'))
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Hapus',
                text: {!! json_encode(session('delete') ?? session('success')) !!},
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
                                                <li class="breadcrumb-item"><a href="#!">Billboard List</a></li>
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
                                <div class="row justify-content-start">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>OOH Billboard List</h4>
                                        <a href="{{ route('create-OOH') }}" class="btn btn-primary">Add New OOH Billboard</a>
                                    </div>
                                    @foreach ($lokasiooh as $location)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4">
                                            <a href="{{ route('lokasi-list-ooh', ['wilayah' => $location->wilayah]) }}"
                                                class="card-link">
                                                <div class="card-location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <h5>{{ $location->wilayah }}</h5>
                                                    <p>{{ $location->jumlah }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
