<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Money\Money;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use NumberFormatter;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->when(request('search'), function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('price', 'like', $searchTerm)
                    ->orWhere('category', 'like', $searchTerm);
            })->paginate(10);

        $currencies = new ISOCurrencies();
        $numberFormatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        foreach ($products as $product) {
            $money = new Money($product->price * 100, new \Money\Currency('IDR'));
            $product->formatted_price = $moneyFormatter->format($money);
        }

        return view('product/index', [
            'products' => $products
        ]);
    }

    public function add()
    {
        return view('product/formAdd');
    }

    public function addPost(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category' => 'required|string|max:255',
            ], [
                'price.numeric' => 'Harga harus berupa angka.',
                'price.min' => 'Harga harus lebih besar atau sama dengan 0.',
            ]);

            $name = $request->name;
            $description = $request->description;
            $price = $request->price;
            $category = $request->category;

            $customer = Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category' => $category,
            ]);

            return redirect(route('products.index'))->with('success', 'Produk berhasil ditambah ');
        } catch (\Throwable $th) {
            return redirect(route('products.add'))->with('errors', 'Produk Gagal ditambah');
        }
    }

    public function edit($productId)
    {
        $product = Product::find($productId);
        return view('product/formEdit', [
            'product' => $product
        ]);
    }

    public function editPost(Request $request)
    {
        $productId = $request->id;

        try {
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category' => 'required|string|max:255',
            ], [
                'price.numeric' => 'Harga harus berupa angka.',
                'price.min' => 'Harga harus lebih besar atau sama dengan 0.',
            ]);

            $product = Product::findOrFail($productId)->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category' => $request->category,
            ]);
            return redirect(route('products.index'))->with('success', 'Produk Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect(route('products.edit', $productId))->with('errors', 'Produk Gagal Diubah');
        }
    }

    public function delete($productId)
    {
        $product = $productId;
        $product = Product::findOrFail($product);
        $product->delete();
        return redirect(route('products.index'))->with('success', 'Produk Berhasil Dihapus');
    }
}
