@extends('layouts.main')
@section('title', 'Order History Data')
@section('content')
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ $message }}
    </div>
@endif
<a class="btn btn-primary mb-2" href="{{ route('order.create') }}">Create New Order</a>
<div class="card mt-6">
    <div class="card-body">
        <table id="ordersTable" class="display table" width='100%'>
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('order.orderData') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'order.customer.name', name: 'order.customer.name' },
                { data: 'product.name', name: 'product.name' },
                { data: 'product.category', name: 'product.category' },
                { data: 'formatted_price', name: 'formatted_price' },
                { data: 'quantity', name: 'quantity' },
                { data: 'order.total_amount', name: 'order.total_amount' },
                { data: 'order.order_date', name: 'order.order_date' },
            ],
            order: [[7, 'desc']],
            pageLength: 10,
        });
    });
</script>
@endsection
