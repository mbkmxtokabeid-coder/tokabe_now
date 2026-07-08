@extends('admin.template')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add Legality</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.legality.index') }}">Legality</a></li>
                            <li class="breadcrumb-item"><a href="#!">Add</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Legality Document</h5>
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

                        <form action="{{ route('admin.legality.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">Logo / Image <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control-file" id="image" name="image" required accept="image/*">
                                        <small class="form-text text-muted">Upload a square image (e.g. 512x512px) for best results.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_id">Name (Indonesian) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name_id" name="name_id" value="{{ old('name_id') }}" required placeholder="e.g., NIB">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_en">Name (English) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') }}" required placeholder="e.g., Business Registration Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description_id">Description / Number (Indonesian) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="description_id" name="description_id" value="{{ old('description_id') }}" required placeholder="e.g., Nomor Induk Berusaha">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description_en">Description / Number (English) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="description_en" name="description_en" value="{{ old('description_en') }}" required placeholder="e.g., Business License Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                                        <small class="form-text text-muted">Lower numbers appear first.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                                            <label class="custom-control-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3"><i class="feather icon-save"></i> Save Legality</button>
                            <a href="{{ route('admin.legality.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
