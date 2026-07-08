@extends('admin.template')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Legality Management</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Legality</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>List of Legalities</h5>
                        <a href="{{ route('admin.legality.create') }}" class="btn btn-primary btn-sm"><i class="feather icon-plus"></i> Add New Legality</a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="zero-configuration" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Name (ID/EN)</th>
                                        <th>Description (ID/EN)</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($legalities as $key => $legality)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($legality->image)
                                                <img src="{{ asset('storage/' . $legality->image) }}" alt="image" style="width: 50px; height: 50px; object-fit: contain;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $legality->name_id }}</strong><br>
                                            <small class="text-muted">{{ $legality->name_en }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ Str::limit($legality->description_id, 30) }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($legality->description_en, 30) }}</small>
                                        </td>
                                        <td>
                                            @if($legality->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $legality->sort_order }}</td>
                                        <td>
                                            <a href="{{ route('admin.legality.edit', $legality->id) }}" class="btn btn-info btn-sm"><i class="feather icon-edit"></i> Edit</a>
                                            <form action="{{ route('admin.legality.destroy', $legality->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Legality?')"><i class="feather icon-trash-2"></i> Delete</button>
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
@endsection
