@extends('admin.template')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Legality</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.legality.index') }}">Legality</a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Legality Document</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.legality.update', $legality->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    @if($legality->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $legality->image) }}" alt="Current Image" style="width: 100px; height: 100px; object-fit: contain; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="image">Replace Logo / Image</label>
                                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                        <small class="form-text text-muted">Leave blank if you don't want to change the image.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_id">Name (Indonesian) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name_id" name="name_id" value="{{ old('name_id', $legality->name_id) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_en">Name (English) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en', $legality->name_en) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description_id">Description / Number (Indonesian) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="description_id" name="description_id" value="{{ old('description_id', $legality->description_id) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description_en">Description / Number (English) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="description_en" name="description_en" value="{{ old('description_en', $legality->description_en) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $legality->sort_order) }}">
                                        <small class="form-text text-muted">Lower numbers appear first.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $legality->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3"><i class="feather icon-save"></i> Update Legality</button>
                            <a href="{{ route('admin.legality.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
