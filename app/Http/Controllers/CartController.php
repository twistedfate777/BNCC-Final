<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        if ($item->quantity <= 0) {
            return back()->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang');
        }

        $cart = session()->get('cart', []);
        
        $requestedQuantity = $request->input('quantity', 1);
        
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] + $requestedQuantity > $item->quantity) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            $cart[$id]['quantity'] += $requestedQuantity;
        } else {
            if ($requestedQuantity > $item->quantity) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            $cart[$id] = [
                "name" => $item->name,
                "quantity" => $requestedQuantity,
                "price" => $item->price,
                "category" => $item->category->name ?? '-',
                "image" => $item->image
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|string|digits:5',
        ]);

        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('catalog')->with('error', 'Keranjang kosong.');
        }

        $totalPrice = 0;
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'shipping_address' => $request->shipping_address,
            'postal_code' => $request->postal_code,
            'total_price' => $totalPrice,
        ]);

        foreach ($cart as $id => $details) {
            $subtotal = $details['price'] * $details['quantity'];
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_id' => $id,
                'quantity' => $details['quantity'],
                'subtotal' => $subtotal,
            ]);
            
            $item = Item::find($id);
            if ($item) {
                $item->decrement('quantity', $details['quantity']);
            }
        }

        session()->forget('cart');

        return redirect()->route('invoice.show', $invoice->id)->with('success', 'Checkout berhasil!');
    }

    public function invoice($id)
    {
        $invoice = Invoice::with(['invoiceItems.item', 'user'])->findOrFail($id);
        
        if ($invoice->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        return view('user.invoice', compact('invoice'));
    }
}
