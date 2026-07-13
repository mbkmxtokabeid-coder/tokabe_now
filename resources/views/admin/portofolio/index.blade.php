@extends('admin.template')
@section('content')

    @if (session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    @if (session('delete'))
        <script>alert("{{ session('delete') }}");</script>
    @endif

    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">

                            <!-- BREADCRUMB -->
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h3 class="m-b-10">Portofolio List</h3>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a href="/admin"><i class="feather icon-home"></i></a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#">Portofolio List</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CONTENT -->
                            <div class="container mt-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">

                                            <div class="card-header d-flex justify-content-between align-items-start">
                                                <h4>Portofolio List</h4>
                                                <a href="{{ route('portofolio.create') }}" class="btn btn-primary">
                                                    Add New Portofolio
                                                </a>
                                            </div>

                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label for="categoryFilter" class="font-weight-bold">Filter Kategori:</label>
                                                        <select id="categoryFilter" class="form-control">
                                                            <option value="">Semua Kategori</option>
                                                            @php
                                                                $kategoris = \App\Models\PortofolioCategory::all();
                                                            @endphp
                                                            @foreach($kategoris as $kat)
                                                                @php
                                                                    $katName = json_decode($kat->nama_kategori, true);
                                                                    $katText = is_array($katName) ? ($katName['id'] ?? $katName['en'] ?? collect($katName)->first() ?? '') : $kat->nama_kategori;
                                                                @endphp
                                                                <option value="{{ $katText }}">{{ $katText }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="dt-responsive table-responsive">



                                                    <table id="simpletable" class="table table-striped table-bordered w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Judul</th>
                                                                <th>Kategori</th>
                                                                <th>Klien</th>
                                                                <th>Tanggal</th>
                                                                <th>Lokasi</th>
                                                                <th>Deskripsi</th>
                                                                <th>Images</th>
                                                                <th>Videos</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($data as $row)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>

                                                                    <td style="white-space: normal !important; word-wrap: break-word; min-width: 150px; max-width: 200px;">
                                                                        @php
                                                                            $judulDecoded = json_decode($row->judul, true);
                                                                            $judulText = is_array($judulDecoded) ? ($judulDecoded['id'] ?? $row->judul) : $row->judul;
                                                                        @endphp
                                                                        {!! \Illuminate\Support\Str::limit($judulText, 30, '...') !!}
                                                                    </td>

                                                                    <td style="white-space: normal !important; word-wrap: break-word; min-width: 100px; max-width: 150px;">
                                                                        @php
                                                                            $katRaw = $row->category->nama_kategori ?? '-';
                                                                            $katDecoded = json_decode($katRaw, true);
                                                                            $katText = is_array($katDecoded) ? ($katDecoded['id'] ?? $katRaw) : $katRaw;
                                                                        @endphp
                                                                        {{ $katText }}
                                                                    </td>

                                                                    <td style="white-space: normal !important; min-width: 100px;">
                                                                        {{ $row->klien ?? '-' }}
                                                                    </td>
                                                                    
                                                                    <td style="white-space: nowrap !important;">
                                                                        {{ $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d M Y') : '-' }}
                                                                    </td>
                                                                    
                                                                    <td style="white-space: normal !important; word-wrap: break-word; min-width: 100px; max-width: 150px;">
                                                                        {{ $row->lokasi ?? '-' }}
                                                                    </td>

                                                                    <td style="white-space: normal !important; word-wrap: break-word; min-width: 200px; max-width: 250px;">
                                                                        @php
                                                                            $descDecoded = json_decode($row->deskripsi, true);
                                                                            $descText = is_array($descDecoded) ? ($descDecoded['id'] ?? $row->deskripsi) : $row->deskripsi;
                                                                        @endphp
                                                                        {{ \Illuminate\Support\Str::limit(strip_tags($descText), 70, '...') }}
                                                                    </td>

                                                                    {{-- Kolom Menampilkan Images --}}
                                                                    <td style="min-width: 80px;">
                                                                        @if ($row->images && $row->images->count() > 0)
                                                                            <div class="d-flex align-items-center gap-1">
                                                                                @foreach ($row->images->take(1) as $img)
                                                                                    <img src="{{ asset('storage/'.$img->image) }}"
                                                                                         width="60"
                                                                                         height="60"
                                                                                         class="rounded border"
                                                                                         style="object-fit:cover;">
                                                                                @endforeach
                                                                                @if($row->images->count() > 1)
                                                                                    <div class="d-flex align-items-center justify-content-center bg-light rounded border text-secondary" style="width: 40px; height: 60px; font-size: 14px; font-weight: 500;">
                                                                                        +{{ $row->images->count() - 1 }}
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        @else
                                                                            <span class="text-muted">No Image</span>
                                                                        @endif
                                                                    </td>

                                                                    {{-- Kolom Menampilkan Videos (BARU) --}}
                                                                    <td style="min-width: 80px;">
                                                                        @if ($row->videos && $row->videos->count() > 0)
                                                                            <div class="d-flex align-items-center gap-1">
                                                                                @foreach ($row->videos->take(1) as $vid)
                                                                                    @if(str_contains($vid->video_path, 'youtube.com') || str_contains($vid->video_path, 'youtu.be'))
                                                                                        @if($vid->thumbnail)
                                                                                            <img src="{{ asset('storage/'.$vid->thumbnail) }}" width="80" height="60" class="rounded border" style="object-fit:cover;">
                                                                                        @else
                                                                                            <div class="d-flex align-items-center justify-content-center bg-light rounded border" style="width: 80px; height: 60px;">
                                                                                                <i class="fab fa-youtube text-danger fa-2x"></i>
                                                                                            </div>
                                                                                        @endif
                                                                                    @else
                                                                                        <video src="{{ asset('storage/'.($vid->video_path ?? $vid->video)) }}" width="80" height="60" class="rounded bg-dark" style="object-fit:cover;"></video>
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($row->videos->count() > 1)
                                                                                    <div class="d-flex align-items-center justify-content-center bg-light rounded border text-secondary" style="width: 40px; height: 60px; font-size: 14px; font-weight: 500;">
                                                                                        +{{ $row->videos->count() - 1 }}
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        @else
                                                                            <span class="text-muted">No Video</span>
                                                                        @endif
                                                                    </td>

                                                                    {{-- Kolom Actions --}}
                                                                    <td style="white-space: nowrap; width: 1%; text-align: center;">
                                                                        <!-- EDIT -->
                                                                        <a class="btn btn-outline-primary btn-sm"
                                                                            href="{{ route('portofolio.edit', $row->id) }}">
                                                                            <i class="feather icon-edit"></i>
                                                                        </a>

                                                                        <!-- DELETE BUTTON -->
                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#confirmDeleteModal-{{ $row->id }}">
                                                                            <i class="feather icon-trash"></i>
                                                                        </button>

                                                                        <!-- DELETE MODAL -->
                                                                        <div class="modal fade"
                                                                            id="confirmDeleteModal-{{ $row->id }}"
                                                                            tabindex="-1">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                                                        <button type="button" class="btn-close"
                                                                                            data-bs-dismiss="modal"></button>
                                                                                    </div>

                                                                                    <div class="modal-body">
                                                                                        Are you sure you want to delete this portofolio?
                                                                                    </div>

                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">Cancel</button>

                                                                                        <form action="{{ route('portofolio.destroy', $row->id) }}"
                                                                                            method="POST">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit" class="btn btn-danger">
                                                                                                Delete
                                                                                            </button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add a slight delay to ensure DataTables is fully initialized by the template
            setTimeout(function() {
                var table = $('#simpletable').DataTable();
                
                $('#categoryFilter').on('change', function() {
                    var category = $(this).val();
                    // Column 2 is Kategori (0: ID, 1: Judul, 2: Kategori)
                    table.column(2).search(category ? '^' + $.fn.dataTable.util.escapeRegex(category) + '$' : '', true, false).draw();
                });
            }, 500);
        });
    </script>
@endsection