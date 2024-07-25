<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);

        return view('admin.stock.index', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('toast_success', 'Berhasil Menambahkan Stok Produk');
    }

    public function report()
    {
        $products = Product::paginate(10);

        return view('admin.stock.report', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Update stock to 0 or delete stock records depending on your application logic
        $product->update(['quantity' => 0]);

        return redirect()->back()->with('toast_success', 'Stock reset successfully.');
    }
}
