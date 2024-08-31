@extends('layouts.main')
@section('title', 'Create Order Product')
@section('content')
    <div class="container mb-3">
        <h2>Order Products</h2>

        <form action="{{ route('order.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="form-group">
                <label for="customerName">Customer Name</label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <table class="table" id="orderTable">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-control product-select" name="products[]">
                                @forelse($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - {{ $product->category }} (Rp{{ $product->price }})</option>
                                @empty
                                    <option value="">No products available</option>
                                @endforelse
                            </select>
                        </td>
                        <td class="price">Rp1.000</td>
                        <td><input type="number" class="form-control quantity" name="quantities[]" value="0"></td>
                        <td class="total-price">Rp0</td>
                        <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" id="addRow" class="btn btn-success">Add Product</button>

            <div class="form-group">
                <label for="totalAmount">Total Amount</label>
                <input type="text" id="totalAmount" name="total_amount" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Submit Order</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateTotal() {
                let totalAmount = 0;
                $('#orderTable tbody tr').each(function() {
                    const price = $(this).find('.product-select option:selected').data('price');
                    const quantity = $(this).find('.quantity').val();
                    const totalPrice = price * quantity;
                    $(this).find('.total-price').text('Rp' + new Intl.NumberFormat().format(totalPrice));
                    totalAmount += totalPrice;
                });
                $('#totalAmount').val('Rp' + new Intl.NumberFormat().format(totalAmount));
            }

            $('#addRow').click(function() {
                const newRow = $('#orderTable tbody tr:first').clone();
                newRow.find('input').val(1);
                newRow.find('.total-price').text('Rp1.000');
                $('#orderTable tbody').append(newRow);
            });

            $('#orderTable').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                updateTotal();
            });

            $('#orderTable').on('change', '.product-select, .quantity', function() {
                updateTotal();
            });

            updateTotal(); 
        });
    </script>
@endsection
