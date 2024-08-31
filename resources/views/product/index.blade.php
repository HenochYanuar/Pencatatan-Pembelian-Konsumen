@extends('layouts.main')
@section('title', 'Products Data')
@section('content')
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ $message }}
    </div>
@endif
<a class="btn btn-primary mb-2" href="{{ route('products.add') }}">Add Product</a>
<div class="card mt-6">
    <div class="card-header">
        <div class="card-tools">
            <form action="">
                <input value="{{ old('search') }}" placeholder="Search Book" type="text" name="search"
                    class="from-control">
            </form>
        </div>
    </div>
    <div class="card-body">
        <table class="table" width='100%'>
            <thead>
                <tr>
                    <th class="col-1">No</th>
                    <th class="col-2">Product</th>
                    <th class="col-2">Description</th>
                    <th class="col-2">Price</th>
                    <th class="col-2">Category</th>
                    <th class="col-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->formatted_price }}</td>
                        <td>{{ $product->category }}</td>
                        <td>
                            <form method="POST" action="{{ route('products.delete', [$product->id]) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning" href="{{ route('products.edit', [$product->id]) }}">
                                    <i class="fa fa-pencil-alt"></i>Edit
                                </a>
                                |
                                <button class="btn btn-danger" href="{{ route('products.delete', [$product->id]) }}"
                                    type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data produk ini?')">
                                    <i class="fa fa-trash"></i>Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td style="text-align: center;" colspan="4"><b>Data Kosong</b></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection