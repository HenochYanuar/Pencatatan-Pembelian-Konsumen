<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{

    public function index()
    {
        return view('order.index');
    }

    public function orderData(Request $request)
    {
        $query = OrderItem::query()->with(['order.customer', 'product']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('formatted_price', function ($orderItem) {
                $money = new Money($orderItem->price * 100, new \Money\Currency('IDR'));
                $currencies = new ISOCurrencies();
                $numberFormatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
                return $moneyFormatter->format($money);
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search')) {
                    $searchTerm = '%' . $request->search['value'] . '%';
                    $query->where('price', 'like', $searchTerm)
                        ->orWhere('quantity', 'like', $searchTerm)
                        ->orWhereHas('order', function ($query) use ($searchTerm) {
                            $query->where('order_date', 'like', $searchTerm)
                                ->orWhere('total_amount', 'like', $searchTerm);
                        })
                        ->orWhereHas('product', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', $searchTerm)
                                ->orWhere('category', 'like', $searchTerm);
                        });
                }
            })
            ->make(true);
    }

    public function create()
    {
        $products = Product::all();

        return view('order/order', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'address' => 'string|max:255',
            'products' => 'required|array',
            'quantities' => 'required|array',
            'total_amount' => 'required|string',
        ]);

        $customer = Customer::create([
            'name' => $request->customer_name,
            'email' => $request->email,
            'address' => $request->address
        ]);

        $totalAmount = preg_replace('/[^0-9]/', '', $request->total_amount);
        $order_date = now();

        $order = Order::create([
            'customer_id' => $customer->id,
            'total_amount' => $totalAmount,
            'order_date' => $order_date
        ]);

        foreach ($request->products as $index => $productId) {
            $product = Product::find($productId);

            if ($product) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $request->quantities[$index],
                    'price' => $product->price
                ]);
            }
        }

        return redirect(route('order.index'))->with('success', 'Order Berhasil dibuat');
    }
}
