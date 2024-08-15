<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index(Product $product)
    {
       
        $prices =Price::where('product_id', $product['id'])->get();
       
        return view('admin.prices.index', compact('product', 'prices'));
    }

    public function create(Product $product)
    {
        return view('admin.prices.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $product->prices()->create($data);

        return redirect()->route('admin.products.prices.index', $product->id)->with('success', 'Price created successfully.');
    }

    public function edit(Product $product, Price $price)
    {
        return view('admin.prices.edit', compact('product', 'price'));
    }

    public function update(Request $request, Product $product, Price $price)
    {
        $data = $request->validate([
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $price->update($data);

        return redirect()->route('admin.products.prices.index', $product->id)->with('success', 'Price updated successfully.');
    }

    public function destroy(Product $product, Price $price)
    {
        $price->delete();

        return redirect()->route('admin.products.prices.index', $product->id)->with('success', 'Price deleted successfully.');
    }
}
