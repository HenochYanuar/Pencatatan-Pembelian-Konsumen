@extends('layouts.main')
@section('title', 'Add Product Data')
@section('content')
    @if ($message = Session::get('errors'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-cross"></i> Failed!</h5>
            {{ $message }}
        </div>
    @endif
    <form method="POST" action="{{ route('products.addPost') }}">
        <div class="row">
            <div class="card col-8 ml-5">
                <div class="card-header">
                    <h3 class="">Add Product Data</h3>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input value="{{ old('name') }}" class="form-control" type="text" name="name" />
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <input value="{{ old('description') }}" class="form-control" type="text" name="description" />
                    </div>
                    <div class="form-group">
                        <label for="">Price</label>
                        <input value="{{ old('price') }}" inputmode="numeric" class="form-control" type="text" name="price" />
                    </div>
                    <div class="form-group">
                        <label for="">Category</label>
                        <input value="{{ old('category') }}" class="form-control" type="text" name="category" />
                    </div>
                    <button class="btn btn-success mt-2" type="submit">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
