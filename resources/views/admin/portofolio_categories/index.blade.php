@extends('admin.template')
@section('content')

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Kategori Portofolio List</h4>
                                <a href="{{ route('portofolio_categories.create') }}"
                                   class="btn btn-primary">
                                    Add New Kategori
                                </a>
                            </div>

                            <div class="card-body table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                             <th>Gambar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($portofolio_categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                   {{-- NAMA --}}
                                                <td>
                                                    @php
                                                        $katDecoded = json_decode($category->nama_kategori, true);
                                                        $katText = is_array($katDecoded) ? ($katDecoded['id'] ?? $category->nama_kategori) : $category->nama_kategori;
                                                    @endphp
                                                    {{ $katText }}
                                                </td>

                                                {{-- GAMBAR --}}
                                                <td>
                                                    @if (!empty($category->image))
                                                        <img src="{{ asset('storage/' . $category->image) }}"
                                                             width="80"
                                                             class="rounded">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>

                                             

                                                {{-- AKSI --}}
                                                <td>
                                                    <a href="{{ route('portofolio_categories.edit', $category->id) }}"
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="feather icon-edit"></i>
                                                    </a>

                                                    <form action="{{ route('portofolio_categories.destroy', $category->id) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Yakin hapus kategori?')">
                                                            <i class="feather icon-trash"></i>
                                                        </button>
                                                    </form>
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
</section>

@endsection
